<?php

namespace lib\adapters;

use lib\core\TmhEntity;
use lib\core\TmhRoute;

readonly class TmhEntityAdapter
{
    public function __construct(private TmhRoute $route, private TmhEntity $entity)
    {
    }

    public function find(): array
    {
        $currentRoute = $this->route->getCurrentRoute();
        $route = $this->route->hydrate($currentRoute);
        if ($route['type'] == 'metal_emperor_coin_specimen') {
            $codeParts = explode('.', $route['code']);
            $route['innerHtml'] = str_replace('_', ' ', $codeParts[count($codeParts) - 1]);
        }
        $entity = $this->entity->byRouteCode($route['code']);
        return array_merge($route, $entity);
    }
}
