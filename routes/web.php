<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

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
Route::post('app/login', [LoginController::class, 'login']);
Route::post('app/logout',[LoginController::class, 'logout'])->middleware('auth');
// Route::post('app/logout',[LoginController::class, 'logout']);
