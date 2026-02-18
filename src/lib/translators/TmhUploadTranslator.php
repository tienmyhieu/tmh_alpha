<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhUploadTranslator implements TmhTranslator
{
    public function __construct(private TmhTranslatorFactory $translatorFactory, private TmhLocale $locale)
    {
    }

    public function translate(array $entity): array
    {
        return $this->routedUpload($entity);
    }

    private function routedUpload(array $entity): array
    {
        $routeTranslator = $this->translatorFactory->create('route1');
        return [
            'alt' => implode( ' ', $this->locale->getMany($entity['alt'])),
            'src' => $entity['src'],
            'route' => $routeTranslator->translate($entity['route'])
        ];
    }
}
