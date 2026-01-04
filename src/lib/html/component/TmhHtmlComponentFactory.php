<?php

namespace lib\html\component;

use lib\html\TmhHtmlElementFactory;

readonly class TmhHtmlComponentFactory
{
    public function __construct(private TmhHtmlElementFactory $elementFactory)
    {
    }
}
