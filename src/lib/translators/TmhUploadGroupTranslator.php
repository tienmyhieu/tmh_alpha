<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhUploadGroupTranslator implements TmhTranslator
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
            'identifier' => $entity['identifier'],
            'uploads' => []
        ];
        if (0 < count($entity['translation'])) {
            $translated['translation'] = $this->locale->getMany($entity['translation']);
        }
        $translator = $this->translatorFactory->create('upload');
        foreach ($entity['uploads'] as $image) {
            $translated['uploads'][] = $translator->translate($image);
        }
        return $translated;
    }
}
