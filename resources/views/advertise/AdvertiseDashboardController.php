<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use DB;
use Illuminate\Support\Facades\Validator;
use App\Advertisers;
use App\ADCourtReporters;
use App\User;
use Session;
use Illuminate\Support\Facades\Hash;
use Stripe\Stripe;
use Auth;
use App\StripePlan;
use Illuminate\Support\Facades\Mail;

class AdvertiseDashboardController extends Controller{

	/**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        // $this->middleware('auth');
    }


    public function adviserdashboard(Request $request){
        $user_id = Auth::user()->id;

        $user = User::where('id',$user_id)->first();

        $advertiser = Advertisers::where('user_id',$user->id)->first();

        return view('advertise.dashboard',compact('advertiser')); 
    }

    /**
     * Edit Advertiser 
     * @param $id
     */

     public function editadvertiser($id){
     
        $advertiser = Advertisers::where('id',$id)->first();
        $data = DB::table('advertiser_listings')->where('advertiser_id',1)->first();
        $category_data = DB::table('advertiser_services')->where('id',$data->advertise_category_id)->first();
        $Court_Reporters_List_Fee = $category_data->service_list_fee;
        $Court_Reporters_List_Term = $category_data->service_list_term;
        $description = $category_data->description;
        $description = str_replace("%fee%","$".$Court_Reporters_List_Fee,$description);
        $description = str_replace("%trem%",$Court_Reporters_List_Term,$description);
       return view('advertise.editcourtreporter',compact('advertiser','category_data','description'));
     }

     /**
      * Update Advertiser
      * @param id
      */

      public function courtreporterupdate(Request $request){
        $id = $request->id;
        $update = Advertisers::where('id',$id)->update([
        //'listing_county' => $request->listing_county,
        'full_Name' => $request->full_name,
        'contact_full_name' => $request->contact_full_name,
        'telephone' => $request->telephone,
        'ZIP_Code' => $request->ZIP_Code,
        'street_address' => $request->street_address,
        'Suite_Unit' => $request->Suite_Unit,
        'state' => $request->state,
        'website' => $request->website,
        'City' => $request->City,
        'county' => $request->county]);
        if($update){
            return redirect()->route('advertise.edit',['id' => $request->id])->with('success', 'Your Advertise are updated Successfully.'); 
        }else{
            return redirect()->route('advertise.edit',['id' => $request->id])->with('error', 'Something was wrong, please try aagain.');
        }

      }

      /**
       *  New Listing
       * @param id
       */
      public function New_listing(Request $request){
        $user_id = Auth::user()->id;
         $user = User::find($user_id);
         $advertise_id =  $user->advertiser->id;
         $listing_data = DB::table('advertiser_listings')->orderBy('premium_bid_amount','desc')->get();

         foreach($listing_data as $key=>$val){
            $country_name = DB::table('counties')->where('id',$val->county_id)->first();
     
            $catgory_name = DB::table('advertiser_services')->where('id',$val->advertise_category_id)->first();
            $val->county_name = $country_name->county_name;
            $val->catgory_name = $catgory_name->name;

         }

         $counties = DB::table('advertiser_listings')->join('counties','counties.id','=','advertiser_listings.county_id')->select('counties.id','counties.county_name')->groupBy('advertiser_listings.county_id')->get();
         $categories = DB::table('advertiser_listings')->join('advertiser_services','advertiser_services.id','=','advertiser_listings.advertise_category_id')->select('advertiser_services.id','advertiser_services.name')->where('advertiser_services.parent_id',0)->groupBy('advertiser_listings.advertise_category_id')->get();
         return view('advertise.listing',compact('listing_data','advertise_id','counties','categories'));

         
      } 


       /**
        * Edit listing
        */

        public function EditListing($id){
            $user_id = Auth::user()->id;
         $user = User::find($user_id);
         $advertise_id =  $user->advertiser->id;

        }

        /**
         * Create New Listing
         */

         public function CreateNewListing(Request $request){
            $user_id = Auth::user()->id;
            $user=User::find($user_id);
            $advertise_id = $user->advertiser->id;
            $listing = DB::table('advertiser_listings')->where('advertiser_id',$advertise_id)->pluck('advertise_category_id');
            
            
            $category_data = DB::table('advertiser_services')->where(['parent_id'=>0,'has_child'=>1])->whereNotIn('id',$listing)->get();

            return view('advertise.create_new',['user'=>$user, 'intent' => $user->createSetupIntent(),'category_data'=>$category_data,'advertise_id'=>$advertise_id,'user_id'=>$user_id]);
         }

    /**
     * Permimum bid
     */  

    public function perimum_bid($id){
        $user_id = Auth::user()->id;
        $user=User::find($user_id);
        $adviser_id = $user->advertiser->id;
        $advertise_listing = DB::table('advertiser_listings')->where('id',$id)->first();
        $listing_id = $id;
        $county_data = DB::table('counties')->where('id',$advertise_listing->county_id)->first();
        $county_name = $county_data->county_name;
        $service_data = DB::table('advertiser_services')->where('id',$advertise_listing->advertise_category_id)->first();
        $category_name = $service_data->name;
        $category_id = $service_data->id;
        $bids = DB::table('bids')->get();
        return view('advertise.createbid',compact('adviser_id','county_name','category_name','listing_id','category_id','bids'));

    }

    /**
     * Bid checkout page
     * @param post data
     */

    public function checkout(Request $request){
        $user_id = Auth::user()->id;
        $user=User::find($user_id);
        $adviser_id = $user->advertiser->id;
        $category_id = $request->category_id;
        $listing_id = $request->listing_id;
        $service_data = DB::table('advertiser_services')->where('id',$category_id)->first();

        $fee = $service_data->service_list_fee;
        
        $listing_priority = $request->listing_priority;
        if($listing_priority == ''){
            return redirect()->route('advertiser.createbid',$listing_id)->with('error','Please select bid from table.');
        }
        $bid_data = DB::table('bids')->where('listing_priority',$listing_priority)->first();
        $bid_amount = $bid_data->bid_amount;
        $increase_amount = $request->increase_bid_amount;
        if(isset($increase_amount) && $increase_amount != ''){
            $bid_amount = $bid_amount + $increase_amount;
        }
        $total_amount = $fee + $bid_amount;
        //$intent = $user->createSetupIntent();
        return view('advertise.checkout',['fee'=>$fee,'bid_amount'=>$bid_amount,'total_amount'=>$total_amount,'category_id'=>$category_id,'listing_id'=>$listing_id,'listing_priority'=>$listing_priority,'intent'=>$user->createSetupIntent(),'user'=>$user]);
    }

    public function payment(Request $request){

       $user_id = Auth::user()->id;
       $user=User::find($user_id);
       $adviser_id = $user->advertiser->id;

       $service_id = $request->category_id;
       $listing_id = $request->listing_id;
       $listing_priority = $request->listing_priority;
       $bid_amount = $request->bid_amount;
       $listing_fee = $request->listing_fee;
       $total_amount = $request->total_amount;
       $paymentMethod = $request->payment_method;
        try {
        $user->createOrGetStripeCustomer();
        $user->updateDefaultPaymentMethod($paymentMethod);
        $payment = $user->charge($total_amount * 100, $paymentMethod,[
                'metadata'=>array(
                    'advertiser_name' => $user->advertiser->full_name,
                    'category_id' => $service_id,
                    'bid_amount' => $bid_amount,
                    'service_fee' => $listing_fee
                ),
                'description' => 'Bid '.$listing_priority.' PAYMENT FOR AMOUNT $'.$total_amount.' DATED '.date('m-d-Y').' BY '.$user->name,
            ]);
       $txn_id = $payment->id;
       $insert_advertiser_bids = DB::table('advertiser_bids')->insert(['listing_id'=>$listing_id,'listing_priority'=>$listing_priority,'listing_bid_amount'=>$bid_amount,'listing_bid_fee'=>$listing_fee,'listing_bid_date'=>date('Y-m-d'),'advertiser_id'=>$adviser_id,'txn_id'=>$txn_id]);
       $renew_expiration_date = date('Y-m-d', strtotime(' + 1 years')); 
       $update = DB::table('advertiser_listings')->where('id',$listing_id)->update(['premium_bid_date'=>date('Y-m-d'),'renew_expiration_date'=>$renew_expiration_date,'advertiser_listing_priority'=>$listing_priority,'list_fee_amount'=>$listing_fee,'premium_bid_amount'=>$bid_amount,'list_fee_date'=>date('Y-m-d')]);
       $update_subscription = DB::table('advertiser_subscription')->insert(['advertise_listings_id'=>$listing_id,'advertiser_id'=> $adviser_id,'advertise_category_id'=>$service_id,'stripe_id'=>$txn_id,'amount'=>$total_amount,'payment_type'=>'BID','stripe_status'=>'active','advertise_category_id'=>$request->category_id]);

          return redirect()->route('advertise.new_listing')->with('success', 'Your Bid is posted successfully.');
         } catch (\Exception $exception) {
                //return back()->with('error', $exception->getMessage());
                return redirect()->route('advertiser.createbid',$listing_id)->with('error',$exception->getMessage());
            }
    }


    public function getadvertiserservicediv(Request $request){
        $id = $request->category_id;

        $services = DB::table('advertiser_services')->where('parent_id',$id)->pluck('id','name');
        $category_data = DB::table('advertiser_services')->where('id',$id)->first();
        $Court_Reporters_List_Fee = $category_data->service_list_fee;
        $Court_Reporters_List_Term = $category_data->service_list_term;
        $description = $category_data->description;
        $description = str_replace("%fee%","$ ".$Court_Reporters_List_Fee,$description);
        $description = str_replace("%trem%","<b>".$Court_Reporters_List_Term."</b>",$description);
        $services['description'] = $description;
        echo json_encode($services);
    }
    
    /** Suscribe Advertise
     * 
     */
     public function advertisersubscribe(Request $request)
    {
       /* return $request->all();
      */
       $user_id = Auth::user()->id;
       $user=User::find($user_id);
       $adviser_id = $user->advertiser->id;
      $advertiser_services_id = $request->service_id;
        $category_id = $request->category_id;
     
      $paymentMethod = $request->payment_method;
     
      $plan_id=StripePlan::where('plan_name', 'main')->pluck('plan_id')->first();
      
      $user->newSubscription('main', $plan_id)->create($paymentMethod, [
          'email' => $user->email,
      ], [
          'metadata' => ['description' => 'Advertiser '.$user->name.'('.$user->id.') purchased this subscription.'],
      ]);

      if ($user->subscribed('main')) {
          $user->active='1';
          $user->save();
          $user->addPaymentMethod($paymentMethod);

           /*$update = DB::table('advertiser_listings')->where('advertiser_id',$request->advertise_id)->update(['advertiser_services_id'=>$advertiser_services_id,'county_id'=>$request->county_id]);*/
           $get_advertise_listings = DB::table('advertiser_listings')->insertGetId(['advertiser_id'=>$request->advertise_id,'advertise_category_id'=>$request->category_id,'advertiser_services_id'=>$advertiser_services_id,'county_id'=>$request->county_id]);
           if($get_advertise_listings){
                $get_subscription = DB::table('subscriptions')->where('user_id',$user->id)->orderBy('id','desc')->first();
                $create = DB::table('advertiser_subscription')->insert(['advertiser_id'=>$user->advertiser->id,'advertise_category_id'=>$category_id,'stripe_id'=>$get_subscription->stripe_id,'stripe_status'=>$get_subscription->stripe_status,'quantity'=>$get_subscription->quantity,'advertise_listings_id'=>$get_advertise_listings,'stripe_plan'=>$get_subscription->stripe_plan,'advertise_category_id'=>$request->advertise_category_id,'payment_type'=>'SUBSCRIPTION']);
           }
           

          //$email_sent=Mail::to($user->email)->send(new AttorneyRegistered($user));

          // to create directory for attorney for storing computation sheets
       
          $name = $user->name;
          $email = $user->email;
          $subject = "Advertise Subscription";
          $email_from= env('MAIL_FROM_ADDRESS');
          $email_us=Mail::send('emails.advertise-subscription',
            array(
                  'name' => $name,
                  'email' => $email
                  ), function($message) use ($name, $email, $email_from,$subject)
                  {
                    $message->from($email_from);
                    $message->to($email, $name)->subject('FDD Advertise - '.$subject.'');
                  });
          return redirect()->route('advertise.new_listing', $user->id)->with('success', 'Your Subscription is Successfully created');
      }
      return redirect()->route('advertise.subscription', $user->id)->with('error', 'Oops there is something error with your input');
    }


     public function Filtering(Request $request)
    {
    $user_id = Auth::user()->id;
    $user=User::find($user_id);
    $advertise_id = $user->advertiser->id;
    $county = $request->county;
    $category = $request->category;
    $sql = 'select * from advertiser_listings where' ;
     if (!empty($county)) {
        $sql  = $sql." county_id = $county and " ;
    }
    if(!empty($category)){
        $sql = $sql. " advertise_category_id = $category and";
    }
    $sql = $sql." status = 1 order by premium_bid_amount  desc";
    $listing_data = DB::select($sql);
    foreach($listing_data as $key=>$val){
            $country_name = DB::table('counties')->where('id',$val->county_id)->first();
     
            $catgory_name = DB::table('advertiser_services')->where('id',$val->advertise_category_id)->first();
            $val->county_name = $country_name->county_name;
            $val->catgory_name = $catgory_name->name;

         }

         $counties = DB::table('advertiser_listings')->join('counties','counties.id','=','advertiser_listings.county_id')->select('counties.id','counties.county_name')->groupBy('advertiser_listings.county_id')->get();
         $categories = DB::table('advertiser_listings')->join('advertiser_services','advertiser_services.id','=','advertiser_listings.advertise_category_id')->select('advertiser_services.id','advertiser_services.name')->where('advertiser_services.parent_id',0)->groupBy('advertiser_listings.advertise_category_id')->get();
         return view('advertise.listing',compact('listing_data','advertise_id','counties','categories'));

   }

   public function activedeactivelist($id,$status){
    $up = DB::table('advertiser_listings')->where('id',$id)->update(['status'=>$status]);
    if($status == 0){
        $message = "Deactivated Successfully";
    }else{
        $message = "Activate Successfully";
    }
    return redirect()->route('advertise.new_listing')->with('success',$message);

   }

   /*public function increase_bid_amount(Request $request){
    $listing_id = $request->listing_id;
    $get_listing_data = DB::table('advertiser_listings')->where('id',$listing_id)->first();
    $last_bid_amoount = $get_listing_data->bid_amount;
    $last_bid_date = $get_listing_data->re


   }*/


   /**
      * Listing Subscription
      */ 

   
    public function subscription_listing(Request $request){
         
         Stripe::setApiKey(env('STRIPE_SECRET'));
         /*$subscription_data = \Stripe\Subscription::retrieve('sub_1KWY42BtWlZKaqgXtNyhrXZO');
         return $subscription_data;*/
         $user_id = Auth::user()->id;
         $user=User::find($user_id);
         $advertise_id = $user->advertiser->id;

        $subscriptions = DB::table('advertiser_subscription')->where(['payment_type'=>'SUBSCRIPTION','advertiser_id'=> $advertise_id])->get();

        foreach($subscriptions as $key=>$val){

            $advertiser_name = Advertisers::where('id',$val->advertiser_id)->first();

            $val->name = $advertiser_name->contact_full_name;

            $advertise_category = DB::table('advertiser_services')->where('id',$val->advertise_category_id)->first();

            $val->category_name = $advertise_category->name;
            $val->amount = $advertise_category->service_list_fee;
             $stripe_id = $val->stripe_id;
         $subscription_data = \Stripe\Subscription::retrieve($stripe_id);
         $val->start = date('d/m/Y h:i:s' ,$subscription_data->current_period_start);
         $val->end = date('d/m/Y h:i:s' ,$subscription_data->current_period_end);
         $val->status = $subscription_data->status;
         /* $listing_data = DB::table('advertiser_listings')->where('id',$val->advertise_listings_id)->first();
          return $listing_data;
             $county_id = $listing_data->county_id;*/
            /* $county_name = DB::table('counties')->where('id',$county_id)->pluck('county_name');
             $val->county_name = $county_name[0];*/
        }

        return view('advertise.subscription_list',compact('subscriptions','user'));

    }

    /**
     * Cancel Subscription
     * 
     */

     public function cancel_subscription(Request $request){
         Stripe::setApiKey(env('STRIPE_SECRET'));
        $license_type=$request->license_type;
        if(isset($license_type) && $license_type !=''){
          try {
              //Auth::user()->subscription($license_type)->cancel();
              $sub = \Stripe\Subscription::retrieve($license_type);
              $sub->cancel();
              return redirect()->route('advertise.subscriptions')->with('success', 'Your Subscription Cancelled Successfully.');
          } catch (Exception $e) {
               // return redirect()->back()->with('error', ['Something went Wrong. Please try again.']);   
               return redirect()->route('advertise.subscriptions')->with('error', 'Something went Wrong. Please try again.');   
          }
        }
     }

     /**
      * Resume Subscription
      * 
      */

      public function resume_Subscription(Request $request){
         $license_type=$request->license_type;
        if(isset($license_type) && $license_type !=''){
          try {
              Auth::user()->subscription($license_type)->resume();
              return redirect()->route('advertise.subscriptions')->with('success', 'Your Subscription Resumed Successfully.');
          } catch (Exception $e) {
               // return redirect()->back()->with('error', ['Something went Wrong. Please try again.']);   
               return redirect()->route('advertise.subscriptions')->with('error', 'Something went Wrong. Please try again.');   
          }
        }
      }

      /**
       * Change Password
       * @param $password
       */

     public function change_password(Request $request){

        return view('advertise.changepassword');
     }

     /**
      * Update Pasword
      * @param $password
      */

      public function update_password(Request $request){
     
        $id = Auth::user()->id;
        $user = User::find($id);

        $password = $request->password;
         
         $user->password = Hash::make($password);
         $user->save();

         return redirect()->route('advertiser.changepassword')->with('success','Password changed Successfully');

      }    

}