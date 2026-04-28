<?php

namespace lib\core;

class TmhDatabase
{
    private array $images = [];
    private array $imageGroups = [];
    private array $inscriptions = [];
    private array $uploads = [];
    private array $uploadGroups = [];
    private array $urls = [];
    private array $webSites = [];

    public function __construct(private readonly TmhJson $json)
    {
    }

    public function image(string $uuid): array
    {
        $images = $this->getImages();
        return in_array($uuid, array_keys($images)) ? $images[$uuid] : ['alt' => [], 'src' => ''];
    }

    public function imageGroup(string $uuid): array
    {
        $imageGroups = $this->getImageGroups();
        return in_array($uuid, array_keys($imageGroups)) ? $imageGroups[$uuid] : ['date' => '', 'images' => []];
    }

    public function inscription(string $uuid): string
    {
        $inscriptions = $this->getInscriptions();
        return in_array($uuid, array_keys($inscriptions)) ? $inscriptions[$uuid] : '';
    }

    public function upload(string $uuid): array
    {
        $uploads = $this->getUploads();
        return in_array($uuid, array_keys($uploads)) ? $uploads[$uuid] : ['alt' => [], 'src' => '', 'url' => ''];
    }

    public function uploadGroup(string $uuid): array
    {
        $uploadGroups = $this->getUploadGroups();
        $emptyUploadGroup = ['uploads' => [], 'type' => '0', 'translation' => ''];
        return in_array($uuid, array_keys($uploadGroups)) ? $uploadGroups[$uuid] : $emptyUploadGroup;
    }

    public function url(string $uuid): array
    {
        $urls = $this->getUrls();
        $empty = ['translation' => '', 'type' => '', 'url' => '', 'website' => ''];
        return in_array($uuid, array_keys($urls)) ? $urls[$uuid] : $empty;
    }

    public function webSite(string $uuid): array
    {
        $webSites = $this->getWebSites();
        $empty = ['translation' => '', 'lang' => '', 'url' => ''];
        return in_array($uuid, array_keys($webSites)) ? $webSites[$uuid] : $empty;
    }

    private function getImages(): array
    {
        if (empty($this->images)) {
            $this->images = $this->json->database('image');
        }
        return $this->images;
    }

    private function getImageGroups(): array
    {
        if (empty($this->imageGroups)) {
            $this->imageGroups = $this->json->database('image_group');
        }
        return $this->imageGroups;
    }

    private function getInscriptions(): array
    {
        if (empty($this->inscriptions)) {
            $this->inscriptions = $this->json->database('inscription');
        }
        return $this->inscriptions;
    }

    private function getUploads(): array
    {
        if (empty($this->uploads)) {
            $this->uploads = $this->json->database('upload');
        }
        return $this->uploads;
    }

    private function getUploadGroups(): array
    {
        if (empty($this->uploadGroups)) {
            $this->uploadGroups = $this->json->database('upload_group');
        }
        return $this->uploadGroups;
    }

    private function getUrls(): array
    {
        if (empty($this->urls)) {
            $this->urls = $this->json->database('url');
        }
        return $this->urls;
    }

    private function getWebSites(): array
    {
        if (empty($this->webSites)) {
            $this->webSites = $this->json->database('web_site');
        }
        return $this->webSites;
    }
}