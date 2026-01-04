<?php

namespace lib\transformers;

use lib\adapters\TmhRouteAdapter;
use lib\core\TmhLocale;

readonly class TmhAncestorTransformer
{
    public function __construct(
        private TmhRouteAdapter $routeAdapter,
        private TmhLocale $locale,
        private TmhRouteTransformer $routeTransformer
    ) {
    }

    public function ancestors(array $route): array
    {
        $ancestors = [];
        $defaultRoute = $this->routeAdapter->defaultRoute();
        if ($route['uuid'] != $defaultRoute['uuid']) {
            $ancestors[] = $this->routeTransformer->translate($this->routeTransformer->hydrate($defaultRoute));
            $cumulative = '';
            foreach ($route['href'] as $href) {
                $cumulative .= $this->locale->scrubbed($this->locale->get($href));
                $ancestor = $this->routeAdapter->getRoute($cumulative);
                $ancestors[] = $this->routeTransformer->translate($this->routeTransformer->hydrate($ancestor));
                $cumulative .= '/';
            }
            $ancestors[] = $this->routeTransformer->translate($route);
        }
        return $ancestors;
    }
}
