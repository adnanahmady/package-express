<?php

namespace App\Support\GeoCreator\Types;

class MultiPolygonType implements TypeInterface
{
    public function __toString(): string
    {
        return 'MultiPolygon';
    }
}
