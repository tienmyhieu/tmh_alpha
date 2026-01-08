<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhEntityListsTranslator implements TmhTranslator
{
    public function __construct(private TmhTranslatorFactory $translatorFactory, private TmhLocale $locale)
    {
    }

    public function translate(array $entity): array
    {
        $translated = [];
        foreach ($entity['items'] as $entityList) {
            $translatedEntityList = ['translation' => $this->locale->get($entityList['translation']), 'items' => []];
            foreach ($entityList['items'] as $entityItem) {
                $translator = $this->translatorFactory->create('entity_list_item');
                $translatedEntityList['items'][] = $translator->translate($entityItem);
            }
            $translated[] = $translatedEntityList;
        }
        return $translated;
    }
}
