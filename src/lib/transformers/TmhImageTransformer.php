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
        return match($entity['type']) {
          'image2' => $this->image($image),
          default => $this->imageToImageRoute($entity)
        };
    }

    private function image(array $image): array
    {
        return [
            'alt' => $image['alt'],
            'src' => $this->server->imageHost() . '/images/128/' . $image['src'] . '.jpg'
        ];
    }

    private function imageToImageRoute(array $image): array
    {
        $href = $this->server->imageHost() . '/images/1024/' . $image['src'] . '.jpg';
        $alt = $image['alt'];
        return [
            'code' => '',
            'innerHtml' => $alt,
            'href' => $href,
            'title' => $alt,
            'type' => 'image',
            'uuid' => ''
        ];
    }
}
