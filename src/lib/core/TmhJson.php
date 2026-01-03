<?php

namespace lib\core;

class TmhJson
{
    public function domains(): array
    {
        return $this->loadFile(__DIR__ . '/../../', 'domains');
    }

    private function loadFile(string $path, string $file): array
    {
        $contents = '[]';
        if ($this->exists($path . $file . '.json')) {
            // echo "<pre>" . 'reading ' . $path . $file . PHP_EOL . "</pre>";
            $contents = file_get_contents($path . $file . '.json');
        } else {
            // echo "<pre>" . 'not reading ' . $path . $file . PHP_EOL . "</pre>";
        }
        return json_decode($contents, true);
    }

    private function exists(string $url): bool
    {
        return (false !== @file_get_contents($url, 0, null, 0, 1));
    }
}
