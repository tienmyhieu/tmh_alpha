<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhEntityListHtmlComponent implements TmhHtmlComponent
{
    public function __construct(private TmhHtmlElementFactory $elementFactory)
    {
    }

    public function get(array $entity, string $language): array
    {
        $componentNodes = [];
        $attributes = [];
        $useLanguage = $this->useLanguage($entity, $language);
        if ($useLanguage) {
            $attributes['lang'] = $entity['lang'];
        }
        $componentNodes[] = $this->elementFactory->listTitle($attributes, $entity['translation']);
        $componentNodes[] = $this->elementFactory->br();

        foreach ($entity['items'] as $listItem) {
            $componentNodes[] = $this->elementFactory->listItem(
                [],
                [$this->transformListItem($listItem, $language)]
            );
        }
        $componentNodes[] = $this->elementFactory->br();

        return [$this->elementFactory->entityList([], $componentNodes)];
    }

    private function transformListItem(array $listItem, string $language): array
    {
        return match($listItem['type']) {
            'route' => $this->routeListItem($listItem, $language),
            default => $this->textListItem($listItem, $language)
        };
    }

    private function routeListItem(array $listItem, string $language): array
    {
        $attributes = ['href' => $listItem['route']['href'], 'title' => $listItem['route']['title']];
        $useLanguage = $this->useLanguage($listItem, $language);
        if ($useLanguage) {
            $attributes['lang'] = $listItem['lang'];
        }
        return $this->elementFactory->listItemLink($attributes, $listItem['route']['innerHtml']);
    }

    private function textListItem(array $listItem, string $language): array
    {
        $attributes = ['class' => 'tmh_list_item'];
        $useLanguage = $this->useLanguage($listItem, $language);
        if ($useLanguage) {
            $attributes['lang'] = $listItem['lang'];
        }
        return $this->elementFactory->span($attributes, $listItem['translation']);
    }

    private function useLanguage(array $entity, string $language): bool
    {
        return 0 < strlen($entity['lang']) && $entity['lang'] != $language;
    }
}
