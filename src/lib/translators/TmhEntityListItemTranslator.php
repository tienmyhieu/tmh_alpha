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
        $routeTypes = ['route1', 'route2', 'route3'];
        if (in_array($entity['type'], $routeTypes)) {
            $translator = $this->translatorFactory->create($entity['type']);
            $entity['route'] = $translator->translate($entity['route']);
        }
        if ($entity['type'] == 'image_route1') {
            $translator = $this->translatorFactory->create($entity['type']);
            $entity['route'] = $translator->translate($entity['route']);
            $entity['type'] = 'route1';
        }
        $entity['translation'] = implode(' ', $this->locale->getMany($entity['translation']));

        return $entity;
    }
}
