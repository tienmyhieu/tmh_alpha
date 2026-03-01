<?php

namespace lib\transformers;

readonly class TmhMaximListTransformer implements TmhTransformer
{
    public function transform(array $entity): array
    {
        return $entity;
    }
}
