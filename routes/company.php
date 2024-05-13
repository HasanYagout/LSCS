<?php


use App\Http\Controllers\Company\Auth\LoginController;
use Illuminate\Support\Facades\Route;



Route::group(['namespace' => 'Company', 'prefix' => 'company', 'as' => 'company.'], function () {
    Route::get('/', function () {
        return redirect()->route('company.auth.login');
    });

    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', [LoginController::class,'login'])->name('login');
        Route::post('login',[LoginController::class,'submit'])->name('submit');
        Route::get('logout', [LoginController::class,'logout'])->name('logout');
        Route::get('register', [LoginController::class,'register'])->name('register');
        Route::post('store', [LoginController::class,'store'])->name('store');
    });
});
