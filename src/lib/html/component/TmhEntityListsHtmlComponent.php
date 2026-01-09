<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhEntityListsHtmlComponent implements TmhHtmlComponent
{
    public function __construct(
        private TmhHtmlComponentFactory $htmlComponentFactory,
        private TmhHtmlElementFactory $elementFactory
    ) {
    }

    public function get(array $entity): array
    {
        $componentLists = [];
        foreach ($entity['items'] as $entityList) {
            $htmlComponent = $this->htmlComponentFactory->create($entityList['type']);
            $componentLists[] = $this->elementFactory->componentList($htmlComponent->get($entityList));
        }
        return $this->elementFactory->componentGroup($componentLists);
    }
}
