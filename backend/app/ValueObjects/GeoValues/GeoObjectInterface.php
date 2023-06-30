<?php

namespace App\ValueObjects\GeoValues;

use Illuminate\Database\Query\Expression;

interface GeoObjectInterface
{
    public function getType(): string;

    public function getCoordinates(): array;

    public function __toString(): string;

    public function isA(string $type): bool;

    public function toGeomExpression(): Expression;

    public static function initiateFromGeom(string $geom): GeoObjectInterface;
}
