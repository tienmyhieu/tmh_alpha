<?php

namespace lib\adapters;

use lib\core\TmhEntity;

readonly class TmhEntityAdapter
{
    public function __construct(private TmhEntity $entity, private TmhRouteAdapter $routeAdapter)
    {
    }

    public function find(): array
    {
        $route = $this->routeAdapter->getCurrentRoute();
        return $this->entity->byRouteCode($route['code']);
    }
}
