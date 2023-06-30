<?php

namespace App\Repositories;

use App\Models\CoverageArea;
use App\Models\Partner;
use App\Support\GeoCreator\Creator;
use App\ValueObjects\GeoValues\GeoObjectInterface;

class CoverageAreaRepository
{
    public function create(
        Partner $partner,
        GeoObjectInterface $object
    ): CoverageArea {
        $geo = (new Creator($object))->create();

        return CoverageArea::create([
            CoverageArea::PARTNER => $partner->getId(),
            CoverageArea::COVERAGE_ID => $geo->getId(),
            CoverageArea::COVERAGE_TYPE => $object->getType(),
        ]);
    }
}
