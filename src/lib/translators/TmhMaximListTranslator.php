<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhMaximListTranslator implements TmhTranslator
{
    public function __construct(private TmhTranslatorFactory $translatorFactory, private TmhLocale $locale)
    {
    }

    public function translate(array $entity): array
    {
        $currentLocale = $this->locale->currentLocale();
        $localizedItems = $this->localizeItems($entity['items'], $currentLocale);
        $translatedItems = [];
        $citationTranslator = $this->translatorFactory->create('citation');
        foreach ($localizedItems as $localizedItem) {
            $translatedItem = $localizedItem;
            $translatedItem['lang'] = substr($localizedItem['lang'], 0, 2);
            $translatedCitations = [];
            foreach ($localizedItem['translation']['citations'] as $citation) {
                $translatedCitation = $citationTranslator->translate($citation);
                $translatedCitations[] = $translatedCitation['citation'];
            }
            $translatedItem['translation']['citations'] = $translatedCitations;
            $translatedItems[] = $translatedItem;
        }
        $entity['items'] = $translatedItems;
        return $entity;
    }

    private function localizeItems(array $items, string $locale): array
    {
        return array_filter($items, function($item) use ($locale) {
            return $item['lang'] == $locale;
        });
    }
}
