<?php

namespace lib;

use lib\core\TmhHtmlEntity;
use lib\html\TmhHtmlDocumentFactory;

readonly class TmhAlpha
{
    public function __construct(private TmhHtmlDocumentFactory $documentFactory, private TmhHtmlEntity $htmlEntity)
    {
    }

    public function toHtml(): string
    {
        $htmlEntity = $this->htmlEntity->get();
        return $this->documentFactory->create($htmlEntity);
    }
}
