<?php

namespace lib\html;

use lib\html\component\TmhHtmlComponentFactory;

readonly class TmhHtmlDocumentFactory
{
    public function __construct(
        private TmhHtmlElementFactory $elementFactory,
        private TmhHtmlComponentFactory $htmlComponentFactory,
        private TmhHtmlNodeTransformer $nodeTransformer
    ) {
    }

    public function create(array $entity): string
    {
        $lang = $entity['metadata']['lang'];
        $nodes = $this->elementFactory->html([$this->head($entity), $this->body($entity)], $lang);
        return $this->nodeTransformer->toHtml($nodes);
    }

    private function body(array $entity): array
    {
        return $this->elementFactory->body([], []);
    }

    private function head(array $entity): array
    {
        $metadata = $entity['metadata'];
        return $this->elementFactory->head($metadata['description'], $metadata['keywords'], $metadata['documentTitle']);
    }
}
