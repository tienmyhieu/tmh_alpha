<?php

namespace lib\transformers;

use lib\core\TmhDomain;
use lib\core\TmhLocale;

readonly class TmhSiblingTransformer
{
    public function __construct(private TmhDomain $domain, private TmhLocale $locale)
    {
    }

    public function siblings(array $route): array
    {
        $siblings = [];
        $domains = $this->domain->domains();
        $currentDomain = $this->domain->domain();
        foreach ($domains as $domain) {
            if ($domain['locale'] != $currentDomain['locale']) {
                $domain['translation'] = $this->locale->get($domain['translation']);
                $domainRoute = $this->fromDomain($domain);
                $locales = $this->locale->getLocales($domain['locale']);
                $sibling = $this->sibling($domainRoute, $locales, $route);
                $sibling['href'] = implode('/', $sibling['href']);
                $sibling['title'] = implode(' ', $sibling['title']);
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
        $patterns = ["'", ' ', '、', '-', '.', "'", ','];
        $replacements = ['', '_', '', '_', '_', '', ''];
        foreach ($route['href'] as $uuid) {
            $domainRoute['href'][] = str_replace($patterns, $replacements, $locales[$uuid]);
        }
        if ($route['type'] == 'metal_emperor_coin_specimen') {
            $codeParts = explode('.', $route['code']);
            $domainRoute['href'][] = $codeParts[count($codeParts) - 1];
        }
        foreach ($route['title'] as $uuid) {
            $domainRoute['title'][] = $locales[$uuid];
        }
        return $domainRoute;
    }
}
