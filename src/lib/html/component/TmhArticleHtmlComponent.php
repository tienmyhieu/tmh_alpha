<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhArticleHtmlComponent implements TmhHtmlComponent
{
    public function __construct(
        private TmhHtmlComponentFactory $componentFactory,
        private TmhHtmlElementFactory $elementFactory
    ) {
    }

    public function get(array $entity, string $language): array
    {
        $childNodes = [];

        $byLine = $entity['author_label'] . ': ' . $entity['author'];
        if (0 < strlen($entity['date'])) {
            $byLine .= ' - ' . $entity['date_label'] . ': ' . $entity['date'];
        }
        $attributes = ['class' => 'tmh_quote_list_horizontal'];
        $useLanguage = $entity['lang'] != $language;
        if ($useLanguage) {
            $attributes['lang'] = $entity['lang'];
        }
        $childNodes[] = $this->elementFactory->span($attributes, $byLine);

        foreach ($entity['paragraphs'] as $paragraphItems) {
            $paragraphNodes = [];
            foreach ($paragraphItems as $paragraphItem) {
                if ($paragraphItem['type'] == 'sentence') {
                    $attributes = ['class' => 'tmh_sentence'];
                    $useLanguage = $paragraphItem['lang'] != $language;
                    if ($useLanguage) {
                        $attributes['lang'] = $paragraphItem['lang'];
                    }
                    $paragraphNodes[] = $this->elementFactory->span($attributes, $paragraphItem['text']);
                } else {
                    $imageGroupFactory = $this->componentFactory->create('image_gallery_item');
                    $paragraphNodes[] = $imageGroupFactory->get($paragraphItem, $language);
                }
            }
            $childNodes[] = $this->elementFactory->p($paragraphNodes);
        }
        return $this->elementFactory->article([], $childNodes);
    }
}
