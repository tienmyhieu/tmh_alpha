<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhImageGalleryItemHtmlComponent implements TmhHtmlComponent
{
    private const string SPACER_IMG = '35609f0ec63d40c9b0cca4f29cc089d0';

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
            if (str_contains($image['src'], self::SPACER_IMG)) {
                $imageGroupNodes[] =  $this->elementFactory->img($image['alt'], $image['src']);
            } else {
                $attributes = [
                    'href' => $image['route']['href'],
                    'src' => $image['src'],
                    'target' => '_self',
                    'title' => $image['alt']
                ];
                $imageGroupNodes[] = $this->elementFactory->linkedImage($attributes);
            }
        }
        return $this->elementFactory->imageGalleryItem([], $imageGroupNodes);
    }
}
