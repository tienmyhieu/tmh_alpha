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
        $nodes = $this->elementFactory->html([$this->head($entity['metadata']), $this->body($entity)], $lang);
        return $this->nodeTransformer->toHtml($nodes);
    }

    private function body(array $entity): array
    {
        $childNodes = [];
        $language = $entity['metadata']['lang'];
        foreach ($entity['attributes'] as $attribute) {
            $htmlComponent = $this->htmlComponentFactory->create($attribute['type']);
            $component = $htmlComponent->get($attribute, $language);
            if (count($component)) {
                $childNodes[] = $this->elementFactory->component([], [$component]);
            }
        }
        $marginLeft = $this->elementFactory->marginLeft([]);
        $center = $this->elementFactory->center([], $childNodes);
        $marginRight = $this->elementFactory->marginRight([]);
        $body = $this->elementFactory->contentBody([], [$marginLeft, $center, $marginRight]);
        return $this->elementFactory->body([], [$body]);
    }

    private function head(array $entity): array
    {
        return $this->elementFactory->head($entity['description'], $entity['keywords'], $entity['documentTitle']);
    }
}
