<?php

namespace lib\transformers;

use lib\core\TmhLocale;

readonly class TmhRouteTransformer
{
    public const string DEFAULT_TITLE = 'nn3zskng';

    public function __construct(private TmhLocale $locale)
    {
    }

    public function hydrate(array $route): array
    {
        return match(count($route['href'])) {
            1,2 => $this->oneTitle($route),
            3,4 => $this->twoTitles($route),
            default => $this->noTitle($route)
        };
    }

    public function toKeyedRoutes(array $routes): array
    {
        $transformed = [];
        $patterns = ["'", ' ', '、', '-', '.', "'", ','];
        $replacements = ['', '_', '', '_', '_', '', ''];
        foreach ($routes as $uuid => $route) {
            $key = implode('/', $this->locale->getMany($route['href']));
            $transformed[str_replace($patterns, $replacements, $key)] = $uuid;
        }
        return $transformed;
    }

    public function withUuids(array $routes): array
    {
        $transformed = [];
        foreach ($routes as $uuid => $route) {
            $route['uuid'] = $uuid;
            $transformed[$uuid] = $route;
        }
        return $transformed;
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

    private function twoTitles(array $route): array
    {
        $last = $route['href'][count($route['href']) - 1];
        $secondLast = $route['href'][count($route['href']) - 2];
        $route['innerHtml'] = $last;
        $route['title'] = [$secondLast, $last];
        return $route;
    }
}
