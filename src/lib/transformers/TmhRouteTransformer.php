<?php

namespace lib\transformers;

use lib\core\TmhRoute;

readonly class TmhRouteTransformer implements TmhTransformer
{
    public function __construct(private TmhRoute $route)
    {
    }

    public function transform(array $entity): array
    {
        $routeUuid = $entity['uuid'];
        $route = $this->route->hydrate($this->route->get($routeUuid));
        $route['innerHtml'] = implode(' ', $entity['translation']);
        return $route;
    }
}
