<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhUploadGroupHtmlComponent implements TmhHtmlComponent
{
    public function __construct(private TmhHtmlElementFactory $elementFactory)
    {
    }

    public function get(array $entity, string $language): array
    {
        $childNodes = [];
        foreach ($entity['uploads'] as $upload) {
            $attributes = [
                'href' => str_replace('/128/', '/1024/', $upload['src']),
                'src' => $upload['src'],
                'target' => '_self',
                'title' => $upload['route']['title']
            ];
            $childNodes[] = $this->elementFactory->linkedImage($attributes);
        }
        return $this->elementFactory->uploadGroup([], $childNodes);
    }
}
