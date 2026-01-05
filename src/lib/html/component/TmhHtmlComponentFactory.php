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
            'siblings' => new TmhSiblingsHtmlComponent($this->elementFactory),
            'topics' => new TmhTopicsHtmlComponent($this->elementFactory),
            default => new TmhTitlesHtmlComponent($this->elementFactory),
        };
    }
}
