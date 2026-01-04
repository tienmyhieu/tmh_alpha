<?php

namespace lib\transformers;

readonly class TmhHtmlEntityTransformer
{
    public function __construct(
        private TmhAncestorTransformer $ancestorTransformer,
        private TmhSiblingTransformer $siblingTransformer
    ) {
    }

    public function ancestors(array $htmlEntity): array
    {
        return $this->ancestorTransformer->ancestors($this->reconstituteRoute($htmlEntity));
    }

    public function siblings(array $htmlEntity): array
    {
        return $this->siblingTransformer->siblings($this->reconstituteRoute($htmlEntity));
    }

    private function reconstituteRoute(array $entity): array
    {
        return [
            'code' => $entity['code'],
            'href' => $entity['href'],
            'innerHtml' => $entity['innerHtml'],
            'title' => $entity['title'],
            'type' => $entity['type'],
            'uuid' => $entity['uuid'],
        ];
    }
}
