<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\Partners\Store\StoreRequest;
use App\Http\Resources\Api\V1\Partners\Stored;
use App\Models\Partner;
use App\Repositories\PartnerRepository;

class PartnerController extends Controller
{
    public function store(
        StoreRequest $request,
        PartnerRepository $partnerRepository,
    ): Stored\PaginatorResource {
        $partner = $partnerRepository->create(
            $request->getId(),
            $request->getDocument(),
            $request->getOwnerName(),
            $request->getTradingName(),
            $request->getAddress(),
            $request->getCoverageArea(),
        );

        return new Stored\PaginatorResource($partner);
    }

    public function show(Partner $partner): void
    {
    }
}
