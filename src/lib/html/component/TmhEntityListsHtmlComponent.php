<?php

namespace lib\html\component;

readonly class TmhEntityListsHtmlComponent implements TmhHtmlComponent
{
    public function __construct(private TmhHtmlComponentFactory $htmlComponentFactory)
    {
    }

    public function get(array $entity): array
    {
        return [];
//        $componentNodes = [];
//        foreach ($entity as $entityList) {
//            $component = $this->htmlComponentFactory->create('entity_list');
//            $componentNodes[] = $component->get($entityList);
//        }
//        return $componentNodes;
    }
}
