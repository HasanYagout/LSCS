<?php


namespace App\Http\Services;

use App\Models\News;
use App\Models\Package;
use App\Models\Post;
use App\Models\User;
use App\Models\Event;
use App\Models\Alumni;
use App\Models\EventTicket;
use App\Models\Notice;
use App\Models\JobPost;
use App\Models\Transaction;
use App\Models\UserPackage;
use App\Traits\ResponseTrait;
use App\Models\UserMembershipPlan;
use Illuminate\Support\Facades\View;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    use ResponseTrait;

    public function getUpcomingEvent(){
        $upcomingEvents = Event::where('date', '>', now())->orderBy('date', 'Desc')->where('status', STATUS_ACTIVE)->with('category')->limit(2)->get();
        return $this->success($upcomingEvents);
    }

    public function getLatestJobs(){
        $latestJobs = JobPost::orderBy('application_deadline', 'DESC')->with('company','admin')->where('status', STATUS_ACTIVE)->limit(2)->get();

        return $this->success($latestJobs);
    }
    public function getLatestPosts(){
        $latestPosts = Post::orderBy('id', 'DESC')->with('creator')->where('status', STATUS_ACTIVE)->get();
        return $this->success($latestPosts);
    }
    public function getPosts(){
        $latestPosts = Post::orderBy('id', 'DESC')->with('creator','media')->where('status', STATUS_ACTIVE)->paginate(10);
        return $latestPosts;
    }
    public function getLatestNotice(){
        $latestNotices = Notice::orderBy('id', 'DESC')->where('status', STATUS_ACTIVE)->limit(2)->get();
        return $this->success($latestNotices);
    }

    public function getLatestNews(){
        $latestNews = News::orderBy('id', 'DESC')->where('status', STATUS_ACTIVE)->with(['category', 'author'])->limit(2)->get();
        return $this->success($latestNews);
    }

//    public function getMorePost($request){
//
//        $data['posts'] = Post::orderBy('id', 'DESC')->where('status', STATUS_ACTIVE)->with(['creator'])->paginate(4);
//
//        $response['html'] = View::make('admin.partials.post', $data)->render();
//        return $this->success($response);
//    }

    public function totalAlumni($tenant_id)
    {
        return Alumni::where('users.tenant_id', $tenant_id)->join('users', 'alumnus.user_id', '=', 'users.id')->where('users.status', STATUS_ACTIVE)->count();
    }

//    public function currentMember($tenant_id)
//    {
//        return User::whereHas('currentMembership')->where('tenant_id', $tenant_id)->count();
//    }

    public function totalUpcomingEvent($tenant_id)
    {
        return Event::where('date', '>', now())->orderBy('date', 'ASC')->where('status', STATUS_ACTIVE)->count();
    }

//    public function memberThisMonth($tenant_id)
//    {
//        return UserMembershipPlan::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->where('tenant_id', $tenant_id)->count();
//    }

//    public function transactionThisMonth($tenant_id)
//    {
//        return Transaction::whereMonth('created_at', Carbon::now()->month)->whereYear('created_at', Carbon::now()->year)->where('tenant_id', $tenant_id)->sum('amount');
//    }

    public function allTransactionList($tenant_id)
    {
        $transaction = Transaction::join('users', 'users.id','=', 'transactions.user_id')
            ->where('transactions.tenant_id', $tenant_id)
            ->select('transactions.*', 'users.name as user_name')
            ->orderBy('transactions.id','DESC');
        return datatables($transaction)
            ->addColumn('name', function ($data) {
                return htmlspecialchars($data->user_name);
            })
            ->addColumn('amount', function ($data) {
                return showPrice($data->amount);
            })
            ->addColumn('created_at', function ($data) {
                return \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $data->created_at)->format('jS F, h:i:s A');
            })
            ->rawColumns(['created_at', 'name', 'amount'])
            ->make(true);
    }

//    public function dashboardDailyMembershipPaymentChart($tenant_id)
//    {
//        $first_day_of_the_current_month = Carbon::now()->startOfMonth();
//        $current_month_days_count = $first_day_of_the_current_month->diff(now());
//        $last_day_of_the_current_month = Carbon::now()->endOfMonth();
//        $transactionData = Transaction::whereBetween('payment_time', [$first_day_of_the_current_month, $last_day_of_the_current_month])
//        ->groupBy(DB::raw("DATE_FORMAT(payment_time,'%Y-%m-%d')"))
//        ->orderBy('payment_time','desc')
//        ->where('tenant_id', $tenant_id)
//        ->whereIn('type',[TRANSACTION_MEMBERSHIP, TRANSACTION_EVENT])
//        ->select(DB::raw("DATE_FORMAT(payment_time,'%b %d') as day, sum(amount) as total"))
//        ->get();
//        $price = [];
//        foreach($transactionData as $rows){
//            $price[$rows->day] = $rows->total;
//        }
//        $membershipChartData['mainData'] = $transactionData;
//        $membershipChartData['days'] = $transactionData->pluck('day')->toArray();
//        $membershipChartData['price'] = $price;
//        $membershipChartData['current_month_days_count'] = $current_month_days_count->d;
//
//        return $membershipChartData;
//    }
//    public function dashboardTopEventTicketChart($firstTenant)
//    {
//        $eventTickets = EventTicket::join('events', 'events.id', '=', 'event_tickets.event_id')
//        ->where('event_tickets.tenant_id', $firstTenant)
//        ->groupBy('event_id')
//        ->select('events.title as event_name',DB::raw("count(ticket_number) as total_ticket"))
//        ->orderBy('total_ticket','desc')
//        ->skip(0)->take(5)->get();
//       $eventTicketData['mainData'] = $eventTickets;
//        $eventTicketData['totalTicket'] =  $eventTickets->pluck('total_ticket')->toArray();
//        $eventTicketData['eventName'] =  $eventTickets->pluck('event_name')->toArray();
//        return $eventTicketData;
//    }

    public function getSuperAdminOrderSummary()
    {
        // Get active packages
        $packages = Package::where(['status' => STATUS_ACTIVE])->select('name', 'id')->get();

        // Calculate the date 12 months ago from today
        $twelveMonthsAgo = now()->subMonths(12);

        // Fetch the user package counts grouped by package_id and month
        $userPackageCounts = UserPackage::where('start_date', '>=', $twelveMonthsAgo)
            ->select([
                'package_id',
                DB::raw('DATE_FORMAT(start_date, "%Y-%m") as month'),
                DB::raw('COUNT(*) as total')
            ])
            ->groupBy('package_id')
            ->groupBy(DB::raw('DATE_FORMAT(start_date, "%Y-%m")'))
            ->orderBy('package_id')
            ->orderBy('month')
            ->get()
            ->groupBy('package_id');

        // Prepare the response data array
        $response = [];

        // Loop through each package
        foreach ($packages as $package) {
            $data = [];

            // Loop through the last 12 months
            for ($i = 11; $i >= 0; $i--) {
                $date = now()->subMonths($i);
                $monthYear = $date->format('Y-m');

                // Find the count for the current package and month, or set it to 0 if not available
                $monthlyData = $userPackageCounts->get($package->id, collect())->firstWhere('month', $monthYear);
                $count = $monthlyData ? $monthlyData->total : 0;
                $data[] = $count;
            }

            // Add the package data to the response array
            $response[] = [
                'name' => $package->name,
                'data' => $data
            ];
        }

        // Generate last 12 month names
        $last12Months = collect();
        for ($i = 11; $i >= 0; $i--) {
            $last12Months->push(now()->subMonths($i)->format('M Y'));
        }

        return ['chartData' => json_encode($response), 'chartCategory' => json_encode($last12Months->toArray())];
    }
}
