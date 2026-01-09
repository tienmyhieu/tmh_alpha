<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhTitleHtmlComponent implements TmhHtmlComponent
{
    public function __construct(private TmhHtmlElementFactory $elementFactory)
    {
    }

    public function get(array $entity): array
    {
        return $this->elementFactory->pageTitle($entity['translation']);
    }
}
