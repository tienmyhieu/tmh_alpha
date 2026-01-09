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
        $componentNodes = [];
        $componentNodes[] = $this->elementFactory->listTitle($entity['translation']);
        $componentNodes[] = $this->elementFactory->br();

        foreach ($entity['items'] as $listItem) {
            $componentNodes[] = $this->elementFactory->listItem([$this->transformListItem($listItem)]);
        }
        $componentNodes[] = $this->elementFactory->br();

        return [$this->elementFactory->entityList($componentNodes)];
    }

    private function transformListItem(array $listItem): array
    {
        return match($listItem['type']) {
            'route' => $this->routeListItem($listItem['route']),
            default => $this->textListItem($listItem)
        };
    }

    private function routeListItem(array $listItem): array
    {
        return $this->elementFactory->listItemLink(
            [
                'href' => $listItem['href'],
                'title' => $listItem['title']
            ],
            $listItem['innerHtml']
        );
    }

    private function textListItem(array $listItem): array
    {
        $class = 'tmh_list_item';
        return $this->elementFactory->span(['class' => $class], $listItem['translation']);
    }
}
