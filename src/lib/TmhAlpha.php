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
        $entity = $this->entityTranslator->translate($this->entityAdapter->get());
        return $this->documentFactory->create($entity);
    }
}
