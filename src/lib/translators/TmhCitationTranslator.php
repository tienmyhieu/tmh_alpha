<?php

namespace lib\translators;

use lib\core\TmhLocale;

readonly class TmhCitationTranslator implements TmhTranslator
{
    public function __construct(private TmhLocale $locale)
    {
    }

    public function translate(array $entity): array
    {
        $hasPage = 0 < strlen($entity['page']);
        $hasPlate = 0 < strlen($entity['plate']);
        $suffix = '';
        if ($hasPage || $hasPlate) {
            $suffix .= ', ';
        }
        if ($hasPage) {
            $suffix .= $this->locale->get('xdz2vcle') . ': ' . $entity['page'];
        }
        if ($hasPlate) {
            $suffix .= ', ' . $this->locale->get('zubs5zpq') . ': ' . $entity['plate'];
        }
        $translatedCitation = $this->locale->get($entity['citation']);
        $entity['citation'] = $translatedCitation . $suffix;

        if (is_array($entity['url'])) {
            $entity['url']['translation'] = implode(' ', $this->locale->getMany($entity['url']['translation']));
        }
        return $entity;
    }
}
