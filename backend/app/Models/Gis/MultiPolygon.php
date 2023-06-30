<?php

namespace App\Models\Gis;

use App\Contracts\Models\GisModelInterface;
use App\Contracts\Models\MultiPolygonContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MultiPolygon extends Model implements
    MultiPolygonContract,
    GisModelInterface
{
    use HasFactory;

    protected $table = self::TABLE;
    protected $primaryKey = self::ID;

    protected $fillable = [
        self::COORDINATION,
    ];

    public function getId(): int
    {
        return $this->{self::ID};
    }
}
