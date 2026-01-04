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
        $entity = $this->entity->byRouteCode($route['code']);
        return array_merge($route, $entity);
    }
}
