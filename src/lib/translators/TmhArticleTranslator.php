<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhArticleTranslator implements TmhTranslator
{
    public function __construct(private TmhTranslatorFactory $translatorFactor, private TmhLocale $locale)
    {
    }

    public function translate(array $entity): array
    {
        $entity['author_label'] = $this->locale->get('12jedk09');
        $entity['date_label'] = $this->locale->get('tvks4dcn');
        $translated = $entity;
        $translated['paragraphs'] = [];
        $sentenceTypes = [
            'anchored_newline_sentence',
            'bold_newline_sentence',
            'bold_sentence',
            'newline_sentence',
            'sentence'
        ];
        foreach ($entity['paragraphs'] as $paragraphItems) {
            $translatedParagraphItems = [];
            foreach ($paragraphItems as $paragraphItem) {
                if (in_array($paragraphItem['type'], $sentenceTypes)) {
                    $translatedParagraphItems[] = $paragraphItem;
                }
                if ($paragraphItem['type'] == 'image_group4') {
                    $translator = $this->translatorFactor->create($paragraphItem['type']);
                    $translatedParagraphItems[] = $translator->translate($paragraphItem);
                }
            }
            $translated['paragraphs'][] = $translatedParagraphItems;
        }
        return $translated;
    }
}
