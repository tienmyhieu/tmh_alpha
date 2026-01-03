<?php

namespace lib\transformers;

use lib\core\TmhLocale;

readonly class TmhRouteTransformer
{
    public function __construct(private TmhLocale $locale)
    {

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
}
