<?php

namespace lib\transformers;

use lib\adapters\TmhServerAdapter;

readonly class TmhDomainTransformer
{
    public function __construct(private TmhServerAdapter $serverAdapter)
    {
    }

    public function filterInactive(array $domains): array
    {
        return array_filter($domains, function($domain) {
            return $domain['active'] == '1';
        });
    }

    public function transformAll(array $domains): array
    {
        $transformed = [];
        foreach ($this->filterInactive($domains) as $subDomain => $domain) {
            unset($domain['active']);
            $domain['baseUrl'] = $this->baseUrl($subDomain);
            $domain['language'] = substr($domain['locale'], 0, 2);
            $transformed[$subDomain] = $domain;
        }

        return $transformed;
    }

    private function baseUrl(string $subDomain): string
    {
        return $this->serverAdapter->requestScheme() . '://' . $subDomain . '.' . $this->serverAdapter->host();
    }
}
