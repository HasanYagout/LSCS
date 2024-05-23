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

    Route::group(['prefix' => 'company', 'as' => 'company.'], function () {
        Route::get('/', [CompanyController::class, 'all'])->name('all');
        Route::post('update/{company}', [CompanyController::class, 'update'])->name('update');

    });
    Route::get('list-search-with-filter', [AlumniController::class, 'alumniListWithAdvanceFilter'])->name('list-search-with-filter');
    Route::get('alumni/profile/{id}', [AlumniController::class, 'view'])->name('alumni.view');
    Route::get('/home', [HomeController::class, 'index'])->name('home');

    Route::get('/', function () {
        return redirect()->route('admin.auth.login');
    });
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
    });
    Route::group(['prefix' => 'students', 'as' => 'students.'], function () {
        Route::get('/', [StudentController::class, 'index'])->name('index');
        Route::get('list', [StudentController::class, 'list'])->name('list');
        Route::post('change-password', [StudentController::class, 'changePasswordUpdate'])->name('change-password.update')->middleware('isDemo');
        Route::post('update', [StudentController::class, 'update'])->name('update');
        Route::get('info/{id}', [StudentController::class, 'info'])->name('info');
    });

    /*authentication*/
    Route::group(['namespace' => 'Auth', 'prefix' => 'auth', 'as' => 'auth.'], function () {
        Route::get('/code/captcha/{tmp}', 'LoginController@captcha')->name('default-captcha');
        Route::get('login', [LoginController::class,'login'])->name('login');
        Route::post('login',[LoginController::class,'submit']);
        Route::get('logout', [LoginController::class,'logout'])->name('logout');
        Route::get('register', [LoginController::class,'register'])->name('register');
    });
    Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

// Event Route Start
    Route::group(['prefix' => 'event', 'as' => 'event.'], function () {
        Route::get('my-event', [EventController::class, 'myEvent'])->name('my-event');
        Route::get('all-event', [EventController::class, 'all'])->name('all');
        Route::get('create', [EventController::class, 'create'])->name('create');
        Route::post('/store', [EventController::class, 'store'])->name('store');
        Route::get('pending', [ EventController::class, 'pending'])->name('pending');
        Route::get('details/{slug}', [EventController::class, 'details'])->name('details');



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
    Route::group(['prefix' => 'membership', 'as' => 'membership.'], function () {
        Route::get('index', [MembershipController::class, 'index'])->name('index');
        Route::post('store', [MembershipController::class, 'store'])->name('store');
        Route::get('edit/{slug}', [MembershipController::class, 'edit'])->name('edit');
        Route::post('update/{slug}', [MembershipController::class, 'update'])->name('update');
        Route::post('delete/{id}', [MembershipController::class, 'delete'])->name('delete');
        Route::get('list', [MembershipController::class, 'list'])->name('list');
    });
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

    Route::group(['prefix' => 'setting', 'as' => 'setting.'], function () {
        Route::group([], function () {
            Route::get('application-settings', [SettingController::class, 'applicationSetting'])->name('application-settings');
            Route::get('configuration-settings', [SettingController::class, 'configurationSetting'])->name('configuration-settings');
            Route::get('configuration-settings/configure', [SettingController::class, 'configurationSettingConfigure'])->name('configuration-settings.configure');
            Route::get('configuration-settings/help', [SettingController::class, 'configurationSettingHelp'])->name('configuration-settings.help');
            Route::post('application-settings-update', [SettingController::class, 'applicationSettingUpdate'])->name('application-settings.update');
            Route::post('configuration-settings-update', [SettingController::class, 'configurationSettingUpdate'])->name('configuration-settings.update');
            Route::post('application-env-update', [SettingController::class, 'saveSetting'])->name('settings_env.update');
            Route::get('color-settings', [SettingController::class, 'colorSettings'])->name('color-settings');

            //website settings
            Route::group(['prefix' => 'website-settings', 'as' => 'website-settings.'], function () {
                Route::get('/', [WebsiteSettingController::class, 'commonSetting'])->name('index');
                Route::get('banner-setting', [WebsiteSettingController::class, 'bannerSetting'])->name('banner.setting');
                Route::get('why-you-should-join-us', [WebsiteSettingController::class, 'whyYouShouldJoinUs'])->name('why-you-should-join-us');
                Route::get('about-us', [WebsiteSettingController::class, 'aboutUs'])->name('about-us');
                Route::get('privacy-policy', [WebsiteSettingController::class, 'privacyPolicy'])->name('privacy-policy');
                Route::get('cookie-policy', [WebsiteSettingController::class, 'cookiePolicy'])->name('cookie-policy');
                Route::get('terms-condition', [WebsiteSettingController::class, 'termsCondition'])->name('terms-condition');
                Route::get('refund-policy', [WebsiteSettingController::class, 'refundPolicy'])->name('refund-policy');
                Route::get('contact-us', [WebsiteSettingController::class, 'contactUs'])->name('contact-us');

                Route::group(['prefix' => 'image-galleries', 'as' => 'image_galleries.'], function () {
                    Route::get('', [ImageGalleryController::class, 'index'])->name('index');
                    Route::post('', [ImageGalleryController::class, 'store'])->name('store');
                    Route::get('edit/{id}', [ImageGalleryController::class, 'edit'])->name('edit');
                    Route::patch('update/{id}', [ImageGalleryController::class, 'update'])->name('update');
                    Route::post('delete/{id}', [ImageGalleryController::class, 'delete'])->name('delete');
                });
            });

            Route::group(['prefix' => 'currency', 'as' => 'currencies.'], function () {
                Route::get('', [CurrencyController::class, 'index'])->name('index');
                Route::post('currency', [CurrencyController::class, 'store'])->name('store');
                Route::get('edit/{id}', [CurrencyController::class, 'edit'])->name('edit');
                Route::patch('update/{id}', [CurrencyController::class, 'update'])->name('update');
                Route::post('delete/{id}', [CurrencyController::class, 'delete'])->name('delete');
            });

            Route::get('storage-settings', [SettingController::class, 'storageSetting'])->name('storage.index');
            Route::post('storage-settings', [SettingController::class, 'storageSettingsUpdate'])->name('storage.update');
            Route::get('google-recaptcha-settings', [SettingController::class, 'googleRecaptchaSetting'])->name('google-recaptcha');
            Route::get('google-analytics-settings', [SettingController::class, 'googleAnalyticsSetting'])->name('google.analytics');

            Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('create', [UserController::class, 'create'])->name('create');
                Route::post('store', [UserController::class, 'store'])->name('store')->middleware('isDemo');
                Route::get('edit/{id}', [UserController::class, 'edit'])->name('edit');
                Route::post('update/{id}', [UserController::class, 'update'])->name('update')->middleware('isDemo');
                Route::get('delete/{id}', [UserController::class, 'delete'])->name('delete')->middleware('isDemo');
            });
        });

        Route::get('mail-configuration', [SettingController::class, 'mailConfiguration'])->name('mail-configuration');
        Route::post('mail-configuration', [SettingController::class, 'mailConfiguration'])->name('mail-configuration');
        Route::post('mail-test', [SettingController::class, 'mailTest'])->name('mail.test');

        Route::get('sms-configuration', [SettingController::class, 'smsConfiguration'])->name('sms-configuration');
        Route::post('sms-configuration', [SettingController::class, 'smsConfigurationStore'])->name('sms-configuration');
        Route::post('sms-test', [SettingController::class, 'smsTest'])->name('sms.test');


        //Start:: Maintenance Mode
        Route::get('maintenance-mode-changes', [SettingController::class, 'maintenanceMode'])->name('maintenance');
        Route::post('maintenance-mode-changes', [SettingController::class, 'maintenanceModeChange'])->name('maintenance.change');
        //End:: Maintenance Mode

        Route::get('cache-settings', [SettingController::class, 'cacheSettings'])->name('cache-settings');
        Route::get('cache-update/{id}', [SettingController::class, 'cacheUpdate'])->name('cache-update');
        Route::get('storage-link', [SettingController::class, 'storageLink'])->name('storage.link');
        Route::get('security-settings', [SettingController::class, 'securitySettings'])->name('security.settings');

        Route::group(['prefix' => 'gateway', 'as' => 'gateway.'], function () {
            Route::get('/', [GatewayController::class, 'index'])->name('index');
            Route::post('store', [GatewayController::class, 'store'])->name('store')->middleware('isDemo');
            Route::get('get-info', [GatewayController::class, 'getInfo'])->name('get.info');
            Route::get('get-currency-by-gateway', [GatewayController::class, 'getCurrencyByGateway'])->name('get.currency');
        });

        //Features Settings
        Route::get('cookie-settings', [SettingController::class, 'cookieSetting'])->name('cookie-settings');
        Route::post('cookie-settings-update', [SettingController::class, 'cookieSettingUpdated'])->name('cookie.settings.update');
        Route::get('live-chat-settings', [SettingController::class, 'liveChatSettings'])->name('live.chat.settings');

        //common setting update
        Route::post('common-settings-update', [SettingController::class, 'commonSettingUpdate'])->name('common.settings.update')->middleware('isDemo');

        Route::get('email-template', [EmailTemplateController::class, 'emailTemplate'])->name('email-template');
        Route::get('email-edit', [EmailTemplateController::class, 'emailTempEdit'])->name('email-edit');
        Route::get('email-edit/{id}', [EmailTemplateController::class, 'emailTempEdit'])->name('email-edit');
        Route::post('email-temp-update/{id}', [EmailTemplateController::class, 'emailTempUpdate'])->name('email-temp-update');

        Route::group(['prefix' => 'batch', 'as' => 'batches.'], function () {
            Route::get('', [BatchController::class, 'index'])->name('index');
            Route::post('batch', [BatchController::class, 'store'])->name('store');
            Route::get('edit/{id}', [BatchController::class, 'edit'])->name('edit');
            Route::patch('update/{id}', [BatchController::class, 'update'])->name('update');
            Route::post('delete/{id}', [BatchController::class, 'delete'])->name('delete');
        });

        Route::group(['prefix' => 'department', 'as' => 'departments.'], function () {
            Route::get('', [DepartmentController::class, 'index'])->name('index');
            Route::post('department', [DepartmentController::class, 'store'])->name('store');
            Route::get('edit/{id}', [DepartmentController::class, 'edit'])->name('edit');
            Route::patch('update/{id}', [DepartmentController::class, 'update'])->name('update');
            Route::post('delete/{id}', [DepartmentController::class, 'delete'])->name('delete');
        });

        Route::group(['prefix' => 'passing-years', 'as' => 'passing_years.'], function () {
            Route::get('', [PassingYearController::class, 'index'])->name('index');
            Route::post('passing-years', [PassingYearController::class, 'store'])->name('store');
            Route::get('edit/{id}', [PassingYearController::class, 'edit'])->name('edit');
            Route::patch('update/{id}', [PassingYearController::class, 'update'])->name('update');
            Route::post('delete/{id}', [PassingYearController::class, 'delete'])->name('delete');
        });

        Route::group(['prefix' => 'language', 'as' => 'languages.'], function () {
            Route::get('/', [LanguageController::class, 'index'])->name('index');
            Route::post('store', [LanguageController::class, 'store'])->name('store');
            Route::get('edit/{id}/{iso_code?}', [LanguageController::class, 'edit'])->name('edit');
            Route::post('update/{id}', [LanguageController::class, 'update'])->name('update');
            Route::get('translate/{id}', [LanguageController::class, 'translateLanguage'])->name('translate');
            Route::post('update-translate/{id}', [LanguageController::class, 'updateTranslate'])->name('update.translate');
            Route::post('delete/{id}', [LanguageController::class, 'delete'])->name('delete');
            Route::post('update-language/{id}', [LanguageController::class, 'updateLanguage'])->name('update-language');
            Route::get('translate/{id}/{iso_code?}', [LanguageController::class, 'translateLanguage'])->name('translate');
            Route::get('update-translate/{id}', [LanguageController::class, 'updateTranslate'])->name('update.translate');
            Route::post('import', [LanguageController::class, 'import'])->name('import')->middleware('isDemo');
        });
    });


//news setting
    Route::group(['prefix' => 'news', 'as' => 'news.'], function () {
        Route::group(['prefix' => 'tags', 'as' => 'tags.'], function () {
            Route::get('list', [NewsTagController::class, 'index'])->name('index');
            Route::post('store', [NewsTagController::class, 'store'])->name('store');
            Route::get('info/{id}', [NewsTagController::class, 'info'])->name('info');
            Route::post('update/{id}', [NewsTagController::class, 'update'])->name('update');
            Route::post('delete/{id}', [NewsTagController::class, 'delete'])->name('delete');
        });

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
    });

//transactions
    Route::group(['prefix' => 'transactions', 'as' => 'transactions.'], function () {
        Route::get('pending-list', [TransactionController::class, 'pendingTransaction'])->name('pending.list');
        Route::get('all-transactions', [TransactionController::class, 'allTransaction'])->name('all.list');
        Route::get('event-transaction', [TransactionController::class, 'eventTransaction'])->name('event.list');
        Route::get('membership-transaction', [TransactionController::class, 'membershipTransaction'])->name('membership.list');
        Route::post('change-transaction-status', [TransactionController::class, 'transactionChangeStatus'])->name('change-status');

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

//users
    Route::group(['prefix' => 'user', 'as' => 'user.'], function () {
        Route::get('list', [UserController::class, 'userList'])->name('list');
        Route::get('add-new', [UserController::class, 'userAdd'])->name('add-new');
        Route::post('store', [UserController::class, 'store'])->name('store');
        Route::get('details-{id}', [UserController::class, 'userDetails'])->name('details');
        Route::get('edit-{id}', [UserController::class, 'userEdit'])->name('edit');
        Route::post('update', [UserController::class, 'userUpdate'])->name('update')->middleware('isDemo');
        Route::get('wallet-{id}', [UserController::class, 'userWallet'])->name('wallet');
        Route::get('accounting-{id}', [UserController::class, 'userAccounting'])->name('accounting');
        Route::get('suspend-{id}', [UserController::class, 'userSuspend'])->name('suspend');
        Route::post('delete-{id}', [UserController::class, 'userDelete'])->name('delete');
        Route::get('activity-{id}', [UserController::class, 'userActivity'])->name('activity');
    });

    if(!isAddonInstalled('ALUSAAS')) {
// version update
        Route::get('version-update', [VersionUpdateController::class, 'versionFileUpdate'])->name('version-update');
        Route::post('version-update', [VersionUpdateController::class, 'versionFileUpdateStore'])->name('version-update-store');
        Route::get('version-update-execute', [VersionUpdateController::class, 'versionUpdateExecute'])->name('version-update-execute');
        Route::get('version-delete', [VersionUpdateController::class, 'versionFileUpdateDelete'])->name('version-delete');

        Route::group(['prefix' => 'addon', 'as' => 'addon.'], function () {
            Route::get('details/{code}', [AddonUpdateController::class, 'addonDetails'])->name('details')->withoutMiddleware(['addon']);
            Route::post('store', [AddonUpdateController::class, 'addonFileStore'])->name('store')->withoutMiddleware(['addon']);
            Route::post('execute', [AddonUpdateController::class, 'addonFileExecute'])->name('execute')->withoutMiddleware(['addon']);
            Route::get('delete/{code}', [AddonUpdateController::class, 'addonFileDelete'])->name('delete')->withoutMiddleware(['addon']);
        });
    }else{
        //subscription
        Route::group(['prefix' => 'subscription', 'as' => 'subscription.'], function () {
            Route::get('/', [SubscriptionController::class, 'index'])->name('index');
            Route::get('checkout', [OrderController::class, 'checkout'])->name('checkout');
            Route::post('pay', [OrderController::class, 'pay'])->name('pay');
            Route::get('get-currency-by-gateway', [OrderController::class, 'getCurrencyByGateway'])->name('get.currency');
            Route::get('checkout/success', [OrderController::class, 'checkoutSuccess'])->name('checkout.success');
            Route::get('get-package', [SubscriptionController::class, 'getPackage'])->name('get.package');
            Route::post('cancel', [SubscriptionController::class, 'cancel'])->name('cancel');
            Route::get('transaction-list', [SubscriptionController::class, 'transactionList'])->name('transaction.list');
        });

//custom domain
        Route::group(['prefix' => 'custom-domain', 'as' => 'custom_domain.'], function () {
            Route::get('/', [CustomDomainRequestController::class, 'index'])->name('index');
            Route::post('store', [CustomDomainRequestController::class, 'store'])->name('store');
            Route::get('info/{id}', [CustomDomainRequestController::class, 'info'])->name('info');
            Route::POST('update/{id}', [CustomDomainRequestController::class, 'update'])->name('update');
        });
    }
});
