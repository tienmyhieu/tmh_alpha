<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhImageGalleryTranslator implements TmhTranslator
{
    public function __construct(private TmhTranslatorFactory $translatorFactor, private TmhLocale $locale)
    {
    }

    public function translate(array $entity): array
    {
        $translated = ['type' => $entity['type'], 'translation' => $entity['translation'], 'items' => []];
        if (0 < strlen($entity['translation'])) {
            $translated['translation'] = $this->locale->get($entity['translation']);
        }
        foreach ($entity['items'] as $imageGroup) {
            $translator = $this->translatorFactor->create($imageGroup['type']);
            $translated['items'][] = $translator->translate($imageGroup);
        }
        return $translated;
    }
}
