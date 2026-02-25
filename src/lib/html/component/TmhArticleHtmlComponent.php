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
                    'upload_group1' => $this->uploadGroup($paragraphItem, $language),
                    'anchor_route' => $this->anchorRoute($paragraphItem['text']),
                    'table' => $this->table($paragraphItem, $language),
                    'named_route' => $this->createNamedRoute($paragraphItem['text']),
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
        if ($paragraphItem['type'] == 'bold_newline_sentence') {
            $paragraphItem['type'] = 'bold_sentence';
        }
        $attributes = ['class' => 'tmh_' . $paragraphItem['type']];
        $useLanguage = $paragraphItem['lang'] != $language;
        if ($useLanguage) {
            $attributes['lang'] = $paragraphItem['lang'];
        }
        return $this->elementFactory->span($attributes, $paragraphItem['text']);
    }

    private function uploadGroup(array $paragraphItem, string $language): array
    {
        $uploadGroupFactory = $this->componentFactory->create('upload_group');
        return $uploadGroupFactory->get($paragraphItem, $language);
    }

    private function anchorRoute(string $text): array
    {
        $attributes = ['href' => $this->articleUrl() . '#ref_' . $text, 'title' => $text];
        return $this->elementFactory->listItemLink($attributes, '&nbsp;[' . $text . ']&nbsp;');
    }

    private function articleUrl(): string
    {
        return $_SERVER['REQUEST_SCHEME'] . '://' . $_SERVER['SERVER_NAME'] . $_SERVER['REDIRECT_URL'];
    }

    private function table(array $paragraphItem, string $language): array
    {
        $rows = [];
        foreach ($paragraphItem['rows'] as $rowCells) {
            $cells = [];
            foreach ($rowCells as $rowCell) {
                $attributes = ['colspan' => $rowCell['colspan'], 'class' => 'tmh_table_cell'];
                $useLanguage = $rowCell['lang'] != $language;
                if ($useLanguage) {
                    $attributes['lang'] = $rowCell['lang'];
                }
                $cells[] = $this->elementFactory->td($attributes, $rowCell['text']);
            }
            $rows[] = $this->elementFactory->tr('tmh_table_row', $cells);
        }
        return $this->elementFactory->table('tmh_table', $rows);
    }

    private function createNamedRoute(string $text): array
    {
        $name = 'ref_' . $text;
        $attributes = ['href' => $this->articleUrl() . '#' . $name, 'name' => $name, 'title' => $text];
        return $this->elementFactory->listItemLink($attributes, '[' . $text . ']&nbsp;');
    }
}
