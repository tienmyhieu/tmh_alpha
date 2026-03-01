<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhMaximListHtmlComponent implements TmhHtmlComponent
{
    public function __construct(private TmhHtmlElementFactory $elementFactory)
    {
    }

    public function get(array $entity, string $language): array
    {
        $listItemNodes = [];
        foreach ($entity['items'] as $listItem) {
            $span = $this->elementFactory->span([], $listItem['translation']['text']);
            $maximNodes = [$span, $this->elementFactory->br()];
            foreach ($listItem['translation']['citations'] as $citation) {
                $maximNodes[] = $this->elementFactory->indentedSmallText($citation);
                $maximNodes[] = $this->elementFactory->br();
            }
            $listItemNodes[] = $this->elementFactory->listItem([], $maximNodes);
        }
        $listItemNodes[] = $this->elementFactory->br();
        return $this->elementFactory->maxims([], $listItemNodes);
    }
}
