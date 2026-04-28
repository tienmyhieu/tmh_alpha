<?php

namespace lib\transformers;

readonly class TmhCitationListTransformer implements TmhTransformer
{
    public function __construct(private TmhTransformerFactory $transformerFactory)
    {
    }

    public function transform(array $entity): array
    {
        $citationList = ['type' => $entity['type'], 'items' => []];
        foreach($entity['items'] as $item) {
            if (0 < strlen($item['url'])) {
                $urlTransformer = $this->transformerFactory->create('url');
                $transformed = $urlTransformer->transform(['uuid' => $item['url']]);
                $item['url'] = $transformed;
            }
            $citationList['items'][] = $item;
        }
        return $citationList;
    }
}
