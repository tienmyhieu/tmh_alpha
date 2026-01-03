<?php

namespace lib\core;

readonly class TmhLocale
{
    private array $locales;

    public function __construct(private TmhDomain $domain, private TmhJson $json)
    {
        $domain = $this->domain->domain();
        $this->locales = $this->getLocales($domain['locale']);
    }

    public function getLocales(string $locale): array
    {
        return $this->json->locale($locale);
    }

    public function locales(): array
    {
        return $this->locales;
    }
}
