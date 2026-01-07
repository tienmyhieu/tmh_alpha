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
        $entity = $this->byRouteCode($route['code']);
        foreach ($this->transformers($route['type']) as $transformerName) {
            $transformer = $this->transformerFactory->create($transformerName);
            $entity[$transformerName] = $transformer->transform($entity[$transformerName]);
        }
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

    private function transformers(string $type): array
    {
        return match($type) {
          'toc' => ['topics']
        };
    }
}
