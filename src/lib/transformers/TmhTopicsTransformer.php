<?php

namespace lib\transformers;

readonly class TmhTopicsTransformer implements TmhTransformer
{
    public function __construct(private TmhTransformerFactory $transformerFactory)
    {
    }

    public function transform(array $entity): array
    {
        $transformed = [];
        $ignoredKeys = ['translation'];
        foreach ($entity as $topic) {
            $transformedTopic = [];
            foreach ($topic as $key => $value) {
                if (in_array($key, $ignoredKeys)) {
                    $transformedTopic[$key] = $value;
                } else {
                    $transformer = $this->transformerFactory->create($key);
                    $transformedTopic[$key] = $transformer->transform($value);
                }
            }
            $transformed[] = $transformedTopic;
        }
        return $transformed;
    }
}
