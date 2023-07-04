<?php

namespace App\Support\ApiMappers;

use App\Support\ValueValidators\TypeValidator;
use App\Support\ValueValidators\UnitValidator;

class WeatherMapper extends AbstractMapper
{
    protected array $map = [
        'longitude' => 'lon',
        'latitude' => 'lat',
        'type' => 'mode',
        'unit' => 'units',
    ];

    protected array $required = [
        'longitude',
        'latitude',
    ];

    protected function type(string $type): string
    {
        (new TypeValidator($type))->validate();

        return $type;
    }

    protected function unit(string $type): string
    {
        (new UnitValidator($type))->validate();

        return $type;
    }
}
