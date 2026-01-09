<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhEntityListHtmlComponent implements TmhHtmlComponent
{
    public function __construct(private TmhHtmlElementFactory $elementFactory)
    {
    }

    public function get(array $entity): array
    {
        return [];
//        $componentNodes = [];
//        $componentNodes[] = $this->elementFactory->listTitle($entity['translation']);
//        $componentNodes[] = $this->elementFactory->br();
//        return $componentNodes;
    }
}
