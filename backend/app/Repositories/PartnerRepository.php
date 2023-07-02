<?php

namespace App\Repositories;

use App\Contracts\Models\CoordinationContract;
use App\Http\Requests\Api\V1\Searches\LatitudeInterface;
use App\Http\Requests\Api\V1\Searches\LongitudeInterface;
use App\Models\Address;
use App\Models\CoverageArea;
use App\Models\Partner;
use App\Support\Values\SridValue;
use App\ValueObjects\GeoValues\GeoObjectInterface;
use Illuminate\Database\Eloquent\Collection;

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

    public function findInArea(
        LongitudeInterface&LatitudeInterface $point
    ): Collection {
        return Partner::query()->whereHas(
            'coverageArea.coverage',
            fn ($q) => $q->whereRaw($this->findInAreaSqlQuery($point))
        )->get();
    }

    private function findInAreaSqlQuery(
        LongitudeInterface&LatitudeInterface $point
    ): string {
        return sprintf(
            'ST_Contains(ST_SetSRID(%1$s::geometry, %2$d), ' .
            'ST_GeomFromText(\'POINT(%3$s %4$s)\', %2$d))',
            CoordinationContract::COORDINATION,
            (string) new SridValue(),
            $point->getLongitude(),
            $point->getLatitude(),
        );
    }
}
