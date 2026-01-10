<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhTitleHtmlComponent implements TmhHtmlComponent
{
    public function __construct(private TmhHtmlElementFactory $elementFactory)
    {
    }

    public function get(array $entity, string $language): array
    {
        $attributes = [];
        $useLanguage = 0 < strlen($entity['lang']) && $entity['lang'] != $language;
        if ($useLanguage) {
            $attributes['lang'] = $entity['lang'];
        }
        return $this->elementFactory->pageTitle($attributes, $entity['translation']);
    }
}
