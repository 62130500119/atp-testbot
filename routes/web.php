<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('/liff/reg', function () {
    return view('liffreg');
});

Route::get('/liff/info', function () {
    return view('liffinfo');
});

Route::get('/liff/test', function () {
    return view('test');
});
