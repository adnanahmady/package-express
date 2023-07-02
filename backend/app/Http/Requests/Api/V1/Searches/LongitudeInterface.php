<?php

namespace App\Http\Requests\Api\V1\Searches;

interface LongitudeInterface
{
    public function getLongitude(): float|int;
}
