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
//    Route::get('/', [\App\Http\Controllers\Alumni\HomeController::class, 'index'])->name('home');
    Route::get('/', function () {
        return redirect()->route('auth.login');
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

    Route::get('make-favorite-or-not', [DashboardController::class, 'makeFavorite'])->name('make.favorite.or.not');

    Route::get('get-currency-price', [DashboardController::class, 'getCurrencyPrice'])->name('get.currency.price');

// event route start
    Route::group(['prefix' => 'event', 'as' => 'event.'], function () {
                Route::get('all-event', [EventController::class, 'all'])->name('all');
        Route::get('details/{slug}', [EventController::class, 'details'])->name('details');
        Route::get('single-ticket/{id}', [TicketController::class, 'singleTicket'])->name('single-ticket');
    });
// event route end

// Job Post route start
    Route::group(['prefix' => 'jobs', 'as' => 'jobs.'], function () {
        Route::get('info/{slug}', [JobPostController::class, 'info'])->name('info');
        Route::post('update/{slug}', [JobPostController::class, 'update'])->name('update');
        Route::post('delete/{slug}', [JobPostController::class, 'delete'])->name('delete');
        Route::get('details/{company}/{slug}', [JobPostController::class, 'details'])->name('details');
        Route::get('all-job-post', [JobPostController::class, 'all'])->name('all-job-post');
        Route::get('my-job-post', [JobPostController::class, 'myJobPost'])->name('my-job-post');
        Route::post('apply/{company}/{slug}', [JobPostController::class, 'apply'])->name('apply');
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
        Route::get('load-post-like', [PostController::class, 'getSinglePostLike'])->name('single.likes');
        Route::get('load-post-comment', [PostController::class, 'getSinglePostComment'])->name('single.comments');
        Route::post('posts/comments', [PostController::class, 'postComment'])->name('comments.store');
        Route::delete('posts/comments/delete', [PostController::class, 'postCommentDelete'])->name('comments.delete');
        Route::PUT('posts/comments/update', [PostController::class, 'postCommentUpdate'])->name('comments.update');
    });
// Post route start

// Membership Route Start
    Route::get('membership-package', [MembershipController::class, 'membershipPackage'])->name('membership-package');
// Membership Route End

//notification  route start
    Route::group(['prefix' => 'notification', 'as' => 'notification.'], function () {
        Route::get('notification-mark-all-as-read', [NotificationController::class, 'notificationMarkAllAsRead'])->name('notification-mark-all-as-read');
        Route::get('notification-mark-as-read/{id}', [NotificationController::class, 'notificationMarkAsRead'])->name('notification-mark-as-read');
    });
// notification route end

    Route::get('testing', [DashboardController::class, 'tester'])->name('testing');

// user notice route start
    Route::get('all-notice', [NoticeController::class, 'allNotice'])->name('all.notice');
    Route::get('notice-details/{slug}', [NoticeController::class, 'noticeDetails'])->name('notice.details');
// user notice route end

// user news route start
    Route::get('all-news', [NewsController::class, 'allNews'])->name('all.news');
    Route::get('news-details/{slug}', [NewsController::class, 'newsDetails'])->name('news.details');
// user news route end

// Alumni Management route start



    Route::get('more-post-load', [HomeController::class, 'loadMorePost'])->name('more-post-load');
// Alumni Management route end

    Route::get('checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('pay', [OrderController::class, 'pay'])->name('pay');
    Route::get('get-currency-by-gateway', [OrderController::class, 'getCurrencyByGateway'])->name('get.currency');
    Route::get('checkout/success', [OrderController::class, 'checkoutSuccess'])->name('checkout.success');

    Route::get('transactions', [TransactionController::class, 'userTransaction'])->name('transaction.list');
    Route::get('transactions-download/{id}', [TransactionController::class, 'userTransactionDownload'])->name('transaction.download');
    Route::get('transactions-print/{id}', [TransactionController::class, 'userTransactionPrint'])->name('transaction.print');

// Chat route start
    Route::group(['prefix' => 'chats', 'as' => 'chats.'], function () {
        Route::get('/', [MessageController::class, 'index'])->name('index');
        Route::get('single-user-chat', [MessageController::class, 'getSingleChat'])->name('single_user_chat');
        Route::post('send-message', [MessageController::class, 'send'])->name('send_message');
    });

    });
});
