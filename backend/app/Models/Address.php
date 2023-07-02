<?php

namespace App\Models;

use App\Contracts\Models\AddressContract;
use App\Contracts\Models\CoordinationContract;
use App\ValueObjects\GeoValues\GeoObjectInterface;
use App\ValueObjects\GeoValues\PointObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
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

    public function partner(): BelongsTo
    {
        return $this->belongsTo(Partner::class);
    }

    public function getGeoObject(): GeoObjectInterface
    {
        return PointObject::initiateFromGeom(
            $this->coordination->{CoordinationContract::COORDINATION}
        );
    }

    public function getId(): int
    {
        return $this->{self::ID};
    }
}
