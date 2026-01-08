<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhTopicTranslator implements TmhTranslator
{
    public function __construct(private TmhLocale $locale)
    {
    }

    public function translate(array $entity): array
    {
        $entity['translation'] = $this->locale->get($entity['translation']);
        return $entity;
    }
}
