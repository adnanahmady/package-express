<?php

namespace App\ValueObjects\GeoValues;

use App\ExceptionMessages\Geo\InvalidGeoObjectMessage;
use App\Exceptions\InvalidGeoJsonException;
use App\Support\Values\SridValue;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Facades\DB;

abstract class AbstractGeoJson implements GeoObjectInterface
{
    public function __construct(
        private readonly string $type,
        private readonly array $coordinates,
    ) {
    }

    public function getType(): string
    {
        return $this->type;
    }

    public function getCoordinates(): array
    {
        return $this->coordinates;
    }

    public function __toString(): string
    {
        return $this->represent();
    }

    public function represent(): string
    {
        $json = json_encode([
            'type' => $this->type,
            'coordinates' => $this->coordinates
        ]);

        InvalidGeoJsonException::throwIf(
            !$json,
            new InvalidGeoObjectMessage($this)
        );

        return $json;
    }

    public function isA(string $type): bool
    {
        return $type === $this->type;
    }

    public function toGeomExpression(): Expression
    {
        return DB::raw(
            "ST_SetSRID(ST_GeomFromGeoJSON('{$this}'), " .
            new SridValue() .
            ')',
        );
    }

    public static function initiateFromGeom(string $geom): static
    {
        $array = toArray(DB::selectOne(DB::raw(
            "SELECT ST_AsGeoJSON('$geom') as json",
        ))->json);

        return static::initiateFromArray($array);
    }

    public static function initiateFromArray(array $array): static
    {
        return new static($array['type'], $array['coordinates']);
    }
}
