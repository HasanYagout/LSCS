<?php

namespace App\Http\Controllers\Alumni;

use App\Http\Controllers\Controller;
use App\Http\Services\DashboardService;
use App\Http\Services\HardwareService;
use App\Http\Services\NewsService;
use App\Http\Services\NotificationService;
use App\Models\Bank;
use App\Models\Category;
use App\Models\FavouriteCoinPairs;
use App\Models\FileManager;
use App\Models\SearchResult;
use App\Models\SearchResultItem;
use App\Models\User;
use App\Models\UserWallet;
use App\Services\SubscriptionService;
use App\Traits\ResponseTrait;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    use ResponseTrait;
    public $tradeService;
    public $newsService;
    public $hardwareService;
    public $walletService;

    public function __construct()
    {
        $this->newsService = new NewsService;
    }

    public function index(Request $request)
    {
        $data['activeDashboard'] = 'active';
        $data['news'] = $this->newsService->list($request);

        return view('alumni.dashboard',$data);
    }

}
