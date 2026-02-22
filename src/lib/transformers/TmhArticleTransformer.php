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
        $sentenceTypes = [
            'anchored_newline_sentence',
            'bold_newline_sentence',
            'bold_sentence',
            'newline_sentence',
            'sentence',
            'italic_sentence',
            'anchor_route',
            'table'
        ];
        foreach ($entity['paragraphs'] as $paragraphItems) {
            $transformedParagraphItems = [];
            foreach ($paragraphItems as $paragraphItem) {
                if (in_array($paragraphItem['type'], $sentenceTypes)) {
                    $transformedParagraphItems[] = $paragraphItem;
                }
                if ($paragraphItem['type'] == 'image_group4') {
                    $transformer = $this->transformerFactory->create($paragraphItem['type']);
                    $transformedParagraphItems[] = $transformer->transform($paragraphItem);
                }
                if ($paragraphItem['type'] == 'upload_group1') {
                    $transformer = $this->transformerFactory->create($paragraphItem['type']);
                    $transformedParagraphItems[] = $transformer->transform($paragraphItem);
                }
            }
            $transformed['paragraphs'][] = $transformedParagraphItems;
        }
        return $transformed;
    }
}
