<?php

namespace lib\transformers;

readonly class TmhEntityListItemTransformer implements TmhTransformer
{
    public function __construct(private TmhTransformerFactory $transformerFactory)
    {
    }

    public function transform(array $entity): array
    {
        $imageRouteTypes = ['image_route1', 'image_route2'];
        $routeTypes = ['route1', 'route2', 'route3', 'route5'];
        unset($entity['active']);
        if (in_array($entity['type'], $routeTypes)) {
            $transformer = $this->transformerFactory->create($entity['type']);
            $entityToTransform = ['uuid' => $entity['route'], 'translation' => $entity['translation']];
            $entity['route'] = $transformer->transform($entityToTransform);
        }
        if (in_array($entity['type'], $imageRouteTypes)) {
            $transformer = $this->transformerFactory->create('image1');
            $entityToTransform = [
                'uuid' => $entity['image'],
                'translation' => $entity['translation'],
                'type' => $entity['type']
            ];
            $entity['route'] = $transformer->transform($entityToTransform);
        }
        unset($entity['image']);
        return $entity;
    }
}
