<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhTopicsTranslator implements TmhTranslator
{
    public function __construct(private TmhTranslatorFactory $translatorFactory, private TmhLocale $locale)
    {
    }

    public function translate(array $entity): array
    {
        $translated = [];
        foreach ($entity as $topic) {
            $translatedTopic = [];
            foreach ($topic as $key => $value) {
                if ($key == 'translation') {
                    $translatedTopic['translation'] = $this->locale->get($value);
                } else {
                    $translator = $this->translatorFactory->create($key);
                    $translatedTopic[$key] = $translator->translate($value);
                }
            }
            $translated[] = $translatedTopic;
        }
        return $translated;
    }
}
