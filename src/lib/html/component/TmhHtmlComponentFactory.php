<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhHtmlComponentFactory
{
    public function __construct(private TmhHtmlElementFactory $elementFactory)
    {
    }

    public function create(string $type): TmhHtmlComponent
    {
        return match ($type) {
            'ancestors' => new TmhAncestorsHtmlComponent($this->elementFactory),
            'entity_list' => new TmhEntityListHtmlComponent($this->elementFactory),
            'entity_lists' => new TmhEntityListsHtmlComponent($this),
            'siblings' => new TmhSiblingsHtmlComponent($this->elementFactory),
            'topic' => new TmhTopicHtmlComponent($this->elementFactory),
            'title' => new TmhTitleHtmlComponent($this->elementFactory),
        };
    }
}
