<?php

namespace App\Api\OpenWeather;

use App\Support\ApiRequest\Request;
use App\Support\ApiRequest\RequestInterface;

abstract class AbstractModel
{
    /**
     * The host address for the url.
     *
     * Overwrite this method if you need to
     * point to another host url.
     *
     * @return string
     */
    protected function getBaseUrl(): string
    {
        return config('api.open_weather.base_url');
    }

    private function getApiKey(): mixed
    {
        return config('api.open_weather.apikey');
    }

    protected function getCaller(): RequestInterface
    {
        $request = new Request($this->getBaseUrl());

        return $request->addParams([
            'appid' => $this->getApiKey()
        ]);
    }
}
