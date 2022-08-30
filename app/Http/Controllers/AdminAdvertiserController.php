<?php

namespace App\Http\Controllers;

use App\ADlistingImage;
use App\AdvertiseListing;
use App\AdvertiserListing;
use App\Advertisers;
use App\AdvertiserService;
use App\County;
use App\User;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Stripe\Stripe;
use Illuminate\Support\Facades\Mail;
class AdminAdvertiserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $advertiser_services = AdvertiserService::where('parent_id', 0)->get();
        return view('admin.advertiser.index', compact('advertiser_services'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $advertiser_services = AdvertiserService::where('parent_id', 0)->get();
        return view('admin.advertiser.create', compact('advertiser_services'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required|unique:advertiser_services,name',

        ]);

        $input = [
            'name' => $request->name,
            'service_list_fee' => $request->service_list_fee,
            'service_list_term' => $request->service_list_term,
            'description' => $request->description,
            'parent_id' => $request->parent_id,


        ];
        $has_child = ($request->parent_id == 0) ? 0 : 1;
        if ($request->parent_id !== 0) {

            AdvertiserService::where('id', $request->parent_id)->update(['has_child' => $has_child]);
        }
        $service = AdvertiserService::create($input);
        return redirect()->route('advertiser-services.index')

            ->with('success', 'Advertiser service created successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        AdvertiserService::findOrFail($id);
        $service = AdvertiserService::where('id', $id)->first();
        return view('admin.advertiser.show', compact('service'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        AdvertiserService::findOrFail($id);
        $advertiser_services = AdvertiserService::where('parent_id', 0)->get();
        $service = AdvertiserService::where('id', $id)->first();
        return view('admin.advertiser.edit', compact('service', 'advertiser_services'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|unique:advertiser_services,name,' . $id,
            // 'service_list_fee' => 'required|numeric',
            // 'description' => 'required',
            // 'service_list_term' => 'required',
        ]);
        $service = AdvertiserService::find($id);
        $service->name = $request->name;
        $service->service_list_fee = $request->service_list_fee;
        $service->description = $request->description;
        $service->service_list_term = $request->service_list_term;
        $service->save();
        return redirect()->route('advertiser-services.index')->with('success', 'Advertiser service updated successfully');
    }


    /**
     * show child services
     * 
     */
    public function childServices($parent_id)
    {

        $childServices = AdvertiserService::where('parent_id', $parent_id)->get();
        return view('admin.advertiser.childServices', compact('childServices'));
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $service = AdvertiserService::findOrFail($id);
        $parent_id = $service->parent_id;

        $data = DB::table('advertiser_listings')->select('advertiser_services_id')->get();
        foreach ($data as $d) {

            $ids = (explode(',', $d->advertiser_services_id));

            $result = in_array($id, $ids);
 
            if ($result) {
                return redirect()->back()->with('error', 'Service cannot be deleted due to service used by advertiser.');
            }
        }


        if ($service->has_child == 1) {
            return redirect()->back()->with('error', 'Service cannot be deleted due to service has child service.');
        } else {

            $service->delete();

            if (!AdvertiserService::where('parent_id', $parent_id)->exists()) {
                AdvertiserService::where('id', $parent_id)->update(['has_child' => 0]);
            }
            return redirect()->back()->with('success', 'Service deleted successfully.');
        }
    }


    /**Advertiser list
     * 
     */
    public function advertiserList()
    {
        $advertisers = Advertisers::all();
        // $ads=AdvertiseListing::join('advertisers','advertisers.id','=', 'advertiser_listings.advertiser_id')->get(['advertisers.full_name','advertisers.email',
        // 'advertises_listings.title', 'advertises_listings.id', 'advertises_listings.']);
         $ads=AdvertiseListing::all();
         foreach($ads as  $key => $val)
         {
            $advertiser=Advertisers::where('id',$val->advertiser_id)->first();
            $val->name= $advertiser->full_name;
            $val->email = $advertiser->email;
            $ids = explode(',', $val->advertiser_services_id);
            $ads_services = AdvertiserService::whereIn('id', $ids)->pluck('name')->toArray();
            // print_r($ads_services);
            // die();
            $services = implode(',', $ads_services);
            $val->advertiser_services = $services;

         }
   

        return view('admin.advertiser.advertiserList', compact('advertisers', 'ads'));
    }
    /**
     *  listing status
     */
    public function listingStatus(Request $request)
    {
      $id=$request->id;
      $name=$request->name;
      $status=($request->status) ? 0 : 1 ;
      $email=$request->email;
      $title=$request->title;
      $subject='Listing Status';
      $listing=AdvertiseListing::find($id);
        $email_from = env('MAIL_FROM_ADDRESS');
      $listing->status=$status;
      $listing->save();
      if($listing){
            if($status)
            {
           
                $email_us = Mail::send(
                    'emails.listing-status',
                    array(
                        'name' => $name,
                        'email' => $email,
                        'user_message'=>'Your advertiser '.$title.' activated by admin'
                        
                    ),
                    function ($message) use ($name, $email, $email_from, $subject) {
                        $message->from($email_from);
                        $message->to($email, $name)->subject('FDD Advertiser - ' . $subject . '');
                    }
                );
                return redirect()->back()->with('success', 'Advertiser  enable successfully');
            }
            else{
                $email_us = Mail::send(
                    'emails.listing-status',
                    array(
                        'name' => $name,
                        'email' => $email,
                        'user_message' => 'Your advertiser ' . $title . ' deactivated by admin'

                    ),
                    function ($message) use ($name, $email, $email_from, $subject) {
                        $message->from($email_from);
                        $message->to($email, $name)->subject('FDD Advertiser - ' . $subject . '');
                    }
                );
                return redirect()->back()->with('success', 'Advertiser  disable successfully');
            }
      }
    
        }
        
    /**
     * show advertiser detail
     */
    public function AdvertiserDetail($id)
    {
        // Advertisers::findOrFail($id);
        // $advertiser = Advertisers::where('id', $id)->first();

        // $advertiser_county = DB::table('counties')->where('id', $advertiser->listing_county)->first();
        // $advertiser_state = DB::table('states')->where('id', $advertiser->state)->first();

        // //$services= '';
        // $category = '';

        // $listing = DB::table('advertiser_listings')->where('advertiser_id', $id)->orderBy('id', 'desc')->get();

        // $data[] = '';
        // if ($listing) {
        //     foreach ($listing as $key => $val) {
        //         $services_data = array();
        //         $service_name = '';
        //         $advertise_services_id = explode(',', $val->advertiser_services_id);

        //         $services = AdvertiserService::whereIn('id', $advertise_services_id)->pluck('name');

        //         foreach ($services as $service) {
        //             $service_name =  $service . ',' . $service_name;
        //         }


        //         $category = AdvertiserService::where('id', $val->advertise_category_id)->first();
        //         $val->category_name = $category->name;
        //         $val->service = $service_name;
        //     }
        // }
        // //return $listing;

        // return view('admin.advertiser.advertiserDetail', compact('advertiser', 'services', 'category', 'advertiser_county', 'advertiser_state', 'listing'));
        try {
            $ads_data = DB::table('advertiser_listings')->where('advertiser_listings.id', $id)->first();
            $county = County::where('id', $ads_data->county_id)->first()->county_name;
            $advertiser = Advertisers::where('id', $ads_data->advertiser_id)->first();
            $category = AdvertiserService::where('id', $ads_data->advertise_category_id)->first()->name;
            $images = ADlistingImage::where('advertiser_listing_id', $ads_data->id)->get();
            $ids = explode(',', $ads_data->advertiser_services_id);
            $ads_services = AdvertiserService::whereIn('id', $ids)->pluck('name')->toArray();
            // print_r($ads_services);
            // die();
            Log::error($county);
            $services = implode(',', $ads_services);
            return view('admin.advertiser.adsDetails', compact('ads_data', 'county', 'category', 'images', 'services', 'advertiser'));
        } catch (Exception $e) {
            return redirect()->route('advertiser.all');
        }
   
   
    }

    /**
     * Listing Subscription
     */


    public function subscription_listing(Request $request)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $subscriptions = DB::table('advertiser_subscription')->where('payment_type', 'SUBSCRIPTION')->get();

        foreach ($subscriptions as $key => $val) {

            $advertiser_name = Advertisers::where('id', $val->advertiser_id)->first();

            $val->name = $advertiser_name->contact_full_name;

            $advertise_category = DB::table('advertiser_services')->where('id', $val->advertise_category_id)->first();
            $val->category_name = $advertise_category->name;
            $val->amount = $advertise_category->service_list_fee;
            // $stripe_id = $val->stripe_id;
            // $subscription_data = \Stripe\Subscription::retrieve($stripe_id);
            // $val->start = date('m/d/Y h:i:s', $subscription_data->current_period_start);
            // $val->end = date('m/d/Y h:i:s', $subscription_data->current_period_end);
        }

        return view('admin.advertiser.subscription_list', compact('subscriptions'));
    }

    public function subscriptiondetail($id)
    {
        Stripe::setApiKey(env('STRIPE_SECRET'));
        $subscriptions = DB::table('advertiser_subscription')->where('id', $id)->first();


        $advertiser_name = Advertisers::where('id', $subscriptions->advertiser_id)->first();

        $full_name = $advertiser_name->contact_full_name;

        $advertise_category = DB::table('advertiser_services')->where('id', $subscriptions->advertise_category_id)->first();

        $category_name = $advertise_category->name;
        $amount = $advertise_category->service_list_fee;
        $stripe_id = $subscriptions->stripe_id;
        $listing_data = DB::table('advertiser_listings')->where('id', $subscriptions->advertise_listings_id)->first();
        $advertise_services_id = explode(',', $listing_data->advertiser_services_id);
        $services = AdvertiserService::whereIn('id', $advertise_services_id)->pluck('name')->toArray();
        $services = implode(', ', $services);
        $county_id = $listing_data->county_id;
        $county_name = DB::table('counties')->where('id', $county_id)->pluck('county_name');
        $county_name = $county_name[0];
        $subscription_data = \Stripe\Subscription::retrieve($stripe_id);
        $start = date('m/d/Y h:i:s', $subscription_data->current_period_start);
        $end = date('m/d/Y h:i:s', $subscription_data->current_period_end);
        return view('admin.advertiser.subscription_detail', compact('full_name', 'services', 'category_name', 'amount', 'stripe_id', 'county_name', 'start', 'end'));
    }

    /**
     * show Advertiser Bids
     * 
     */
    public function showBids()
    {
        $bids = DB::table('advertiser_bids')
            ->Join('advertisers', 'advertisers.id', '=', 'advertiser_bids.advertiser_id')
            ->get(['advertisers.full_name', 'advertisers.id', 'advertiser_bids.id', 'advertiser_bids.txn_id', 'advertiser_bids.listing_bid_amount', 'advertiser_bids.listing_bid_date']);
        return view('admin.advertiser.showBids', compact('bids'));
    }
    /**
     *  Advertiser Bids Details
     * @param $id
     */
    public function bidDetail($id)
    {
        
        try {
            $bid = DB::table('advertiser_bids')->where('id', $id)->first();

            $bid_details = DB::table('advertiser_listings')
                ->Join('counties', 'counties.id', '=', 'advertiser_listings.county_id')
                ->Join('advertisers', 'advertisers.id', '=', 'advertiser_listings.advertiser_id')
                ->where('advertiser_listings.id', $bid->listing_id)->get([
                    'advertisers.full_name', 'advertisers.email', 'counties.county_name', 'advertiser_listings.list_fee_amount', 'advertiser_listings.premium_bid_amount',
                    'advertiser_listings.list_fee_date', 'advertiser_listings.renew_expiration_date'
                ]);
                 
            return view('admin.advertiser.bidsDetail', compact('bid', 'bid_details'));
        } catch (Exception $e) {
            return redirect()->route('advertiser.bids')->with('error', 'Bid Not Found');
        }
    }

    /* Show advertiser reports/graphs */
    public function get_advertiser_reports()
    {
        return view('admin.reports.advertiser_reports');
    }

    /* Get advertisers registered in last 30 days to show in graph day wise registration */
    public function get_advertisers_by_day_chart_data()
    {

        $data = array();
        $label = array();
        for ($days_backwards = 0; $days_backwards < 30; $days_backwards++) {

            array_push($data, User::where('active', '1')->whereDate('created_at', $sub = today()->subDays($days_backwards))->role('Advertise')->count());
            // array_push($label, $days_backwards);
            array_push($label, date('m/d/Y', strtotime($sub)));
        }

        $all = array(
            'label' => $label,
            'data' => $data
        );
        echo json_encode($all);
    }

    /* Get advertisers registered in last 52 weeks to show in graph week wise registration */
    public function get_advertisers_by_week_chart_data()
    {
        $data = array();
        $label = array();
        $today = Carbon::now()->endOfWeek();
        $subToday = Carbon::now()->endOfWeek();
        $subWeek = $subToday->subWeek(1);
        $title = array();
        $t = 0;
        for ($weeks_backwards = 0; $weeks_backwards < 52; $weeks_backwards++) {

            array_push(
                $data,
                User::where('active', '1')->whereDate('created_at', '<=', $today)
                    ->whereDate('created_at', '>',  $subWeek)->role('Advertise')->count()
            );
            $to = date('m/d/Y', strtotime($today));
            $from = date('m/d/Y', strtotime($subWeek));
            // array_push($label, $to." - ".$from);
            array_push($label, "week " . ++$t);
            array_push($title, $to . " - " . $from);
            $today->subWeek(1);
            $subWeek->subWeek(1);
        }

        $all = array(
            'label' => $label,
            'data' => $data,
            'title' => $title
        );
        echo json_encode($all);
    }
}
