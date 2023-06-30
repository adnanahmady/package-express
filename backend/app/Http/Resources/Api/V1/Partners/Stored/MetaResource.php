<?php

namespace App\Http\Resources\Api\V1\Partners\Stored;

use App\Models\Partner;
use App\Repositories\PartnerRepository;
use Illuminate\Http\Resources\Json\JsonResource;

class MetaResource extends JsonResource implements RelationContract
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
            self::ADDRESS => new AddressResource(
                $this->partnerRepository
                    ->getAddress($this->resource)
            ),
            self::COVERAGE_AREA => new CoverageAreaResource(
                $this->partnerRepository
                    ->getCoverageArea($this->resource)
            ),
        ];
    }
}
