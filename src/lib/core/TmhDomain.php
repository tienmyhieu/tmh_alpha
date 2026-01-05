<?php

namespace lib\core;

readonly class TmhDomain
{
    private const string DEFAULT_DOMAIN = 'vi';

    private array $domain;
    private array $domains;

    public function __construct(private TmhJson $json, private TmhServer $server)
    {
        $this->domains = $this->transformAll($this->filterInactive($this->json->domains()));
        $this->initializeDomain();
    }

    public function domain(): array
    {
        return $this->domain;
    }

    public function domains(): array
    {
        return $this->domains;
    }

    private function baseUrl(string $subDomain): string
    {
        return $this->server->requestScheme() . '://' . $subDomain . '.' . $this->server->host();
    }

    private function filterInactive(array $domains): array
    {
        return array_filter($domains, function($domain) {
            return $domain['active'] == '1';
        });
    }

    private function initializeDomain(): void
    {
        $subDomain = $this->server->subDomain();
        $isValidSubDomain = in_array($subDomain, array_keys($this->domains));
        $this->domain = $isValidSubDomain ? $this->domains[$subDomain] : $this->domains[self::DEFAULT_DOMAIN];
    }

    private function transformAll(array $domains): array
    {
        $transformed = [];
        foreach ($domains as $subDomain => $domain) {
            unset($domain['active']);
            $domain['baseUrl'] = $this->baseUrl($subDomain);
            $domain['language'] = substr($domain['locale'], 0, 2);
            $transformed[$subDomain] = $domain;
        }
        return $transformed;
    }
}
