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
        if ($entity['type'] == 'image') {
            $transformer = $this->transformerFactory->create('image');
            $entityToTransform = ['uuid' => $entity['image']];
            $entity['route'] = $transformer->transform($entityToTransform);
        }
        if (in_array($entity['type'], $routeTypes)) {
            $transformer = $this->transformerFactory->create($entity['type']);
            $entityToTransform = ['uuid' => $entity['route'], 'translation' => $entity['translation']];
            $entity['route'] = $transformer->transform($entityToTransform);
        }
        unset($entity['image']);
        return $entity;
    }
}
