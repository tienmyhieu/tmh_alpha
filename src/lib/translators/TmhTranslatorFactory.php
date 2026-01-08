<?php

namespace lib\translators;

use lib\core\TmhLocale;
use lib\core\TmhRoute;
use lib\core\TmhServer;

readonly class TmhTranslatorFactory
{
    public function __construct(private TmhLocale $locale, private TmhRoute $route, private TmhServer $server)
    {
    }

    public function create(string $type): TmhTranslator
    {
        return match($type) {
            'ancestors' => new TmhAncestorsTranslator($this),
            'entity_list_item' => new TmhEntityListItemTranslator($this, $this->locale),
            'entity_lists' => new TmhEntityListsTranslator($this, $this->locale),
            'metadata' => new TmhMetadataTranslator($this->locale),
            'route' => new TmhRouteTranslator($this->locale, $this->route, $this->server),
            'title' => new TmhTitleTranslator($this->locale),
            'topic' => new TmhTopicTranslator($this->locale)
        };
    }
}