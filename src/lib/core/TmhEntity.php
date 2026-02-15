<?php

namespace lib\core;

use lib\transformers\TmhTransformerFactory;

readonly class TmhEntity
{
    public function __construct(
        private TmhJson $json,
        private TmhRoute $route,
        private TmhTransformerFactory $transformerFactory
    ) {
    }

    public function get(): array
    {
        $route = $this->route->hydrate($this->route->getCurrentRoute());
        $entity = $this->transform($this->byRouteCode($route['code']), $route);
        return array_merge($route, $entity);
    }

    private function byRouteCode(string $routeCode): array
    {
        $pathParts = explode('.', $routeCode);
        $entityFile = $pathParts[count($pathParts) - 1];
        unset($pathParts[count($pathParts) - 1]);
        $entityDirectory = implode('/', $pathParts);
        return $this->json->entity($entityDirectory, $entityFile);
    }

    private function transform(array $entity, array $route): array
    {
        $transformed = [];
        $transformers = $this->transformers($route['type']);
        foreach ($entity as $entityAttribute) {
            if (in_array($entityAttribute['type'], $transformers)) {
                $transformer = $this->transformerFactory->create($entityAttribute['type']);
                $transformed[] = $transformer->transform($entityAttribute);
            } else {
                $transformed[] = $entityAttribute;
            }
        }
        return $transformed;
    }

    private function transformers(string $type): array
    {
        return ['entity_lists', 'image_gallery', 'article'];
    }
}
