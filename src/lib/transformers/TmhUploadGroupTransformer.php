<?php

namespace lib\transformers;

use lib\core\TmhDatabase;

readonly class TmhUploadGroupTransformer implements TmhTransformer
{
    public function __construct(private TmhTransformerFactory $transformerFactory, private TmhDatabase $database)
    {
    }

    public function transform(array $entity): array
    {
        $uploadGroup = $this->database->uploadGroup($entity['upload_group']);
        $transformed = [
            'identifier' => $entity['identifier'],
            'uploads' => [],
            'lang' => $entity['lang'],
            'translation' => $entity['translation'],
            'type' => $entity['type']
        ];
        foreach ($uploadGroup['uploads'] as $upload) {
            $transformed['uploads'][] = $this->routedToUploadGroup($entity, $upload);
        }
        return $transformed;
    }

    private function routedToUploadGroup(array $entity, string $upload): array
    {
        $uploadTransformer = $this->transformerFactory->create('upload1');
        $uploadToTransform = ['uuid' => $upload, 'translation' => $entity['translation'], 'type' => 'upload1'];
        return $uploadTransformer->transform($uploadToTransform);
    }
}
