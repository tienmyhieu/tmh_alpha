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
        if (0 < strlen($entity['translation'])) {
            $componentNodes[] = $this->elementFactory->listTitle([], $entity['translation']);
        }
        foreach ($entity['items'] as $imageGroup) {
            $imageGroupFactory = $this->componentFactory->create('image_group');
            $componentNodes[] = $imageGroupFactory->get($imageGroup, $language);
        }
        return $this->elementFactory->imageGallery([], $componentNodes);
    }
}
