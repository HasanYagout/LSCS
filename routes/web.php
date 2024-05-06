<?php

use App\Http\Controllers\Admin\StoryController;
use App\Http\Controllers\Web\HomeController;
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
Route::group(['namespace' => 'web'], function () {

    Route::get('/', [HomeController::class, 'index'])->name('index');
    Route::get('ticket-verify/{ticket}', [TicketVerifyController::class, 'ticketPreview'])->name('ticket.verify');

// alumni
    Route::get('all-alumni', [AlumniController::class, 'alumni'])->name('all.alumni');

// event
    Route::get('all-event', [EventController::class, 'event'])->name('all.event');
    Route::get('event-view-details/{slug}', [EventController::class, 'eventDetails'])->name('event.view.details');

// news
    Route::get('our-news', [NewsController::class, 'news'])->name('our.news');
    Route::get('news-view-details/{slug}', [NewsController::class, 'newsDetails'])->name('news.view.details');

// notice
    Route::get('our-notice', [NoticeController::class, 'notice'])->name('our.notice');
    Route::get('notice-view-details/{slug}', [NoticeController::class, 'noticeDetails'])->name('notice.view.details');

// Membership
    Route::get('all-membership', [MembershipController::class, 'membership'])->name('all.membership');

// job
    Route::get('all-job', [JobController::class, 'job'])->name('all.job');
    Route::get('job-view-details/{slug}', [JobController::class, 'jobDetails'])->name('job.view.details');

// story
    Route::get('all-stories', [StoryController::class, 'list'])->name('all.stories');
    Route::get('view-stories/{slug}', [StoryController::class, 'view'])->name('story.view');

// pages
    Route::get('page/{slug}', [HomeController::class, 'page'])->name('pages');

// contact-us
    Route::get('contact-us', [ContactUsController::class, 'contactUs'])->name('contact_us');
    Route::post('contact-us-store', [ContactUsController::class, 'store'])->name('contact_us.store');

});
