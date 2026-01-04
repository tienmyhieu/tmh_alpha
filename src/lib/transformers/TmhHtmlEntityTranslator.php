<?php

namespace lib\transformers;

use lib\core\TmhLocale;
use lib\core\TmhRoute;

readonly class TmhHtmlEntityTranslator
{
    public function __construct(
        private TmhLocale $locale,
        private TmhRoute $route,
        private TmhRouteTransformer $routeTransformer
    )
    {
    }

    public function translate(array $attributes): array
    {
        $translated = [];
        foreach ($attributes as $key => $attribute) {
            $translated[$key] = match ($key) {
                'titles' => $this->translateTitles($attribute),
                'topics' => $this->translateTopics($attribute),
                default => $attribute
            };
        }
        return $translated;
    }

    public function filterInactive(array $entities): array
    {
        return array_filter($entities, function($entity) {
            return $entity['active'] == '1';
        });
    }

    private function translateEntityList(array $entityList): array
    {
        $translatedKey = $this->locale->get($entityList['translation']);
        $translated = ['translation' => $translatedKey, 'items' => []];
        $items = $this->filterInactive($entityList['items']);
        foreach ($items as $item) {
            $translatedItem = match($item['type']) {
                'route' => $this->translateRouteItem($item),
                default => $this->translateTextItem($item)
            };
            unset($translatedItem['active']);
            $translated['items'][] = $translatedItem;
        }
        return $translated;
    }

    private function translateTextItem(array $item): array
    {
        $item['translation'] = $this->locale->get($item['translation']);
        return $item;
    }

    private function translateRouteItem(array $item): array
    {
        $route = $this->routeTransformer->hydrate($this->route->get($item['route']));
        $route['innerHtml'] = $item['translation'];
        $item['route'] = $this->routeTransformer->translate($route);
        return $item;
    }

    private function translateTitles(array $titles): array
    {
        return $this->locale->getMany($titles);
    }

    private function translateTopics(array $topics): array
    {
        $translated = [];
        foreach ($topics as $key => $topic) {
            $translatedKey = $this->locale->get($key);
            $translated[$translatedKey] = ['entity_lists' => []];
            if (in_array('entity_lists', array_keys($topic))){
                foreach ($topic['entity_lists'] as $entityList) {
                    $translated[$translatedKey]['entity_lists'][] = $this->translateEntityList($entityList);
                }
            }
        }
        return $translated;
    }
}
