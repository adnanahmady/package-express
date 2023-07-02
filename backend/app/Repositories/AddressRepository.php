<?php

namespace App\Repositories;

use App\Http\Requests\Api\V1\Searches\LatitudeInterface;
use App\Http\Requests\Api\V1\Searches\LongitudeInterface;
use App\Models\Address;
use App\Models\Gis\Point;
use App\Models\Partner;
use App\Support\GeoCreator\Creator;
use App\ValueObjects\GeoValues\GeoObjectInterface;
use Illuminate\Database\Query\Expression;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

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

    public function findNearest(
        Collection $partners,
        LongitudeInterface&LatitudeInterface $point
    ): Address|null {
        /** @var Address */
        return Address::query()
            ->whereIn(Address::PARTNER, $partners)
            ->join(
                Point::TABLE,
                sprintf('%s.%s', Point::TABLE, Point::ID),
                '=',
                sprintf('%s.%s', Address::TABLE, Address::COORDINATION_ID)
            )
            ->select($this->sortByNearestSqlQuery($point, $key = 'nearest'))
            ->orderBy($key)
            ->first();
    }

    private function sortByNearestSqlQuery(
        LongitudeInterface&LatitudeInterface $point,
        string $key
    ): Expression {
        return DB::raw(sprintf(
            '%s, ST_DistanceSphere(%s.%s::geometry,' .
            ' ST_MakePoint(%s,%s)::geometry) as %s',
            Address::PARTNER,
            Point::TABLE,
            Point::COORDINATION,
            $point->getLongitude(),
            $point->getLatitude(),
            $key
        ));
    }
}
