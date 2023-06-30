<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\CoverageArea;
use App\Models\Partner;
use App\ValueObjects\GeoValues\GeoObjectInterface;

class PartnerRepository
{
    public function create(
        string $id,
        string $document,
        string $ownerName,
        string $tradingName,
        GeoObjectInterface $addressGeo,
        GeoObjectInterface $coverageAreaGeo
    ): Partner {
        $partner = Partner::create([
            Partner::ID => $id,
            Partner::DOCUMENT => $document,
            Partner::OWNER_NAME => $ownerName,
            Partner::TRADING_NAME => $tradingName,
        ]);
        (new AddressRepository())->create($partner, $addressGeo);
        (new CoverageAreaRepository())->create($partner, $coverageAreaGeo);

        return $partner;
    }

    public function getAddress(Partner $partner): Address
    {
        return $partner->address;
    }

    public function getCoverageArea(Partner $partner): CoverageArea
    {
        return $partner->coverageArea;
    }
}
