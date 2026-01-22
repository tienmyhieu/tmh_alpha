<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhImageTranslator implements TmhTranslator
{
    public function __construct(private TmhTranslatorFactory $translatorFactory, private TmhLocale $locale)
    {
    }

    public function translate(array $entity): array
    {
        return match($entity['route']['type']) {
            'image1' => $this->notRoutedImage($entity),
            default => $this->routedImage($entity)
        };
    }

    private function notRoutedImage(array $entity): array
    {
        $title = implode( ' ', $this->locale->getMany($entity['alt']));
        return [
            'alt' => $title,
            'src' => $entity['src'],
            'route' => [
                'title' => $title,
                'href' => str_replace('/128/', '/1024/', $entity['src'])
            ]
        ];
    }

    private function routedImage(array $entity): array
    {
        $routeTranslator = $this->translatorFactory->create('route1');
        return [
            'alt' => implode( ' ', $this->locale->getMany($entity['alt'])),
            'src' => $entity['src'],
            'route' => $routeTranslator->translate($entity['route'])
        ];
    }
}
