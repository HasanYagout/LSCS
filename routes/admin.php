<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AlumniController;

use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\EventCategoryController;
use App\Http\Controllers\Admin\EventController;
use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\JobsController;
use App\Http\Controllers\Admin\NewsCategoryController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Admin\NewsTagController;
use App\Http\Controllers\Admin\NoticeCategoryController;
use App\Http\Controllers\Admin\NoticeController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\StoryController;
use App\Http\Controllers\Admin\StudentController;
use App\Http\Controllers\Admin\Website\WebsiteSettingController;

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

Route::middleware(['web'])->group(function () {
Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::post('delete/{id}', [AdminController::class,'delete'])->name('delete');
    Route::get('edit/{id}', [AdminController::class,'edit'])->name('edit');
    Route::post('update', [AdminController::class,'update'])->name('update');
    Route::get('list', [AdminController::class, 'index'])->name('index');
    Route::post('store', [AdminController::class, 'store'])->name('store');
    Route::post('status/{id}', [AdminController::class, 'status'])->name('status');
    Route::post('reset-password/{id}', [AdminController::class, 'resetPassword'])->name('reset-password');


    Route::get('/', function () {
        return redirect()->route('auth.login');
    });

    Route::group(['middleware' => ['admin']], function () {

    Route::group(['prefix' => 'instructor', 'as' => 'instructor.'], function () {
            Route::group(['prefix' => 'recommendation', 'as' => 'recommendation.'], function () {
                Route::get('/edit/{id}', [DashboardController::class, 'recommendation_edit'])->name('edit');
                Route::post('store', [DashboardController::class, 'store'])->name('store');
                Route::post('/status', [DashboardController::class, 'status_update'])->name('status.update');
            });
            Route::get('/', [DashboardController::class, 'index'])->name('dashboard');


        });

    Route::group(['prefix' => 'company', 'as' => 'company.'], function () {
        Route::get('/', [CompanyController::class, 'all'])->name('all');
        Route::post('update/{company}', [CompanyController::class, 'update'])->name('update');
        Route::get('/info/{slug}', [CompanyController::class, 'details'])->name('details');
        Route::get('pending', [CompanyController::class, 'pending'])->name('pending');
        Route::get('active', [CompanyController::class, 'active'])->name('active');

    });

    Route::get('/home', [HomeController::class, 'index'])->name('home');


    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'myProfile'])->name('index');
        Route::post('change-password', [ProfileController::class, 'changePassword'])->name('change-password');
        Route::post('update', [ProfileController::class, 'update'])->name('update');
    });
    Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
        Route::post('store', [PostController::class, 'store'])->name('store');
        Route::delete('delete', [PostController::class, 'delete'])->name('delete');
        Route::get('edit', [PostController::class, 'edit'])->name('edit');
        Route::PUT('update', [PostController::class, 'update'])->name('update');
        Route::get('single-post', [PostController::class, 'getSinglePost'])->name('single');
        Route::get('load-post-body', [PostController::class, 'getSinglePostBody'])->name('single.body');

    });
    Route::group(['prefix' => 'students', 'as' => 'students.'], function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::post('update', [StudentController::class, 'update'])->name('update');
        Route::get('info/{id}', [StudentController::class, 'info'])->name('info');
    });

    /*authentication*/
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Event Route Start
    Route::group(['prefix' => 'event', 'as' => 'event.'], function () {
        Route::get('my-event', [EventController::class, 'myEvent'])->name('my-event');
        Route::get('all-event', [EventController::class, 'all'])->name('all');
        Route::get('create', [EventController::class, 'create'])->name('create');
        Route::post('/store', [EventController::class, 'store'])->name('store');
        Route::get('pending', [ EventController::class, 'pending'])->name('pending');
        Route::get('details/{slug}', [EventController::class, 'details'])->name('details');
        Route::get('edit/{slug}', [EventController::class, 'edit'])->name('edit');
        Route::post('delete/{id}', [EventController::class, 'delete'])->name('delete');
        Route::post('update/{slug}', [EventController::class, 'update'])->name('update');
        Route::post('admin/event/toggle-status', [EventController::class, 'toggleStatus'])->name('toggleStatus');

    });

    Route::group(['prefix' => 'eventCategory', 'as' => 'eventCategory.'], function () {
        Route::get('/category', [EventCategoryController::class, 'index'])->name('index');
        Route::get('create', [EventCategoryController::class, 'create'])->name('create');
        Route::post('/store', [EventCategoryController::class, 'store'])->name('store');
        Route::get('/info/{id}', [EventCategoryController::class, 'info'])->name('info');
        Route::post('/update/{id}', [EventCategoryController::class, 'update'])->name('update');
        Route::post('/delete/{id}', [EventCategoryController::class, 'delete'])->name('delete');

    });
// Event Route End

// Membership Route Start
// Membership Route End

// JobPost Route Start
    Route::group(['prefix' => 'jobs', 'as' => 'jobs.'], function () {
        Route::post('add', [JobsController::class, 'add'])->name('add');
        Route::get('create', [JobsController::class, 'create'])->name('create');
        Route::get('/pending', [JobsController::class, 'pending'])->name('pending');
        Route::get('info/{slug}', [JobsController::class, 'info'])->name('info');
        Route::post('update/{slug}', [JobsController::class, 'update'])->name('update');
        Route::post('update/status/{company}', [JobsController::class, 'toggleStatus'])->name('update.status');
        Route::post('delete/{slug}', [JobsController::class, 'delete'])->name('delete');
        Route::get('all-job-post', [JobsController::class, 'all'])->name('all-job-post');
        Route::get('my-job-post', [JobsController::class, 'myJobPost'])->name('my-job-post');
        Route::get('details/{slug}', [JobsController::class, 'details'])->name('details');


    });
// JobPost Route End
    Route::get('all-notice', [NoticeController::class, 'allNotice'])->name('all.notice');
    Route::get('notice-details/{slug}', [NoticeController::class, 'noticeDetails'])->name('notice.details');
    Route::get('all-news', [NewsController::class, 'allNews'])->name('all.news');
// Stories route start
    Route::group(['prefix' => 'stories', 'as' => 'stories.'], function () {
        Route::get('create', [StoryController::class, 'create'])->name('create');
        Route::get('all', [StoryController::class, 'all'])->name('all');
        Route::post('my-story', [StoryController::class, 'toggleStatus'])->name('status');
        Route::get('status', [StoryController::class, 'my-story'])->name('my-story');
        Route::get('active', [StoryController::class, 'active'])->name('active');
        Route::get('list', [StoryController::class, 'myStory'])->name('my-story');
        Route::post('store', [StoryController::class, 'store'])->name('store');
        Route::get('info/{slug}', [StoryController::class, 'info'])->name('info');
        Route::post('delete/{slug}', [StoryController::class, 'delete'])->name('delete');
        Route::post('update/{slug}', [StoryController::class, 'update'])->name('update');
        Route::post('delete/{slug}', [StoryController::class, 'delete'])->name('delete');

    });
// Stories route end

// Manage Alumni Route Start
    Route::group(['prefix' => 'alumni', 'as' => 'alumni.'], function () {
        Route::get('list', [AlumniController::class, 'alumniList'])->name('list');
        Route::get('alumni/profile/{id}', [AlumniController::class, 'view'])->name('view');
        Route::get('list-pending-alumni-with-filter', [AlumniController::class, 'alumniPendingListWithAdvanceFilter'])->name('list-pending-alumni-with-filter');
        Route::post('change-alumni-status', [AlumniController::class, 'alumniChangeStatus'])->name('change-alumni-status');
        Route::get('gallery/{alumni}', [AlumniController::class, 'gallery'])->name('gallery');
        Route::post('gallery/store', [AlumniController::class, 'gallery_store'])->name('gallery.store');

    });
    // Manage Alumni Route End




//news setting
    Route::group(['prefix' => 'news', 'as' => 'news.'], function () {

        Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
            Route::get('list', [NewsCategoryController::class, 'index'])->name('index');
            Route::post('store', [NewsCategoryController::class, 'store'])->name('store');
            Route::get('info/{id}', [NewsCategoryController::class, 'info'])->name('info');
            Route::post('update/{id}', [NewsCategoryController::class, 'update'])->name('update');
            Route::post('delete/{id}', [NewsCategoryController::class, 'delete'])->name('delete');
        });

        Route::get('list', [NewsController::class, 'index'])->name('index');
        Route::post('store', [NewsController::class, 'store'])->name('store');
        Route::get('info/{id}', [NewsController::class, 'info'])->name('info');
        Route::post('update/{id}', [NewsController::class, 'update'])->name('update');
        Route::post('delete/{id}', [NewsController::class, 'delete'])->name('delete');
        Route::get('details/{slug}', [NewsController::class, 'details'])->name('details');

    });




//notice setting
    Route::group(['prefix' => 'notices', 'as' => 'notices.'], function () {

        Route::group(['prefix' => 'categories', 'as' => 'categories.'], function () {
            Route::get('list', [NoticeCategoryController::class, 'index'])->name('index');
            Route::post('store', [NoticeCategoryController::class, 'store'])->name('store');
            Route::get('info/{id}', [NoticeCategoryController::class, 'info'])->name('info');
            Route::post('update/{id}', [NoticeCategoryController::class, 'update'])->name('update');
            Route::post('delete/{id}', [NoticeCategoryController::class, 'delete'])->name('delete');
        });

        Route::get('list', [NoticeController::class, 'index'])->name('index');
        Route::post('store', [NoticeController::class, 'store'])->name('store');
        Route::get('info/{id}', [NoticeController::class, 'info'])->name('info');
        Route::post('update/{id}', [NoticeController::class, 'update'])->name('update');
        Route::post('delete/{id}', [NoticeController::class, 'delete'])->name('delete');
    });
    });

});
});
