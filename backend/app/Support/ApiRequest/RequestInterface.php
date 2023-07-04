<?php

namespace App\Support\ApiRequest;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\Response;

interface RequestInterface
{
    public function addParams(array $params): self;

    public function get(
        string $url,
        array $params = []
    ): Response|PromiseInterface;

    public function getJson(string $url, array $params = []): array;
}
