<?php

namespace App\Http\Resources\Api\V1\Searches\Nearest;

use App\Http\Resources\Api\V1\Partners\Shared\PaginatorContract;
use Illuminate\Http\JsonResponse;

class NoFilterResponse extends JsonResponse implements
    PaginatorContract,
    MessageContract
{
    public function __construct()
    {
        parent::__construct($this->data());
    }

    public function data(): array
    {
        return [
            self::META => [
                self::MESSAGE => __('You should set an enquiry.'),
            ]
        ];
    }
}
