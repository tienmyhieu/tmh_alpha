<?php

namespace lib\adapters;

class TmhServerAdapter
{
    public function host(): string
    {
        $domainParts = $this->domainParts();
        return $domainParts[count($domainParts) - 2] . '.' . $domainParts[count($domainParts) - 1];
    }

    public function redirectQueryString(): string
    {
        parse_str($_SERVER['REDIRECT_QUERY_STRING'], $fields);
        return $fields['title'];
    }

    public function requestScheme(): string
    {
        return $_SERVER['REQUEST_SCHEME'];
    }

    public function subDomain(): string
    {
        $domainParts = $this->domainParts();
        return array_shift($domainParts);
    }

    private function domainParts(): array
    {
        return explode('.', $_SERVER['SERVER_NAME']);
    }
}
