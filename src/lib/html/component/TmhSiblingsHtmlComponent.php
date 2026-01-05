<?php

namespace lib\html\component;

use lib\Html\TmhHtmlElementFactory;

readonly class TmhSiblingsHtmlComponent implements TmhHtmlComponent
{
    public function __construct(private TmhHtmlElementFactory $elementFactory)
    {
    }

    public function get(array $entity): array
    {
        $childNodes = [];
        $siblingKeys = array_keys($entity);
        $lastSiblingKey = $siblingKeys[count($siblingKeys) - 1];
        $lastSibling = $entity[$lastSiblingKey];
        unset($entity[$lastSiblingKey]);
        foreach ($entity as $sibling) {
            $siblingNodes = [];
            $siblingNodes[] = $this->siblingItemLink($sibling);
            $siblingNodes[] = $this->elementFactory->span([], '&nbsp;&#9675;&nbsp;');
            $childNodes[] = $this->elementFactory->siblingItem($siblingNodes);
        }
        $childNodes[] = $this->siblingItemLink($lastSibling);
        return [$this->elementFactory->siblings($childNodes)];
    }

    private function siblingItemLink(array $sibling): array
    {
        $attributes = ['lang' => $sibling['lang'], 'href' => $sibling['href'], 'title' => $sibling['title']];
        return $this->elementFactory->siblingItemLink($attributes, $sibling['innerHtml']);
    }
}
