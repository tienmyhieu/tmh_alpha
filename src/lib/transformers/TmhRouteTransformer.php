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
        $route = $this->route->get($entity['uuid']);
        if (in_array('code', array_keys($entity))) {
            $route['code'] = $entity['code'];
        }
        if (in_array('type', array_keys($entity))) {
            $route['type'] = $entity['type'];
        }
        $transformed = $this->route->hydrate($route);
        $transformed['innerHtml'] = str_replace('_', ' ', implode(' ', $entity['translation']));
        return $transformed;
    }
}
