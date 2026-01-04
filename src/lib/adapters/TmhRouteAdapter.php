<?php

namespace lib\adapters;

use lib\core\TmhRoute;

readonly class TmhRouteAdapter
{
    public const string DEFAULT_ROUTE = 'umd0xr1h';

    private array $routeMap;

    public function __construct(private TmhRoute $route)
    {
        $this->routeMap = $this->route->routeMap();
    }

    public function getCurrentRoute(): array
    {
        $requestedRoute = $this->route->requestedRoute();
        if (in_array($requestedRoute, array_keys($this->routeMap))) {
            return $this->getRoute($requestedRoute);
        }

        if (1 < count(explode('/', $requestedRoute))) {
            return $this->childRoute($requestedRoute);
        }

        return $this->defaultRoute();
    }

    public function defaultRoute(): array
    {
        return $this->route->get(self::DEFAULT_ROUTE);
    }

    public function getRoute(string $requestedRoute): array
    {
        return $this->route->get($this->routeMap[$requestedRoute]);
    }

    private function ancestorRoute(array $routeParts): array
    {
        if (1 < count($routeParts)) {
            unset($routeParts[count($routeParts) - 1]);
            $requestedRoute = implode('/', $routeParts);
            if (in_array($requestedRoute, array_keys($this->routeMap))) {
                return $this->getRoute($requestedRoute);
            } else {
                return $this->ancestorRoute($routeParts);
            }
        }
        return $this->defaultRoute();
    }

    private function childRoute(string $requestedRoute): array
    {
        $routeParts = explode('/', $requestedRoute);
        $requestedChildRoute = strtolower($routeParts[count($routeParts) - 1]);
        $ancestorRoute = $this->ancestorRoute($routeParts);
        $childRoute = $ancestorRoute;
        if ($ancestorRoute['type'] === 'metal_emperor_coin') {
            $childRoute['code'] = $ancestorRoute['code'] . '.' . $requestedChildRoute;
            $childRoute['type'] = $ancestorRoute['type'] . '_specimen';
        }
        return $childRoute;
    }
}
