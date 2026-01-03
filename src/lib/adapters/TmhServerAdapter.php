<?php

namespace lib\adapters;

class TmhServerAdapter
{
    public function domainParts(): array
    {
        return explode('.', $_SERVER['SERVER_NAME']);
    }

    public function host(): string
    {
        $domainParts = $this->domainParts();
        return $domainParts[count($domainParts) - 2] . '.' . $domainParts[count($domainParts) - 1];
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
}
