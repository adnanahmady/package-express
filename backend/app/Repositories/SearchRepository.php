<?php

namespace App\Repositories;

use App\Http\Requests\Api\V1\Searches\LatitudeInterface;
use App\Http\Requests\Api\V1\Searches\LongitudeInterface;
use App\Models\Partner;

class SearchRepository
{
    public function findNearest(
        LongitudeInterface&LatitudeInterface $point
    ): Partner|null {
        $coveredPartners = (new PartnerRepository())->findInArea($point);
        $address = (new AddressRepository())->findNearest(
            $coveredPartners->map->getId(),
            $point
        );

        return $address?->partner;
    }
}
