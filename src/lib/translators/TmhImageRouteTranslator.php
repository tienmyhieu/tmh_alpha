<?php

namespace lib\translators;

use lib\core\TmhLocale;
use lib\core\TmhRoute;

readonly class TmhImageRouteTranslator implements TmhTranslator
{
    public function __construct(private TmhLocale $locale, private TmhRoute $route)
    {
    }

    public function translate(array $entity): array
    {
        $translated = ['href' => [$entity['route']['href']], 'title' => []];
        $translated['innerHtml'] = implode(' ', $this->locale->getMany($entity['route']['innerHtml']));
        foreach ($entity['route']['title'] as $uuid) {
            $translated['title'][] = $this->locale->get($uuid);
        }
        $translated['code'] = $entity['route']['code'];
        $translated['type'] = $entity['route']['type'];
        $translated['uuid'] = $entity['route']['uuid'];
        return $this->route->flatten($translated);
    }
}
