<?php

namespace lib\transformers;

use lib\core\TmhDatabase;
use lib\core\TmhRoute;
use lib\core\TmhServer;

readonly class TmhTransformerFactory
{
    public function __construct(private TmhDatabase $database, private TmhRoute $route, private TmhServer $server)
    {
    }

    public function create(string $type): TmhTransformer
    {
        return match($type) {
            'entity_list_item' => new TmhEntityListItemTransformer($this),
            'entity_lists' => new TmhEntityListsTransformer($this),
            'image' => new TmhImageTransformer($this->database, $this->server),
            'route' => new TmhRouteTransformer($this->route),
            'topics' => new TmhTopicsTransformer($this)
        };
    }
}
