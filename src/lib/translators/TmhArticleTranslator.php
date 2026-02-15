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
        $transformed = $entity;
        $transformed['paragraphs'] = [];
        foreach ($entity['paragraphs'] as $paragraphItems) {
            $transformedParagraphItems = [];
            foreach ($paragraphItems as $paragraphItem) {
                if ($paragraphItem['type'] == 'sentence') {
                    $transformedParagraphItems[] = $paragraphItem;
                }
                if ($paragraphItem['type'] == 'image_group4') {
                    $translator = $this->translatorFactor->create($paragraphItem['type']);
                    $transformedParagraphItems[] = $translator->translate($paragraphItem);
                }
            }
            $transformed['paragraphs'][] = $transformedParagraphItems;
        }
        return $transformed;
    }
}
