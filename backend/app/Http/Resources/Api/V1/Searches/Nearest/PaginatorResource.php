<?php

namespace App\Http\Resources\Api\V1\Searches\Nearest;

use App\Http\Resources\Api\V1\Partners\Shared\PaginatorContract;
use App\Http\Resources\Api\V1\Partners\Show;
use Illuminate\Http\Resources\Json\JsonResource;

class PaginatorResource extends JsonResource implements
    PaginatorContract
{
    public function toArray($request): array
    {
        return [
            self::DATA => $this->resource ?
                new Show\DataResource($this->resource) :
                [],
            self::META => $this->when(
                $this->resource,
                new Show\MetaResource($this->resource)
            ),
        ];
    }
}
