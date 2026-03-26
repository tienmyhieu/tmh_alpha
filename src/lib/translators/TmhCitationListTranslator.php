<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhCitationListTranslator implements TmhTranslator
{
    public function __construct(private TmhTranslatorFactory $translatorFactory)
    {
    }

    public function translate(array $entity): array
    {
        $citationTranslator = $this->translatorFactory->create('citation');
        $translated = $entity;
        $translatedCitations = [];
        foreach ($entity['items'] as $citation) {
            $translatedCitation = $citationTranslator->translate($citation);
            $translatedCitations[] = [
                'citation' => $translatedCitation['citation'],
                'lang' => $citation['lang']
            ];
        }
        $translated['items'] = $translatedCitations;
        return $translated;
    }
}
