<?php

namespace App\Providers;

use App\Models\Gis\MultiPolygon;
use App\Models\Gis\Point;
use App\Support\GeoCreator\Types\MultiPolygonType;
use App\Support\GeoCreator\Types\PointType;
use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot(): void
    {
        Relation::enforceMorphMap([
            (string) new PointType() => Point::class,
            (string) new MultiPolygonType() => MultiPolygon::class,
        ]);
    }
}
