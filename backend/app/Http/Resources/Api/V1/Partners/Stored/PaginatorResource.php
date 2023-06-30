<?php

namespace App\Http\Resources\Api\V1\Partners\Stored;

use Illuminate\Http\Resources\Json\JsonResource;

class PaginatorResource extends JsonResource
{
    public const DATA = 'data';
    public const META = 'meta';

    public function toArray($request): array
    {
        return [
            self::DATA => new DataResource($this->resource),
            self::META => new MetaResource($this->resource),
        ];
    }
}
