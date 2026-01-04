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

    public function get(string $uuid): string
    {
        return in_array($uuid, array_keys($this->locales)) ? $this->locales[$uuid] : $uuid;
    }

    public function getLocales(string $locale): array
    {
        return $this->json->locale($locale);
    }

    public function getMany(array $uuids): array
    {
        return array_map(function ($uuid) { return $this->get($uuid); }, $uuids);
    }

    public function locales(): array
    {
        return $this->locales;
    }

    public function scrubbed(string $locale): string
    {
        $patterns = ["'", ' ', '、', '-', '.', "'", ','];
        $replacements = ['', '_', '', '_', '_', '', ''];
        return str_replace($patterns, $replacements, $locale);
    }
}
