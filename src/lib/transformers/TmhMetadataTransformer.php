<?php

namespace lib\transformers;

use lib\core\TmhDomain;
use lib\core\TmhLocale;

readonly class TmhMetadataTransformer
{
    public function __construct(private TmhDomain $domain, private TmhLocale $locale)
    {
    }

    public function metadata(array $route): array
    {
        $domain = $this->domain->domain();
        $title = $this->locale->getMany($route['title']);
        return [
            'description' => implode(' ', $title),
            'documentTitle' => implode(' ', $title),
            'keywords' => implode(',', $title),
            'lang' => $domain['language']
        ];
    }
}
