<?php

namespace lib\core;

use lib\adapters\TmhServerAdapter;
use lib\transformers\TmhRouteTransformer;

readonly class TmhRoute
{
    public const string DEFAULT_TITLE = 'nn3zskng';

    private array $keyedRoutes;
    private string $requestedRoute;
    private array $routes;

    public function __construct(
        private TmhRouteTransformer $routeTransformer,
        private TmhJson $json,
        private TmhServerAdapter $serverAdapter
    ) {
        $this->requestedRoute = $this->serverAdapter->redirectQueryString();
        $this->routes = $this->json->routes();
        $this->keyedRoutes = $this->routeTransformer->toKeyedRoutes($this->routes);
    }

    public function get(string $uuid): array
    {
        return in_array($uuid, array_keys($this->routes)) ? $this->routes[$uuid] : [];
    }

    public function keyedRoutes(): array
    {
        return $this->keyedRoutes;
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
