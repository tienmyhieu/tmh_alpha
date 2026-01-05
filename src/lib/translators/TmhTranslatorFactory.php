<?php

namespace lib\translators;

use lib\core\TmhLocale;
use lib\core\TmhServer;

readonly class TmhTranslatorFactory
{
    public function __construct(private TmhLocale $locale, private TmhServer $server)
    {
    }

    public function create(string $type): TmhTranslator
    {
        return match($type) {
            'route' => new TmhRouteTranslator($this->locale, $this->server)
        };
    }
}