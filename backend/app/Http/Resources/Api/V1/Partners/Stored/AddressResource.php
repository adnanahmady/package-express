<?php

namespace App\Http\Resources\Api\V1\Partners\Stored;

use App\Models\Address;
use Illuminate\Http\Resources\Json\JsonResource;

class AddressResource extends JsonResource implements GeoContract
{
    /**
     * @var Address
     */
    public $resource;

    public function toArray($request): array
    {
        return [
            self::ID => $this->resource->getId(),
            self::TYPE => $this->resource->getGeoObject()->getType(),
            self::COORDINATES => $this->resource->getGeoObject()
                ->getCoordinates(),
        ];
    }
}
