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
        if (0 == count($entity['translation'])) {
            $entity['translation'] = [$entity['code']];
        }
        $imageGroup = $this->database->imageGroup($entity['image_group']);
        $transformed = [
            'date' => $imageGroup['date'],
            'images' => [],
            'lang' => $entity['lang'],
            'translation' => $entity['translation'],
            'type' => $entity['type']
        ];
        foreach ($imageGroup['images'] as $image) {
            $transformed['images'][] = match($entity['type']) {
                'image_group1' => $this->routedToSpecimenImageGroup($entity, $image),
                default => $this->routedToImageGroup($entity, $image)
            };
        }
        return $transformed;
    }

    private function routedToImageGroup(array $entity, string $image): array
    {
        $imageTransformer = $this->transformerFactory->create('image2');
        $imageToTransform = ['uuid' => $image, 'translation' => $entity['translation'], 'type' => 'image2'];
        return $imageTransformer->transform($imageToTransform);
    }

    private function routedToSpecimenImageGroup(array $entity, string $image): array
    {
        $imageTransformer = $this->transformerFactory->create('image2');
        $routeTransformer = $this->transformerFactory->create('route1');
        $routeToTransform = ['uuid' => $entity['route'], 'translation' => [$entity['code']]];
        if ($entity['type'] == 'image_group1') {
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
