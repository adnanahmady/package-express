<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('partners.')
    ->prefix('/partners')
    ->group(base_path('routes/api/v1/partners.php'));
Route::name('searches.')
    ->prefix('/searches')
    ->group(base_path('routes/api/v1/searches.php'));
