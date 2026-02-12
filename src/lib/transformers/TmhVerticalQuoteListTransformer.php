<?php

namespace lib\transformers;

readonly class TmhVerticalQuoteListTransformer implements TmhTransformer
{
    public function transform(array $entity): array
    {
        return $entity;
    }
}
