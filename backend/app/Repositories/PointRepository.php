<?php

namespace App\Repositories;

use App\Models\Gis\Point;
use App\ValueObjects\GeoValues\GeoObjectInterface;

class PointRepository
{
    public function create(GeoObjectInterface $object): Point
    {
        return Point::create([
            Point::COORDINATION => $object->toGeomExpression()
        ]);
    }
}
