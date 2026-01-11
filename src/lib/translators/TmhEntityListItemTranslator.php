<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhEntityListItemTranslator implements TmhTranslator
{
    public function __construct(private TmhTranslatorFactory $translatorFactory, private TmhLocale $locale)
    {
    }

    public function translate(array $entity): array
    {
        $routeTypes = ['route', 'route2'];
        if (in_array($entity['type'], $routeTypes)) {
            $translator = $this->translatorFactory->create('route');
            $entity['route'] = $translator->translate($entity['route']);
        }
        $entity['translation'] = implode(' ', $this->locale->getMany($entity['translation']));

        return $entity;
    }
}
