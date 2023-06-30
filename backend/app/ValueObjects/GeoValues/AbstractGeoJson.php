<?php

namespace App\ValueObjects\GeoValues;

use App\ExceptionMessages\Geo\CoordinatesRequiredMessage;
use App\ExceptionMessages\Geo\TypeRequiredMessage;
use App\Exceptions\InvalidGeoJsonException;
use App\Support\Values\SridValue;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\DB;

abstract class AbstractGeoJson implements GeoObjectInterface
{
    public const TYPE = 'type';
    public const COORDINATES = 'coordinates';

    public function __construct(private readonly array $object)
    {
        $this->validate($object);
    }

    public function getType(): string
    {
        return $this->object[self::TYPE];
    }

    public function getCoordinates(): array
    {
        return $this->object[self::COORDINATES];
    }

    public function __toString(): string
    {
        return json_encode($this->object);
    }

    public function isA(string $type): bool
    {
        return $type === $this->object['type'];
    }

    protected function validate(array $object): void
    {
        InvalidGeoJsonException::throwIf(
            !key_exists(self::TYPE, $object),
            new TypeRequiredMessage()
        );
        InvalidGeoJsonException::throwIf(
            !key_exists(self::COORDINATES, $object),
            new CoordinatesRequiredMessage()
        );
    }

    public function toGeomExpression(): Expression
    {
        return DB::raw(
            "ST_SetSRID(ST_GeomFromGeoJSON('{$this}'), " .
            new SridValue() .
            ')',
        );
    }

    public static function initiateFromGeom(string $geom): GeoObjectInterface
    {
        return new static(
            toArray(DB::selectOne(DB::raw(
                "SELECT ST_AsGeoJSON('$geom') as json",
            ))->json)
        );
    }
}
