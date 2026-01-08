<?php

namespace lib\html\component;

readonly class TmhTopicsHtmlComponent implements TmhHtmlComponent
{
    public function __construct(private TmhHtmlComponentFactory $htmlComponentFactory)
    {
    }

    public function get(array $entity): array
    {
        $componentNodes = [];
        foreach ($entity as $topic) {
            $component = $this->htmlComponentFactory->create('topic');
            $componentNodes = $component->get($topic);
        }

//        $componentLists = [];
//        foreach ($attributeGroup as $attributeList) {
//            $components = [];
//            foreach ($attributeList as $attribute) {
//                $htmlComponent = $this->htmlComponentFactory->create($attribute['component_type']);
//                $components = array_merge($components, $htmlComponent->get($attribute));
//            }
//            $componentLists[] = $this->elementFactory->componentList($components);
//        }
//        $childNodes[] = $this->elementFactory->componentGroup($componentLists);
        return $componentNodes;
    }
}
