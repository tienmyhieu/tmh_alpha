<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhVerticalQuoteListTranslator implements TmhTranslator
{
    public function __construct(private TmhLocale $locale)
    {
    }

    public function translate(array $entity): array
    {
        return $entity;
    }
}
