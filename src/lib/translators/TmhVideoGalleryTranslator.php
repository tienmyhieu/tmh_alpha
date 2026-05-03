<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhVideoGalleryTranslator implements TmhTranslator
{
    public function __construct(private TmhLocale $locale)
    {
    }

    public function translate(array $entity): array
    {
        $translated = ['type' => $entity['type'], 'items' => []];
        foreach ($entity['items'] as $videoGalleryItem) {
            $videoGalleryItem['translation'] = $this->locale->get($videoGalleryItem['translation']);
            $translated['items'][] = $videoGalleryItem;
        }
        return $translated;
    }
}
