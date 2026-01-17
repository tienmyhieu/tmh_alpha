<?php

namespace lib\transformers;

readonly class TmhEntityListItemTransformer implements TmhTransformer
{
    public function __construct(private TmhTransformerFactory $transformerFactory)
    {
    }

    public function transform(array $entity): array
    {
        $routeTypes = ['route1', 'route2', 'route3'];
        unset($entity['active']);
        if (in_array($entity['type'], $routeTypes)) {
            $transformer = $this->transformerFactory->create($entity['type']);
            $entityToTransform = ['uuid' => $entity['route'], 'translation' => $entity['translation']];
            $entity['route'] = $transformer->transform($entityToTransform);
        }
        if ($entity['type'] == 'image_route1') {
            $transformer = $this->transformerFactory->create('image1');
            $entityToTransform = [
                'uuid' => $entity['image'],
                'translation' => $entity['translation'],
                'type' => 'image_route1'
            ];
            $entity['route'] = $transformer->transform($entityToTransform);
        }
        unset($entity['image']);
        return $entity;
    }
}
