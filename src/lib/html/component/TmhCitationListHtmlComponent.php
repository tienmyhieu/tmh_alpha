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
            if (is_array($listItem['url'])) {
                $listItemNodes[] = $this->externalUrl($listItem['url'], $attributes);
            } else {
                $listItemNodes[] = $this->elementFactory->span($attributes, $listItem['citation']);
            }

            $listItemNodes[] = $br;
        }
        return $this->elementFactory->citations([], $listItemNodes);
    }

    private function useLanguage(array $entity, string $language): bool
    {
        return 0 < strlen($entity['lang']) && $entity['lang'] != $language;
    }

    private function externalUrl(array $url, array $attributes): array
    {
        $baseUrl = 'http://img1.tienmyhieu.com/';
        $svgLink = match($url['type']) {
            'pdf' => $baseUrl . 'pdf.svg',
            default => $baseUrl . 'external-link.svg'
        };
        $svg = $this->elementFactory->svgImg($svgLink);
        $span = $this->elementFactory->span($attributes, $url['translation']);
        $link = $this->elementFactory->externalListItemLink(
            [
                'href' =>$url['url'],
                'title' => $url['translation']
            ],
            '',
            [$span, $svg]
        );
        return $this->elementFactory->listItem($attributes, [$link]);
    }
}
