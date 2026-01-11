<?php

namespace lib\html\component;

use lib\Html\TmhHtmlElementFactory;

readonly class TmhSiblingsHtmlComponent implements TmhHtmlComponent
{
    public function __construct(private TmhHtmlElementFactory $elementFactory)
    {
    }

    public function get(array $entity, string $language): array
    {
        $childNodes = [];
        $siblingKeys = array_keys($entity['items']);
        $lastSiblingKey = $siblingKeys[count($siblingKeys) - 1];
        $lastSibling = $entity['items'][$lastSiblingKey];
        unset($entity[$lastSiblingKey]);
        foreach ($entity['items'] as $sibling) {
            $siblingNodes = [];
            $siblingNodes[] = $this->siblingItemLink($sibling, $language);
            $siblingNodes[] = $this->elementFactory->span([], '&nbsp;&#9675;&nbsp;');
            $childNodes[] = $this->elementFactory->siblingItem([], $siblingNodes);
        }
        $childNodes[] = $this->siblingItemLink($lastSibling, $language);
        return $this->elementFactory->siblings([], $childNodes);
    }

    private function siblingItemLink(array $sibling, string $language): array
    {
        $useLanguage = $sibling['lang'] != $language;
        $attributes = ['href' => $sibling['href'], 'title' => trim($sibling['title'])];
        if ($useLanguage) {
            $attributes['lang'] = $sibling['lang'];
        }
        return $this->elementFactory->siblingItemLink($attributes, $sibling['innerHtml']);
    }
}
