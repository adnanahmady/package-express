<?php

namespace App\Http\Resources\Api\V1\Partners\Stored;

use App\Models\CoverageArea;
use Illuminate\Http\Resources\Json\JsonResource;

class CoverageAreaResource extends JsonResource implements GeoContract
{
    /**
     * @var CoverageArea
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
