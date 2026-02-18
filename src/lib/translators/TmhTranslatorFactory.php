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
            'article' => new TmhArticleTranslator($this, $this->locale),
            'entity_list_item' => new TmhEntityListItemTranslator($this, $this->locale),
            'entity_lists' => new TmhEntityListsTranslator($this, $this->locale),
            'image' => new TmhImageTranslator($this, $this->locale),
            'image_gallery' => new TmhImageGalleryTranslator($this),
            'image_gallery_title' => new TmhImageGalleryTitleTranslator($this->locale),
            'image_group1',
            'image_group2',
            'image_group3',
            'image_group4',
            'image_group5' => new TmhImageGroupTranslator($this, $this->locale),
            'image_route1',
            'image_route2' => new TmhImageRouteTranslator($this->locale, $this->route),
            'metadata' => new TmhMetadataTranslator($this->locale),
            'route1',
            'route2',
            'route3',
            'route4',
            'route5' => new TmhRouteTranslator($this->locale, $this->route, $this->server),
            'title' => new TmhTitleTranslator($this->locale),
            'topic' => new TmhTopicTranslator($this->locale),
            'upload' => new TmhUploadTranslator($this, $this->locale),
            'upload_group1' => new TmhUploadGroupTranslator($this, $this->locale),
            'vertical_quote_list' => new TmhVerticalQuoteListTranslator($this->locale)
        };
    }
}