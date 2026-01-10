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
//        echo "<pre>";
//        print_r($entity);
//        echo "</pre>";
        $translated = ['type' => $entity['type'], 'items' => []];
        foreach ($entity['items'] as $entityList) {
            $translatedEntityList = [
                'type' => $entityList['type'],
                'lang' => $entityList['lang'],
                'translation' => $this->locale->get($entityList['translation']),
                'items' => []
            ];
            foreach ($entityList['items'] as $entityItem) {
                $translator = $this->translatorFactory->create('entity_list_item');
                $translatedEntityList['items'][] = $translator->translate($entityItem);
            }
            $translated['items'][] = $translatedEntityList;
        }
        return $translated;
    }
}
