<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhImageGroupTranslator implements TmhTranslator
{
    public function __construct(private TmhTranslatorFactory $translatorFactory, private TmhLocale $locale)
    {
    }

    public function translate(array $entity): array
    {
        $translated = [
            'type' => $entity['type'],
            'lang' => $entity['lang'],
            'translation' => $entity['translation'],
            'date' => $entity['date'],
            'identifier' => $entity['identifier'],
            'images' => []
        ];
        if (0 < count($entity['translation'])) {
            $translated['translation'] = $this->locale->getMany($entity['translation']);
        }
        $translator = $this->translatorFactory->create('image');
        foreach ($entity['images'] as $image) {
            $translated['images'][] = $translator->translate($image);
        }
        return $translated;
    }
}
