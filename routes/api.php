<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\VacancyController;
use App\Http\Controllers\API\APISelectionController;

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

header('Access-Control-Allow-Origin: *');

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('/vacancy', [VacancyController::class,'index'])->name('api.vacancy.index');
Route::get('/vacancy/{url}', [VacancyController::class,'detail'])->name('api.vacancy.detail');
Route::get('/selection/detail', [APISelectionController::class,'detail'])->name('api.selection.detail');
Route::get('/tests', [APISelectionController::class,'getData'])->name('api.selection.tests');

\Ajifatur\Helpers\RouteExt::api();