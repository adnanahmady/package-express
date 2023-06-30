<?php

namespace App\Support\GeoCreator;

use App\Contracts\Models\GisModelInterface;
use App\ValueObjects\GeoValues\GeoObjectInterface;

class Creator
{
    public function __construct(public GeoObjectInterface $object)
    {
    }

    public function create(): GisModelInterface
    {
        return (new PointCreator($this))->create();
    }
}
