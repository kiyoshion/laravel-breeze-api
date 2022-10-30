<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChapterController;
use App\Http\Controllers\ContentController;
use App\Http\Controllers\FlashController;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\MaterialController;
use App\Http\Controllers\MemoController;
use App\Http\Controllers\OutputController;
use App\Http\Controllers\SectionController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\StatusController;
use App\Http\Controllers\TopicController;
use App\Http\Controllers\TypeController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\HomeController;

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
    'chapters' => ChapterController::class,
    'contents' => ContentController::class,
    'flashes' => FlashController::class,
    'items' => ItemController::class,
    'materials' => MaterialController::class,
    'memos' => MemoController::class,
    'outputs' => OutputController::class,
    'sections' => SectionController::class,
    'rooms' => RoomController::class,
    'statuses' => StatusController::class,
    'topics' => TopicController::class,
    'types' => TypeController::class,
    'users' => UserController::class,
    'homes' => HomeController::class,
]);

Route::get('/scrap', [MaterialController::class, 'scrap']);
Route::get('/users/{name}/words/{id}', [UserController::class, 'showUserWords']);
