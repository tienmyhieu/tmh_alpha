<?php

namespace lib\transformers;

readonly class TmhEntityListsTransformer implements TmhTransformer
{
    public function __construct(private TmhTransformerFactory $transformerFactory)
    {
    }

    public function transform(array $entity): array
    {
        $transformedEntityLists = [];
        foreach ($entity as $entityList) {
            $transformedEntityList = ['translation' => $entityList['translation'], 'items' => []];
            $activeEntityListItems = $this->filterInactive($entityList['items']);
            foreach ($activeEntityListItems as $activeEntityListItem) {
                $transformer = $this->transformerFactory->create('entity_list_item');
                $transformedEntityList['items'][] = $transformer->transform($activeEntityListItem);
            }
            $transformedEntityLists[] = $transformedEntityList;
        }
        return $transformedEntityLists;
    }

    private function filterInactive(array $entityListItems): array
    {
        return array_filter($entityListItems, function($entityListItem) {
            return $entityListItem['active'] == '1';
        });
    }
}
