<?php

namespace lib\transformers;

readonly class TmhHtmlEntityTransformer
{
    public function __construct(
        private TmhAncestorTransformer $ancestorTransformer,
        private TmhMetadataTransformer $metadataTransformer,
        private TmhSiblingTransformer $siblingTransformer
    ) {
    }

    public function ancestors(array $htmlEntity): array
    {
        return $this->ancestorTransformer->transform($this->reconstituteRoute($htmlEntity));
    }

    public function metadata(array $htmlEntity): array
    {
        return $this->metadataTransformer->transform($this->reconstituteRoute($htmlEntity));
    }

    public function siblings(array $htmlEntity): array
    {
        return $this->siblingTransformer->transform($this->reconstituteRoute($htmlEntity));
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
