<?php

namespace lib\adapters;

use lib\core\TmhRoute;

readonly class TmhRouteAdapter
{
    public const string DEFAULT_ROUTE = 'umd0xr1h';

    public function __construct(private TmhRoute $route)
    {
    }

    public function getCurrentRoute(): array
    {
        $keyedRoutes = $this->route->keyedRoutes();
        $requestedRoute = $this->route->requestedRoute();
        if (in_array($requestedRoute, array_keys($keyedRoutes))) {
            return $this->route->get($keyedRoutes[$requestedRoute]);
        }

        if (1 < count(explode('/', $requestedRoute))) {
            return $this->childRoute($keyedRoutes, $requestedRoute);
        }

        return $this->route->get(self::DEFAULT_ROUTE);
    }

    private function ancestorRoute(array $keyedRoutes, array $routeParts): array
    {
        if (1 < count($routeParts)) {
            unset($routeParts[count($routeParts) - 1]);
            $requestedRoute = implode('/', $routeParts);
            if (in_array($requestedRoute, array_keys($keyedRoutes))) {
                return $this->route->get($keyedRoutes[$requestedRoute]);
            } else {
                return $this->ancestorRoute($keyedRoutes, $routeParts);
            }
        }
        return $this->route->get(self::DEFAULT_ROUTE);
    }

    private function childRoute(array $keyedRoutes, string $requestedRoute): array
    {
        $routeParts = explode('/', $requestedRoute);
        $requestedChildRoute = strtolower($routeParts[count($routeParts) - 1]);
        $ancestorRoute = $this->ancestorRoute($keyedRoutes, $routeParts);
        $childRoute = $ancestorRoute;
        if ($ancestorRoute['type'] === 'metal_emperor_coin') {
            $childRoute['code'] = $ancestorRoute['code'] . '.' . $requestedChildRoute;
            $childRoute['type'] = $ancestorRoute['type'] . '_specimen';
        }
        return $childRoute;
    }
}
