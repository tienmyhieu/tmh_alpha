<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhTopicHtmlComponent implements TmhHtmlComponent
{
    public function __construct(
        private TmhHtmlComponentFactory $htmlComponentFactory,
        private TmhHtmlElementFactory $elementFactory
    ) {
    }

    public function get(array $entity): array
    {
        $componentNodes = [$this->elementFactory->topic('topic', $entity['translation'])];
        foreach (array_keys($entity) as $topicComponent) {
            if ($topicComponent != 'translation') {
                $component = $this->htmlComponentFactory->create($topicComponent);
                $componentNodes = array_merge($componentNodes, $component->get($entity[$topicComponent]));
            }
        }
        return $componentNodes;
    }
}
