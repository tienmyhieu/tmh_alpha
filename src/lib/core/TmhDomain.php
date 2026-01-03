<?php

namespace lib\core;

use lib\adapters\TmhServerAdapter;
use lib\transformers\TmhDomainTransformer;

readonly class TmhDomain
{
    private const string DEFAULT_DOMAIN = 'vi';

    private array $domain;
    private array $domains;

    public function __construct(
        private TmhDomainTransformer $domainTransformer,
        private TmhJson $json,
        private TmhServerAdapter $serverAdapter
    ) {
        $this->domains = $this->domainTransformer->transformAll($this->json->domains());
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

    private function initializeDomain(): void
    {
        $subDomain = $this->serverAdapter->subDomain();
        $isValidSubDomain = in_array($subDomain, array_keys($this->domains));
        $this->domain = $isValidSubDomain ? $this->domains[$subDomain] : $this->domains[self::DEFAULT_DOMAIN];
    }
}
