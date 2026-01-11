<?php

namespace lib\core;

use lib\transformers\TmhTransformerFactory;
use lib\translators\TmhTranslatorFactory;

readonly class TmhHtmlEntity
{
    public function __construct(
        private TmhEntity $entity,
        private TmhTransformerFactory $transformerFactory,
        private TmhTranslatorFactory $translatorFactory
    ) {
    }

    public function get(): array
    {
        $entity = $this->entity->get();
        $route = $this->reconstituteRoute($entity);
        $htmlEntity = ['uuid' => $route['uuid'], 'attributes' => []];
        $htmlEntity['metadata'] = $this->metadata($route);
        if ($entity['type'] != 'article') {
            $htmlEntity['attributes'][] = $this->siblings($route);
        }
        if ($entity['type'] != 'toc') {
            $htmlEntity['attributes'][] = $this->ancestors($route);
        }
        $entity = $this->unsetRouteAttributes($entity, $route);
        foreach ($entity as $attribute) {
            $translator = $this->translatorFactory->create($attribute['type']);
            $htmlEntity['attributes'][] = $translator->translate($attribute);
        }
        return $htmlEntity;
    }

    private function ancestors(array $route): array
    {
        $transformer = $this->transformerFactory->create('ancestors');
        $translator = $this->translatorFactory->create('ancestors');
        return ['type' => 'ancestors', 'items' => $translator->translate($transformer->transform($route))];
    }

    private function metadata(array $route): array
    {
        $transformer = $this->transformerFactory->create('metadata');
        $translator = $this->translatorFactory->create('metadata');
        return $translator->translate($transformer->transform($route));
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

    private function siblings(array $route): array
    {
        $transformer = $this->transformerFactory->create('siblings');
        return ['type' => 'siblings', 'items' => $transformer->transform($route)];
    }

    private function unsetRouteAttributes(array $entity, array $route): array
    {
        foreach (array_keys($route) as $attribute) {
            unset($entity[$attribute]);
        }
        return $entity;
    }
}
