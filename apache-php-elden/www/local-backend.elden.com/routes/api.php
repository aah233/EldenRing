<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;
use App\Http\Controllers\NewsController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::get('/items', 'App\Http\Controllers\ItemController@index');


Route::put('/items/{id}', [ItemController::class, 'update']);

Route::get('/news', [NewsController::class, 'fetchNews']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
