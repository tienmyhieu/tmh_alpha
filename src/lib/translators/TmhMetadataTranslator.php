<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhMetadataTranslator implements TmhTranslator
{
    public function __construct(private TmhLocale $locale)
    {
    }

    public function translate(array $entity): array
    {
        return [
            'description' => implode(' ', $this->locale->getMany($entity['description'])),
            'documentTitle' => implode(' ', $this->locale->getMany($entity['documentTitle'])),
            'keywords' => implode(', ', $this->locale->getMany($entity['keywords'])),
            'lang' => $entity['lang']
        ];
    }
}
