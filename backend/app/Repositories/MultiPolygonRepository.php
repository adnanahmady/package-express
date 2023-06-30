<?php

namespace App\Repositories;

use App\Models\Gis\MultiPolygon;
use App\ValueObjects\GeoValues\GeoObjectInterface;

class MultiPolygonRepository
{
    public function create(GeoObjectInterface $object): MultiPolygon
    {
        return MultiPolygon::create([
            MultiPolygon::COORDINATION => $object->toGeomExpression()
        ]);
    }
}
