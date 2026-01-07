<?php

namespace lib\transformers;

use lib\core\TmhDomain;
use lib\core\TmhLocale;
use lib\core\TmhRoute;

readonly class TmhSiblingTransformer implements TmhTransformer
{
    public function __construct(private TmhDomain $domain, private TmhLocale $locale, private TmhRoute $route)
    {
    }

    public function transform(array $entity): array
    {
        $siblings = [];
        $domains = $this->domain->domains();
        $currentDomain = $this->domain->domain();
        foreach ($domains as $domain) {
            if ($domain['locale'] != $currentDomain['locale']) {
                $domain['translation'] = $this->locale->get($domain['translation']);
                $domainRoute = $this->fromDomain($domain);
                $locales = $this->locale->getLocales($domain['locale']);
                $sibling = $this->route->flatten($this->sibling($domainRoute, $locales, $entity));
                $siblings[$domain['locale']] = $sibling;
            }
        }
        return $siblings;
    }

    private function fromDomain(array $domain): array
    {
        return [
            'innerHtml' => $domain['native_name'],
            'lang' => $domain['language'],
            'href' => [$domain['baseUrl']],
            'title' => [$domain['translation'] . ' -']
        ];
    }

    private function sibling(array $domainRoute, array $locales, array $route): array
    {
        $domainRoute['code'] = $route['code'];
        foreach ($route['href'] as $uuid) {
            $domainRoute['href'][] = $this->locale->scrubbed($locales[$uuid]);
        }
        if ($route['type'] == 'metal_emperor_coin_specimen') {
            $codeParts = explode('.', $route['code']);
            $domainRoute['href'][] = $codeParts[count($codeParts) - 1];
        }
        foreach ($route['title'] as $uuid) {
            $domainRoute['title'][] = $locales[$uuid];
        }
        $domainRoute['type'] = $route['type'];
        $domainRoute['uuid'] = $route['uuid'];
        return $domainRoute;
    }
}
