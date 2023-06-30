<?php

namespace App\Models;

use App\Contracts\Models\AddressContract;
use App\Contracts\Models\CoordinationContract;
use App\ValueObjects\GeoValues\AddressGeo;
use App\ValueObjects\GeoValues\GeoObjectInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Address extends Model implements AddressContract
{
    use HasFactory;

    protected $table = self::TABLE;
    protected $primaryKey = self::ID;

    protected $fillable = [
        self::PARTNER,
        self::COORDINATION_ID,
        self::COORDINATION_TYPE,
    ];

    public function coordination(): MorphTo
    {
        return $this->morphTo();
    }

    public function getGeoObject(): GeoObjectInterface
    {
        return AddressGeo::initiateFromGeom(
            $this->coordination->{
                CoordinationContract::COORDINATION
            }
        );
    }

    public function getId(): int
    {
        return $this->{self::ID};
    }
}
