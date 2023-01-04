<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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

Route::get('/', function () { return view('welcome'); });

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::post('/start-server-websocket', function (Request $request) {
    //$res = shell_exec('php ../artisan server:up');
    //return response()->json(['server is running' => $res]);
});

Route::get('/messages', [\App\Http\Controllers\HomeController::class, 'messages']);

Route::get('/login-data', [\App\Http\Controllers\HomeController::class, 'data']);
