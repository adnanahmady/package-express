<?php

namespace App\Support\ApiRequest;

use GuzzleHttp\Promise\PromiseInterface;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\Client\Response;
use Illuminate\Support\Facades\Http;

class Request implements RequestInterface
{
    private readonly PendingRequest $request;
    private array $params = [];

    public function __construct(string $baseUrl)
    {
        $this->request = Http::baseUrl($baseUrl);
    }

    public function addParams(array $params): self
    {
        $this->params = array_merge(
            $this->params,
            $params
        );

        return $this;
    }

    public function get(
        string $url,
        array $params = []
    ): Response|PromiseInterface {
        $this->addParams($params);

        return $this->request->get($url, $this->params);
    }

    public function getJson(string $url, array $params = []): array
    {
        return $this->get($url, $params)->json();
    }
}
