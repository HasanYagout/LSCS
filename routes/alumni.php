<?php

use App\Http\Controllers\Alumni\AlumniController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::group(['namespace' => 'Alumni', 'prefix' => 'alumni', 'as' => 'alumni.'], function () {
    Route::get('/', [\App\Http\Controllers\Alumni\HomeController::class, 'index'])->name('home');
    Route::get('list-search-with-filter', [AlumniController::class, 'alumniListWithAdvanceFilter'])->name('list-search-with-filter');

});
