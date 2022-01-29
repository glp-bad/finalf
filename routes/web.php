<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\App\ParteneriController;

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

// Auth::routes();
Route::post('app/login', [LoginController::class, 'login']);
Route::post('app/logout',[LoginController::class, 'logout'])->middleware('auth');
Route::post('app/loginCheck',[LoginController::class, 'loginCheck'])->middleware('auth');
Route::post('app/gridListParteneri',[ParteneriController::class, 'gridListParteneri'])->middleware('auth');
Route::post('app/partenerGetData',  [ParteneriController::class, 'partenerGetData'])->middleware('auth');
Route::post('app/nomTipPartener',  [ParteneriController::class, 'nomTipPartener'])->middleware('auth');



// Route::post('app/logout',[LoginController::class, 'logout']);
