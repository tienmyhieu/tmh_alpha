<?php

namespace lib\core;

use lib\adapters\TmhServerAdapter;
use lib\transformers\TmhRouteTransformer;

readonly class TmhRoute
{
    private string $requestedRoute;
    private array $routeMap;
    private array $routes;

    public function __construct(
        private TmhRouteTransformer $routeTransformer,
        private TmhJson $json,
        private TmhServerAdapter $serverAdapter
    ) {
        $this->requestedRoute = $this->serverAdapter->redirectQueryString();
        $this->routes = $this->routeTransformer->withUuids($this->json->routes());
        $this->routeMap = $this->routeTransformer->toKeyedRoutes($this->routes);
    }

    public function get(string $uuid): array
    {
        return in_array($uuid, array_keys($this->routes)) ? $this->routes[$uuid] : [];
    }

    public function routeMap(): array
    {
        return $this->routeMap;
    }

    public function requestedRoute(): string
    {
        return $this->requestedRoute;
    }

    public function routes(): array
    {
        return $this->routes;
    }
}
