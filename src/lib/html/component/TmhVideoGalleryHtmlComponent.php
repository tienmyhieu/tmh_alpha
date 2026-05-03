<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhVideoGalleryHtmlComponent implements TmhHtmlComponent
{
    public function __construct(private TmhHtmlElementFactory $elementFactory)
    {
    }

    public function get(array $entity, string $language): array
    {
        $componentNodes = [];
        foreach ($entity['items'] as $video ) {
            $entityChildNodes = [];
            $attributes = [];
            $useLanguage = 0 < strlen($video['lang']) && $video['lang'] != $language;
            if ($useLanguage) {
                $attributes['lang'] = $video['lang'];
            }
            if (0 < strlen($video['translation'])) {
                $entityChildNodes[] = $this->elementFactory->span($attributes, $video['translation']);
            }
            $timeStart = 0 < strlen($video['time_start']) ? '#t=' . $video['time_start'] : '';
            $src = 'http://img1.tienmyhieu.com/videos/' . $video['src'] . '.mp4' . $timeStart;
            $entityChildNodes[] = $this->elementFactory->video(
                $video['height'],
                $src,
                $video['width']
            );
            $componentNodes[] = $this->elementFactory->videoGroup([], $entityChildNodes);
        }
        return $this->elementFactory->videoGroupList([], $componentNodes);
    }
}

