<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhImageGalleryHtmlComponent implements TmhHtmlComponent
{
    public function __construct(
        private TmhHtmlComponentFactory $componentFactory,
        private TmhHtmlElementFactory $elementFactory
    ) {
    }

    public function get(array $entity, string $language): array
    {
        $componentNodes = [];
        foreach ($entity['items'] as $imageGroup) {
            $imageGroupFactory = $this->componentFactory->create('image_gallery_item');
            $componentNodes[] = $imageGroupFactory->get($imageGroup, $language);
        }
        return $this->elementFactory->imageGallery([], $componentNodes);
    }
}
