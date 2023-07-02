<?php

namespace App\Support\GeoCreator;

use App\Contracts\Models\GisModelInterface;
use App\ExceptionMessages\Geo\InvalidGeoObjectMessage;
use App\Exceptions\InvalidGeoJsonException;
use App\Repositories\MultiPolygonRepository;
use App\Support\GeoCreator\Types\MultiPolygonType;

class MultiPolygonCreator implements CreatorInterface
{
    public function __construct(private readonly Creator $creator)
    {
    }

    public function create(): GisModelInterface
    {
        InvalidGeoJsonException::throwIf(
            !$this->creator->object->isA(new MultiPolygonType()),
            new InvalidGeoObjectMessage(
                $this->creator->object
            )
        );

        return $this->getRepository()->create(
            $this->creator->object
        );
    }

    private function getRepository(): MultiPolygonRepository
    {
        return new MultiPolygonRepository();
    }
}
