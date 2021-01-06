<?php

use App\Http\Controllers\CoronaController;
use Illuminate\Http\Request;
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
$router->group(['prefix'=>'apps'],function() use ($router){
    $router->get('/movingAvgSembuh',[CoronaController::class, 'movingAvgSembuh']);
    $router->get('/movingAvgPositif',[CoronaController::class, 'movingAvgPositif']);
    $router->get('/movingAvgMeninggal',[CoronaController::class, 'movingAvgMeninggal']);
    $router->get('/index',[CoronaController::class, 'index']);
    $router->get('/contactProvinsi',[CoronaController::class, 'contactProvinsi']);
    $router->get('/contactKabupaten',[CoronaController::class, 'contactKabupaten']);
    $router->get('/provinceChart',[CoronaController::class, 'provinceChart']);
    $router->get('/provinceLowestChart',[CoronaController::class, 'provinceLowestChart']);
    $router->get('/posts',[CoronaController::class, 'post']);
    $router->get('/kesimpulan',[CoronaController::class, 'kesimpulan']);

});
// Route::get('/movingAvg', 'CoronaController@movingAvg')->name('movingAvg');
// Route::get('/provincechart', 'CoronaController@provinceChart');
// Route::get('/provinceLowestChart', 'CoronaController@provinceLowestChart');
