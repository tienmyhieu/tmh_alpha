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
        $htmlEntity['siblings'] = $this->entityTransformer->siblings($htmlEntity);
        return $htmlEntity;
    }
}
