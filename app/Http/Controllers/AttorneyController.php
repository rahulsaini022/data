<?php

namespace App\Http\Controllers;

use App\ADlistingImage;
use App\AdvertiseListing;
use App\Advertisers;
use App\AdvertiserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\State;
use App\County;
use App\Attorney;
use App\Download;
use App\Setting;
use App\Courtcase;
use App\Stateseatlicensetransactionhistory;
use App\AttorneyTableActive;
use App\AttorneyTableActiveBeforeEdit;
use App\StripePlan;
use App\DocumentTable;
use Redirect;
use Validator;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use App\Mail\AttorneyRegistered;
use Exception;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;
use Stripe\Stripe;

class AttorneyController extends Controller
{
  /* Get List of Attorneys */
  public function index()
  {
    $data = User::role('attorney')->orderBy('id', 'DESC')->get();
    return view('attorney.index', compact('data'));
  }
  /* Show Attorney Details for admin OR Show attorney dashboard for attorney */
  public function show($id)
  {
    $attorney = User::find($id);
    $attorney_data = User::find($id)->attorney;
    if (Auth::user()->id == $id && Auth::user()->hasRole('attorney')) {
      // $practice_aids=DocumentTable::where('doc_type', 'Practice_Aids')->get();
      $practice_aids = DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Dashboard_Practice_Aids')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->get();
      foreach ($practice_aids as $key => $val) {
        $doctypecc = DB::table('document_table')->where('doc_disp_name', $val->package_name)->pluck('document_out_format')->first();
        $val->document_out_format = $doctypecc;
      }
      return view('attorney.dashboard', ['attorney' => $attorney, 'attorney_data' => $attorney_data, 'practice_aids' => $practice_aids]);
    } else if (Auth::user()->hasAnyRole(['admin', 'super admin'])) {
      if (isset($attorney_data->state_id)) {
        $attorney_state = State::where('id', $attorney_data->state_id)->get()->pluck('state');
        $attorney_data->firm_state = $attorney_state[0];
      }
      if (isset($attorney_data->attorney_reg_1_state_id)) {
        $attorney_attorney_reg_1_state_id = State::where('id', $attorney_data->attorney_reg_1_state_id)->get()->pluck('state');
        $attorney_data->attorney_attorney_reg_1_state_id = $attorney_attorney_reg_1_state_id[0];
      }
      if (isset($attorney_data->attorney_reg_2_state_id)) {
        $attorney_attorney_reg_2_state_id = State::where('id', $attorney_data->attorney_reg_2_state_id)->get()->pluck('state');
        $attorney_data->attorney_attorney_reg_2_state_id = $attorney_attorney_reg_2_state_id[0];
      }
      if (isset($attorney_data->attorney_reg_3_state_id)) {
        $attorney_attorney_reg_3_state_id = State::where('id', $attorney_data->attorney_reg_3_state_id)->get()->pluck('state');
        $attorney_data->attorney_attorney_reg_3_state_id = $attorney_attorney_reg_3_state_id[0];
      }
      if (isset($attorney_data->state_id)) {
        $attorney_county = County::where('id', $attorney_data->county_id)->get()->pluck('county_name');
        $attorney_data->firm_county = $attorney_county[0];
      }
      $attorney_state_seat_license_transaction_history = DB::table('state_seat_license_transaction_history')
        ->join('states', 'state_seat_license_transaction_history.state_id', '=', 'states.id')
        ->where('user_id', $id)
        ->get()
        ->all();
      $number_of_cases_registered_by_attorney = Courtcase::where('attorney_id', $id)->get()->count();
      if ($attorney_data) {
        $attorney_data->setAttribute('number_of_cases_registered_by_attorney', $number_of_cases_registered_by_attorney);
      }
      return view('attorney.show', ['user' => $attorney, 'attorney_data' => $attorney_data, 'attorney_state_seat_license_transaction_history' => $attorney_state_seat_license_transaction_history]);
    } else {
      return redirect()->route('home');
    }
  }
  public function create()
  {

  }
  /* To store attorney info */
  public function store(Request $request)
  {
    // validate recaptcha
    // if (isset($request->recaptcha_response)) {
    //       // Build POST request:
    //       $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    //       $recaptcha_secret = env('GOOGLE_RECAPTCHA_SECRET');
    //       $recaptcha_response = $request->recaptcha_response;
    //       // Make and decode POST request:
    //       $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
    //       $recaptcha = json_decode($recaptcha);
    //     // Take action based on the score returned:
    //     if ($recaptcha->success == true && $recaptcha->score >= 0.5) {
    //     } else {
    //         return redirect()->route('register')->with('error','Captcha Error. Please try again.');
    //     }
    // } else {
    //     return redirect()->route('register')->with('error','Captcha Error. Please try again.');
    // }
    $checkuserexists = User::where('email', $request->email)->first();
    if ($checkuserexists && $checkuserexists->active == '0') {
    
      $validatedData = $request->validate([
        'password' => ['required', 'string', 'min:6'],
        'password_confirmation'=>['same:password'],
      ], ['same' => 'Password and Confirm Password must be same.']);
      $password = Hash::make($request->password);
      $checkuserexists->password = $password;
      $checkuserexists->save();
      $free_trial = env('FREE_TRIAL');
      $free_trial = Carbon::parse($free_trial)->startOfDay();
      $date = Carbon::now()->startOfDay();
      if ($date > $free_trial) {
       
        return redirect()->route('attorneys.subscription', $checkuserexists->id);
      } else {
      
        $checkuserexists = User::find($checkuserexists->id);
        $checkuserexists->active = '1';
        $checkuserexists->trial_ends_at = $free_trial;
        $checkuserexists->save();
        //$email_sent=Mail::to($checkuserexists->email)->send(new AttorneyRegistered());
        return redirect()->route('attorneys.thanks', $checkuserexists->id)->with('success', 'Attorney Registered Successfully! Now you can login to use our services.');
      }
    }
    $validatedData = $request->validate([
      'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'username' => ['required', 'string', 'max:255', 'unique:users'],
     'password' => ['required', 'string', 'min:6'],
        'password_confirmation'=>['required','same:password'],
      'document_sign_name' => ['required', 'string'],
      'gender' => ['required'],
      'firm_name' => ['required', 'string'],
      'firm_zipcode' => ['required', 'string'],
      'firm_state' => ['required'],
      'firm_county' => ['required'],
      'firm_city' => ['required'],
      'firm_street_address' => ['required', 'string'],
      'agreement_checkbox' => ['required'],
    ], ['same' => 'Password and confirm password must be same.']);
    $fname = $request->fname;
    $mname = $request->mname;
    $lname = $request->lname;
    $document_sign_name = $request->document_sign_name;
    $email = $request->email;
    $username = $request->username;
    $password = Hash::make($request->password);
    $special_practice = $request->special_practice;
    $firm_name = $request->firm_name;
    $firm_street_address = $request->firm_street_address;
    $firm_suite_unit_mailcode = $request->firm_suite_unit_mailcode;
    $firm_fax = $request->firm_fax;
    $po_box = $request->po_box;
    $firm_city = $request->firm_city;
    $firm_state = $request->firm_state;
    $firm_county = $request->firm_county;
    $firm_zipcode = $request->firm_zipcode;
    $firm_telephone = $request->firm_telephone;
    $attorney_reg_1_state_id = $request->attorney_reg_1_state_id;
    // $attorney_reg_2_state_id=$request->attorney_reg_2_state_id;
    // $attorney_reg_3_state_id=$request->attorney_reg_3_state_id;
    $attorney_reg_1_num = $request->attorney_reg_1_num;
    // $attorney_reg_2_num=$request->attorney_reg_2_num;
    // $attorney_reg_3_num=$request->attorney_reg_3_num;
    if (isset($request->pro_hac_vice) && $request->pro_hac_vice == 'yes' && isset($request->pro_vice_hac_num) && $request->pro_vice_hac_num != '') {
      $pro_vice_hac_num = $request->pro_vice_hac_num;
    } else {
      $pro_vice_hac_num = NULL;
    }
    if ($special_practice == 'court') {
      $special_practice_text = $request->court_text;
    } else if ($special_practice == 'law_school') {
      $special_practice_text = $request->law_school_text;
    } else if ($special_practice == 'legal_aid') {
      $special_practice_text = $request->legal_aid_text;
    } else {
      $special_practice_text = 'Nill';
    }
    $array = array(
      'name' => $fname . ' ' . $lname,
      'email' => $email,
      'username' => $username,
      'password' => $password,
      'created_at' => now(),
      'updated_at' => now(),
    );
    Session::put('entered_password', $request->password);
    Session::put('is_client', false);
    $user = User::create($array);
    $user->assignRole('attorney');
    $attorney_state = State::where('id', $firm_state)->get()->first();
    $attorney_reg_state = State::where('id', $attorney_reg_1_state_id)->get()->first();
    $attorney_county = County::where('id', $firm_county)->get()->first();
    $array2 = array(
      'user_id' => $user->id,
      'mname' => $mname,
      'document_sign_name' => $document_sign_name,
      'special_practice' => $special_practice,
      'special_practice_text' => $special_practice_text,
      'firm_name' => $firm_name,
      'firm_street_address' => $firm_street_address,
      'firm_suite_unit_mailcode' => $firm_suite_unit_mailcode,
      'po_box' => $po_box,
      'firm_city' => $firm_city,
      'state_id' => $firm_state,
      'county_id' => $firm_county,
      'firm_zipcode' => $firm_zipcode,
      'firm_telephone' => $firm_telephone,
      'firm_fax' => $firm_fax,
      'attorney_reg_1_state_id' => $attorney_reg_1_state_id,
      // 'attorney_reg_2_state_id'=>$attorney_reg_2_state_id,
      // 'attorney_reg_3_state_id'=>$attorney_reg_3_state_id,
      'attorney_reg_1_num' => $attorney_reg_1_num,
      // 'attorney_reg_2_num'=>$attorney_reg_2_num,
      // 'attorney_reg_3_num'=>$attorney_reg_3_num,
      'pro_vice_hac_num' => $pro_vice_hac_num,
      'created_at' => now(),
      'updated_at' => now(),
      'fname' => $request->fname,
      'lname' => $request->lname,
      'sufname' => $request->sufname,
      'currentstatus' => $request->currentstatus,
      'gender' => $request->gender,
      'attorneytitle' => $request->attorneytitle,
      'insured' => $request->insured,
      'admissiondate' => date("Y-m-d", strtotime($request->admissiondate)),
      'admissiondatevalue' => date("Ymd", strtotime($request->admissiondate)),
      'howadmitted' => $request->howadmitted,
      'birthdate' => date("Y-m-d", strtotime($request->birthdate)),
      'birthdatevalue' => date("Ymd", strtotime($request->birthdate)),
      'firm_tagline' => $request->firm_tagline,
      'firm_state' => $attorney_state->state,
      'firm_state_abr' => $attorney_state->state_abbreviation,
      'email' => $request->email,
      'firm_county' => $attorney_county->county_name,
      'registration_state_1' => $attorney_reg_state->state,
    );
    $attorney = Attorney::create($array2);
    $name = $user->name;
    $email = $user->email;
    $subject = "Attorney Registration";
    $email_from = env('MAIL_FROM_ADDRESS');
    $email_us = Mail::send(
      'emails.attorney-register',
      array(
        'name' => $name,
        'email' => $email,
        'password' => $request->password

      ),
      function ($message) use ($name, $email, $email_from, $subject) {
        $message->from($email_from);
        $message->to($email, $name)->subject('FDD - ' . $subject . '');
      }
    );
    // to create directory for attorney for storing computation sheets
    $path1 = public_path('/uiodirs/' . $user->id . '/download');
    if (!File::isDirectory($path1)) {
      File::makeDirectory($path1, 0755, true, true);
    }
    $path2 = public_path('/uiodirs/' . $user->id . '/uploaded');
    if (!File::isDirectory($path2)) {
      File::makeDirectory($path2, 0755, true, true);
    }
    $free_trial = env('FREE_TRIAL');
    $free_trial = Carbon::parse($free_trial)->startOfDay();
    $date = Carbon::now()->startOfDay();
    if ($date > $free_trial) {
      return redirect()->route('attorneys.subscription', $user->id);
    } else {
      $user = User::find($user->id);
      $user->active = '1';
      $user->trial_ends_at = $free_trial;
      $user->save();
     

      // $email_sent=Mail::to($user->email)->send(new AttorneyRegistered());
      return redirect()->route('attorneys.thanks', $user->id)->with('success', 'Attorney Registered Successfully! Now you can login to use our services.');
    }
  }
  /* to edit attorney info */
  public function edit($id)
  {
    if (Auth::user()->id == $id || Auth::user()->hasrole('super admin') === true) {
      $attorney = User::find($id);
      $attorney_data = User::find($id)->attorney;
      if ($attorney_data) {
        $attorney_active_data = DB::table('attorney_table_active')
          ->where([['registrationnumber', $attorney_data->attorney_reg_1_num], ['registration_state_id', $attorney_data->attorney_reg_1_state_id]])
          // ->orWhere('registrationnumber_state1', $attorney_data->attorney_reg_1_num)
          ->get()->first();
      } else {
        $attorney_active_data = NULL;
      }
      return view('attorney.edit', ['attorney' => $attorney, 'attorney_data' => $attorney_data, 'attorney_active_data' => $attorney_active_data]);
    } else {
      return redirect()->route('home');
    }
  }
  /* to update attorney info */
  public function update(Request $request, $id)
  {
    if (Auth::user()->id == $id || Auth::user()->hasrole('super admin') === true) {
    } else {
      return redirect()->route('home');
    }
    $validatedData = $request->validate([
      // 'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
      'email' => 'required | email | unique:users,email,' . $id,
    ]);

    $fname = $request->fname;
    $mname = $request->mname;
    $lname = $request->lname;
    $email = $request->email;
    $document_sign_name = $request->document_sign_name;
    $special_practice = $request->special_practice;
    $firm_name = $request->firm_name;
    $firm_street_address = $request->firm_street_address;
    $firm_suite_unit_mailcode = $request->firm_suite_unit_mailcode;
    $po_box = $request->po_box;
    $firm_city = $request->firm_city;
    $firm_state = $request->firm_state;
    $firm_county = $request->firm_county;
    $firm_zipcode = $request->firm_zipcode;
    $firm_telephone = $request->firm_telephone;
    $firm_fax = $request->firm_fax;
    $attorney_reg_1_state_id = $request->attorney_reg_1_state_id;
    // $attorney_reg_2_state_id=$request->attorney_reg_2_state_id;
    // $attorney_reg_3_state_id=$request->attorney_reg_3_state_id;
    $attorney_reg_1_num = $request->attorney_reg_1_num;
    // $attorney_reg_2_num=$request->attorney_reg_2_num;
    // $attorney_reg_3_num=$request->attorney_reg_3_num;
    if (isset($request->pro_hac_vice) && $request->pro_hac_vice == 'yes' && isset($request->pro_vice_hac_num) && $request->pro_vice_hac_num != '') {
      $pro_vice_hac_num = $request->pro_vice_hac_num;
    } else {
      $pro_vice_hac_num = NULL;
    }
    if ($special_practice == 'court') {
      $special_practice_text = $request->court_text;
    } else if ($special_practice == 'law_school') {
      $special_practice_text = $request->law_school_text;
    } else if ($special_practice == 'legal_aid') {
      $special_practice_text = $request->legal_aid_text;
    } else {
      $special_practice_text = 'Nill';
    }
    $attorney_state = State::where('id', $firm_state)->get()->first();
    $attorney_reg_state = State::where('id', $attorney_reg_1_state_id)->get()->first();
    $attorney_county = County::where('id', $firm_county)->get()->first();
    $user = User::find($id);
    $user->name = $fname . ' ' . $lname;
    $user->email = $email;
    $user->updated_at = now();
    $user->save();
    $attorney_user = User::find($id)->attorney;

    $attorney_user->mname = $mname;
    $attorney_user->email = $email;
    $attorney_user->document_sign_name = $document_sign_name;
    $attorney_user->special_practice = $special_practice;
    $attorney_user->special_practice_text = $special_practice_text;
    $attorney_user->firm_name = $firm_name;
    $attorney_user->firm_street_address = $firm_street_address;
    $attorney_user->firm_suite_unit_mailcode = $firm_suite_unit_mailcode;
    $attorney_user->po_box = $po_box;
    $attorney_user->firm_city = $firm_city;
    $attorney_user->state_id = $firm_state;
    $attorney_user->county_id = $firm_county;
    $attorney_user->firm_zipcode = $firm_zipcode;
    $attorney_user->firm_telephone = $firm_telephone;
    $attorney_user->firm_fax = $firm_fax;
    $attorney_user->attorney_reg_1_state_id = $attorney_reg_1_state_id;
    // $attorney_user->attorney_reg_2_state_id=$attorney_reg_2_state_id;
    // $attorney_user->attorney_reg_3_state_id=$attorney_reg_3_state_id;
    $attorney_user->attorney_reg_1_num = $attorney_reg_1_num;
    // $attorney_user->attorney_reg_2_num=$attorney_reg_2_num;
    // $attorney_user->attorney_reg_3_num=$attorney_reg_3_num;
    $attorney_user->pro_vice_hac_num = $pro_vice_hac_num;
    $attorney_user->updated_at = now();
    $attorney_user->fname = $request->fname;
    $attorney_user->lname = $request->lname;
    $attorney_user->sufname = $request->sufname;
    // $attorney_user->currentstatus=$request->currentstatus;
    $attorney_user->gender = $request->gender;
    $attorney_user->attorneytitle = $request->attorneytitle;
    $attorney_user->insured = $request->insured;
    // $attorney_user->admissiondate=date("Y-m-d",strtotime($request->admissiondate));
    // $attorney_user->admissiondatevalue=date("Ymd",strtotime($request->admissiondate));
    // $attorney_user->howadmitted=$request->howadmitted;
    // $attorney_user->birthdate=date("Y-m-d",strtotime($request->birthdate));
    // $attorney_user->birthdatevalue=date("Ymd",strtotime($request->birthdate));
    $attorney_user->firm_tagline = $request->firm_tagline;
    $attorney_user->firm_state = $attorney_state->state;
    $attorney_user->firm_state_abr = $attorney_state->state_abbreviation;
    $attorney_user->email = $request->email;
    $attorney_user->firm_county = $attorney_county->county_name;
    $attorney_user->registration_state_1 = $attorney_reg_state->state;
    $attorney_user->save();
    // to backup old attorney data before updating in attorney table active
    if (isset($request->update_source_data) && $request->update_source_data == 'Yes') {
      $attorney_active_data_old = DB::table('attorney_table_active')
        ->where([['registrationnumber', $request->attorney_reg_1_num], ['registration_state_id', $request->attorney_reg_1_state_id]])
        // ->orWhere('registrationnumber_state1', $request->attorney_reg_1_num)
        ->get()->first();
      if ($attorney_active_data_old) {
        unset($attorney_active_data_old->id);
        $attorney_active_data_old = (array) $attorney_active_data_old;
        AttorneyTableActiveBeforeEdit::create($attorney_active_data_old);
      }
      //  to update attorney table active
      $last_update = date('Y-m-d');
      $lastupdatevalue = date('Ymd');
      if (isset($request->gender) && $request->gender != '') {
        $gender = $request->gender;
      } else {
        $gender = 'N';
      }
      if (isset($request->insured) && $request->insured != '') {
        $insured = $request->insured;
      } else {
        $insured = NULL;
      }
      $data['fname'] = $fname;
      $data['mname'] = $mname;
      $data['lname'] = $lname;
      $data['sufname'] = $request->sufname;
      $data['document_sign_name'] = $document_sign_name;
      $data['gender'] = $gender;
      $data['attorneytitle'] = $request->attorneytitle;
      $data['insured'] = $insured;
      $data['firm_zip'] = $firm_zipcode;
      $data['firm_name'] = $firm_name;
      $data['firm_tagline'] = $request->firm_tagline;
      $data['firm_street_address'] = $firm_street_address;
      $data['firm_suite_unit_mailcode'] = $firm_suite_unit_mailcode;
      $data['po_box'] = $po_box;
      $data['firm_city'] = $firm_city;
      $data['firm_state'] = $attorney_state->state;
      $data['firm_state_abr'] = $attorney_state->state_abbreviation;
      $data['firm_telephone'] = $firm_telephone;
      $data['firm_fax'] = $firm_fax;
      $data['email'] = $email;
      $data['lawschool'] = $request->law_school_text;
      $data['firm_county'] = $attorney_county->county_name;
      $data['county_id'] = $firm_county;
      $data['last_update'] = $last_update;
      $data['last_updatevalue'] = $lastupdatevalue;
      $data['last_edited_by'] = $user->name;
      // $data['admissiondate']=date("Y-m-d",strtotime($request->admissiondate));
      // $data['admissiondatevalue']=date("Ymd",strtotime($request->admissiondate));
      // $data['howadmitted']=$request->howadmitted;
      // $data['birthdate']=date("Y-m-d",strtotime($request->birthdate));
      // $data['birthdatevalue']=date("Ymd",strtotime($request->birthdate));
      $data['registration_state'] = $attorney_reg_state->state;
      // $data['currentstatus']=$request->currentstatus;
      // dd($data);
      $attorney_active_data = DB::table('attorney_table_active')
        ->where([['registrationnumber', $request->attorney_reg_1_num], ['registration_state_id', $request->attorney_reg_1_state_id]])
        // ->orWhere('registrationnumber_state1', $request->attorney_reg_1_num)
        ->update($data);
    }
    $attorney = User::find($id);
    $attorney_data = User::find($id)->attorney;
    return redirect()->route('attorneys.edit', ['id' => $id])->with('success', 'Account Info Updated Successfully');
    // return view('attorney.edit',['attorney'=>$attorney, 'attorney_data' =>$attorney_data])->with('success', 'Account Info Updated Successfully');
  }
  /* To show Attorney subscription form and create stripe setup intent*/
  public function subscription($id)
  {
    $user = User::find($id);
    if ($user->active == '0' && $user->hasRole('attorney')) {
      return view('attorney.subscription', ['user' => $user, 'intent' => $user->createSetupIntent()]);
    } else {
      return redirect()->route('home');
    }
  }
  /* Purchase Main Subscription */
  public function subscribe(Request $request)
  {
    $user = User::find($request->user_id);
    $paymentMethod = $request->payment_method;
    $plan_id = StripePlan::where('plan_name', 'main')->pluck('plan_id')->first();
    $user->newSubscription('main', $plan_id)->create($paymentMethod, [
      'email' => $user->email,
    ], [
      'metadata' => ['description' => 'Attorney ' . $user->name . '(' . $user->id . ') purchased this subscription.'],
    ]);
    if ($user->subscribed('main')) {
      $user->active = '1';
      $user->save();
      $user->addPaymentMethod($paymentMethod);
      //$email_sent=Mail::to($user->email)->send(new AttorneyRegistered($user));
      // to create directory for attorney for storing computation sheets
      $path1 = public_path('/uiodirs/' . $user->id . '/download');
      if (!File::isDirectory($path1)) {
        File::makeDirectory($path1, 0755, true, true);
      }
      $path2 = public_path('/uiodirs/' . $user->id . '/uploaded');
      if (!File::isDirectory($path2)) {
        File::makeDirectory($path2, 0755, true, true);
      }
    
      return redirect()->route('attorneys.thanks', $user->id)->with('success', 'Thanks for subscribing. Now you can login to use our services.');
    }
    return redirect()->route('attorneys.subscription', $user->id)->with('error', 'Oops there is something error with your input');
  }
  /* To show thanks message after successfull purchase of subscription */
  public function thanks($id)
  {
    $user = User::find($id);
    if ($user->active == '1' && $user->hasRole('attorney')) {
      return view('attorney.thanks', ['user' => $user]);
    } else {
      return redirect()->route('home');
    }
  }
  /* Delete Attorney User */
  public function destroy($id)
  {
    User::find($id)->delete();
    return redirect()->route('attorneys.index')
      ->with('success', 'User deleted successfully');
  }
  /* Get Attorney files for Downloads */
  public function getDownloads()
  {
    // $path=( public_path() . '/uiodirs/'.Auth::user()->id.'/download/');
    // $files = File::allfiles($path);
    // // dd($files);
    // $files_data=Download::where('attorney_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get()->all();
    // $settings=Setting::get()->all();
    $path = (public_path() . '/uiodirs/' . Auth::user()->id . '/download/');
    if (File::isDirectory($path)) {
    } else {
      return redirect()->route('home')->with('error', 'Something went Wrong. Please contact Administrator.');
    }
    $files = collect(File::allfiles($path))->sortByDesc(function ($file) {
      return $file->getCTime();
    });
    return view('attorney.download_directory', ['files_data' => $files]);
  }
  /* Download and delete file */
  public function download(Request $request)
  {
    $file_name = $request->file_name;
    $path = (public_path() . '/uiodirs/' . Auth::user()->id . '/download/' . $file_name . '');
    $headers = array(
      'Content-Type' => 'application/pdf'
    );
    if (file_exists($path)) {
      // $response=response()->download($path, $file_name, $headers);
      $response = response()->download($path, $file_name, $headers)->deleteFileAfterSend();
      ob_end_clean();
      $download = Download::where([['attorney_id', Auth::user()->id], ['file_name', $file_name]])->delete();
      return $response;
    } else {
      die('File Does not Exist');
    }
  }
  /* Show Purchase State Seat License Form */
  public function getSeatLicensePaymentForm()
  {
    $user_id = Auth::user()->id;
    $user = User::find($user_id);
    $advertise_id = (isset($user->advertiser->id)) ? $user->advertiser->id : 0;
    Stripe::setApiKey(env('STRIPE_SECRET'));
    $allstripepayments = \Stripe\PaymentIntent::all(['limit' => 200]);
    //print_r($allstripepayments);
    //die;
    //$subscription = \Stripe\Subscription::retrieve('sub_IXRiZoFMoHdPL3');
    /* if($subscription){
        $status = $subscription->status;
      }*/
    //return $subscription;
    $user = User::find(Auth::user()->id);
    $subscription_data = array();
    $attorney_data = User::find(Auth::user()->id)->attorney;
    try {
      $subcription = $user->subscription('main');
      if ($advertise_id != 0) {
        $get_all_subscription = DB::table('subscriptions')->where('user_id', $user->id)->pluck('stripe_id');
        foreach ($get_all_subscription as $key => $val) {
          $a1[] = $val;
        }
        $get_adv_subscription = DB::table('advertiser_subscription')->where(['advertiser_id' => $advertise_id, 'payment_type' => 'SUBSCRIPTION'])->pluck('stripe_id');
        foreach ($get_adv_subscription as $k => $v) {
          $b1[] = $v;
        }
        /* $output = array_merge(array_diff($a1, $b1), array_diff($b1, $a1));
       print_r($output);
       die;
      $new_array=array_merge($a1,$b1);
      print_r($new_array);
      die;
      $unique=array_unique($new_array);
      print_r($unique);
      die;*/
      }
      if ($subcription) {
        $stripe_id = $subcription->stripe_id;
        $subscription_data = \Stripe\Subscription::retrieve($stripe_id);
      }
      // dd($subscription_data);
      return view('attorney.state_seat_license', ['attorney' => $user, 'attorney_data' => $attorney_data, 'intent' => $user->createSetupIntent(), 'subscription_data' => $subscription_data]);
    } catch (\Stripe\Exception\ApiErrorException $e) {
      return view('attorney.state_seat_license', ['attorney' => $user, 'attorney_data' => $attorney_data, 'intent' => $user->createSetupIntent(), 'subscription_data' => $subscription_data, 'stripe_error' => $e->getMessage()]);
    }
    /* if($subscription_data){
        $status = $subscription_data->status;
      $attorney_data = User::find(Auth::user()->id)->attorney;
        }else{
          $attorney_data = array();
        }*/
    // return  $subscription;
  }
  /* Purchase State Seat license Subscription */
  public function purchaseSeatLicensePaymentForm(Request $request)
  {
    $user = User::find(Auth::user()->id);
    $attorney_data = User::find(Auth::user()->id)->attorney;
    $paymentMethod = $request->payment_method;
    if (isset($request->attorney_reg_2_state_id) && $request->attorney_reg_2_state_id != '' && isset($request->attorney_reg_2_state_id) && $request->attorney_reg_2_state_id != '') {
    } else if (isset($request->attorney_reg_3_state_id) && $request->attorney_reg_3_state_id != '' && isset($request->attorney_reg_3_state_id) && $request->attorney_reg_3_state_id != '') {
    } else {
      return redirect()->route('attorneys.state_seat_license')->with('error', 'Please fill all required Fields.');
    }
    // $seat_license_price=$request->hidden_seat_license_price;
    // $amount = intval($seat_license_price * 100);
    // if ($user->hasPaymentMethod()) {
    //     // $paymentMethods = $user->paymentMethods();
    //     $user->addPaymentMethod($paymentMethod);
    // } else {
    //     $user->addPaymentMethod($paymentMethod);
    // }
    // for purchasing second state seat license
    if (isset($request->attorney_reg_2_state_id) && $request->attorney_reg_2_state_id != '' && isset($request->attorney_reg_2_state_id) && $request->attorney_reg_2_state_id != '') {
      $plan_id = StripePlan::where('plan_name', 'main')->pluck('plan_id')->first();
      try {
        $user->newSubscription('main', $plan_id)->create($paymentMethod, [
          'email' => $user->email,
        ], [
          'metadata' => ['description' => 'Attorney ' . $user->name . '(' . $user->id . ') purchased this subscription.'],
        ]);
        if ($user->subscribed('main')) {
          $attorney_reg_2_num = $request->attorney_reg_2_num;
          $attorney_reg_2_state_id = $request->attorney_reg_2_state_id;
          // $state_id=$attorney_reg_2_state_id;
          // $state_reg_num=$attorney_reg_2_num;
          $attorney_data->attorney_reg_1_num = $attorney_reg_2_num;
          $attorney_data->attorney_reg_1_state_id = $attorney_reg_2_state_id;
          $attorney_data->save();
          return redirect()->route('attorneys.state_seat_license')->with('success', 'Thanks. Your Transaction Completed Successfully.');
        } else {
          return redirect()->route('attorneys.state_seat_license')->with('error', 'Something went Wrong. Please try again.');
        }
      } catch (Exception $e) {
        // return redirect()->back()->with('error', ['Something went Wrong. Please try again.']);
        return redirect()->route('attorneys.state_seat_license')->with('error', 'Something went Wrong. Please try again.');
      }
    }
    // end for purchasing second state seat license
    // for purchasing third state seat license
    if (isset($request->attorney_reg_3_state_id) && $request->attorney_reg_3_state_id != '' && isset($request->attorney_reg_3_state_id) && $request->attorney_reg_3_state_id != '') {
      $plan_id = StripePlan::where('plan_name', 'third_state_seat_license_plan')->pluck('plan_id')->first();
      try {
        $user->newSubscription('third_state_seat_license_plan', $plan_id)->create($paymentMethod, [
          'email' => $user->email,
        ], [
          'metadata' => ['description' => 'Attorney ' . $user->name . '(' . $user->id . ') purchased this subscription.'],
        ]);
        if ($user->subscribed('third_state_seat_license_plan')) {
          $attorney_reg_3_num = $request->attorney_reg_3_num;
          $attorney_reg_3_state_id = $request->attorney_reg_3_state_id;
          // $state_id=$attorney_reg_3_state_id;
          // $state_reg_num=$attorney_reg_3_num;
          $attorney_data->attorney_reg_3_num = $attorney_reg_3_num;
          $attorney_data->attorney_reg_3_state_id = $attorney_reg_3_state_id;
          $attorney_data->save();
          return redirect()->route('attorneys.state_seat_license')->with('success', 'Thanks. Your Transaction Completed Successfully.');
        } else {
          return redirect()->route('attorneys.state_seat_license')->with('error', 'Something went Wrong. Please try again.');
        }
      } catch (Exception $e) {
        // return redirect()->back()->with('error', ['Something went Wrong. Please try again.']);
        return redirect()->route('attorneys.state_seat_license')->with('error', 'Something went Wrong. Please try again.');
      }
    }
    // end for purchasing third state seat license
  }
  /* Update Attorneys State and State Number*/
  public function updateStateAndStateNumber(Request $request)
  {
    $user = User::find(Auth::user()->id);
    $attorney_data = User::find(Auth::user()->id)->attorney;
    if (isset($request->attorney_reg_2_state_id) && $request->attorney_reg_2_state_id != '' && isset($request->attorney_reg_2_state_id) && $request->attorney_reg_2_state_id != '') {
      $attorney_reg_2_num = $request->attorney_reg_2_num;
      $attorney_reg_2_state_id = $request->attorney_reg_2_state_id;
      $attorney_data->attorney_reg_2_num = $attorney_reg_2_num;
      $attorney_data->attorney_reg_2_state_id = $attorney_reg_2_state_id;
      $attorney_data->save();
    }
    if (isset($request->attorney_reg_3_state_id) && $request->attorney_reg_3_state_id != '' && isset($request->attorney_reg_3_state_id) && $request->attorney_reg_3_state_id != '') {
      $attorney_reg_3_num = $request->attorney_reg_3_num;
      $attorney_reg_3_state_id = $request->attorney_reg_3_state_id;
      $attorney_data->attorney_reg_3_num = $attorney_reg_3_num;
      $attorney_data->attorney_reg_3_state_id = $attorney_reg_3_state_id;
      $attorney_data->save();
    }
    return redirect()->route('attorneys.state_seat_license')->with('success', 'Record Updated Successfully.');
  }
  /* Cancel Attorneys State Seat License subscription */
  public function cancelStateSeatLicenseSubscription(Request $request)
  {
    $license_type = $request->license_type;
    if (isset($license_type) && $license_type != '') {
      try {
        Auth::user()->subscription($license_type)->cancel();
        return redirect()->route('attorneys.state_seat_license')->with('success', 'Your Subscription Cancelled Successfully.');
      } catch (Exception $e) {
        // return redirect()->back()->with('error', ['Something went Wrong. Please try again.']);
        return redirect()->route('attorneys.state_seat_license')->with('error', 'Something went Wrong. Please try again.');
      }
    }
  }
  /* Resume Attorneys State Seat License subscription */
  public function resumeCancelledStateSeatLicenseSubscription(Request $request)
  {
    $license_type = $request->license_type;
    if (isset($license_type) && $license_type != '') {
      try {
        Auth::user()->subscription($license_type)->resume();
        return redirect()->route('attorneys.state_seat_license')->with('success', 'Your Subscription Resumed Successfully.');
      } catch (Exception $e) {
        // return redirect()->back()->with('error', ['Something went Wrong. Please try again.']);
        return redirect()->route('attorneys.state_seat_license')->with('error', 'Something went Wrong. Please try again.');
      }
    }
  }
  /* Delete downloaded file */
  public function deleteDownloadFile(Request $request)
  {
    $file_name = $request->file_name;
    $path = (public_path() . '/uiodirs/' . Auth::user()->id . '/download/' . $file_name . '');
    $headers = array(
      'Content-Type' => 'application/pdf'
    );
    if (file_exists($path)) {
      // $response=response()->download($path, $file_name, $headers);
      File::delete($path);
      ob_end_clean();
      $download = Download::where([['attorney_id', Auth::user()->id], ['file_name', $file_name]])->delete();
      return redirect()->back()->with('success', 'File deleted successfully.');
    } else {
      return redirect()->back()->with('error', 'File does not exist.');
    }
  }
  // for drafting/downloading practice aids
  public function draftPracticeAids(Request $request)
  {
    $doc_number = $request->select_practice_aid;
    $doctype = $request->doctype;
    $admin_email = Setting::where('setting_key', 'admin_email')->pluck('setting_value')->first();
    if (!$admin_email) {
      $admin_email = env('APP_EMAIL');
    }
    /* Initiating the package record to start the document generation */
    $triggers_all_packages = DB::table('triggers_all_packages')->insert(
      ['attorney_self_id' => Auth::user()->id, 'trig_package' => $doc_number, 'package_select' => 1]
    );
    /* call the procedure to update the package_select 0 */
    $user_id = Auth::user()->id;
    DB::select("CALL packages2docs(?,?)", [$user_id, 0]);
    /* Fetching the touch directories for document to call macro */
    $votes = DB::table('FDD_triggers_all_documents_Votes')->get();
    $success_macros = 0;
    $failed_macros = 0;
    foreach ($votes as $vote) {
      exec('touch ' . $vote->vote_dir . '', $output, $return);
      //sleep(1);
      // Return will return non-zero upon an error
      if (!$return) {
        ++$success_macros;
        // sleep(3);
        // return redirect()->route('get_practice_aids_downloads');
      } else {
        // $response= "PDF not created";
        ++$failed_macros;
      }
    }
    //if(count($votes) == $success_macros){
    return redirect()->route('attorney.downloads')->with('success', 'Your drafts will be available in your download directory soon. If you do not see your file here after a few seconds then please try again or Email Us.');
    //}
    //echo $errmsg="Sorry, File that you are trying to download is not available yet. Please <a href='mailto:".$admin_email."'>check</a> with admin for more details"; die;
    // $practice_aids=DB::table('document_package_table')->where('associated_view', 'FDD_View_Attorney_Self')->where('package_name', $doc_number)->get();
    // foreach($practice_aids as $practice_aid){
    //     $document_out_format=DocumentTable::where('doc_number', $practice_aid->doc_id)->pluck('document_out_format')->first();
    //     if($triggers_attorneyself && isset($document_out_format) && strtolower($document_out_format)=='doc'){
    //         sleep(1);
    //         exec('touch /var/www/html/public/LatchProcessing/LatchVotes/FDD_View_Attorney_Self_DOC/junk.txt', $output, $return);
    //                     // Return will return non-zero upon an error
    //         if (!$return)
    //         {
    //               // sleep(3);
    //               return redirect()->route('attorney.downloads')->with('success', 'Your drafts will be available in your download directory soon. If you do not see your file here after a few seconds then please try again or Email Us.');
    //               // return redirect()->route('get_practice_aids_downloads');
    //         } else {
    //               // $response= "PDF not created";
    //               echo $errmsg="Sorry, File that you are trying to download is not available yet. Please <a href='mailto:".$admin_email."'>check</a> with admin for more details"; die;
    //         }
    //     } else if($triggers_attorneyself && isset($document_out_format) && strtolower($document_out_format)=='pdf'){
    //         sleep(1);
    //         exec('touch /var/www/html/public/LatchProcessing/LatchVotes/FDD_View_Attorney_Self_PDF/junk.txt', $output, $return);
    //                     // Return will return non-zero upon an error
    //         if (!$return)
    //         {
    //               // sleep(3);
    //               return redirect()->route('attorney.downloads')->with('success', 'Your drafts will be available in your download directory soon. If you do not see your file here after a few seconds then please try again or Email Us.');
    //               // return redirect()->route('get_practice_aids_downloads');
    //         } else {
    //               // $response= "PDF not created";
    //               echo $errmsg="Sorry, File that you are trying to download is not available yet. Please <a href='mailto:".$admin_email."'>check</a> with admin for more details"; die;
    //         }
    //     } else {
    //         return redirect()->back()->with('error', 'File does not exist.');
    //     }
    // }
  }
  /* Show attorneys Practice Aids Files */
  public function getPracticeAidsDownloads()
  {
    $path = (public_path() . '/uiodirs/' . Auth::user()->id . '/download/');
    if (File::isDirectory($path)) {
    } else {
      return redirect()->route('home')->with('error', 'Something went Wrong. Please contact Administrator.');
    }
    $files = collect(File::allfiles($path))->sortByDesc(function ($file) {
      return $file->getCTime();
    });
    return view('attorney.download_practice_aids_files', ['files_data' => $files]);
  }
  /* Check if new Files are available in download directory for downloading */
  public function checkNewDownloads(Request $request)
  {
    // $path=( public_path() . '/uiodirs/'.Auth::user()->id.'/download/');
    // $files = File::allfiles($path);
    // // dd($files);
    // $files_data=Download::where('attorney_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get()->all();
    // $settings=Setting::get()->all();
    $path = (public_path() . '/uiodirs/' . Auth::user()->id . '/download/');
    if (File::isDirectory($path)) {
    } else {
      return redirect()->route('home')->with('error', 'Something went Wrong. Please contact Administrator.');
    }
    $files = collect(File::allfiles($path))->sortByDesc(function ($file) {
      return $file->getCTime();
    });
    if ($files->first()) {
      $new_last_created_file = $files->first()->getFilename();
    } else {
      $new_last_created_file = '';
    }
    $old_last_created_file = $request->last_created_file;
    if (isset($old_last_created_file) && $old_last_created_file == '') {
      $old_last_created_file = $new_last_created_file;
    }
    $oldfilescount = $request->oldfilescount;
    // echo $new_last_created_file;
    // dd($files->first());
    // $test_response=array(
    //   'new_last_created_file'=>$new_last_created_file,
    //   'old_last_created_file'=>$old_last_created_file,
    //   'newfilesavailable'=>false
    // );
    // return response()->json($test_response);
    // if(count($files) > $oldfilescount){
    //   $response=['newfilesavailable'=>true];
    //   return response()->json($response);
    // } else if($new_last_created_file != $old_last_created_file && $new_last_created_file !=''){
    //   $response=['newfilesavailable'=>true];
    //   return response()->json($response);
    // } else {
    //   $response=['newfilesavailable'=>false];
    //   return response()->json($response);
    // }
    if (count($files) > $oldfilescount) {
      $response = ['newfilesavailable' => true];
      return response()->json($response);
    } else if ($new_last_created_file != $old_last_created_file && $new_last_created_file != '' && count($files) >= $oldfilescount) {
      $response = ['newfilesavailable' => true];
      return response()->json($response);
    } else {
      $response = ['newfilesavailable' => false];
      return response()->json($response);
    }
  }
  public function caseResources(Request $request)
  {
    return view('case_resources.index');
  }
  /**advertiser service category */
  public function AdDetails($id)
  {
    try{
    $ads_data = DB::table('advertiser_listings')->where('advertiser_listings.id', $id)->first();
    $county=County::where('id',$ads_data->county_id)->first()->county_name;
    $advertiser=Advertisers::where('id',$ads_data->advertiser_id)->first();
    $category=AdvertiserService::where('id',$ads_data->advertise_category_id)->first()->name;
    $images=ADlistingImage::where('advertiser_listing_id',$ads_data->id)->get();
    $ids = explode(',', $ads_data->advertiser_services_id);
    $ads_services = AdvertiserService::whereIn('id', $ids)->pluck('name')->toArray();
    // print_r($ads_services);
    // die();
    $services = implode(',', $ads_services);
    return view('attorney.adsDetails', compact('ads_data','county','category','images','services','advertiser'));
    }
    catch(Exception $e){
        return redirect()->route('ads_listing');
    }
  }
  /**ads listing */
  public function AdListing()
  {


         $county=Auth::user()->attorney_county[0]->id;
         
      $listing = DB::table('advertiser_listings')->where('county_id', auth()->user()->attorney->county_id)->whereNotIn('status', [0])->orderByRaw('advertiser_listing_priority=0','advertiser_listing_priority', 'asc')->paginate(12);
      foreach ($listing as $key => $val) {
        $advertiser = Advertisers::where('id', $val->advertiser_id)->first();
        $val->county_name=County::where('id',$val->county_id)->first()->county_name;
        $val->category_name = AdvertiserService::where('id', $val->advertise_category_id)->first()->name;
       $image=ADlistingImage::where('advertiser_listing_id',$val->id)->get();
       $val->image=$image;
        $ids = explode(',', $val->advertiser_services_id);
        $ads_services = AdvertiserService::whereIn('id', $ids)->pluck('name')->toArray();
        // print_r($ads_services);
        // die();
        $services = implode(',', $ads_services);
        $val->advertiser_services = $services;
        $val->advertiser_name = $advertiser->full_name;
        $val->email = $advertiser->email;
        $val->telephone = $advertiser->telephone;
        $val->City = $advertiser->City;
      }
    // $counties = DB::table('advertiser_listings')->join('counties', 'counties.id', '=', 'advertiser_listings.county_id')->select('counties.id', 'counties.county_name')->where('status',1)->groupBy('advertiser_listings.county_id')->orderByDesc('counties.county_name')->get();
    $counties = County::where('state_id',35)->orderBy('county_name')->get();
   
    // $categories = DB::table('advertiser_listings')->join('advertiser_services', 'advertiser_services.id', '=', 'advertiser_listings.advertise_category_id')->select('advertiser_services.id', 'advertiser_services.name')->where('advertiser_services.parent_id', 0)->groupBy('advertiser_listings.advertise_category_id')->get();
    $categories = DB::table('advertiser_services')->where('parent_id', 0)->get();
      return view('attorney.adsListing', compact('listing','categories','counties','county'));

  }
  /**ads search filter */
  public function searchRemember(Request $request)
  {
    //  dd(Session::all())  ;
    $search = Session::get('search');
    // dd( $request->all());
    $user_id = Auth::user()->id;
    $user = User::find($user_id);
    $advertise_id = '';
    $county = Session::get('county');
    $category = Session::get('category');
    $page = ($request->has('page') ? $request->page : Session::get('page'));
    // die($page);
    $attorney_county = '';
    $query = AdvertiseListing::query()->orderByRaw('advertiser_listing_priority=0', 'advertiser_listing_priority', 'asc');
    // Session::put('county', $county);
    // Session::put('search', $search);
    // Session::put('category', $category);
 
    if (!empty($county)) {
      $query->where('county_id', '=', $county);
    }
    if (!empty($category)) {
      $query->where('advertise_category_id', '=', $category);
    }
    if (!empty($search)) {
      $query->where('title', 'LIKE', '%' . $search . '%')->orWhere('description', 'LIKE', '%' . $search . '%');
    }
    $listing = $query->paginate(12, ['*'],'page' ,$page);
    Session::put('page', $page);
    if ($listing) {
      foreach ($listing as $key => $val) {
        $country_name = DB::table('counties')->where('id', $val->county_id)->first();
        $category_name = DB::table('advertiser_services')->where('id', $val->advertise_category_id)->first();
        $val->category_name = AdvertiserService::where('id', $val->advertise_category_id)->first()->name;
        $image = ADlistingImage::where('advertiser_listing_id', $val->id)->get();
        $val->image = $image;
        $ids = explode(',', $val->advertiser_services_id);
        $ads_services = AdvertiserService::whereIn('id', $ids)->pluck('name')->toArray();
        $services = implode(',', $ads_services);
        $val->advertiser_services = $services;
        $val->county_name = $country_name->county_name;
        $advertiser = Advertisers::where('id', $val->advertiser_id)->first();
        $val->advertiser_name = $advertiser->full_name;
        $val->email = $advertiser->email;
        $val->telephone = $advertiser->telephone;
        $val->City = $advertiser->City;
        $val->category_name = $category_name->name;
      }
    } else {
      $listing = array();
    }
  
    // $counties = DB::table('advertiser_listings')->join('counties', 'counties.id', '=', 'advertiser_listings.county_id')->select('counties.id', 'counties.county_name')->where('status',1)->groupBy('advertiser_listings.county_id')->orderByDesc('counties.county_name')->get();
    $counties = County::where('state_id', 35)->orderBy('county_name')->get();

    // $categories = DB::table('advertiser_listings')->join('advertiser_services', 'advertiser_services.id', '=', 'advertiser_listings.advertise_category_id')->select('advertiser_services.id', 'advertiser_services.name')->where('advertiser_services.parent_id', 0)->groupBy('advertiser_listings.advertise_category_id')->get();
    $categories = DB::table('advertiser_services')->where('parent_id', 0)->get();
    return view('attorney.adsListing', compact('attorney_county', 'listing', 'advertise_id', 'search', 'counties', 'categories', 'county', 'category'));
  }
  /**
   * ads listing filters
   */
  public function Filtering(Request $request)
  {
    $search = ($request->has('search') ? $request->search : Session::get('search'));
    $page = ($request->has('page') ? $request->page : Session::get('page'));


   // dd( $request->all());
    $user_id = Auth::user()->id;
    $user = User::find($user_id);
    $advertise_id ='';
    $county = ($request->has('county') ? $request->county : Session::get('county'));
    $category = ($request->has('category') ? $request->category : Session::get('category'));
    $attorney_county = '';
    $query=AdvertiseListing::query()->orderByRaw('advertiser_listing_priority=0', 'advertiser_listing_priority', 'asc');


    if (!empty($county)) {
      $query->where('county_id', '=', $county);
    }
    if (!empty($category)) {
      $query->where('advertise_category_id', '=', $category);
    }
    if (!empty($search)) {
      $query->where('title', 'LIKE', '%' . $search . '%')->orWhere('description', 'LIKE', '%' . $search . '%');
    }
    $listing = $query->paginate(12);


    Session::put('county', $county);
    Session::put('search', $search);
    Session::put('category', $category);
    Session::put('page', $page);
    if ($listing) {
      foreach ($listing as $key => $val) {
        $country_name = DB::table('counties')->where('id', $val->county_id)->first();
        $category_name = DB::table('advertiser_services')->where('id', $val->advertise_category_id)->first();
        $val->category_name = AdvertiserService::where('id', $val->advertise_category_id)->first()->name;
        $image=ADlistingImage::where('advertiser_listing_id',$val->id)->get();
        $val->image=$image;
        $ids = explode(',', $val->advertiser_services_id);
        $ads_services = AdvertiserService::whereIn('id', $ids)->pluck('name')->toArray();
        $services = implode(',', $ads_services);
        $val->advertiser_services = $services;
        $val->county_name = $country_name->county_name;
        $advertiser = Advertisers::where('id', $val->advertiser_id)->first();
        $val->advertiser_name = $advertiser->full_name;
        $val->email = $advertiser->email;
        $val->telephone = $advertiser->telephone;
        $val->City = $advertiser->City;
        $val->category_name = $category_name->name;
      }
    } else {
      $listing = array();
    }

    // $counties = DB::table('advertiser_listings')->join('counties', 'counties.id', '=', 'advertiser_listings.county_id')->select('counties.id', 'counties.county_name')->where('status',1)->groupBy('advertiser_listings.county_id')->orderByDesc('counties.county_name')->get();
    $counties = County::where('state_id', 35)->orderBy('county_name')->get();
   
    // $categories = DB::table('advertiser_listings')->join('advertiser_services', 'advertiser_services.id', '=', 'advertiser_listings.advertise_category_id')->select('advertiser_services.id', 'advertiser_services.name')->where('advertiser_services.parent_id', 0)->groupBy('advertiser_listings.advertise_category_id')->get();
    $categories = DB::table('advertiser_services')->where('parent_id',0)->get();
     return view('attorney.adsListing', compact('attorney_county','listing', 'advertise_id','search', 'counties', 'categories', 'county', 'category'));

  }

}
