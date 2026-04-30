<?php

namespace lib\transformers;

use lib\core\TmhDatabase;

readonly class TmhUploadGalleryTransformer implements TmhTransformer
{
    public function __construct(private TmhTransformerFactory $transformerFactory, private TmhDatabase $database)
    {
    }

    public function transform(array $entity): array
    {
        $transformed = ['type' => $entity['type'], 'items' => []];
        foreach ($entity['items'] as $uploadGalleryItem) {
            $upload = $this->database->upload($uploadGalleryItem);
            $transformed['items'][] = [
                'upload' => $this->routedToUploadGroup($upload, $uploadGalleryItem)
            ];
        }
        return $transformed;
    }

    private function routedToUploadGroup(array $entity, string $upload): array
    {
        $uploadTransformer = $this->transformerFactory->create('upload1');
        $uploadToTransform = ['uuid' => $upload, 'translation' => $entity['alt'], 'type' => 'upload1'];
        return $uploadTransformer->transform($uploadToTransform);
    }
}
