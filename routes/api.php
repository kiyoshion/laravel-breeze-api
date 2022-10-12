<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\FlashController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\OutputController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TypeController;

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

Route::middleware(['auth:sanctum'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::apiResources([
    'flashes' => FlashController::class,
    'items' => ItemController::class,
    'materials' => MaterialController::class,
    'outputs' => OutputController::class,
    'sections' => SectionController::class,
    'rooms' => RoomController::class,
    'types' => TypeController::class,
]);
