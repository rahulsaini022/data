<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\User;
use App\Attorney;
use App\Courtcase;
use App\Caseuser;
use App\Userloginreport;
use File;
use Illuminate\Support\Facades\Storage;
use ZipArchive;
use Stripe\Stripe;
class AdminController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        
    }

    /* To fetch last 10 active users */
    public function admin()
    {
        $last_active_users = User::orderBy('last_login', 'desc')->limit(10)->get();
        
        return view('admin.dashboard',['last_active_users'=>$last_active_users]);
        // $most_active_users = User::orderBy('login_count', 'desc')->limit(10)->get();
        // return view('admin.dashboard',['last_active_users'=>$last_active_users, 'most_active_users'=>$most_active_users]);
    }

    /* Get Stats like total users, attorneys, clients, cases etc based on date */
    public function getStats(Request $request)
    {
        $type=$request->type;
        $total=$request->total;
        if($type=='all')
        {
            $users = User::count();
            $attornies = User::role('attorney')->count();
            $clients = User::role('client')->count();
            $advertiser = User::role('advertise')->count();
            $cases = Courtcase::count();
            $most_active_users= DB::table('userloginreports')
            ->join('users', 'userloginreports.user_id', '=', 'users.id')
            ->select('userloginreports.user_id', 'users.name','users.email', DB::raw('count(userloginreports.id) as total'))
            ->whereNotNull('userloginreports.last_login')
            ->groupBy('userloginreports.user_id')
            ->orderBy('total','desc')
            ->limit(10)
            ->get();
            $all=array(
                'users' => $users,
                'attornies' => $attornies,
                'clients' => $clients,
                'cases' => $cases,
                'advertisers' => $advertiser,
                'most_active_users' => $most_active_users,
            );
            echo json_encode($all);
        }
        if($type=='year')
        {
            $users = User::whereDate('created_at', '>', Carbon::now()->subYear($total))
                   ->count();
            $attornies = User::whereDate('created_at', '>', Carbon::now()->subYear($total))->role('attorney')->count();
            $clients = User::whereDate('created_at', '>', Carbon::now()->subYear($total))->role('client')->count();
            $cases = Courtcase::whereDate('created_at', '>', Carbon::now()->subYear($total))->count();
            $most_active_users= DB::table('userloginreports')
            ->join('users', 'userloginreports.user_id', '=', 'users.id')
            ->select('userloginreports.user_id', 'users.name','users.email', DB::raw('count(userloginreports.id) as total'))
            ->whereDate('userloginreports.last_login', '>', Carbon::now()->subYear($total))
            ->groupBy('userloginreports.user_id')
            ->orderBy('total','desc')
            ->limit(10)
            ->get();
            $all=array(
                'users' => $users,
                'attornies' => $attornies,
                'clients' => $clients,
                'cases' => $cases,
                'most_active_users' => $most_active_users,
            );
            echo json_encode($all);
        }
        if($type=='month')
        {
            $users = User::whereDate('created_at', '>', Carbon::now()->subMonth($total))
                   ->count();
            $attornies = User::whereDate('created_at', '>', Carbon::now()->subMonth($total))->role('attorney')->count();
            $clients = User::whereDate('created_at', '>', Carbon::now()->subMonth($total))->role('client')->count();
            $cases = Courtcase::whereDate('created_at', '>', Carbon::now()->subMonth($total))->count();
            $most_active_users= DB::table('userloginreports')
            ->join('users', 'userloginreports.user_id', '=', 'users.id')
            ->select('userloginreports.user_id', 'users.name','users.email', DB::raw('count(userloginreports.id) as total'))
            ->whereDate('userloginreports.last_login', '>', Carbon::now()->subMonth($total))
            ->groupBy('userloginreports.user_id')
            ->orderBy('total','desc')
            ->limit(10)
            ->get();
            $all=array(
                'users' => $users,
                'attornies' => $attornies,
                'clients' => $clients,
                'cases' => $cases,
                'most_active_users' => $most_active_users,
            );
            echo json_encode($all);
        }
        if($type=='days')
        {
            $users = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
            $attornies = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->role('attorney')->count();
            $clients = User::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->role('client')->count();
            $cases = Courtcase::whereYear('created_at', Carbon::now()->year)->whereMonth('created_at', Carbon::now()->month)->count();
            $most_active_users= DB::table('userloginreports')
            ->join('users', 'userloginreports.user_id', '=', 'users.id')
            ->select('userloginreports.user_id', 'users.name','users.email', DB::raw('count(userloginreports.id) as total'))
            ->whereYear('userloginreports.last_login', Carbon::now()->year)
            ->whereMonth('userloginreports.last_login', Carbon::now()->month)
            ->groupBy('userloginreports.user_id')
            ->orderBy('total','desc')
            ->limit(10)
            ->get();
            $all=array(
                'users' => $users,
                'attornies' => $attornies,
                'clients' => $clients,
                'cases' => $cases,
                'most_active_users' => $most_active_users,
            );
            echo json_encode($all);
        }
    }

    // following functions are for users graphs

    /* Show user reports/graphs */
    public function get_user_reports(){
        return view('admin.reports.user_reports');
    }

    /* Get users registered in last 30 days to show in graph day wise registration */
    public function get_users_by_day_chart_data(){
        $data = array(); 
        $label=array();
        for ($days_backwards = 0; $days_backwards < 30; $days_backwards++) {
            array_push($data, User::whereDate('created_at', $sub=today()->subDays($days_backwards))->count());
            // array_push($label, $days_backwards);
            array_push($label, date('m/d/Y', strtotime($sub)));
        }
        
        $all=array(
            'label'=>$label,
            'data'=>$data
        );
        echo json_encode($all);
    }

    /* Get users registered in last 52 weeks to show in graph week wise registration */
    public function get_users_by_week_chart_data(){
        $data = array(); 
        $label=array();
        $today=Carbon::now()->endOfWeek();
        $subToday=Carbon::now()->endOfWeek();
        $subWeek=$subToday->subWeek(1);
        $title=array();
        $t=0;
        for ($weeks_backwards = 0; $weeks_backwards <52; $weeks_backwards++) {
            
            array_push($data, User::whereDate('created_at', '<=', $today)
                           ->whereDate('created_at', '>',  $subWeek)->count());
            $to=date('m/d/Y', strtotime($today));
            $from=date('m/d/Y', strtotime($subWeek));
            // array_push($label, $to." - ".$from);
            array_push($label, "week ".++$t);
            array_push($title, $to." - ".$from);
            $today->subWeek(1);
            $subWeek->subWeek(1);
        }
        
        $all=array(
            'label'=>$label,
            'data'=>$data,
            'title'=>$title
        );
        echo json_encode($all);
    }

    // following functions are for attorneys graphs

    /* To show attorney reports/graphs */
    public function get_attorney_reports(){
        return view('admin.reports.attorney_reports');
    }

    /* Get attorney users registered in last 30 days to show in graph day wise registration */
    public function get_attorney_users_by_day_chart_data(){
        $data = array(); 
        $label=array();
        for ($days_backwards = 0; $days_backwards < 30; $days_backwards++) {
            
            array_push($data, User::where('active', '1')->whereDate('created_at', $sub=today()->subDays($days_backwards))->role('attorney')->count());
            // array_push($label, $days_backwards);
            array_push($label, date('m/d/Y', strtotime($sub)));
        }
        
        $all=array(
            'label'=>$label,
            'data'=>$data
        );
        echo json_encode($all);
    }

    /* Get attorney users registered in last 52 weeks to show in graph week wise registration */
    public function get_attorney_users_by_week_chart_data(){
        $data = array(); 
        $label=array();
        $today=Carbon::now()->endOfWeek();
        $subToday=Carbon::now()->endOfWeek();
        $subWeek=$subToday->subWeek(1);
        $title=array();
        $t=0;
        for ($weeks_backwards = 0; $weeks_backwards <52; $weeks_backwards++) {
            
            array_push($data, User::where('active', '1')->whereDate('created_at', '<=', $today)
                           ->whereDate('created_at', '>',  $subWeek)->role('attorney')->count());
            $to=date('m/d/Y', strtotime($today));
            $from=date('m/d/Y', strtotime($subWeek));
            array_push($label, "week ".++$t);
            array_push($title, $to." - ".$from);
            $today->subWeek(1);
            $subWeek->subWeek(1);
        }
        
        $all=array(
            'label'=>$label,
            'data'=>$data,
            'title'=>$title
        );
        echo json_encode($all);
    }

    // following functions are for clients graphs
    /* Show Client Reports/Graphs */
    public function get_client_reports(){
        return view('admin.reports.client_reports');
    }

    /* Get client users registered in last 30 days to show in graph day wise registration */
    public function get_client_users_by_day_chart_data(){
        $data = array(); 
        $label=array();
        for ($days_backwards = 0; $days_backwards < 30; $days_backwards++) {
            
            // array_push($data, User::whereDate('created_at', today()->subDays($days_backwards))->role('client')->count());
            $client_id = DB::table('caseusers')
                ->where('type', 'client')
                ->get()->pluck('user_id');
            array_push($data, User::whereIn('id', $client_id)->whereDate('created_at', $sub=today()->subDays($days_backwards))->role('client')->count());
            // array_push($label, $days_backwards);
            array_push($label, date('m/d/Y', strtotime($sub)));
        }
        
        $all=array(
            'label'=>$label,
            'data'=>$data
        );
        echo json_encode($all);
    }

    /* Get client users registered in last 52 weeks to show in graph week wise registration */
    public function get_client_users_by_week_chart_data(){
        $data = array(); 
        $label=array();
        $today=Carbon::now()->endOfWeek();
        $subToday=Carbon::now()->endOfWeek();
        $subWeek=$subToday->subWeek(1);
        $title=array();
        $t=0;
        for ($weeks_backwards = 0; $weeks_backwards <52; $weeks_backwards++) {
            
            // array_push($data, User::whereDate('created_at', '<=', $today)
            //                ->whereDate('created_at', '>=',  $today->subWeek(1))->role('client')->count());

            $client_id = DB::table('caseusers')
                ->where('type', 'client')
                ->get()->pluck('user_id');
            array_push($data, User::whereIn('id', $client_id)->whereDate('created_at', '<=', $today)
                           ->whereDate('created_at', '>',  $subWeek)->role('client')->count());

            $to=date('m/d/Y', strtotime($today));
            $from=date('m/d/Y', strtotime($subWeek));
            array_push($label, "week ".++$t);
            array_push($title, $to." - ".$from);
            $today->subWeek(1);
            $subWeek->subWeek(1);
        }
        
        $all=array(
            'label'=>$label,
            'data'=>$data,
            'title'=>$title
        );
        echo json_encode($all);
    }

    // following functions are for case graphs
    /* To show case Reports/Graphs */
    public function get_case_reports(){
        return view('admin.reports.case_reports');
    }

    /* Get cases registered in last 30 days to show in graph days wise registration */
    public function get_cases_by_day_chart_data(){
        $data = array(); 
        $label=array();
        for ($days_backwards = 0; $days_backwards < 30; $days_backwards++) {
            
            array_push($data, Courtcase::whereDate('created_at', $sub=today()->subDays($days_backwards))->count());
            // array_push($label, $days_backwards);
            array_push($label, date('m/d/Y', strtotime($sub)));
        }
        $all=array(
            'label'=>$label,
            'data'=>$data
        );
        echo json_encode($all);
    }

    /* Get cases registered in last 52 weeks to show in graph week wise registration */
    public function get_cases_by_week_chart_data(){
        $data = array(); 
        $label=array();
        $today=Carbon::now()->endOfWeek();
        $subToday=Carbon::now()->endOfWeek();
        $subWeek=$subToday->subWeek(1);
        $title=array();
        $t=0;
        for ($weeks_backwards = 0; $weeks_backwards <52; $weeks_backwards++) {
            
            array_push($data, Courtcase::whereDate('created_at', '<=', $today)
                ->whereDate('created_at', '>',  $subWeek)->count());
            $to=date('m/d/Y', strtotime($today));
            $from=date('m/d/Y', strtotime($subWeek));
            array_push($label, "week ".++$t);
            array_push($title, $to." - ".$from);
            $today->subWeek(1);
            $subWeek->subWeek(1);

        }
        
        $all=array(
            'label'=>$label,
            'data'=>$data,
            'title'=>$title
        );
        echo json_encode($all);
    }
    
    // following functions are for user logins graphs
    /* Show User Login Reports/Graphs */
    public function get_user_login_reports(){
        return view('admin.reports.user_login_reports');
    }

    /* Get users login in last 30 days to show in graph day wise logins */
    public function get_user_logins_by_day_chart_data(){
        $data = array(); 
        $label=array();
        for ($days_backwards = 0; $days_backwards < 30; $days_backwards++) {
            
            array_push($data, Userloginreport::whereDate('last_login', $sub=today()->subDays($days_backwards))->count());
            // array_push($label, $days_backwards);
            array_push($label, date('m/d/Y', strtotime($sub)));
        }
        $all=array(
            'label'=>$label,
            'data'=>$data
        );
        echo json_encode($all);
    }

    /* Get users login in last 52 weeks to show in graph week wise logins */
    public function get_user_logins_by_week_chart_data(){
        $data = array(); 
        $label=array();
        $today=Carbon::now()->endOfWeek();
        $subToday=Carbon::now()->endOfWeek();
        $subWeek=$subToday->subWeek(1);
        $title=array();
        $t=0;
        for ($weeks_backwards = 0; $weeks_backwards <52; $weeks_backwards++) {
            
            array_push($data, Userloginreport::whereDate('last_login', '<=', $today)
                           ->whereDate('last_login', '>',  $subWeek)->count());
            $to=date('m/d/Y', strtotime($today));
            $from=date('m/d/Y', strtotime($subWeek));
            array_push($label, "week ".++$t);
            array_push($title, $to." - ".$from);
            $today->subWeek(1);
            $subWeek->subWeek(1);
        }
        
        $all=array(
            'label'=>$label,
            'data'=>$data,
            'title'=>$title
        );
        echo json_encode($all);
    }

    // following functions are for failed user logins graphs
    /* Show Users failed Logins Reports/Graphs */
    public function get_failed_user_login_reports(){
        return view('admin.reports.user_failed_login_reports');
    }

    /* Get users failed login in last 30 days to show in graph day wise logins */
    public function get_failed_user_logins_by_day_chart_data(){
        $data = array(); 
        $label=array();
        for ($days_backwards = 0; $days_backwards < 30; $days_backwards++) {
            
            array_push($data, Userloginreport::whereDate('last_failed_login', $sub=today()->subDays($days_backwards))->count());
            // array_push($data, Userloginreport::whereDate('last_failed_login', $sub=today()->subDays($days_backwards))->distinct('user_id')->count('user_id'));
            // array_push($label, $days_backwards);
            array_push($label, date('m/d/Y', strtotime($sub)));
        }
        $all=array(
            'label'=>$label,
            'data'=>$data
        );
        echo json_encode($all);
    }

    /* Get users failed login in last 52 weeks to show in graph week wise logins */
    public function get_failed_user_logins_by_week_chart_data(){
        $data = array(); 
        $label=array();
        $today=Carbon::now()->endOfWeek();
        $subToday=Carbon::now()->endOfWeek();
        $subWeek=$subToday->subWeek(1);
        $title=array();
        $t=0;
        for ($weeks_backwards = 0; $weeks_backwards <52; $weeks_backwards++) {
            
            array_push($data, Userloginreport::whereDate('last_failed_login', '<=', $today)
                           ->whereDate('last_failed_login', '>',  $subWeek)->count());
            // array_push($label, $weeks_backwards);
            $to=date('m/d/Y', strtotime($today));
            $from=date('m/d/Y', strtotime($subWeek));
            array_push($label, "week ".++$t);
            array_push($title, $to." - ".$from);
            $today->subWeek(1);
            $subWeek->subWeek(1);
        }
        
        $all=array(
            'label'=>$label,
            'data'=>$data,
            'title'=>$title
        );
        echo json_encode($all);
    }

    // following functions are for showing payment data to admin
    public function showAllPayments(){

        // $first=DB::table('state_seat_license_transaction_history')
        //     ->select('state_seat_license_transaction_history.user_id as user_id','state_seat_license_transaction_history.stripe_transaction_id as stripe_transaction_id','state_seat_license_transaction_history.amount as amount','state_seat_license_transaction_history.description as notes','state_seat_license_transaction_history.created_at as created_at','users.name', 'users.email')
        //     ->leftJoin('users', 'state_seat_license_transaction_history.user_id', '=', 'users.id');
        $second=DB::table('user_credits_history')
            ->select('user_credits_history.user_id as user_id','user_credits_history.stripe_transaction_id as stripe_transaction_id','user_credits_history.amount as amount','user_credits_history.description as notes','user_credits_history.created_at as created_at','users.name', 'users.email')
            ->leftJoin('users', 'user_credits_history.user_id', '=', 'users.id')
            ->whereNotNull('user_credits_history.stripe_transaction_id');

        $allpayments = DB::table('case_payment_transaction_history')
            ->select('case_payment_transaction_history.user_id as user_id','case_payment_transaction_history.stripe_transaction_id as stripe_transaction_id','case_payment_transaction_history.amount as amount','case_payment_transaction_history.description as notes','case_payment_transaction_history.created_at as created_at','users.name', 'users.email')
            ->leftJoin('users', 'case_payment_transaction_history.user_id', '=', 'users.id')
            //->unionAll($first)
            ->unionAll($second)
            ->get();
            // dd($allpayments);
        return view('admin.payment_reports.show_all_payments',['allpayments'=>$allpayments]);

    }

    /* Get Current Month Stripe Payments */
    public function getCurrentMonthAllPayments(){
        $currentMonth = date('m');
        $currentyear = date('Y');
        
        // $first=DB::table('state_seat_license_transaction_history')
        //     ->select('state_seat_license_transaction_history.user_id as user_id','state_seat_license_transaction_history.stripe_transaction_id as stripe_transaction_id','state_seat_license_transaction_history.amount as amount','state_seat_license_transaction_history.description as notes','state_seat_license_transaction_history.created_at as created_at','users.name', 'users.email')
        //     ->leftJoin('users', 'state_seat_license_transaction_history.user_id', '=', 'users.id')
        //     ->whereRaw('MONTH(state_seat_license_transaction_history.created_at) = ?',[$currentMonth])
        //     ->whereRaw('YEAR(state_seat_license_transaction_history.created_at) = ?',[$currentyear]);
        $second=DB::table('user_credits_history')
            ->select('user_credits_history.user_id as user_id','user_credits_history.stripe_transaction_id as stripe_transaction_id','user_credits_history.amount as amount','user_credits_history.description as notes','user_credits_history.created_at as created_at','users.name', 'users.email')
            ->leftJoin('users', 'user_credits_history.user_id', '=', 'users.id')
            ->whereNotNull('user_credits_history.stripe_transaction_id')
            ->whereRaw('MONTH(user_credits_history.created_at) = ?',[$currentMonth])
            ->whereRaw('YEAR(user_credits_history.created_at) = ?',[$currentyear]);

        $currentmonthpayments = DB::table('case_payment_transaction_history')
            ->select('case_payment_transaction_history.user_id as user_id','case_payment_transaction_history.stripe_transaction_id as stripe_transaction_id','case_payment_transaction_history.amount as amount','case_payment_transaction_history.description as notes','case_payment_transaction_history.created_at as created_at','users.name', 'users.email')
            ->leftJoin('users', 'case_payment_transaction_history.user_id', '=', 'users.id')
            ->whereRaw('MONTH(case_payment_transaction_history.created_at) = ?',[$currentMonth])
            ->whereRaw('YEAR(case_payment_transaction_history.created_at) = ?',[$currentyear])
            //->unionAll($first)
            ->unionAll($second)
            ->get();
            return view('admin.payment_reports.show_all_payments',['allpayments'=>$currentmonthpayments]);

    } 
    
    /* Get Monthly Stripe Payments */
    public function getMonthBasedAllPayments($months){

        $first=DB::table('state_seat_license_transaction_history')
            ->select('state_seat_license_transaction_history.user_id as user_id','state_seat_license_transaction_history.stripe_transaction_id as stripe_transaction_id','state_seat_license_transaction_history.amount as amount','state_seat_license_transaction_history.description as notes','state_seat_license_transaction_history.created_at as created_at','users.name', 'users.email')
            ->leftJoin('users', 'state_seat_license_transaction_history.user_id', '=', 'users.id')
            ->where('state_seat_license_transaction_history.created_at', '>', (new \Carbon\Carbon)->submonths($months) );
        $second=DB::table('user_credits_history')
            ->select('user_credits_history.user_id as user_id','user_credits_history.stripe_transaction_id as stripe_transaction_id','user_credits_history.amount as amount','user_credits_history.description as notes','user_credits_history.created_at as created_at','users.name', 'users.email')
            ->leftJoin('users', 'user_credits_history.user_id', '=', 'users.id')
            ->whereNotNull('user_credits_history.stripe_transaction_id')
            ->where('user_credits_history.created_at', '>', (new \Carbon\Carbon)->submonths($months) );

        $monthsbasedpayments = DB::table('case_payment_transaction_history')
            ->select('case_payment_transaction_history.user_id as user_id','case_payment_transaction_history.stripe_transaction_id as stripe_transaction_id','case_payment_transaction_history.amount as amount','case_payment_transaction_history.description as notes','case_payment_transaction_history.created_at as created_at','users.name', 'users.email')
            ->leftJoin('users', 'case_payment_transaction_history.user_id', '=', 'users.id')
            ->where('case_payment_transaction_history.created_at', '>', (new \Carbon\Carbon)->submonths($months) )
            ->unionAll($first)
            ->unionAll($second)
            ->get();
            return view('admin.payment_reports.show_all_payments',['allpayments'=>$monthsbasedpayments]);

    } 
    
    /* Get Date Based Stripe Payments */
    public function getDateBasedAllPayments(Request $request){
        $from_date=$request->from_date;
        $to_date=$request->to_date;
        $from_date = new Carbon($from_date);
        $to_date = new Carbon($to_date);

        // whereBetween('created_at', [$from_date->format('Y-m-d')." 00:00:00", $to_date->format('Y-m-d')." 23:59:59"])->get();

        // $first=DB::table('state_seat_license_transaction_history')
        //     ->select('state_seat_license_transaction_history.user_id as user_id','state_seat_license_transaction_history.stripe_transaction_id as stripe_transaction_id','state_seat_license_transaction_history.amount as amount','state_seat_license_transaction_history.description as notes','state_seat_license_transaction_history.created_at as created_at','users.name', 'users.email')
        //     ->leftJoin('users', 'state_seat_license_transaction_history.user_id', '=', 'users.id')
        //     ->whereBetween('state_seat_license_transaction_history.created_at', [$from_date->format('Y-m-d')." 00:00:00", $to_date->format('Y-m-d')." 23:59:59"]);
        $second=DB::table('user_credits_history')
            ->select('user_credits_history.user_id as user_id','user_credits_history.stripe_transaction_id as stripe_transaction_id','user_credits_history.amount as amount','user_credits_history.description as notes','user_credits_history.created_at as created_at','users.name', 'users.email')
            ->leftJoin('users', 'user_credits_history.user_id', '=', 'users.id')
            ->whereNotNull('user_credits_history.stripe_transaction_id')
            ->whereBetween('user_credits_history.created_at', [$from_date->format('Y-m-d')." 00:00:00", $to_date->format('Y-m-d')." 23:59:59"]);

        $paymentsbetweentwodates = DB::table('case_payment_transaction_history')
            ->select('case_payment_transaction_history.user_id as user_id','case_payment_transaction_history.stripe_transaction_id as stripe_transaction_id','case_payment_transaction_history.amount as amount','case_payment_transaction_history.description as notes','case_payment_transaction_history.created_at as created_at','users.name', 'users.email')
            ->leftJoin('users', 'case_payment_transaction_history.user_id', '=', 'users.id')
            ->whereBetween('case_payment_transaction_history.created_at', [$from_date->format('Y-m-d')." 00:00:00", $to_date->format('Y-m-d')." 23:59:59"])
            // ->unionAll($first)
            ->unionAll($second)
            ->get();
            return view('admin.payment_reports.show_all_payments',['allpayments'=>$paymentsbetweentwodates]);

    }

    // following functions are for case payments view
    public function showCasePayments(){

        $allcasepayments = DB::table('case_payment_transaction_history')
            ->select('case_payment_transaction_history.user_id as user_id','case_payment_transaction_history.stripe_transaction_id as stripe_transaction_id','case_payment_transaction_history.amount as amount','case_payment_transaction_history.description as notes','case_payment_transaction_history.created_at as created_at','users.name', 'users.email')
            ->leftJoin('users', 'case_payment_transaction_history.user_id', '=', 'users.id')
            ->get();
            // dd($allpayments);
        return view('admin.payment_reports.show_case_payments',['allpayments'=>$allcasepayments]);

    }

    /* Get Current Month Case Stripe Payments */
    public function getCurrentMonthCasePayments(){
        $currentMonth = date('m');
        $currentyear = date('Y');
        
        $currentmonthpayments = DB::table('case_payment_transaction_history')
            ->select('case_payment_transaction_history.user_id as user_id','case_payment_transaction_history.stripe_transaction_id as stripe_transaction_id','case_payment_transaction_history.amount as amount','case_payment_transaction_history.description as notes','case_payment_transaction_history.created_at as created_at','users.name', 'users.email')
            ->leftJoin('users', 'case_payment_transaction_history.user_id', '=', 'users.id')
            ->whereRaw('MONTH(case_payment_transaction_history.created_at) = ?',[$currentMonth])
            ->whereRaw('YEAR(case_payment_transaction_history.created_at) = ?',[$currentyear])
            ->get();
            return view('admin.payment_reports.show_case_payments',['allpayments'=>$currentmonthpayments]);

    } 
    
    /* Get Monthly Based Case Stripe Payments */
    public function getMonthBasedCasePayments($months){

        $monthsbasedpayments = DB::table('case_payment_transaction_history')
            ->select('case_payment_transaction_history.user_id as user_id','case_payment_transaction_history.stripe_transaction_id as stripe_transaction_id','case_payment_transaction_history.amount as amount','case_payment_transaction_history.description as notes','case_payment_transaction_history.created_at as created_at','users.name', 'users.email')
            ->leftJoin('users', 'case_payment_transaction_history.user_id', '=', 'users.id')
            ->where('case_payment_transaction_history.created_at', '>', (new \Carbon\Carbon)->submonths($months) )
            ->get();
            return view('admin.payment_reports.show_case_payments',['allpayments'=>$monthsbasedpayments]);

    } 
    
    /* Get Date Based Case Stripe Payments */
    public function getDateBasedCasePayments(Request $request){
        $from_date=$request->from_date;
        $to_date=$request->to_date;
        $from_date = new Carbon($from_date);
        $to_date = new Carbon($to_date);

        // whereBetween('created_at', [$from_date->format('Y-m-d')." 00:00:00", $to_date->format('Y-m-d')." 23:59:59"])->get();

        $paymentsbetweentwodates = DB::table('case_payment_transaction_history')
            ->select('case_payment_transaction_history.user_id as user_id','case_payment_transaction_history.stripe_transaction_id as stripe_transaction_id','case_payment_transaction_history.amount as amount','case_payment_transaction_history.description as notes','case_payment_transaction_history.created_at as created_at','users.name', 'users.email')
            ->leftJoin('users', 'case_payment_transaction_history.user_id', '=', 'users.id')
            ->whereBetween('case_payment_transaction_history.created_at', [$from_date->format('Y-m-d')." 00:00:00", $to_date->format('Y-m-d')." 23:59:59"])
            ->get();
            return view('admin.payment_reports.show_case_payments',['allpayments'=>$paymentsbetweentwodates]);

    }



    // following functions are for state seat license payments view
    // public function showStateSeatLicensePayments(){

    //     $allstateseatlicensepayments = DB::table('state_seat_license_transaction_history')
    //         ->select('state_seat_license_transaction_history.user_id as user_id','state_seat_license_transaction_history.stripe_transaction_id as stripe_transaction_id','state_seat_license_transaction_history.amount as amount','state_seat_license_transaction_history.description as notes','state_seat_license_transaction_history.created_at as created_at','users.name', 'users.email')
    //         ->leftJoin('users', 'state_seat_license_transaction_history.user_id', '=', 'users.id')
    //         ->get();
    //         // dd($allpayments);
    //     return view('admin.payment_reports.show_state_seat_license_payments',['allpayments'=>$allstateseatlicensepayments]);

    // }

    // public function getCurrentMonthStateSeatLicensePayments(){
    //     $currentMonth = date('m');
    //     $currentyear = date('Y');
        
    //     $currentmonthpayments = DB::table('state_seat_license_transaction_history')
    //         ->select('state_seat_license_transaction_history.user_id as user_id','state_seat_license_transaction_history.stripe_transaction_id as stripe_transaction_id','state_seat_license_transaction_history.amount as amount','state_seat_license_transaction_history.description as notes','state_seat_license_transaction_history.created_at as created_at','users.name', 'users.email')
    //         ->leftJoin('users', 'state_seat_license_transaction_history.user_id', '=', 'users.id')
    //         ->whereRaw('MONTH(state_seat_license_transaction_history.created_at) = ?',[$currentMonth])
    //         ->whereRaw('YEAR(state_seat_license_transaction_history.created_at) = ?',[$currentyear])
    //         ->get();
    //         return view('admin.payment_reports.show_state_seat_license_payments',['allpayments'=>$currentmonthpayments]);

    // } 
    
    // public function getMonthBasedStateSeatLicensePayments($months){

    //     $monthsbasedpayments = DB::table('state_seat_license_transaction_history')
    //         ->select('state_seat_license_transaction_history.user_id as user_id','state_seat_license_transaction_history.stripe_transaction_id as stripe_transaction_id','state_seat_license_transaction_history.amount as amount','state_seat_license_transaction_history.description as notes','state_seat_license_transaction_history.created_at as created_at','users.name', 'users.email')
    //         ->leftJoin('users', 'state_seat_license_transaction_history.user_id', '=', 'users.id')
    //         ->where('state_seat_license_transaction_history.created_at', '>', (new \Carbon\Carbon)->submonths($months) )
    //         ->get();
    //         return view('admin.payment_reports.show_state_seat_license_payments',['allpayments'=>$monthsbasedpayments]);

    // } 
    
    // public function getDateBasedStateSeatLicensePayments(Request $request){
    //     $from_date=$request->from_date;
    //     $to_date=$request->to_date;
    //     $from_date = new Carbon($from_date);
    //     $to_date = new Carbon($to_date);

    //     // whereBetween('created_at', [$from_date->format('Y-m-d')." 00:00:00", $to_date->format('Y-m-d')." 23:59:59"])->get();

    //     $paymentsbetweentwodates = DB::table('state_seat_license_transaction_history')
    //         ->select('state_seat_license_transaction_history.user_id as user_id','state_seat_license_transaction_history.stripe_transaction_id as stripe_transaction_id','state_seat_license_transaction_history.amount as amount','state_seat_license_transaction_history.description as notes','state_seat_license_transaction_history.created_at as created_at','users.name', 'users.email')
    //         ->leftJoin('users', 'state_seat_license_transaction_history.user_id', '=', 'users.id')
    //         ->whereBetween('state_seat_license_transaction_history.created_at', [$from_date->format('Y-m-d')." 00:00:00", $to_date->format('Y-m-d')." 23:59:59"])
    //         ->get();
    //         return view('admin.payment_reports.show_state_seat_license_payments',['allpayments'=>$paymentsbetweentwodates]);

    // }

    // following functions are for user credits payments view
    public function showUserCreditsPayments(){

        $allusercreditspayments = DB::table('user_credits_history')
            ->select('user_credits_history.user_id as user_id','user_credits_history.stripe_transaction_id as stripe_transaction_id','user_credits_history.amount as amount','user_credits_history.description as notes','user_credits_history.created_at as created_at','users.name', 'users.email')
            ->leftJoin('users', 'user_credits_history.user_id', '=', 'users.id')
            ->whereNotNull('user_credits_history.stripe_transaction_id')
            ->get();
            // dd($allusercreditspayments);
        return view('admin.payment_reports.show_user_credits_payments',['allpayments'=>$allusercreditspayments]);

    }

    /* Get Current Month Fdd Pdf Credits Stripe Payments */
    public function getCurrentMonthUserCreditsPayments(){
        $currentMonth = date('m');
        $currentyear = date('Y');
        
        $currentmonthpayments = DB::table('user_credits_history')
            ->select('user_credits_history.user_id as user_id','user_credits_history.stripe_transaction_id as stripe_transaction_id','user_credits_history.amount as amount','user_credits_history.description as notes','user_credits_history.created_at as created_at','users.name', 'users.email')
            ->leftJoin('users', 'user_credits_history.user_id', '=', 'users.id')
            ->whereNotNull('user_credits_history.stripe_transaction_id')
            ->whereRaw('MONTH(user_credits_history.created_at) = ?',[$currentMonth])
            ->whereRaw('YEAR(user_credits_history.created_at) = ?',[$currentyear])
            ->get();
            return view('admin.payment_reports.show_user_credits_payments',['allpayments'=>$currentmonthpayments]);

    } 
    
    /* Get Monthly Fdd Pdf Credits Stripe Payments */
    public function getMonthBasedUserCreditsPayments($months){

        $monthsbasedpayments = DB::table('user_credits_history')
            ->select('user_credits_history.user_id as user_id','user_credits_history.stripe_transaction_id as stripe_transaction_id','user_credits_history.amount as amount','user_credits_history.description as notes','user_credits_history.created_at as created_at','users.name', 'users.email')
            ->leftJoin('users', 'user_credits_history.user_id', '=', 'users.id')
            ->whereNotNull('user_credits_history.stripe_transaction_id')
            ->where('user_credits_history.created_at', '>', (new \Carbon\Carbon)->submonths($months) )
            ->get();
            return view('admin.payment_reports.show_user_credits_payments',['allpayments'=>$monthsbasedpayments]);

    } 
    
    /* Get Date Based Fdd Pdf Credits Stripe Payments */
    public function getDateBasedUserCreditsPayments(Request $request){
        $from_date=$request->from_date;
        $to_date=$request->to_date;
        $from_date = new Carbon($from_date);
        $to_date = new Carbon($to_date);

        // whereBetween('created_at', [$from_date->format('Y-m-d')." 00:00:00", $to_date->format('Y-m-d')." 23:59:59"])->get();

        $paymentsbetweentwodates = DB::table('user_credits_history')
            ->select('user_credits_history.user_id as user_id','user_credits_history.stripe_transaction_id as stripe_transaction_id','user_credits_history.amount as amount','user_credits_history.description as notes','user_credits_history.created_at as created_at','users.name', 'users.email')
            ->leftJoin('users', 'user_credits_history.user_id', '=', 'users.id')
            ->whereNotNull('user_credits_history.stripe_transaction_id')
            ->whereBetween('user_credits_history.created_at', [$from_date->format('Y-m-d')." 00:00:00", $to_date->format('Y-m-d')." 23:59:59"])
            ->get();
            return view('admin.payment_reports.show_user_credits_payments',['allpayments'=>$paymentsbetweentwodates]);

    }

    /* Show Project Backups */
    public function getProjectBackupFiles(){
        $zip = new ZipArchive;
        $directory=env('APP_NAME', 'First-Draft-Data');
        $directory=str_replace(" ", "-", $directory);
        $headers = ["Content-Type"=>"application/zip"];
        // $files = Storage::disk('local')->files($directory, $headers);

        $path = storage_path('app/'.$directory);
        $files = File::files($path);
        $files_data=array();
        $i=0;
        foreach($files as $file){
        //  dd($files);
            $files_data[$i]['file_name']=basename($file);
            // $files_data[$i]['created_at']=date("m-d-Y H:i:s.", filemtime($file));
            $files_data[$i]['created_at']=filemtime($file);
            ++$i;
        }
        return view('admin.project-backups.index',['files_data'=>$files_data]);
    }

    /* Download Project Backups */
    public function downloadProjectBackupFile(Request $request){
        $file_name=$request->file_name;
        $directory=env('APP_NAME', 'First-Draft-Data');
        $directory=str_replace(" ", "-", $directory);
        $path = storage_path('app/' . $directory.'/'.$file_name);
        $headers = array(
            'Content-Type'=> 'application/zip'
          );
        if(file_exists($path)){
            // $response=response()->download($path, $file_name, $headers);
            $response=response()->download($path, $file_name, $headers);
            ob_end_clean();
            return $response;
        } else {
          die('File Does not Exist');
        }
    }

    /* Show All Stripe Payments */
    public function showAllStripePayments(Request $request){
        Stripe::setApiKey(env('STRIPE_SECRET'));
        if(isset($request->last_id)){
            $starting_after = $request->last_id;
            $allstripepayments=\Stripe\PaymentIntent::all(['limit' => 200, 'starting_after'=> $starting_after]);
        }

        else if(isset($request->ending_before)){
            $ending_before = $request->ending_before;
            $allstripepayments= \Stripe\PaymentIntent::all(['limit' => 200, 'ending_before'=> $ending_before]);
        } 
        else {
            $allstripepayments=\Stripe\PaymentIntent::all(['limit' => 200]);
        }
        // echo "<pre>";
        // print_r($allstripepayments);
        // die();
        return view('admin.payment_reports.show_all_stripe_payments',['allstripepayments'=>$allstripepayments]);

        // dd($allstripepayments);
    }

    /* Show All Stripe Refunds */
    public function showAllStripeRefunds(Request $request){
        Stripe::setApiKey(env('STRIPE_SECRET'));
        if(isset($request->last_id)){
            $starting_after = $request->last_id;
            $allstriperefunds=\Stripe\Refund::all(['limit' => 200, 'starting_after'=> $starting_after]);
        }
        // else if(isset($request->ending_before)){
        //     $ending_before = $request->ending_before;
        //     $allstriperefunds=$stripe->paymentIntents->all(['limit' => 15, 'ending_before'=> $ending_before]);
        // } 
        else {
            $allstriperefunds=\Stripe\Refund::all(['limit' => 200]);
        }
        // dd($allstriperefunds);
        return view('admin.payment_reports.show_all_stripe_refunds',['allstriperefunds'=>$allstriperefunds]);

    }

    /* Show All Users Subscriptions */
    public function showUserSubscriptions(){
        $users = User::join('subscriptions', function($join)
                {
                    $join->on('users.id', '=', 'subscriptions.user_id');
                })->select('users.*', 'subscriptions.user_id', 'subscriptions.stripe_id', 'subscriptions.ends_at', 'subscriptions.stripe_status', 'subscriptions.name as subscription_name', 'subscriptions.created_at as subscription_created_at')->orderBy('subscriptions.id','DESC')->get();
            // $subscriptions = User::find(3);
        return view('admin.users_subscriptions',compact('users'));
    }
}
