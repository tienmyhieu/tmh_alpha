<?php

namespace lib\transformers;

use lib\core\TmhDatabase;

readonly class TmhUrlTransformer implements TmhTransformer
{
    public function __construct(private TmhDatabase $database)
    {
    }

    public function transform(array $entity): array
    {
        $transformed = [];
        $url = $this->database->url($entity['uuid']);
        if (0 < strlen($url['website'])) {
            $webSite = $this->database->webSite($url['website']);
            $transformed['url'] = $webSite['url'] . $url['url'];
            $transformed['type'] = $url['type'];
            $transformed['translation'] = $url['translation'];
        }
        return $transformed;
    }
}
