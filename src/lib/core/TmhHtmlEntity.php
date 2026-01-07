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
        $htmlEntity = ['uuid' => $entity['uuid'], 'attributes' => []];
        foreach ($this->dynamicAttributes($entity['type']) as $attribute) {
            $htmlEntity['attributes'][$attribute] = $route;
        }
        foreach ($this->transformerAttributes($entity['type']) as $attribute) {
            $transformer = $this->transformerFactory->create($attribute);
            $htmlEntity['attributes'][$attribute] = $transformer->transform($htmlEntity['attributes'][$attribute]);
        }
        foreach ($this->translatorAttributes($entity['type']) as $attribute) {
            $translator = $this->translatorFactory->create($attribute);
            $htmlEntity['attributes'][$attribute] = $translator->translate($htmlEntity['attributes'][$attribute]);
        }
        foreach ($this->entityAttributes($entity['type']) as $attribute) {
            if (in_array($attribute, array_keys($entity))) {
                $translator = $this->translatorFactory->create($attribute);
                $htmlEntity['attributes'][$attribute] = $translator->translate($entity[$attribute]);
            }
        }
        return $htmlEntity;
    }

    private function dynamicAttributes(string $type): array
    {
        return $type == 'article' ? self::DYNAMIC_ATTRIBUTES : array_merge(['siblings'], self::DYNAMIC_ATTRIBUTES);
    }

    private function entityAttributes(string $type): array
    {
        return ['topics'];
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
        return array_merge(self::DYNAMIC_ATTRIBUTES, []);
    }
}
