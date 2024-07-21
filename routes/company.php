<?php


use App\Http\Controllers\Company\Auth\LoginController;
use App\Http\Controllers\Company\DashboardController;
use App\Http\Controllers\Company\HomeController;
use App\Http\Controllers\Company\JobsController;
use App\Http\Controllers\Company\ProfileController;
use Illuminate\Support\Facades\Route;



Route::group(['namespace' => 'Company', 'prefix' => 'company', 'as' => 'company.'], function () {
    Route::get('/', function () {
        return redirect()->route('auth.login');
    });
    Route::group(['middleware' => ['admin']], function () {
    Route::get('home', [HomeController::class,'index'])->name('home');
    Route::get('all', [DashboardController::class,'all'])->name('all');
    Route::get('info/{id}', [DashboardController::class,'info'])->name('info');
    Route::get('proposal/{id}', [DashboardController::class,'view'])->name('view');
    Route::post('status', [DashboardController::class,'status'])->name('status');


    Route::group(['namespace' => 'Profile', 'prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('index', [ProfileController::class,'index'])->name('index');
        Route::post('change-password', [ProfileController::class, 'changePassword'])->name('change-password');
        Route::post('update', [ProfileController::class, 'update'])->name('update');
    });

    Route::group(['prefix' => 'jobs', 'as' => 'jobs.'], function () {
        Route::post('add', [JobsController::class, 'add'])->name('add');
        Route::post('status/{id}', [JobsController::class, 'toggleStatus'])->name('status');
        Route::get('create', [JobsController::class, 'create'])->name('create');
        Route::get('/pending', [JobsController::class, 'pending'])->name('pending');
        Route::get('info/{slug}', [JobsController::class, 'info'])->name('info');
        Route::get('alumni-profile/{id}', [JobsController::class, 'alumniProfile'])->name('alumni-profile');
        Route::post('update/{slug}', [JobsController::class, 'update'])->name('update');
        Route::post('delete/{slug}', [JobsController::class, 'delete'])->name('delete');

        Route::get('all-job-post', [JobsController::class, 'all'])->name('all-job-post');
        Route::get('my-job-post', [JobsController::class, 'myJobPost'])->name('my-job-post');
        Route::get('details/{company}/{slug}', [JobsController::class, 'details'])->name('details');
        Route::get('applied/{id}', [JobsController::class, 'applied'])->name('applied');


    });
    });

});
