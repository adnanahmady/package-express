<?php

namespace Tests\Feature\Searches;

use App\Models\Partner;
use App\Repositories\PartnerRepository;
use App\ValueObjects\GeoValues\MultiPolygonObject;
use App\ValueObjects\GeoValues\PointObject;
use Illuminate\Support\Str;

class PartnerCreator
{
    public function createFarthestPartner(): Partner
    {
        return $this->createPartner(
            address: [51.62299017132483, 35.59750970371337],
            coverageArea: [
                [51.49259019107063, 35.44375247295332],
                [51.69654913454502, 35.575756672298354],
                [51.53271326191819, 35.897368143836005],
                [51.23346202518201, 35.68717846494236],
                [51.49927736954555, 35.44375247295332],
            ]
        );
    }

    public function createNearestPartner(): Partner
    {
        return $this->createPartner(
            address: [51.365533800053896, 35.666808037797324],
            coverageArea: [
                [51.33042611306254, 35.581195484184946],
                [51.29030304221595, 35.62469268106375],
                [51.26856971217342, 35.69804056646748],
                [51.39061071933392, 35.752328879334655],
                [51.454138914841735, 35.680388900315975],
                [51.4257184063253, 35.60702479645083],
                [51.33042611306254, 35.581195484184946],
            ]
        );
    }

    public function createFarPartner(): Partner
    {
        return $this->createPartner(
            address: [51.20671331128432, 35.51590537203106],
            coverageArea: [
                [51.15321588348786, 35.63963938099428],
                [51.37556456776636, 35.680388900315975],
                [51.41067225475766, 35.50637945621041],
                [51.33711329153746, 35.42604470330157],
                [51.13816973191925, 35.31698813345001],
                [51.036190260182536, 35.44375247295332],
                [50.98770821624231, 35.552637601900614],
                [51.124795374970404, 35.65594168405154],
                [51.15823126734304, 35.6382807055834]
            ]
        );
    }

    public function createNotCoveringPartner(): Partner
    {
        return $this->createPartner(
            address: [51.00944154628485, 35.839113192515],
            coverageArea: [
                [50.94925694001347, 35.85266467702064],
                [51.176621008148146, 35.88246979106319],
                [51.012785135522336, 35.693967451753096],
                [50.94925694001347, 35.85401969811225]
            ]
        );
    }

    public function createPartner(
        string $id = null,
        array $address = null,
        array $coverageArea = null,
    ): Partner {
        $data = $this->getData();

        return (new PartnerRepository())->create(
            $id ?? Str::random(),
            Str::random(),
            $data['ownerName'],
            $data['tradingName'],
            new PointObject(
                type: 'Point',
                coordinates: $address ?? [
                    28.40984179744649,
                    34.57718007780727
                ],
            ),
            new MultiPolygonObject(
                type: "MultiPolygon",
                coordinates: [
                    [
                        $coverageArea ?? [
                            [30.0, 20.0],
                            [45.0, 40.0],
                            [10.0, 40.0],
                            [30.0, 20.0]
                        ]
                    ],
                ],
            ),
        );
    }

    private function getData(): array
    {
        return jsonReader('Partners/rawData')->read()->first();
    }
}
