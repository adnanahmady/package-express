<?php

namespace App\Models\Gis;

use App\Contracts\Models\GisModelInterface;
use App\Contracts\Models\PointContract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Point extends Model implements PointContract, GisModelInterface
{
    use HasFactory;

    protected $table = self::TABLE;
    protected $primaryKey = self::ID;

    protected $fillable = [
        self::COORDINATION
    ];

    public function getId(): int
    {
        return $this->{self::ID};
    }
}
