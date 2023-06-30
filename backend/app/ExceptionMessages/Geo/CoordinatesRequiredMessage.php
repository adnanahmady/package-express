<?php

namespace App\ExceptionMessages\Geo;

use App\ExceptionMessages\ExceptionMessageInterface;

class CoordinatesRequiredMessage implements ExceptionMessageInterface
{
    public function __toString(): string
    {
        return 'Please set the coordinates of Geo json object.';
    }
}
