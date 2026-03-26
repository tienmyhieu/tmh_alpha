<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhCitationListHtmlComponent implements TmhHtmlComponent
{
    public function __construct(private TmhHtmlElementFactory $elementFactory)
    {
    }

    public function get(array $entity, string $language): array
    {
        $listItemNodes = [];
        $br = $this->elementFactory->br();
        foreach ($entity['items'] as $listItem) {
            $attributes = ['class' => 'tmh_list_item'];
            $useLanguage = $this->useLanguage($listItem, $language);
            if ($useLanguage) {
                $attributes['lang'] = $listItem['lang'];
            }
            $listItemNodes[] = $this->elementFactory->span($attributes, $listItem['citation']);
            $listItemNodes[] = $br;
        }
        return $this->elementFactory->citations([], $listItemNodes);
    }

    private function useLanguage(array $entity, string $language): bool
    {
        return 0 < strlen($entity['lang']) && $entity['lang'] != $language;
    }
}
