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
        $childNodes = [$this->byLine($entity, $language)];
        $withNewlines = ['anchored_newline_sentence', 'bold_newline_sentence', 'newline_sentence'];
        foreach ($entity['paragraphs'] as $paragraphItems) {
            $paragraphNodes = [];
            foreach ($paragraphItems as $paragraphItem) {
                $paragraphNodes[] = match($paragraphItem['type']) {
                    'image_group4' => $this->imageGroup($paragraphItem, $language),
                    default => $this->sentence($paragraphItem, $language)
                };
                if (in_array($paragraphItem['type'], $withNewlines)) {
                    $paragraphNodes[] = $this->elementFactory->br();
                }
            }
            $childNodes[] = $this->elementFactory->p($paragraphNodes);
        }
        return $this->elementFactory->article([], $childNodes);
    }

    private function byLine(array $entity, string $language): array
    {
        $byLine = $entity['author_label'] . ': ' . $entity['author'];
        if (0 < strlen($entity['date'])) {
            $byLine .= ' - ' . $entity['date_label'] . ': ' . $entity['date'];
        }
        $attributes = ['class' => 'tmh_quote_list_horizontal'];
        $useLanguage = $entity['lang'] != $language;
        if ($useLanguage) {
            $attributes['lang'] = $entity['lang'];
        }
        return $this->elementFactory->span($attributes, $byLine);
    }

    private function imageGroup(array $paragraphItem, string $language): array
    {
        $imageGroupFactory = $this->componentFactory->create('image_gallery_item');
        return $imageGroupFactory->get($paragraphItem, $language);
    }

    private function sentence(array $paragraphItem, string $language): array
    {
        $attributes = ['class' => 'tmh_' . $paragraphItem['type']];
        $useLanguage = $paragraphItem['lang'] != $language;
        if ($useLanguage) {
            $attributes['lang'] = $paragraphItem['lang'];
        }
        return $this->elementFactory->span($attributes, $paragraphItem['text']);
    }
}
