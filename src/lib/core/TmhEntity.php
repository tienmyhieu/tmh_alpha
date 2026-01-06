<?php

namespace lib\core;

readonly class TmhEntity
{
    public function __construct(private TmhJson $json, private TmhRoute $route)
    {
    }

    public function get(): array
    {
        $route = $this->route->hydrate($this->route->getCurrentRoute());
        if ($route['type'] == 'metal_emperor_coin_specimen') {
            $codeParts = explode('.', $route['code']);
            $route['innerHtml'] = str_replace('_', ' ', $codeParts[count($codeParts) - 1]);
        }
        $entity = $this->byRouteCode($route['code']);
        return array_merge($route, $entity);
    }

    public function byRouteCode(string $routeCode): array
    {
        $pathParts = explode('.', $routeCode);
        $entityFile = $pathParts[count($pathParts) - 1];
        unset($pathParts[count($pathParts) - 1]);
        $entityDirectory = implode('/', $pathParts);
        return $this->json->entity($entityDirectory, $entityFile);
    }
}