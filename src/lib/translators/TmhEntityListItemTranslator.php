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
        $imageRouteTypes = ['image_route1', 'image_route2'];
        $routeTypes = ['route1', 'route2', 'route3'];
        if (in_array($entity['type'], $routeTypes)) {
            $translator = $this->translatorFactory->create($entity['type']);
            $entity['route'] = $translator->translate($entity['route']);
        }
        if (in_array($entity['type'], $imageRouteTypes)) {
            $routeType = $entity['type'] == 'image_route1' ? 'route1' : 'route4';
            $translator = $this->translatorFactory->create($entity['type']);
            $entity['route'] = $translator->translate($entity['route']);
            $entity['type'] = $routeType;
        }
        $entity['translation'] = implode(' ', $this->locale->getMany($entity['translation']));

        return $entity;
    }
}
