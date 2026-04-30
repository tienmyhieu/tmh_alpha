<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhImageGalleryTranslator implements TmhTranslator
{
    public function __construct(private TmhTranslatorFactory $translatorFactory)
    {
    }

    public function translate(array $entity): array
    {
        $translated = ['type' => $entity['type'], 'items' => []];
        foreach ($entity['items'] as $imageGroup) {
            $translator = $this->translatorFactory->create($imageGroup['type']);
            $translated['items'][] = $translator->translate($imageGroup);
        }
        return $translated;
    }
}
