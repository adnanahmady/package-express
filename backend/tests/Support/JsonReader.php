<?php

namespace Tests\Support;

use Illuminate\Support\Collection;

class JsonReader implements ReaderInterface
{
    private string $path;

    public function __construct(string $path)
    {
        $this->path = base_path(
            join('/', ['tests/files', trim($path, '/')])
        );
    }

    public function read(string $file = null): Collection
    {
        $content = $this->extractContent($file);
        $array = $this->decode($content);

        return collect($array);
    }

    private function decode(bool|string $content): mixed
    {
        return json_decode($content, true);
    }

    private function extractContent(?string $file): string|false
    {
        return file_get_contents($this->preparePath($file));
    }

    private function preparePath(?string $file): string
    {
        $path = $file ?
            join('/', [$this->path, $file]) :
            $this->path;

        return str_replace('.json', '', $path) . '.json';
    }
}
