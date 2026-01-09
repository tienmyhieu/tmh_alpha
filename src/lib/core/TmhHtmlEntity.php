<?php

namespace lib\core;

use lib\transformers\TmhTransformerFactory;
use lib\translators\TmhTranslatorFactory;

readonly class TmhHtmlEntity
{
    private const array DYNAMIC_ATTRIBUTES = ['ancestors', 'metadata'];

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
        $entity = $this->unsetRouteAttributes($entity, $route);
        $htmlEntity = ['uuid' => $route['uuid'], 'attributes' => []];
        foreach ($this->dynamicAttributes($route['type']) as $attribute) {
            $htmlEntity['attributes'][$attribute] = $route;
        }
        foreach ($this->transformerAttributes($route['type']) as $attribute) {
            $transformer = $this->transformerFactory->create($attribute);
            $htmlEntity['attributes'][$attribute] = $transformer->transform($htmlEntity['attributes'][$attribute]);
        }
        foreach ($this->translatorAttributes($route['type']) as $attribute) {
            $translator = $this->translatorFactory->create($attribute);
            $htmlEntity['attributes'][$attribute] = $translator->translate($htmlEntity['attributes'][$attribute]);
        }
        $entityAttributes = $this->entityAttributes($route['type']);
        foreach ($entity as $attribute) {
            if (in_array($attribute['type'], $entityAttributes)) {
                $translator = $this->translatorFactory->create($attribute['type']);
                $htmlEntity['attributes'][$attribute['type']] = $translator->translate($attribute);
            }
        }
        return $htmlEntity;
    }

    private function dynamicAttributes(string $type): array
    {
        return match ($type) {
            'article' => self::DYNAMIC_ATTRIBUTES,
            'toc' => ['siblings', 'metadata'],
            default => array_merge(['siblings'], self::DYNAMIC_ATTRIBUTES)
        };
    }

    private function entityAttributes(string $type): array
    {
        return ['title', 'topic', 'entity_lists'];
    }

    private function unsetRouteAttributes(array $entity, array $route): array
    {
        foreach (array_keys($route) as $attribute) {
            unset($entity[$attribute]);
        }
        return $entity;
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

    private function transformerAttributes(string $type): array
    {
        return array_merge($this->dynamicAttributes($type), []);
    }

    private function translatorAttributes(string $type): array
    {
        return match ($type) {
            'toc' => ['metadata'],
            default => self::DYNAMIC_ATTRIBUTES
        };
    }
}
