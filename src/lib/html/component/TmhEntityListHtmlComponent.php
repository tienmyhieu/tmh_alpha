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
        if (0 < strlen($entity['translation'])) {
            $componentNodes[] = $this->elementFactory->listTitle($attributes, $entity['translation']);
            $componentNodes[] = $this->elementFactory->br();
        }

        foreach ($entity['items'] as $listItem) {
            $componentNodes[] = $this->elementFactory->listItem(
                [],
                [$this->transformListItem($listItem, $language)]
            );
        }
        $componentNodes[] = $this->elementFactory->br();

        return [$this->elementFactory->entityList([], $componentNodes)];
    }

    private function routeAttributes(array $listItem, string $language): array
    {
        $attributes = ['href' => $listItem['route']['href'], 'title' => $listItem['route']['title']];
        $useLanguage = $this->useLanguage($listItem, $language);
        if ($useLanguage) {
            $attributes['lang'] = $listItem['lang'];
        }
        return $attributes;
    }

    private function routeTypeOneListItem(array $listItem, string $language): array
    {
        $attributes = $this->routeAttributes($listItem, $language);
        return $this->elementFactory->listItemLink($attributes, $listItem['route']['innerHtml']);
    }

    private function routeTypeTwoListItem(array $listItem, string $language): array
    {
        $attributes = $this->routeAttributes($listItem, $language);
        $listItem['route']['innerHtml'] = $listItem['identifier'] . ' - ' . $listItem['route']['innerHtml'];
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

    private function transformListItem(array $listItem, string $language): array
    {
        return match($listItem['type']) {
            'route1' => $this->routeTypeOneListItem($listItem, $language),
            'route2' => $this->routeTypeTwoListItem($listItem, $language),
            default => $this->textListItem($listItem, $language)
        };
    }

    private function useLanguage(array $entity, string $language): bool
    {
        return 0 < strlen($entity['lang']) && $entity['lang'] != $language;
    }
}
