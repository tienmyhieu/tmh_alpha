<?php

namespace lib\transformers;

readonly class TmhArticleTransformer implements TmhTransformer
{
    public function __construct(private TmhTransformerFactory $transformerFactory)
    {
    }

    public function transform(array $entity): array
    {
        $transformed = $entity;
        $transformed['paragraphs'] = [];
        foreach ($entity['paragraphs'] as $paragraphItems) {
            $transformedParagraphItems = [];
            foreach ($paragraphItems as $paragraphItem) {
                if ($paragraphItem['type'] == 'sentence') {
                    $transformedParagraphItems[] = $paragraphItem;
                }
                if ($paragraphItem['type'] == 'image_group4') {
                    $transformer = $this->transformerFactory->create($paragraphItem['type']);
                    $transformedParagraphItems[] = $transformer->transform($paragraphItem);
                }
            }
            $transformed['paragraphs'][] = $transformedParagraphItems;
        }
        return $transformed;
    }
}
