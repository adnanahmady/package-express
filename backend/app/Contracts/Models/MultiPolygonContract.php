<?php

namespace App\Contracts\Models;

interface MultiPolygonContract extends CoordinationContract
{
    public const TABLE = 'multi_polygons';
    public const ID = 'id';
}
