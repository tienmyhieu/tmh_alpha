<?php

namespace lib\translators;

readonly class TmhAncestorsTranslator implements TmhTranslator
{
    public function __construct(private TmhTranslatorFactory $translatorFactory)
    {
    }

    public function translate(array $entity): array
    {
        $translated = [];
        $translator = $this->translatorFactory->create('route');
        foreach ($entity as $ancestor) {
            $translated[] = $translator->translate($ancestor);
        }
        return $translated;
    }
}
