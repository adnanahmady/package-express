<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Requests\Api\V1\Searches\SearchNearestRequest;
use App\Http\Resources\Api\V1\Searches\Nearest;
use App\Repositories\SearchRepository;

class LocationController
{
    public function nearest(
        SearchNearestRequest $request,
        SearchRepository $searchRepository
    ): Nearest\NoFilterResponse|Nearest\PaginatorResource {
        if (!$request->hasPoint()) {
            return new Nearest\NoFilterResponse();
        }

        return new Nearest\PaginatorResource(
            $searchRepository->findNearest($request->getPoint())
        );
    }
}
