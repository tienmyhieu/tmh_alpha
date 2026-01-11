<?php

namespace lib\core;

readonly class TmhRoute
{
    public const string DEFAULT_ROUTE = 'umd0xr1h';
    public const string DEFAULT_TITLE = 'nn3zskng';

    private string $requestedRoute;
    private array $routeMap;
    private array $routes;

    public function __construct(
        private TmhLocale $locale,
        private TmhJson $json,
        private TmhServer $server
    ) {
        $this->requestedRoute = $this->server->redirectQueryString();
        $this->routes = $this->withUuids($this->json->routes());
        $this->routeMap = $this->toKeyedRoutes($this->routes);
    }

    public function defaultRoute(): array
    {
        return $this->get(self::DEFAULT_ROUTE);
    }

    public function flatten(array $route): array
    {
        $prefix = '/';
        if (in_array('lang', array_keys($route)) || $route['type'] == 'toc') {
            $prefix = '';
        }
        $route['href'] = $prefix . implode('/', $route['href']);
        $route['title'] = implode(' ', $route['title']);
        return $route;
    }

    public function get(string $uuid): array
    {
        return in_array($uuid, array_keys($this->routes)) ? $this->routes[$uuid] : [];
    }

    public function getCurrentRoute(): array
    {
        $requestedRoute = $this->requestedRoute();
        if (in_array($this->requestedRoute, array_keys($this->routeMap))) {
            return $this->getRoute($requestedRoute);
        }

        if (1 < count(explode('/', $this->requestedRoute))) {
            return $this->childRoute($this->requestedRoute);
        }

        return $this->defaultRoute();
    }

    public function getRoute(string $requestedRoute): array
    {
        return $this->get($this->routeMap[$requestedRoute]);
    }

    public function hydrate(array $route): array
    {
        return match(count($route['href'])) {
            1,2 => $this->oneTitle($route),
            3,4 => $this->twoTitles($route),
            default => $this->noTitle($route)
        };
    }

    public function requestedRoute(): string
    {
        return $this->requestedRoute;
    }

    public function routeMap(): array
    {
        return $this->routeMap;
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

    private function noTitle(array $route): array
    {
        $route['innerHtml'] = self::DEFAULT_TITLE;
        $route['title'] = [self::DEFAULT_TITLE];
        return $route;
    }

    private function oneTitle(array $route): array
    {
        $last = $route['href'][count($route['href']) - 1];
        $route['innerHtml'] = $last;
        $route['title'] = [$last];
        return $route;
    }

    public function routeTypes(): array
    {
        $routeTypes = [];
        foreach ($this->routes as $route) {
            if (!in_array($route['type'], $routeTypes)) {
                $routeTypes[] = $route['type'];
            }
        }
        $routeTypes[] = 'metal_emperor_coin_specimen';
        sort($routeTypes);
        return $routeTypes;
    }

    public function routes(): array
    {
        return $this->routes;
    }

    private function toKeyedRoutes(array $routes): array
    {
        $transformed = [];
        $patterns = ["'", ' ', '、', '-', '.', "'", ',', ':'];
        $replacements = ['', '_', '', '_', '_', '', '', ''];
        foreach ($routes as $uuid => $route) {
            $key = implode('/', $this->locale->getMany($route['href']));
            $transformed[str_replace($patterns, $replacements, $key)] = $uuid;
        }
        return $transformed;
    }

    private function twoTitles(array $route): array
    {
        $last = $route['href'][count($route['href']) - 1];
        $secondLast = $route['href'][count($route['href']) - 2];
        $route['innerHtml'] = $last;
        $route['title'] = [$secondLast, $last];
        if ($route['type'] == 'metal_emperor_coin_specimen') {
            $codeParts = explode('.', $route['code']);
            $uuid = $codeParts[count($codeParts) - 1];
            $route['innerHtml'] = str_replace('_', ' ', $uuid);
            $route['uuid'] = $uuid;
        }
        return $route;
    }

    private function withUuids(array $routes): array
    {
        $transformed = [];
        foreach ($routes as $uuid => $route) {
            $route['uuid'] = $uuid;
            $transformed[$uuid] = $route;
        }
        return $transformed;
    }
}
