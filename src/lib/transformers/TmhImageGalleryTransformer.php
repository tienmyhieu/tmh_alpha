<?php

namespace lib\transformers;

readonly class TmhImageGalleryTransformer implements TmhTransformer
{
    public function __construct(private TmhTransformerFactory $transformerFactory)
    {
    }

    public function transform(array $entity): array
    {
        $transformedItems = [];
        foreach($entity['items'] as $imageGroup) {
            $transformer = $this->transformerFactory->create($imageGroup['type']);
            $transformedItems[] = $transformer->transform($imageGroup);
        }
        $entity['items'] = $transformedItems;
        return $entity;
    }
}
