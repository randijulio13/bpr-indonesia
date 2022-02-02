<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\LivenessController;
use App\Http\Controllers\LocationController;
use App\Http\Controllers\UserController;
use App\Models\User;
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

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::get('/', [UserController::class, 'index'])->name('home');
    Route::get('/location', [LocationController::class, 'get']);

    Route::get('user/datatables',[UserController::class,'datatables']);
    Route::post('user/ocr_ktp',[UserController::class,'ocr_ktp'])->name('user.ocr_ktp');
    Route::resource('user', UserController::class);

    Route::resource('liveness',LivenessController::class);
});
