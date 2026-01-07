<?php

namespace lib\transformers;

use lib\core\TmhDomain;
use lib\core\TmhLocale;

readonly class TmhMetadataTransformer implements TmhTransformer
{
    public function __construct(private TmhDomain $domain)
    {
    }

    public function transform(array $entity): array
    {
        $domain = $this->domain->domain();
        return [
            'description' => $entity['title'],
            'documentTitle' => $entity['title'],
            'keywords' => $entity['title'],
            'lang' => $domain['language']
        ];
    }
}
