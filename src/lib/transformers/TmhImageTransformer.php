<?php

namespace lib\transformers;

use lib\core\TmhDatabase;
use lib\core\TmhServer;

readonly class TmhImageTransformer implements TmhTransformer
{
    public function __construct(private TmhDatabase $database, private TmhServer $server)
    {
    }

    public function transform(array $entity): array
    {
        $image = $this->database->image($entity['uuid']);
        $href = $this->server->imageHost() . '/images/1024/' . $image['src'] . '.jpg';
        $alt = $image['alt'];
        return [
            'code' => '',
            'innerHtml' => $alt[count($alt) - 1],
            'href' => $href,
            'title' => $alt,
            'type' => 'image',
            'uuid' => ''
        ];
    }
}
