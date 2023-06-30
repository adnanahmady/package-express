<?php

namespace App\Repositories;

use App\Models\Address;
use App\Models\Partner;
use App\Support\GeoCreator\Creator;
use App\ValueObjects\GeoValues\GeoObjectInterface;

class AddressRepository
{
    public function create(
        Partner $partner,
        GeoObjectInterface $object
    ): Address {
        $geo = (new Creator($object))->create();

        return Address::create([
            Address::PARTNER => $partner->getId(),
            Address::COORDINATION_ID => $geo->getId(),
            Address::COORDINATION_TYPE => $object->getType()
        ]);
    }
}
