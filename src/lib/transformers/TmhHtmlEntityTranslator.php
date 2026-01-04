<?php

namespace lib\transformers;

use lib\core\TmhLocale;

readonly class TmhHtmlEntityTranslator
{
    public function __construct(private TmhLocale $locale)
    {
    }

    public function translate(array $entity): array
    {
        return $entity;
    }
}
