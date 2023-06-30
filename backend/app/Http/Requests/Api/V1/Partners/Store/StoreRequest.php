<?php

namespace App\Http\Requests\Api\V1\Partners\Store;

use App\Http\Requests\Api\AbstractFormRequest;
use App\Models\Partner;
use App\ValueObjects\GeoValues\AddressGeo;
use App\ValueObjects\GeoValues\CoverageAreaGeo;
use App\ValueObjects\GeoValues\GeoObjectInterface;

class StoreRequest extends AbstractFormRequest implements StoreContract
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            self::ID => sprintf(
                'required|unique:%s,%s',
                Partner::class,
                Partner::ID
            ),
            self::OWNER_NAME => 'required',
            self::TRADING_NAME => 'required',
            self::DOCUMENT => sprintf(
                'required|unique:%s,%s',
                Partner::class,
                Partner::DOCUMENT
            ),
            self::ADDRESS => 'required',
            self::ADDRESS . '.type' => 'required',
            self::ADDRESS . '.coordinates' => 'required|array|min:2|max:3',
            self::COVERAGE_AREA => 'required',
            self::COVERAGE_AREA . '.type' => 'required',
            self::COVERAGE_AREA . '.coordinates' => 'required|array',
        ];
    }

    public function getId(): string
    {
        return $this->{self::ID};
    }

    public function getDocument(): string
    {
        return $this->{self::DOCUMENT};
    }

    public function getOwnerName(): string
    {
        return $this->{self::OWNER_NAME};
    }

    public function getTradingName(): string
    {
        return $this->{self::TRADING_NAME};
    }

    public function getAddress(): GeoObjectInterface
    {
        return new AddressGeo($this->{self::ADDRESS});
    }

    public function getCoverageArea(): GeoObjectInterface
    {
        return new CoverageAreaGeo($this->{self::COVERAGE_AREA});
    }
}
