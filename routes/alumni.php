<?php

use App\Http\Controllers\Alumni\AlumniController;
use App\Http\Controllers\Alumni\DashboardController;
use App\Http\Controllers\Alumni\EventController;
use App\Http\Controllers\Alumni\HomeController;
use App\Http\Controllers\Alumni\JobPostController;
use App\Http\Controllers\Alumni\MembershipController;
use App\Http\Controllers\Alumni\MessageController;
use App\Http\Controllers\Alumni\NewsController;
use App\Http\Controllers\Alumni\NoticeController;
use App\Http\Controllers\Alumni\NotificationController;
use App\Http\Controllers\Alumni\OrderController;
use App\Http\Controllers\Alumni\PostController;
use App\Http\Controllers\Alumni\ProfileController;
use App\Http\Controllers\Alumni\RecommendationController;
use App\Http\Controllers\Alumni\SettingController;
use App\Http\Controllers\Alumni\StoryController;
use App\Http\Controllers\Alumni\TicketController;
use App\Http\Controllers\Alumni\TransactionController;
use App\Http\Controllers\Alumni\UserEmailVerifyController;
use App\Http\Controllers\Web\Auth\LoginController;
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
    Route::get('/', function () {
        return redirect()->route('alumni.auth.login');
    });
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('login', [LoginController::class,'login'])->name('login');
        Route::post('login',[LoginController::class,'submit'])->name('submit');
        Route::post('register',[LoginController::class,'register'])->name('register');
        Route::get('logout',[LoginController::class,'logout'] )->name('logout');
    });
    Route::group(['middleware' => 'alumni'], function () {


    Route::get('home', [HomeController::class, 'index'])->name('home');
    Route::get('images', [ProfileController::class, 'images'])->name('images');

    Route::group(['prefix' => 'recommendation', 'as' => 'recommendation.'], function () {
        Route::get('/', [RecommendationController::class, 'index'])->name('index');
        Route::get('/list', [RecommendationController::class, 'list'])->name('list');
        Route::get('/create', [RecommendationController::class, 'create'])->name('create');
        Route::get('/edit/{id}', [RecommendationController::class, 'edit'])->name('edit');
        Route::post('/store', [RecommendationController::class, 'store'])->name('store');
        Route::get('view/{file}', [RecommendationController::class,'view'])->name('view');
        Route::get('download/{file}', [RecommendationController::class,'download'])->name('download');

    });

    Route::post('add-institution', [ProfileController::class, 'addInstitution'])->name('add_institution');

    Route::group(['prefix' => 'profile', 'as' => 'profile.'], function () {
        Route::get('/', [ProfileController::class, 'profile'])->name('index');
        Route::post('update', [ProfileController::class, 'userProfileUpdate'])->name('update');
        Route::post('add', [ProfileController::class, 'addEducation'])->name('add-education');
        Route::post('add-experience', [ProfileController::class, 'addExperience'])->name('add-experience');
        Route::get('generate-cv', [ProfileController::class, 'generateCV'])->name('generate-cv');
        Route::post('add-cv', [ProfileController::class, 'addCV'])->name('add-cv');
    });


    Route::group(['prefix' => 'cvs', 'as' => 'cvs.'], function () {
        Route::get('all', [ProfileController::class, 'list_cvs'])->name('all');
        Route::get('create', [ProfileController::class, 'create_cv'])->name('create');
        Route::post('submit', [ProfileController::class, 'store_cv'])->name('submit');
        Route::get('view/{slug}', [ProfileController::class, 'view'])->name('view');

    });

    Route::get('settings', [SettingController::class, 'settings'])->name('settings');
    Route::post('change-password', [SettingController::class, 'changePasswordUpdate'])->name('change-password')->middleware('isDemo');
    Route::post('setting-update', [SettingController::class, 'settingUpdate'])->name('setting_update');

    Route::post('phone-verification-sms-send', [ProfileController::class, 'smsSend'])->name('phone.verification.sms.send');
    Route::get('phone-verification-sms-resend', [ProfileController::class, 'smsReSend'])->name('phone.verification.sms.resend');
    Route::post('phone-verification-sms-verify', [ProfileController::class, 'smsVerify'])->name('phone.verification.sms.verify');

    Route::post('email/verified/{token}', [UserEmailVerifyController::class, 'emailVerified'])->name('email.verified')->withoutMiddleware('is_email_verify');
    Route::get('email/verify/{token}', [UserEmailVerifyController::class, 'emailVerify'])->name('email.verify')->withoutMiddleware('is_email_verify');
    Route::post('email/verify/resend/{token}', [UserEmailVerifyController::class, 'emailVerifyResend'])->name('email.verify.resend')->withoutMiddleware('is_email_verify');

    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('dashboard/chart-data', [DashboardController::class, 'chartData'])->name('dashboard_chart_data');



// event route start
    Route::group(['prefix' => 'event', 'as' => 'event.'], function () {
        Route::get('all-event', [EventController::class, 'all'])->name('all');
        Route::get('details/{slug}', [EventController::class, 'details'])->name('details');
        Route::get('pending', [ EventController::class, 'pending'])->name('pending');
    });
// event route end
        Route::group(['prefix' => 'notices', 'as' => 'notices.'], function () {
            Route::get('list', [NoticeController::class, 'index'])->name('index');

        });
// Job Post route start
    Route::group(['prefix' => 'jobs', 'as' => 'jobs.'], function () {
        Route::get('info/{slug}', [JobPostController::class, 'info'])->name('info');
        Route::post('update/{slug}', [JobPostController::class, 'update'])->name('update');
        Route::post('delete/{slug}', [JobPostController::class, 'delete'])->name('delete');
//        Route::get('details/{company}/{slug}', [JobPostController::class, 'details'])->name('details');
        Route::get('all-job-post', [JobPostController::class, 'all'])->name('all-job-post');
        Route::get('my-job-post', [JobPostController::class, 'myJobPost'])->name('my-job-post');
        Route::post('apply/{company}/{slug}', [JobPostController::class, 'apply'])->name('apply');
        Route::get('/pending', [JobPostController::class, 'pending'])->name('pending');
        Route::get('job-view-details/{slug}', [JobPostController::class, 'jobDetails'])->name('details');

    });
// Job Post route end

// Stories route start
    Route::group(['prefix' => 'stories', 'as' => 'stories.'], function () {
        Route::get('create', [StoryController::class, 'create'])->name('create');
        Route::post('store', [StoryController::class, 'store'])->name('store');
        Route::get('list', [StoryController::class, 'myStory'])->name('my-story');
        Route::get('info/{slug}', [StoryController::class, 'info'])->name('info');

    });
// Stories route end

// Post route start
    Route::group(['prefix' => 'posts', 'as' => 'posts.'], function () {
        Route::post('store', [PostController::class, 'store'])->name('store');
        Route::delete('delete', [PostController::class, 'delete'])->name('delete');
        Route::post('like', [PostController::class, 'likeDislike'])->name('like');
        Route::get('edit', [PostController::class, 'edit'])->name('edit');
        Route::PUT('update', [PostController::class, 'update'])->name('update');
        Route::get('single-post', [PostController::class, 'getSinglePost'])->name('single');
        Route::get('load-post-body', [PostController::class, 'getSinglePostBody'])->name('single.body');
    });

    Route::get('testing', [DashboardController::class, 'tester'])->name('testing');

    Route::get('all-notice', [NoticeController::class, 'allNotice'])->name('all.notice');
    Route::get('notice-details/{slug}', [NoticeController::class, 'noticeDetails'])->name('notice.details');

    Route::get('all-news', [NewsController::class, 'allNews'])->name('all.news');
    Route::get('news-details/{slug}', [NewsController::class, 'newsDetails'])->name('news.details');

        Route::group(['prefix' => 'news', 'as' => 'news.'], function () {
            Route::get('list', [NewsController::class, 'index'])->name('index');
            Route::get('details/{slug}', [NewsController::class, 'details'])->name('details');

        });
    Route::get('more-post-load', [HomeController::class, 'loadMorePost'])->name('more-post-load');


    });
});
