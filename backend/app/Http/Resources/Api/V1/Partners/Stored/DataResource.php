<?php

namespace App\Http\Resources\Api\V1\Partners\Stored;

use App\Models\Partner;
use App\Repositories\PartnerRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class DataResource extends JsonResource implements RelationContract
{
    public const ID = 'id';
    public const OWNER_NAME = 'owner_name';
    public const DOCUMENT = 'document';
    public const TRADING_NAME = 'trading_name';

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
