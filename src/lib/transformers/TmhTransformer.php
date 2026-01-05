<?php

namespace lib\transformers;

interface TmhTransformer
{
    public function transform(array $entity): array;
}
