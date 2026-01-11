<?php

namespace lib\transformers;

use lib\core\TmhDatabase;
use lib\core\TmhDomain;
use lib\core\TmhLocale;
use lib\core\TmhRoute;
use lib\core\TmhServer;

readonly class TmhTransformerFactory
{
    public function __construct(
        private TmhDatabase $database,
        private TmhDomain $domain,
        private TmhLocale $locale,
        private TmhRoute $route,
        private TmhServer $server
    ) {
    }

    public function create(string $type): TmhTransformer
    {
        return match($type) {
            'ancestors' => new TmhAncestorsTransformer($this->locale, $this->route),
            'entity_list_item' => new TmhEntityListItemTransformer($this),
            'entity_lists' => new TmhEntityListsTransformer($this),
            'image' => new TmhImageTransformer($this->database, $this->server),
            'metadata' => new TmhMetadataTransformer($this->domain),
            'siblings' => new TmhSiblingTransformer($this->domain, $this->locale, $this->route),
            'route',
            'route2' => new TmhRouteTransformer($this->route)
        };
    }
}
