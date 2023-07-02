<?php

namespace App\Http\Requests\Api\V1\Searches;

interface LatitudeInterface
{
    public function getLatitude(): float|int;
}
