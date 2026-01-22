<?php

namespace lib\transformers;

use lib\core\TmhDatabase;

readonly class TmhImageGroupTransformer implements TmhTransformer
{
    public function __construct(private TmhTransformerFactory $transformerFactory, private TmhDatabase $database)
    {
    }

    public function transform(array $entity): array
    {
        $imageGroup = $this->database->imageGroup($entity['image_group']);
        if (0 == count($entity['translation'])) {
            $entity['translation'] = [$this->imageGroupTranslation($entity, $imageGroup)];
        }
        $transformed = [
            'date' => $imageGroup['date'],
            'identifier' => $entity['identifier'],
            'images' => [],
            'lang' => $entity['lang'],
            'translation' => $entity['translation'],
            'type' => $entity['type']
        ];
        foreach ($imageGroup['images'] as $image) {
            $transformed['images'][] = match($entity['type']) {
                'image_group1',
                'image_group2',
                'image_group3' => $this->routedToSpecimenImageGroup($entity, $image),
                default => $this->routedToImageGroup($entity, $image)
            };
        }
        return $transformed;
    }

    private function datedIdentifiedImageGroupTranslation(array $entity, array $imageGroup): string
    {
        return $imageGroup['date'] . ' - ' . $this->entityIdentifiedImageGroupTranslation($entity);
    }

    private function entityIdentifiedImageGroupTranslation(array $entity): string
    {
        return strtoupper(substr($entity['code'], 0, 4)) . ' ' . $this->identifiedImageGroupTranslation($entity);
    }

    private function identifiedImageGroupTranslation(array $entity): string
    {
        return $entity['identifier'];
    }

    private function imageGroupTranslation(array $entity, array $imageGroup): string
    {
        return match($entity['type']) {
            'image_group1' => $this->entityIdentifiedImageGroupTranslation($entity),
            'image_group2' => $this->datedIdentifiedImageGroupTranslation($entity, $imageGroup),
            'image_group3',
            'image_group4' => $this->identifiedImageGroupTranslation($entity),
            default => $entity['code']
        };
    }

    private function routedToImageGroup(array $entity, string $image): array
    {
        $imageTransformer = $this->transformerFactory->create('image1');
        $imageToTransform = ['uuid' => $image, 'translation' => $entity['translation'], 'type' => 'image1'];
        return $imageTransformer->transform($imageToTransform);
    }

    private function routedToSpecimenImageGroup(array $entity, string $image): array
    {
        $imageGroupTypes = ['image_group1', 'image_group2', 'image_group3'];
        $imageTransformer = $this->transformerFactory->create('image2');
        $routeTransformer = $this->transformerFactory->create('route1');
        $routeToTransform = ['uuid' => $entity['route'], 'translation' => [$entity['code']]];
        if (in_array($entity['type'], $imageGroupTypes)) {
            $type = 4 == strlen($entity['code']) ? 'specimen_group' : 'specimen';
            $routeToTransform['code'] = $entity['code'];
            $routeToTransform['type'] = $type;
        }
        $transformedRoute = $routeTransformer->transform($routeToTransform);
        $transformedImage = $imageTransformer->transform(['uuid' => $image, 'translation' => '', 'type' => 'image2']);
        $transformedImage['route'] = $transformedRoute;
        return $transformedImage;
    }
}
