<?php

namespace App\Http\Resources\Api\V1\Partners\Show;

use App\Http\Resources\Api\V1\Partners\Shared\PaginatorContract;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginatorResource extends JsonResource implements PaginatorContract
{
    public function toArray($request): array
    {
        return [
            self::DATA => new DataResource($this->resource),
            self::META => new MetaResource($this->resource),
        ];
    }
}
