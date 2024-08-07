<?php


use App\Http\Controllers\Company\Auth\LoginController;
use App\Http\Controllers\Company\DashboardController;
use App\Http\Controllers\Company\HomeController;
use App\Http\Controllers\Company\JobsController;
use App\Http\Controllers\Company\ProfileController;
use Illuminate\Support\Facades\Route;



Route::group(['namespace' => 'Company', 'prefix' => 'company', 'as' => 'company.'], function () {
    Route::get('/', function () {
        return redirect()->route('company.auth.login');
    });
    Route::get('dashboard', [DashboardController::class,'index'])->name('dashboard');
    Route::get('home', [HomeController::class,'index'])->name('home');
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
    Route::group(['namespace' => 'Profile', 'prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('index', [ProfileController::class,'index'])->name('index');
        Route::get('change-password', [ProfileController::class, 'changePassword'])->name('change-password');
        Route::post('change-password', [ProfileController::class, 'changePasswordUpdate'])->name('change-password.update')->middleware('isDemo');
        Route::post('update', [ProfileController::class, 'update'])->name('update')->middleware('isDemo');
    });

    Route::group(['prefix' => 'jobs', 'as' => 'jobs.'], function () {
        Route::post('add', [JobsController::class, 'add'])->name('add');
        Route::post('status/{id}', [JobsController::class, 'toggleStatus'])->name('status');
        Route::get('create', [JobsController::class, 'create'])->name('create');
        Route::get('/pending', [JobsController::class, 'pending'])->name('pending');
        Route::get('info/{slug}', [JobsController::class, 'info'])->name('info');
        Route::post('update/{slug}', [JobsController::class, 'update'])->name('update');
        Route::post('delete/{slug}', [JobsController::class, 'delete'])->name('delete');
        Route::get('all-job-post', [JobsController::class, 'all'])->name('all-job-post');
        Route::get('my-job-post', [JobsController::class, 'myJobPost'])->name('my-job-post');
        Route::get('details/{company}/{slug}', [JobsController::class, 'details'])->name('details');
        Route::get('applied/{id}', [JobsController::class, 'applied'])->name('applied');


    });
    Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
        Route::post('store', [PostController::class, 'store'])->name('store');
        Route::delete('delete', [PostController::class, 'delete'])->name('delete');
        Route::get('edit', [PostController::class, 'edit'])->name('edit');
        Route::PUT('update', [PostController::class, 'update'])->name('update');
        Route::get('single-post', [PostController::class, 'getSinglePost'])->name('single');
        Route::get('load-post-body', [PostController::class, 'getSinglePostBody'])->name('single.body');

    });
});
