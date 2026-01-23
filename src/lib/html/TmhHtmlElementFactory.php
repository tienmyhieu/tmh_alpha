<?php

namespace lib\html;

use lib\core\TmhServer;

readonly class TmhHtmlElementFactory
{
    private const string FAV_ICON = '/favicon.png';
    private const string PRINT_STYLE_SHEET = '/css/tienmyhieu-print.css';
    private const string STYLE_SHEET = '/css/tienmyhieu.css';

    public function __construct(private TmhHtmlNodeFactory $nodeFactory, private TmhServer $server)
    {
    }

    public function ancestors(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_ancestors';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function ancestorItem(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_ancestor_item';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function ancestorItemLink(array $attributes, string $innerHtml): array
    {
        $attributes['class'] = 'tmh_ancestor_item_link';
        return $this->nodeFactory->a($attributes, [], $innerHtml);
    }

    public function article(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_article';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function body(array $attributes, array $childNodes): array
    {
        return $this->nodeFactory->body($attributes, $childNodes);
    }

    public function br(): array
    {
        return $this->nodeFactory->br();
    }

    public function center(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_center';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function charset(): array
    {
        return $this->nodeFactory->meta(['charset' => 'utf-8']);
    }

    public function citations(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_citations';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function component(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_component';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function componentGroup(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_component_group';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function componentList(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_component_list';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function contentBody(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_body';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function creativeCommons(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_creative_commons';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function creativeCommonsLink(array $attributes, string $innerHtml): array
    {
        $attributes = [
            'class' => 'tmh_creative_commons_link',
            'href' => $attributes['href'],
            'title' => $attributes['title'],
            'target' => '_blank'
        ];
        return $this->nodeFactory->a($attributes, [], $innerHtml);
    }

    public function entityList(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_entity_list';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function favIcon(): array
    {
        $favIcon = $this->server->imageHost() . self::FAV_ICON;
        return $this->nodeFactory->link(['rel' => 'icon', 'href' => $favIcon, 'type' => 'image/png']);
    }

    public function head(string $description, string $keywords, string $title): array
    {
        return $this->nodeFactory->head([
            $this->charset(),
            $this->title($title),
            $this->metaDescription($description),
            $this->metaKeywords($keywords),
            $this->metaViewport(),
            $this->styleSheet(),
            $this->printStyleSheet(),
            $this->favIcon()
        ]);
    }

    public function html(array $childNodes, string $language): array
    {
        return $this->nodeFactory->html(['lang' => $language], $childNodes);
    }

    public function imageGallery(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_image_gallery';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function imageGalleryItem(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_image_gallery_item';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function imageGalleryItemDescription(array $attributes, string $innerHtml): array
    {
        $attributes['class'] = 'tmh_image_gallery_item_description';
        return $this->nodeFactory->div($attributes, [], $innerHtml);
    }

    public function imageGalleryTitle(array $attributes, string $innerHtml): array
    {
        $attributes['class'] = 'tmh_image_gallery_title';
        return $this->nodeFactory->div($attributes, [], $innerHtml);
    }


    public function imageGroup(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_image_group';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function imageGroupList(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_image_group_list';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function img(string $alt, string $src): array
    {
        return $this->nodeFactory->img(['alt' => $alt, 'class' => 'tmh_image', 'src' => $src]);
    }

    public function indentedSmallText(string $innerHtml): array
    {
        return $this->nodeFactory->span(['class' => 'tmh_indented_small_text'], $innerHtml);
    }

    public function indentedFartherSmallText(string $innerHtml): array
    {
        return $this->nodeFactory->span(['class' => 'tmh_indented_farther_small_text'], $innerHtml);
    }

    public function linkedImage(array $attributes): array
    {
        $linkAttributes = [
            'class' => 'tmh_list_item_link',
            'href' => $attributes['href'],
            //'name' => $attributes['name'],
            'target' => $attributes['target'],
            'title' => $attributes['title']
        ];
        return $this->nodeFactory->a($linkAttributes, [$this->img($attributes['title'], $attributes['src'])], '');
    }

    public function listItem(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_list_item';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function externalListItemLink(array $rawAttributes, string $innerHtml, array $childNodes): array
    {
        $attributes = [
            'class' => 'tmh_list_item_link',
            'href'=> $rawAttributes['href'],
            'title' => $rawAttributes['title'],
            'target' => '_blank'
        ];
        return $this->nodeFactory->a($attributes, $childNodes, $innerHtml);
    }

    public function listItemLink(array $attributes, string $innerHtml): array
    {
        $attributes['class'] = 'tmh_list_item_link';
        return $this->nodeFactory->a($attributes, [], $innerHtml);
    }

    public function listTitle(array $attributes, string $title): array
    {
        return $this->nodeFactory->span($attributes, $title);
    }

    public function marginLeft(array $attributes): array
    {
        $attributes['class'] = 'tmh_margin';
        return $this->nodeFactory->div($attributes, [], '&nbsp;');
    }

    public function marginRight(array $attributes): array
    {
        $attributes['class'] = 'tmh_margin';
        return $this->nodeFactory->div($attributes, [], '&nbsp;');
    }

    public function maxims(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_maxims';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function metaDescription(string $description): array
    {
        return $this->nodeFactory->meta(['name' => 'description', 'content' => $description]);
    }

    public function keyValueList(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_key_value_list';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function keyValue(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_key_value';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function keyValueKey(string $innerHtml): array
    {
        return $this->nodeFactory->span([], $innerHtml);
    }

    public function keyValueListTitle(array $attributes, string $title): array
    {
        $attributes['class'] = 'tmh_key_value_list_title';
        return $this->nodeFactory->div($attributes, [], $title);
    }

    public function keyValueValue(array $attributes, string $innerHtml): array
    {
        return $this->nodeFactory->span($attributes, $innerHtml);
    }

    public function metaKeywords(string $keywords): array
    {
        return $this->nodeFactory->meta(['name' => 'keywords', 'content' => $keywords]);
    }

    public function metaViewport(): array
    {
        return $this->nodeFactory->meta(['name' => 'viewport', 'content' => 'width=device-width, initial-scale=1.0']);
    }

    public function p(array $childNodes): array
    {
        return $this->nodeFactory->p($childNodes);
    }

    public function pageTitle(array $attributes, string $innerHtml): array
    {
        $attributes['class'] = 'tmh_title';
        return $this->nodeFactory->div($attributes, [], $innerHtml);
    }

    public function paleListItemLink(array $attributes, string $innerHtml): array
    {
        $attributes['class'] = 'tmh_pale_list_item_link';
        return $this->nodeFactory->a($attributes, [], $innerHtml);
    }

    public function paleText(array $attributes, string $innerHtml): array
    {
        $attributes['class'] = 'tmh_pale_text';
        return $this->nodeFactory->span($attributes, $innerHtml);
    }

    public function printStyleSheet(): array
    {
        $styleSheet = $this->server->cdnHost() . self::PRINT_STYLE_SHEET;
        return $this->nodeFactory->link(['media'=> 'print', 'rel' => 'stylesheet', 'href' => $styleSheet]);
    }

    public function quoteList(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_quote_list';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function quoteListHorizontal(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_quote_list_horizontal';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function verticalQuoteListItem(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_vertical_quote_list_item';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function quoteListVertical(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_quote_list_vertical';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function siblings(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_siblings';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function siblingItem(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_sibling_item';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function siblingItemLink(array $attributes, string $innerHtml): array
    {
        $attributes['class'] = 'tmh_sibling_item_link';
        return $this->nodeFactory->a($attributes, [], $innerHtml);
    }

    public function smallText(array $attributes, string $innerHtml): array
    {
        $attributes['class'] = 'tmh_small_text';
        return $this->nodeFactory->span($attributes, $innerHtml);
    }

    public function span(array $attributes, string $innerHtml): array
    {
        return $this->nodeFactory->span($attributes, $innerHtml);
    }

    public function styleSheet(): array
    {
        $styleSheet = $this->server->cdnHost() . self::STYLE_SHEET;
        return $this->nodeFactory->link(['media'=> 'screen', 'rel' => 'stylesheet', 'href' => $styleSheet]);
    }

    public function source(array $attributes): array
    {
        return $this->nodeFactory->source($attributes);
    }

    public function svgImg(string $src): array
    {
        return $this->nodeFactory->img(['alt' => '', 'class' => 'tmh_svg_icon', 'src' => $src]);
    }

    public function table(string $class, array $childNodes): array
    {
        return $this->nodeFactory->table($class, $childNodes);
    }

    public function td(array $attributes, string $innerHtml): array
    {
        return $this->nodeFactory->td($attributes, $innerHtml);
    }

    public function thinBr(array $attributes): array
    {
        $attributes['class'] = 'tmh_thin_br';
        return $this->nodeFactory->div($attributes, [], '');
    }

    public function title(string $innerHtml): array
    {
        return $this->nodeFactory->title($innerHtml);
    }

    public function tr(string $class, array $childNodes): array
    {
        return $this->nodeFactory->tr($class, $childNodes);
    }

    public function topic(array $attributes, string $innerHtml): array
    {
        $attributes['class'] = 'tmh_' . $attributes['class'];
        return $this->nodeFactory->div($attributes, [], $innerHtml);
    }

    public function uploadGroup(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_upload_group';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function uploadGroupList(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_upload_group_list';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function video(string $height, string $src, string $width): array
    {
        $source = $this->source(['src' => $src, 'type' => 'video/mp4']);
        $video = $this->nodeFactory->video(['height' => $height, 'width' => $width], [$source], '');
        $attributes['class'] = 'tmh_video';
        return $this->nodeFactory->div($attributes, [$video], '');
    }

    public function videoGroup(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_video_group';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }

    public function videoGroupList(array $attributes, array $childNodes): array
    {
        $attributes['class'] = 'tmh_video_group_list';
        return $this->nodeFactory->div($attributes, $childNodes, '');
    }
}
