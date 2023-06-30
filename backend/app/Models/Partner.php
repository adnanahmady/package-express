<?php

namespace App\Models;

use App\Contracts\Models\PartnerContract;
use App\ValueObjects\GeoValues\AddressGeo;
use App\ValueObjects\GeoValues\CoverageAreaGeo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Partner extends Model implements PartnerContract
{
    use HasFactory;

    protected $table = self::TABLE;
    protected $primaryKey = self::ID;
    public $incrementing = false;

    protected $fillable = [
        self::ID,
        self::OWNER_NAME,
        self::TRADING_NAME,
        self::DOCUMENT,
    ];

    public function address(): HasOne
    {
        return $this->hasOne(
            Address::class,
            Address::PARTNER,
            self::ID,
        );
    }

    public function coverageArea(): HasOne
    {
        return $this->hasOne(
            CoverageArea::class,
            CoverageArea::PARTNER,
            self::ID
        );
    }

    public function getId(): string
    {
        return $this->{self::ID};
    }

    public function getOwnerName(): string
    {
        return $this->{self::OWNER_NAME};
    }

    public function getDocument(): string
    {
        return $this->{self::DOCUMENT};
    }

    public function getTradingName(): string
    {
        return $this->{self::TRADING_NAME};
    }

    public function getAddress(): AddressGeo
    {
        return $this->address->getGeoObject();
    }

    public function getCoverageArea(): CoverageAreaGeo
    {
        return $this->coverageArea->getGeoObject();
    }
}
