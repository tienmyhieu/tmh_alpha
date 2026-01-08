<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhAncestorsHtmlComponent implements TmhHtmlComponent
{
    public function __construct(private TmhHtmlElementFactory $elementFactory)
    {
    }

    public function get(array $entity): array
    {
        if (count($entity)) {
            $childNodes = [];
            $lastAncestor = $entity[count($entity) - 1];
            unset($entity[count($entity) - 1]);
            foreach ($entity as $ancestor) {
                $ancestorNodes = [];
                $ancestorNodes[] = $this->ancestorItemLink($ancestor);
                $ancestorNodes[] = $this->elementFactory->span([], '&nbsp;&raquo;&nbsp;');
                $childNodes[] = $this->elementFactory->ancestorItem($ancestorNodes);
            }
            $childNodes[] = $this->elementFactory->span([], $lastAncestor['innerHtml']);
            return [$this->elementFactory->ancestors($childNodes)];
        }
        return [];
    }

    private function ancestorItemLink(array $ancestor): array
    {
        $attributes = ['href' => $ancestor['href'], 'title' => $ancestor['title']];
        return $this->elementFactory->ancestorItemLink($attributes, $ancestor['innerHtml']);
    }
}
