<?php

namespace lib\transformers;

use lib\core\TmhLocale;
use lib\core\TmhRoute;

readonly class TmhAncestorsTransformer implements TmhTransformer
{
    public function __construct(private TmhLocale $locale, private TmhRoute $route)
    {
    }

    public function transform(array $entity): array
    {
        $ancestors = [];
        $defaultRoute = $this->route->defaultRoute();
        if ($entity['uuid'] != $defaultRoute['uuid']) {
            $ancestors[] = $this->route->hydrate($defaultRoute);
            $cumulative = '';
            foreach ($entity['href'] as $href) {
                $cumulative .= $this->locale->scrubbed($this->locale->get($href));
                $ancestor = $this->route->getRoute($cumulative);
                $ancestors[] = $this->route->hydrate($ancestor);
                $cumulative .= '/';
            }
            //$ancestors[] = $entity;
        }
        return $ancestors;
    }
}
