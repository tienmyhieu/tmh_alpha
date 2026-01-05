<?php

namespace lib\transformers;

use lib\core\TmhDomain;
use lib\core\TmhLocale;

readonly class TmhMetadataTransformer implements TmhTransformer
{
    public function __construct(private TmhDomain $domain, private TmhLocale $locale)
    {
    }

    public function transform(array $entity): array
    {
        $domain = $this->domain->domain();
        $title = $this->locale->getMany($entity['title']);
        return [
            'description' => implode(' ', $title),
            'documentTitle' => implode(' ', $title),
            'keywords' => implode(',', $title),
            'lang' => $domain['language']
        ];
    }
}
