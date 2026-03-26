<?php

namespace lib\transformers;

readonly class TmhCitationListTransformer implements TmhTransformer
{
    public function transform(array $entity): array
    {
        return $entity;
    }
}
