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
            'image1',
            'image2' => new TmhImageTransformer($this->database, $this->server),
            'image_gallery' => new TmhImageGalleryTransformer($this),
            'image_group1' => new TmhImageGroupTransformer($this, $this->database),
            'metadata' => new TmhMetadataTransformer($this->domain),
            'siblings' => new TmhSiblingTransformer($this->domain, $this->locale, $this->route),
            'route1',
            'route2',
            'route3' => new TmhRouteTransformer($this->route)
        };
    }
}
