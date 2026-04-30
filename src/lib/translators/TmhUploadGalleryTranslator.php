<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhUploadGalleryTranslator implements TmhTranslator
{
    public function __construct(private TmhLocale $locale)
    {
    }

    public function translate(array $entity): array
    {
        $translated = ['type' => $entity['type'], 'items' => []];
        foreach ($entity['items'] as $uploadGalleryItem) {
            $alt = $this->locale->getMany($uploadGalleryItem['upload']['alt']);
            $title = $this->locale->getMany($uploadGalleryItem['upload']['route']['title']);
            $uploadGalleryItem['upload']['alt'] = implode(' ', $alt);
            $uploadGalleryItem['upload']['route']['title'] = implode(' ', $title);
            $translated['items'][] = $uploadGalleryItem;
        }
        return $translated;
    }
}
