<?php

namespace App\Support\GeoCreator\Types;

class PointType implements TypeInterface
{
    public function __toString(): string
    {
        return 'Point';
    }
}
