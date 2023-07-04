<?php

namespace App\Api\OpenWeather;

use App\Support\ApiMappers\AbstractMapper;
use App\Support\ApiMappers\WeatherMapper;

class Weather extends AbstractModel
{
    private AbstractMapper $mapper;

    public function __construct(array $params = [])
    {
        $this->mapper = new WeatherMapper($params);
    }

    public function get(): array
    {
        return $this->getCaller()
            ->addParams($this->mapper->getParams())
            ->getJson('/data/2.5/weather');
    }
}
