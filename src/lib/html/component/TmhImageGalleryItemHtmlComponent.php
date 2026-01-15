<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhImageGalleryItemHtmlComponent implements TmhHtmlComponent
{
    public function __construct(private TmhHtmlElementFactory $elementFactory)
    {
    }

    public function get(array $entity, string $language): array
    {
        $imageGroupNodes = [];
        if (0 < count($entity['translation'])) {
            $innerHtml = str_replace('_', ' ', implode(' ', $entity['translation']));
            $imageGroupNodes[] = $this->elementFactory->imageGalleryItemDescription([], $innerHtml);
        }
        foreach ($entity['images'] as $image) {
            $attributes = [
                'href' => $image['route']['href'],
                'src' => $image['src'],
                'target' => '_self',
                'title' => $image['alt']
            ];
            $imageGroupNodes[] = $this->elementFactory->linkedImage($attributes);
        }
        return $this->elementFactory->imageGalleryItem([], $imageGroupNodes);
    }
}
