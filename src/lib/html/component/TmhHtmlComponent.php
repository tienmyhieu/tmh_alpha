<?php

namespace lib\html\component;

interface TmhHtmlComponent
{
    public function get(array $entity, string $language): array;
}
