<?php

namespace lib\adapters;

use lib\transformers\TmhHtmlEntityTransformer;

readonly class TmhHtmlEntityAdapter
{
    public function __construct(
        private TmhEntityAdapter $entityAdapter,
        private TmhHtmlEntityTransformer $entityTransformer
    ) {
    }

    public function get(): array
    {
        $htmlEntity = $this->entityAdapter->find();
        $htmlEntity['attributes'] = [
            'siblings' => $this->entityTransformer->siblings($htmlEntity),
            'ancestors' => $this->entityTransformer->ancestors($htmlEntity),
            'titles' => $htmlEntity['title']
        ];
        foreach ($this->attributeMap($htmlEntity['type']) as $attribute) {
            if (in_array($attribute, array_keys($htmlEntity))) {
                $htmlEntity['attributes'][$attribute] = $htmlEntity[$attribute];
                unset($htmlEntity[$attribute]);
            }
        }
        $htmlEntity['metadata'] = $this->entityTransformer->metadata($htmlEntity);
        return $htmlEntity;
    }

    private function attributeMap(string $type): array
    {
        return match($type) {
            'metal_emperor_coin_specimen' => $this->specimenAttributes(),
            default => ['topics']
        };
    }

    private function specimenAttributes(): array
    {
        return ['image_group_list', 'key_value_list', 'upload_group_list', 'citation_list'];
    }
}
