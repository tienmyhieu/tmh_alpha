<?php

namespace lib\core;

readonly class TmhEntity
{
    public function __construct(private TmhJson $json)
    {
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