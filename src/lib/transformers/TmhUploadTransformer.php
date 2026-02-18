<?php

namespace lib\transformers;

use lib\core\TmhDatabase;
use lib\core\TmhServer;

readonly class TmhUploadTransformer implements TmhTransformer
{
    public function __construct(private TmhDatabase $database, private TmhServer $server)
    {
    }

    public function transform(array $entity): array
    {
        $upload = $this->database->upload($entity['uuid']);
        return $this->uploadToUploadRoute(
            array_merge($upload, ['translation' => $entity['translation'], 'type' => $entity['type']])
        );
    }

    private function uploadToUploadRoute(array $upload): array
    {
        return [
            'alt' => $upload['alt'],
            'src' => $this->server->imageHost() . '/uploads/128/' . $upload['src'] . '.jpg',
            'route' => [
                'code' => '',
                'innerHtml' => '',
                'href' => [$this->server->imageHost() . '/uploads/1024/' . $upload['src'] . '.jpg'],
                'title' => $upload['alt'],
                'type' => 'image_route1',
                'uuid' => ''
            ]
        ];
    }
}
