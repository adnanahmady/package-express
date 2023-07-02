<?php

namespace App\Models;

use App\Contracts\Models\CoordinationContract;
use App\Contracts\Models\CoverageAreaContract;
use App\ValueObjects\GeoValues\GeoObjectInterface;
use App\ValueObjects\GeoValues\MultiPolygonObject;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class CoverageArea extends Model implements CoverageAreaContract
{
    use HasFactory;

    protected $table = self::TABLE;
    protected $primaryKey = self::ID;

    protected $fillable = [
        self::PARTNER,
        self::COVERAGE_ID,
        self::COVERAGE_TYPE,
    ];

    public function coverage(): MorphTo
    {
        return $this->morphTo();
    }

    public function getGeoObject(): GeoObjectInterface
    {
        return MultiPolygonObject::initiateFromGeom(
            $this->coverage->{CoordinationContract::COORDINATION}
        );
    }

    public function getId(): int
    {
        return $this->{self::ID};
    }
}
