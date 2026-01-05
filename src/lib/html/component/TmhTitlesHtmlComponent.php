<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

class TmhTitlesHtmlComponent implements TmhHtmlComponent
{
    public function __construct(private TmhHtmlElementFactory $elementFactory)
    {
    }

    public function get(array $entity): array
    {
        return [];
    }
}
