<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhVerticalQuoteListHtmlComponent implements TmhHtmlComponent
{
    public function __construct(private TmhHtmlElementFactory $elementFactory)
    {
    }

    public function get(array $entity, string $language): array
    {
        $quoteItems = [];
        foreach ($entity['items'] as $rawQuoteItem) {
            $attributes = [];
            $useLanguage = $rawQuoteItem['lang'] != $language;
            if ($useLanguage) {
                $attributes['lang'] = $rawQuoteItem['lang'];
            }
            $span = $this->elementFactory->span($attributes, $rawQuoteItem['value']);
            $quoteItems[] = $this->elementFactory->verticalQuoteListItem([], [$span]);
        }
        $quoteListNodes = [$this->elementFactory->quoteListVertical([], $quoteItems)];
        return $this->elementFactory->quoteList([], $quoteListNodes);
    }
}
