<?php

use App\Http\Controllers\Admin\MemberCrudController;
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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('/atp-bot',[ MemberCrudController::class,'linebot']);

Route::post('/register',[ MemberCrudController::class,'regis'])->name('regis');

Route::post('/get/info',[ MemberCrudController::class,'getinfo'])->name('getInfo');
