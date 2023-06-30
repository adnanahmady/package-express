<?php

namespace App\Http\Resources\Api\V1\Partners\Show;

use App\Http\Resources\Api\V1\Partners\Shared\DataContract;
use App\Http\Resources\Api\V1\Partners\Shared\RelationContract;
use App\Models\Partner;
use App\Repositories\PartnerRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class DataResource extends JsonResource implements
    DataContract,
    RelationContract
{
    /**
     * @var Partner
     */
    public $resource;
    private PartnerRepository $partnerRepository;

    public function __construct($resource)
    {
        parent::__construct($resource);
        $this->partnerRepository = new PartnerRepository();
    }

    public function toArray($request): array
    {
        return [
            self::ID => $this->resource->getId(),
            self::OWNER_NAME => $this->resource->getOwnerName(),
            self::DOCUMENT => $this->resource->getDocument(),
            self::TRADING_NAME => $this->resource->getTradingName(),
            self::ADDRESS => $this->partnerRepository
                ->getAddress($this->resource)
                ->getId(),
            self::COVERAGE_AREA => $this->partnerRepository
                ->getCoverageArea($this->resource)
                ->getId(),
        ];
    }
}
