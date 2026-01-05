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
        $i = 0;
        foreach ($entity as $sibling) {
            $siblingNodes = [];
            $attributes = [
                'lang' => $sibling['lang'],
                'href' => $sibling['href'],
                'title' => $sibling['title']
            ];
            $siblingNodes[] = $this->elementFactory->siblingItemLink($attributes, $sibling['innerHtml']);
            if ($i < count($entity) - 1) {
                $siblingNodes[] = $this->elementFactory->span([], '&nbsp;&#9675;&nbsp;');
            }
            $childNodes[] = $this->elementFactory->siblingItem($siblingNodes);
            $i++;
        }
        return [$this->elementFactory->siblings($childNodes)];
    }
}
