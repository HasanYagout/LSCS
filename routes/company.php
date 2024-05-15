<?php


use App\Http\Controllers\Company\Auth\LoginController;
use App\Http\Controllers\Company\DashboardController;
use App\Http\Controllers\Company\JobsController;
use Illuminate\Support\Facades\Route;



Route::group(['namespace' => 'Company', 'prefix' => 'company', 'as' => 'company.'], function () {
    Route::get('/', function () {
        return redirect()->route('company.auth.login');
    });
    Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::get('all', [DashboardController::class,'all'])->name('all');
    Route::get('info/{id}', [DashboardController::class,'info'])->name('info');
    Route::get('proposal/{id}', [DashboardController::class,'view'])->name('view');
    Route::post('status', [DashboardController::class,'status'])->name('status');


    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', [LoginController::class,'login'])->name('login');
        Route::post('login',[LoginController::class,'submit'])->name('submit');
        Route::get('logout', [LoginController::class,'logout'])->name('logout');
        Route::get('register', [LoginController::class,'register'])->name('register');
        Route::post('store', [LoginController::class,'store'])->name('store');
    });

    Route::group(['prefix' => 'jobs', 'as' => 'jobs.'], function () {
        Route::post('add', [JobsController::class, 'add'])->name('add');
        Route::get('create', [JobsController::class, 'create'])->name('create');
        Route::get('/pending', [JobsController::class, 'pending'])->name('pending');
        Route::get('info/{slug}', [JobsController::class, 'info'])->name('info');
        Route::post('update/{slug}', [JobsController::class, 'update'])->name('update');
        Route::post('delete/{slug}', [JobsController::class, 'delete'])->name('delete');
        Route::get('all-job-post', [JobsController::class, 'all'])->name('all-job-post');
        Route::get('my-job-post', [JobsController::class, 'myJobPost'])->name('my-job-post');
        Route::get('details/{slug}', [JobsController::class, 'details'])->name('details');


    });
});
