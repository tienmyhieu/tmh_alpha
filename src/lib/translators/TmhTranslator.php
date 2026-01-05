<?php

namespace lib\translators;

interface TmhTranslator
{
    public function translate(array $entity): array;
}
