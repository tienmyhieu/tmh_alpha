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
        $translated = ['href' => [$entity['href']], 'title' => []];
        $translated['innerHtml'] = implode(' ', $this->locale->getMany($entity['innerHtml']));
        foreach ($entity['title'] as $uuid) {
            $translated['title'][] = $this->locale->get($uuid);
        }
        $translated['code'] = $entity['code'];
        $translated['type'] = $entity['type'];
        $translated['uuid'] = $entity['uuid'];
        return $this->route->flatten($translated);
    }
}
