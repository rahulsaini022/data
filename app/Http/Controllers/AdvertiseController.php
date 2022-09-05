<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\ADCourtReporters;
use App\ADlistingImage;
use App\Advertisers;
use App\County;
use App\User;
use Session;
use Illuminate\Support\Facades\Hash;
use Stripe\Stripe;
use Illuminate\Support\Facades\Mail;
use App\StripePlan;
use File;
use Illuminate\Support\Facades\DB ;

class AdvertiseController extends Controller{

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
     * Show the application advertiser.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(){
    	return view('advertise.index');
    }

    /**
     * Advertiser Login Application
     * 
     */

    public function advetiserlogin(Request $request){
        return view('advertise.advertiserlogin');
    }

    /**
     *  Advertise now appiction to show
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function advertisenow(Request $request){
       $categories = DB::table('advertiser_services')->where('parent_id',0)->get();
    	 return view('advertise.advertise_now',compact('categories'));

    }

    /**
     * Show Court reporter Application
     * 
     * @return \Illuminate\Contracts\Support\Renderable
     */
     public function courtreporter($id){
        $data = DB::table('advertiser_services')->where('id',$id)->first();
        $Court_Reporters_List_Fee = $data->service_list_fee;
        $Court_Reporters_List_Term = $data->service_list_term;
        return view('advertise.courtreporter',compact('Court_Reporters_List_Fee','Court_Reporters_List_Term','id'));
     } 

     /**
      * Court Reporter submit
      * 
      * @return \Illuminate\Contracts\Support\Renderable
      */

     public function courtreportersubmit(Request $request){
       $validatedData = $request->validate([
             'email' => ['required', 'string', 'email', 'max:255', 'unique:advertisers'],
            
        ]);
        try{

            $plainpassword = $this->generatePassword();
            $advertiser = new Advertisers;
            $advertiser->listing_county = $request->listing_county;
            $advertiser->full_Name = $request->Full_Name;
            $advertiser->contact_full_name = $request->contact_full_name;
            $advertiser->email = $request->email;
            $advertiser->telephone = $request->Telephone;
            $advertiser->ZIP_Code = $request->ZIP_Code;
            $advertiser->street_address = $request->Street_Address;
            $advertiser->Suite_Unit = $request->Suite_Unit;
            $advertiser->state = $request->State;
            $advertiser->website = $request->website;
            $advertiser->City = $request->City;
            $advertiser->county = $request->County;
            $advertiser->password = $plainpassword;
            $advertiser->save();

            $password=Hash::make($plainpassword);
            $check_user = User::where('email',$request->email)->first();
            if($check_user){
              $check_user->assignRole('Advertise');
              $user_id = $check_user->id;
            }else{
              $array=array(
                        'name'=>$request->Full_Name,
                    'email'=>$request->email,
                    'username'=>$request->email,
                    'password'=>$password,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                  );
                Session::put('entered_password', $password);
                Session::put('is_client', false);
                $user_advertise = User::create($array);
                $user_advertise->assignRole('Advertise');
                 $user_id = $user_advertise->id;
              }
        

        if($advertiser){
          $update = Advertisers::where('id',$advertiser->id)->update(['user_id'=>$user_id]);
             $user=User::find($user_id);
          //  $create = DB::table('advertiser_listings')->insert(['advertiser_id'=>$advertiser->id,'advertise_category_id'=>$request->category_id]);
            return redirect()->route('advertise.subscription',['id'=>$user->id,'category_id'=>$request->category_id])->with('success', 'You have successfully registered as advertiser.Please continue from the form below to add your listing');    
           // return view('attorney.subscription',['user'=>$user, 'intent' => $user->createSetupIntent()]);

        }else{
            return redirect()->back()->with('error', 'Your Advertise are not created ,please try Again.');
        }


        }catch(Exception $e){
            return redirect()->back()->with('error', $e->getMessage());
        }
        

     }

     /* To show Attorney  form and create stripe setup intent*/
    public function subscription(Request $request, $id,$category_id)
    {
      $user=User::find($id);
      $advertise = Advertisers::where('user_id',$id)->first();
      $advertise_id = $advertise->id;
      $county=County::where('id',$advertise->listing_county)->first(['county_name','id']);
     $county_name=$request->has('county') ? $request->get('county') : $county ;
      $category_services = DB::table('advertiser_services')->where('parent_id',$category_id)->get();
      $category_data = DB::table('advertiser_services')->where('id',$category_id)->first();
        $Court_Reporters_List_Fee = $category_data->service_list_fee;
        $Court_Reporters_List_Term = $category_data->service_list_term;
        $description = $category_data->description;
        $description = str_replace("%fee%","$ ".$Court_Reporters_List_Fee,$description);
        $description = str_replace("%trem%","<b>".$Court_Reporters_List_Term."</b>",$description);
      if($user->active=='0' && $user->hasRole('Advertise')){

        return view('advertise.subscription',['user'=>$user, 'intent' => $user->createSetupIntent(),'services'=>$category_services, 'listing_county' => $county, 'description'=>$description,'category_name'=>$category_data->name,'advertise_id'=>$advertise_id,'category_id'=>$category_data->id]);

      } else {
         if($user->hasRole('Advertise')){
          return view('advertise.subscription',['user'=>$user, 'intent' => $user->createSetupIntent(),'services'=>$category_services,'listing_county'=>$county,'description'=>$description,'category_name'=>$category_data->name,'advertise_id'=>$advertise_id,'category_id'=>$category_data->id]);
         }
      }
    }

    /** Suscribe Advertise
     * 
     */
     public function subscribe(Request $request)
    {
      //return $request->all();
      $user=User::find($request->user_id);
      $advertiser_services_id = $request->service_id;
    $price = $request->AD_price;
      $password = '';
      $check_attorney = DB::table('attorneys')->where('email',$user->email)->first();
      if($check_attorney){
        $password = "You can use your attorney account password for Advertise login";
      }else{
        $password = $user->advertiser->password;
        //$password = '12345678';
      }
      
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

          /* $update = DB::table('advertiser_listings')->where('advertiser_id',$request->advertise_id)->update(['advertiser_services_id'=>$advertiser_services_id,'county_id'=>$request->county_id]);*/

           $get_advertise_listings = DB::table('advertiser_listings')->insertGetId(['advertiser_id'=>$request->advertise_id,'advertise_category_id'=>$request->advertise_category_id,'advertiser_services_id'=>$advertiser_services_id,'county_id'=>$request->county_id, 'title' => $request->title, 'description' => $request->description, 'AD_price' => $price]);

          if($get_advertise_listings){
        if ($request->hasfile('images')) {
          $images = $request->file('images');

          foreach ($images as $image) {
            $name = uniqid() . '.' . $image->extension();
            $path = $image->move(public_path('uploads/AD_images'), $name);

            ADlistingImage::create([
              'image' => $name,
              'advertiser_listing_id' => $get_advertise_listings
            ]);
          }
        }
            $get_subscription = DB::table('subscriptions')->where('user_id',$user->id)->orderBy('id','desc')->first();
           $create = DB::table('advertiser_subscription')->insert(['advertiser_id'=>$request->advertise_id,'advertise_category_id'=>$request->advertise_category_id,'stripe_id'=>$get_subscription->stripe_id,'stripe_status'=>$get_subscription->stripe_status,'quantity'=>$get_subscription->quantity,'advertise_listings_id'=>$get_advertise_listings,'stripe_plan'=>$get_subscription->stripe_plan,'payment_type'=>'SUBSCRIPTION']);

          }

           

          //$email_sent=Mail::to($user->email)->send(new AttorneyRegistered($user));

          // to create directory for attorney for storing computation sheets
          $path1 = public_path('/uiodirs/'.$user->id.'/download');
          if(!File::isDirectory($path1)){

              File::makeDirectory($path1, 0755, true, true);

          }
          $path2 = public_path('/uiodirs/'.$user->id.'/uploaded');
          if(!File::isDirectory($path2)){

              File::makeDirectory($path2, 0755, true, true);

          }

          $name = $user->name;
          $email = $user->email;
          $subject = "Login detail";
          $email_from= env('MAIL_FROM_ADDRESS');
          $email_us=Mail::send('emails.advertise-register',
            array(
                  'name' => $name,
                  'email' => $email,
                  'password' => $password,
                  ), function($message) use ($name, $email, $email_from,$subject)
                  {
                    $message->from($email_from);
                    $message->to($email, $name)->subject('FDD Advertise - '.$subject.'');
                  });
          return redirect()->route('advertise.thanks', $user->id)->with('success', 'Thank you for the subscription. Please login as advertiser using the credentials sent to you in the email.');
      }
      return redirect()->route('advertise.subscription', $user->id)->with('error', 'Oops there is something error with your input');
    }


    /* To show thanks message after successfull purchase of subscription */
    public function thanks($id)
    {
      $user=User::find($id);

      if($user->active=='1' && $user->hasRole('Advertise')){
        return view('advertise.thanks',['user'=> $user]);
      } else {
        return redirect()->route('home');
      } 
    }
   
   /*public function demoemail(Request $request){
           $name = 'Amit';
          $email = 'amitkumartpss@gmail.com';
          $subject = "Login detail";
          $email_from= env('MAIL_FROM_ADDRESS');
          $subject = "testing";
          $email_us=Mail::send('emails.advertise-register',
            array(
                  'name' => $name,
                  'email' => $email,
                  'password' => '123456',
                  ), function($message) use ($name, $email, $email_from,$subject)
                  {
                    $message->from($email_from);
                    $message->to($email, $name)->subject('FDD Advertise - '.$subject.'');
                  });


   }*/
   // generate random password

   function generatePassword() {
    $length = 8;
    $chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789';
    $count = mb_strlen($chars);

    for ($i = 0, $result = ''; $i < $length; $i++) {
        $index = rand(0, $count - 1);
        $result .= mb_substr($chars, $index, 1);
    }

    return $result;
}
}

