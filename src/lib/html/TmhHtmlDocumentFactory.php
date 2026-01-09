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
        $lang = $entity['attributes']['metadata']['lang'];
        $nodes = $this->elementFactory->html([$this->head($entity), $this->body($entity)], $lang);
        return $this->nodeTransformer->toHtml($nodes);
    }

    private function body(array $entity): array
    {
        $childNodes = [];
        unset($entity['attributes']['metadata']);
        foreach ($entity['attributes'] as $key => $attribute) {
            $htmlComponent = $this->htmlComponentFactory->create($key);
            $component = $htmlComponent->get($attribute);
            if (count($component)) {
                $childNodes[] = $this->elementFactory->component([$component]);
            }
        }
        $marginLeft = $this->elementFactory->marginLeft();
        $center = $this->elementFactory->center($childNodes);
        $marginRight = $this->elementFactory->marginRight();
        $body = $this->elementFactory->contentBody([$marginLeft, $center, $marginRight]);
        return $this->elementFactory->body([], [$body]);
    }

    private function head(array $entity): array
    {
        $metadata = $entity['attributes']['metadata'];
        return $this->elementFactory->head($metadata['description'], $metadata['keywords'], $metadata['documentTitle']);
    }
}
