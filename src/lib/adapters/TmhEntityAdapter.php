<?php

namespace lib\adapters;

use lib\core\TmhEntity;
use lib\transformers\TmhRouteTransformer;

readonly class TmhEntityAdapter
{
    public function __construct(
        private TmhRouteTransformer $routeTransformer,
        private TmhEntity $entity,
        private TmhRouteAdapter $routeAdapter
    ) {
    }

    public function find(): array
    {
        $currentRoute = $this->routeAdapter->getCurrentRoute();
        $route = $this->routeTransformer->hydrate($currentRoute);
        if ($route['type'] == 'metal_emperor_coin_specimen') {
            $codeParts = explode('.', $route['code']);
            $route['innerHtml'] = str_replace('_', ' ', $codeParts[count($codeParts) - 1]);
        }
        $entity = $this->entity->byRouteCode($route['code']);
        return array_merge($route, $entity);
    }
}
