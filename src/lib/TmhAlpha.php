<?php

namespace lib;

use lib\adapters\TmhHtmlEntityAdapter;
use lib\html\TmhHtmlDocumentFactory;
use lib\transformers\TmhHtmlEntityTranslator;

readonly class TmhAlpha
{
    public function __construct(
        private TmhHtmlDocumentFactory $documentFactory,
        private TmhHtmlEntityAdapter $entityAdapter,
        private TmhHtmlEntityTranslator $entityTranslator
    ) {
    }

    public function toHtml(): string
    {
        $htmlEntity = $this->entityAdapter->get();
        $htmlEntity['attributes'] = $this->entityTranslator->translate($htmlEntity['attributes']);
        return $this->documentFactory->create($htmlEntity);
    }
}
