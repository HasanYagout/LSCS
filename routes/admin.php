<?php

use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\Auth\LoginController;
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
use App\Http\Controllers\AdminController;
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

Route::group(['namespace' => 'Admin', 'prefix' => 'admin', 'as' => 'admin.'], function () {
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('/code/captcha/{tmp}', 'LoginController@captcha')->name('default-captcha');
        Route::get('login', [LoginController::class,'login'])->name('login');
        Route::post('login',[LoginController::class,'submit']);
        Route::post('logout', [LoginController::class,'logout'])->name('logout');
        Route::get('register', [LoginController::class,'register'])->name('register');
    });
    Route::get('/', function () {
        return redirect()->route('admin.auth.login');
    });

    Route::group(['middleware' => ['admin']], function () {

    Route::group(['prefix' => 'instructor', 'as' => 'instructor.'], function () {
            Route::group(['prefix' => 'recommendation', 'as' => 'recommendation.'], function () {
                Route::get('/edit/{id}', [DashboardController::class, 'recommendation_edit'])->name('edit');
                Route::post('store', [DashboardController::class, 'store'])->name('store');
            });
                Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
            Route::post('/status', [DashboardController::class, 'status_update'])->name('status.update');

        });
    Route::group(['prefix' => 'company', 'as' => 'company.'], function () {
        Route::get('/', [CompanyController::class, 'all'])->name('all');
        Route::post('update/{company}', [CompanyController::class, 'update'])->name('update');
        Route::get('/info/{slug}', [CompanyController::class, 'details'])->name('details');

    });
    Route::get('list-search-with-filter', [AlumniController::class, 'alumniListWithAdvanceFilter'])->name('list-search-with-filter');
    Route::get('alumni/profile/{id}', [AlumniController::class, 'view'])->name('alumni.view');
    Route::get('/home', [HomeController::class, 'index'])->name('home');


    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'myProfile'])->name('index');
        Route::get('change-password', [ProfileController::class, 'changePassword'])->name('change-password');
        Route::post('change-password', [ProfileController::class, 'changePasswordUpdate'])->name('change-password.update')->middleware('isDemo');
        Route::post('update', [ProfileController::class, 'update'])->name('update')->middleware('isDemo');
    });
    Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
        Route::post('store', [PostController::class, 'store'])->name('store');
        Route::delete('delete', [PostController::class, 'delete'])->name('delete');
        Route::post('like', [PostController::class, 'likeDislike'])->name('like');
        Route::get('edit', [PostController::class, 'edit'])->name('edit');
        Route::PUT('update', [PostController::class, 'update'])->name('update');
        Route::get('single-post', [PostController::class, 'getSinglePost'])->name('single');
        Route::get('load-post-body', [PostController::class, 'getSinglePostBody'])->name('single.body');
        Route::get('load-post-like', [PostController::class, 'getSinglePostLike'])->name('single.likes');
        Route::get('load-post-comment', [PostController::class, 'getSinglePostComment'])->name('single.comments');
        Route::post('posts/comments', [PostController::class, 'postComment'])->name('comments.store');
        Route::delete('posts/comments/delete', [PostController::class, 'postCommentDelete'])->name('comments.delete');
        Route::PUT('posts/comments/update', [PostController::class, 'postCommentUpdate'])->name('comments.update');
        Route::get('more-post-load', [HomeController::class, 'loadMorePost'])->name('more-post-load');

    });
    Route::group(['prefix' => 'students', 'as' => 'students.'], function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::post('change-password', [StudentController::class, 'changePasswordUpdate'])->name('change-password.update')->middleware('isDemo');
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
        Route::post('delete/{slug}', [JobsController::class, 'delete'])->name('delete');
        Route::get('all-job-post', [JobsController::class, 'all'])->name('all-job-post');
        Route::get('my-job-post', [JobsController::class, 'myJobPost'])->name('my-job-post');
        Route::get('details/{slug}', [JobsController::class, 'details'])->name('details');


    });
// JobPost Route End
    Route::get('all-notice', [NoticeController::class, 'allNotice'])->name('all.notice');
    Route::get('notice-details/{slug}', [NoticeController::class, 'noticeDetails'])->name('notice.details');
    Route::get('all-news', [NewsController::class, 'allNews'])->name('all.news');
    Route::get('news-details/{slug}', [NewsController::class, 'newsDetails'])->name('news.details');
// Stories route start
    Route::group(['prefix' => 'stories', 'as' => 'stories.'], function () {
        Route::get('create', [StoryController::class, 'create'])->name('create');
        Route::get('pending', [StoryController::class, 'pending'])->name('pending');
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
        Route::get('list-search-with-filter', [AlumniController::class, 'alumniListWithAdvanceFilter'])->name('list-search-with-filter');
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
