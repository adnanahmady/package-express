<?php

namespace App\Http\Requests\Api\V1\Searches;

class PointParameter implements LongitudeInterface, LatitudeInterface
{
    public function __construct(private readonly array $point)
    {
    }

    public function getLongitude(): float|int
    {
        return $this->point['lon'];
    }

    public function getLatitude(): float|int
    {
        return $this->point['lat'];
    }
}
