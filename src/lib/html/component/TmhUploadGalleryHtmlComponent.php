<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhUploadGalleryHtmlComponent implements TmhHtmlComponent
{
    public function __construct(private TmhHtmlElementFactory $elementFactory)
    {
    }

    public function get(array $entity, string $language): array
    {
        $uploadGroupNodes = [];
        foreach ($entity['items'] as $upload) {
            $href = implode('', $upload['upload']['route']['href']);
            $attributes = [
                'href' => $href,
                'src' => $upload['upload']['src'],
                'target' => '_self',
                'title' => $upload['upload']['alt']
            ];
            $uploadElement = $this->elementFactory->linkedImage($attributes);
            $uploadGroupNodes[] = $this->elementFactory->imageGalleryItem([], [$uploadElement]);

        }
        return $this->elementFactory->imageGallery([], $uploadGroupNodes);
    }
}
