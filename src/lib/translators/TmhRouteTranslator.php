<?php

namespace lib\translators;

use lib\core\TmhLocale;
use lib\core\TmhRoute;
use lib\core\TmhServer;

readonly class TmhRouteTranslator implements TmhTranslator
{
    public function __construct(private TmhLocale $locale, private TmhRoute $route, private TmhServer $server)
    {
    }

    public function translate(array $entity): array
    {
        $translated = ['href' => [], 'title' => []];
        $translated['innerHtml'] = $this->locale->get($entity['innerHtml']);
        foreach ($entity['href'] as $uuid) {
            $translated['href'][] = $this->locale->scrubbed($this->locale->get($uuid));
        }
        $specimenRouteTypes = ['specimen', 'specimen_group'];
        if (in_array($entity['type'], $specimenRouteTypes)) {
            $translated['href'][] = $entity['code'];
        }
        foreach ($entity['title'] as $uuid) {
            $translated['title'][] = $this->locale->get($uuid);
        }
        if ($entity['type'] == 'toc') {
            $translated['href'][] = $this->server->url();
        }
        $translated['code'] = $entity['code'];
        $translated['type'] = $entity['type'];
        $translated['uuid'] = $entity['uuid'];
        return $this->route->flatten($translated);
    }
}
