<?php

namespace App\Http\Controllers;

use Auth;
use Illuminate\Http\Request;
use App\Price;
use App\CasePaymentPackage;
use App\Testimonial;
use App\Page;
use App\Demo;
use App\Setting;
use App\ReferAttorney;
use App\InformAttorney;
use App\Mail\ContactMail;
use Illuminate\Support\Facades\Mail;
use File;
use Illuminate\Support\Facades\DB;
use App\CustomerUploads;

class HomeController extends Controller
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
        $state_id = config('constants.state_id');

        // if(Auth::check()){
        //     return view('home');
        // } else{
            $data = Testimonial::orderBy('id','DESC')->get();
            return view('home',compact('data'));
        //}
    }

    public function whatWeOffer()
    {
        return view('what_we_offer');
    }

    public function pricing()
    {
        $data = Price::orderBy('id','ASC')->get();

        return view('pricing',compact('data'));
    }

    /* Show dynamic pages based on page slug */
    public function showPage($page_slug)
    {
        // $data = Price::orderBy('id','DESC')->get();
        $data = CasePaymentPackage::where('active', '1')->orderBy('id','DESC')->get();
        $page = Page::where('slug',$page_slug)->get()->first();

        return view('admin.pages.show',compact('page', 'data'));
    }

    public function showEmailUsForm()
    {
        return view('email_us');
    }


    /*  Email Us */
    public function getEmailData(Request $request)
    {
        $admin_email=Setting::where('setting_key', 'admin_email')->pluck('setting_value')->first();
       // $email_us=Mail::to($admin_email)->send(new ContactMail($request))
        // validate recaptcha
        // if (isset($request->recaptcha_response)) {

            // Build POST request:
            // $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
            // $recaptcha_secret = env('GOOGLE_RECAPTCHA_SECRET');
            // $recaptcha_response = $request->recaptcha_response;

            // // Make and decode POST request:
            // $recaptcha = file_get_contents($recaptcha_url . '?secret=' . $recaptcha_secret . '&response=' . $recaptcha_response);
            // $recaptcha = json_decode($recaptcha);

            // // Take action based on the score returned:
            // if ($recaptcha->success == true && $recaptcha->score >= 0.5) {
                // $admin_email= env('APP_EMAIL');
                $email_from= env('MAIL_FROM_ADDRESS');
                $email_us=Mail::send('emails.contactmail',
                    array(
                        'name' => $request->name,
                        'email' => $request->email,
                        'subject' => $request->subject,
                        'phone_number' => $request->phone,
                        'user_message' => $request->message,
                    ), function($message) use ($request, $admin_email, $email_from)
                      {
                        $message->from($email_from);
                        $message->to($admin_email, 'Admin')->subject('FDD Contact - '.$request->subject.'');

                      });
               return redirect()->route('email_us')->with('success','Your message sent successfully.');
            // } else {
            //     return redirect()->route('email_us')->with('error','Captcha Error. Please try again.');
            // }

        // }
       // $email_us=Mail::send(new ContactMail($request));
    }

    public function showDemoPage(){
        return view('demo');
    }

    /* Store Demo and send Email with Demo files */
    public function storeDemo(Request $request){

        $this->validate($request, [

            'state_of_registration' => 'required',

            'attorney_registration_number' => 'required',

            'name' => 'required',

            'email' => ['required', 'string', 'email', 'max:255']

        ],
        [
            'email.email'    => 'There is a problem with your email address.  Please be sure to enter a valid email address.',
        ]);

        $get_state_id = DB::table('states')
        ->where('state_abbreviation', $request->state_of_registration)
        ->get()->first();

        $is_att_reg_num_in_db=DB::table('attorney_table_active')
                                ->where([['registrationnumber', $request->attorney_registration_number],['registration_state_id', $get_state_id->id]])
                                // ->orWhere('registrationnumber_state1', $request->attorney_reg_1_num)
                                ->get()->first();

        if(!$is_att_reg_num_in_db){
            sleep(4);
            return redirect()->route('demo')->with('error','There is a problem with your attorney number.  Please be sure to enter a valid registration number.');
        }

        if($request->name && $is_att_reg_num_in_db->fname){
            if(substr(ucfirst($request->name), 0,2) == substr($is_att_reg_num_in_db->fname, 0,2)){
            } else {
                sleep(4);
                return redirect()->route('demo')->with('error','This name does not correspond correctly with the registration number.  Please be sure to use the proper first name.');
            }
        } else {
            sleep(4);
            return redirect()->route('demo')->with('error','There is a problem with your attorney number.  Please be sure to enter a valid registration number.');
        }

        $alreadyhaddemo=Demo::where('attorney_registration_number', $request->attorney_registration_number)->whereYear('created_at', '=', date("Y"))->get()->all();
        if(count($alreadyhaddemo) >= 2){
            sleep(4);
            return redirect()->route('demo')->with('error','Demos are limited to two per year per registration number.  If you need to get access, please follow the registration button at the top of the web page.');
        } else {
            $input = $request->all();
            $demo = Demo::create($input);
            // $demo_triggered=DB::table('triggers_demo')->insert(
            //     ['demo_id' => $demo->id, 'trigdemo' => 'Demo']
            // );
            /*$demo_triggered=DB::table('triggers_all')->insert(
                ['demo_id' => $demo->id, 'trig_package' => 'Demo']
            );*/

            $demo_triggered = DB::table('triggers_all_packages')->insertGetId(
                 ['demo_id' => $demo->id, 'trig_package' => 'Demo','attorney_self_id' => $is_att_reg_num_in_db->id]
          );

             DB::select("CALL packages2docs(?,?)",[$is_att_reg_num_in_db->id,1]);
            // to create directory for user for storing demo sheets
            // $path1 = public_path('/uiodirs/DemoOut/'.$request->email);
            // if(!File::isDirectory($path1)){

            //     File::makeDirectory($path1, 0755, true, true);

            // }
            $votes=DB::table('FDD_triggers_all_documents_Votes')->get();
            if($demo_triggered){
            $success_macros=0;
            $failed_macros=0;
            foreach($votes as $vote){
                exec('touch '.$vote->vote_dir.'', $output, $return);
                //sleep(1);
                // Return will return non-zero upon an error
                if (!$return)
                {
                  ++$success_macros;
                      // sleep(3);

                      // return redirect()->route('get_practice_aids_downloads');

                } else {
                      // $response= "PDF not created";
                      ++$failed_macros;
                }
             }
             if($success_macros != 0){
                return redirect()->route('demo')->with('success','Your documents are generated successfully. You will shortly receive an email with these documents.');
            }else{
                return redirect()->route('demo')->with('error','Something went wrong. Please try again.');
            }
         }

            /*if($demo_triggered){
                sleep(2);
                // trigdemo is Demo, touch demo.txt in FDD_View_Demo_PDF directory
                exec('touch /var/www/html/public/LatchProcessing/LatchVotes/FDD_View_Demo_DOC/demo.txt', $output, $return);
                        // Return will return non-zero upon an error
                if (!$return)
                {
                    // sleep(2);
                    // trigdemo is Demo, touch demo.txt in FDD_View_Demo_PDF directory
                    exec('touch /var/www/html/public/LatchProcessing/LatchVotes/FDD_View_Demo_PDF/demo.txt', $output, $return);
                    if (!$return)
                    {
                        sleep(2);
                        return redirect()->route('demo')->with('success','Your documents are generated successfully. You will shortly receive an email with these documents.');
                    } else {
                        return redirect()->route('demo')->with('error','Something went wrong. Please try again.');
                    }

                } else {
                      // $response= "PDF not created";
                    return redirect()->route('demo')->with('error','Something went wrong. Please try again.');
                }
            }*/

            // send demo files to user email
            // $email_from= env('MAIL_FROM_ADDRESS');


            // $demofiles=File::files(public_path() . '/demofiles/');
            // $email_us=Mail::send('emails.demomail',
            // array(
            //     'name' => $request->name,
            //     'email' => $request->email,
            // ), function($message) use ($request, $email_from, $demofiles)
            // {
            //     $message->from($email_from);
            //     $message->to($request->email, $request->name)
            //     ->subject('FDD Demo Email')
            //     ->attach(
            //         $demofiles[0]->getRealPath(),array(
            //         'as'=>$demofiles[0]->getFileName(),
            //         'mime'=>mime_content_type($demofiles[0]->getRealPath())
            //         )
            //     )
            //     ->attach(
            //         $demofiles[1]->getRealPath(),array(
            //         'as'=>$demofiles[1]->getFileName(),
            //         'mime'=>mime_content_type($demofiles[1]->getRealPath())
            //         )
            //     )
            //     ->attach(
            //         $demofiles[2]->getRealPath(),array(
            //         'as'=>$demofiles[2]->getFileName(),
            //         'mime'=>mime_content_type($demofiles[2]->getRealPath())
            //         )
            //     );
            // });


            // return redirect()->route('demo')->with('success','Your files generated successfully. Please check your email.');
        }
    }

    public function howFddCanSaveYouMoney(){
        return view('how_fdd_can_save_you_money');
    }

    public function referAnAttorneyWhoUsesFdd(){
        return view('refer_an_attorney_who_uses_fdd');
    }

    public function storeReferAnAttorney(Request $request){

        $validatedData = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'fname' => ['required'],
            'lname' => ['required'],
            'zipcode' => ['required'],
            'state_id' => ['required'],
            'county_id' => ['required'],
            'city' => ['required'],
            'street_address' => ['required'],
            'type_of_legal_matter' => ['required'],
        ]);

        $data=array(
            'fname' => $request->fname,
            'mname' => $request->mname,
            'lname' => $request->lname,
            'sufname' => $request->sufname,
            'email' => $request->email,
            'phone_number' => $request->phone_number,
            'zipcode' => $request->zipcode,
            'state_id' => $request->state_id,
            'county_id' => $request->county_id,
            'city' => $request->city,
            'street_address' => $request->street_address,
            'suite_unit_mailcode' => $request->suite_unit_mailcode,
            'type_of_legal_matter' => $request->type_of_legal_matter,
        );
        // dd($data);
        $refer_attorney = ReferAttorney::create($data);
        if($refer_attorney){
            return redirect()->route('refer_an_attorney_who_uses_fdd')->with('success','Thank you! We’ll be emailing you some referrals, usually within 24 hours.');
        } else {
            return redirect()->route('refer_an_attorney_who_uses_fdd')->with('error','Something went wrong! Please try again.');
        }
    }

    public function informMyAttorneyToUseFdd(){
        return view('inform_my_attorney_to_use_fdd');
    }

    public function storeInformMyAttorney(Request $request){

        $validatedData = $request->validate([
            'user_email' => ['required', 'string', 'email', 'max:255'],
            'user_fname' => ['required'],
            'user_lname' => ['required'],
            'user_zipcode' => ['required'],
            'user_state_id' => ['required'],
            'user_county_id' => ['required'],
            'user_city' => ['required'],
            'user_street_address' => ['required'],
            'user_phone_number' => ['required'],
            'type_of_legal_matter' => ['required'],
            'user_attorney_reg_state_id' => ['required'],
            // 'user_attorney_registration_number' => ['required'],
            'user_attorney_fname' => ['required'],
            'user_attorney_lname' => ['required'],
            // 'user_attorney_email' => ['required', 'string', 'email', 'max:255'],
            'user_attorney_phone_number' => ['required'],
        ]);

        $data=array(
            'user_fname' => $request->user_fname,
            'user_mname' => $request->user_mname,
            'user_lname' => $request->user_lname,
            'user_sufname' => $request->user_sufname,
            'user_email' => $request->user_email,
            'user_phone_number' => $request->user_phone_number,
            'user_zipcode' => $request->user_zipcode,
            'user_state_id' => $request->user_state_id,
            'user_county_id' => $request->user_county_id,
            'user_city' => $request->user_city,
            'user_street_address' => $request->user_street_address,
            'user_suite_unit_mailcode' => $request->user_suite_unit_mailcode,
            'type_of_legal_matter' => $request->type_of_legal_matter,

            'user_attorney_reg_state_id' => $request->user_attorney_reg_state_id,
            'user_attorney_registration_number' => $request->user_attorney_registration_number,
            'user_attorney_fname' => $request->user_attorney_fname,
            'user_attorney_mname' => $request->user_attorney_mname,
            'user_attorney_lname' => $request->user_attorney_lname,
            'user_attorney_sufname' => $request->user_attorney_sufname,
            'user_attorney_firm_name' => $request->user_attorney_firm_name,
            'user_attorney_email' => $request->user_attorney_email,
            'user_attorney_phone_number' => $request->user_attorney_phone_number,
            'user_attorney_zipcode' => $request->user_attorney_zipcode,
            'user_attorney_county_id' => $request->user_attorney_county_id,
            'user_attorney_city' => $request->user_attorney_city,
            'user_attorney_street_address' => $request->user_attorney_street_address,
            'user_attorney_suite_unit_mailcode' => $request->user_attorney_suite_unit_mailcode,
        );
        // dd($data);
        $inform_attorney = InformAttorney::create($data);
        if($inform_attorney){
            return redirect()->route('inform_my_attorney_to_use_fdd')->with('success','Thank you! We’ll be contacting your attorney, usually within 24 hours.');
        } else {
            return redirect()->route('inform_my_attorney_to_use_fdd')->with('error','Something went wrong! Please try again.');
        }
    }

     public function demotiny(Request $request){
        $case_id = $request->case_id;
        if($case_id){
        include(base_path() . '/vendor/tbs_plugindemo/demo/tbs_class.php');
        include(base_path() . '/vendor/tbs_plugindemo/tbs_plugin_opentbs.php');
        $TBS = new \clsTinyButStrong;
        $TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN);
        // get the service
       // dd($TBS);
       // $TBS = $this->get('opentbs');
        // load your template
       // $row = DB::select('SELECT * FROM FDD_View_CoreCase_triggered where courtcase_id = ?',[$case_id]);
        $row = DB::select("SELECT `courtcases`.`id` AS `courtcase_id`,`courtcases`.`attorney_id` AS `courtcase_attorney_id`,`attorneys`.`document_sign_name` AS `courtcase_attorney_doc_sign_name`,`attorneys`.`firm_name` AS `courtcase_attorney_firm_name`,`attorneys`.`firm_street_address` AS `courtcase_attorney_firm_street_address`,`attorneys`.`firm_suite_unit_mailcode` AS `courtcase_attorney_firm_suite_unit_mailcode`,`attorneys`.`po_box` AS `courtcase_attorney_po_box`,`attorneys`.`firm_city` AS `courtcase_attorney_firm_city`,`attorneys`.`firm_county` AS `courtcase_attorney_firm_county`,`attorneys`.`firm_state` AS `courtcase_attorney_firm_state`,`attorneys`.`firm_zipcode` AS `courtcase_attorney_firm_zipcode`,`attorneys`.`firm_telephone` AS `courtcase_attorney_firm_telephone`,`attorneys`.`firm_fax` AS `courtcase_attorney_firm_fax`,`attorneys`.`firm_tagline` AS `courtcase_attorney_firm_tagline`,`attorneys`.`email` AS `courtcase_attorney_email`,`courtcases`.`courtcase_county_name` AS `county`,`courtcases`.`courtcase_state_name` AS `state`,`courtcases`.`court_name` AS `court_name`,`courtcases`.`division_name` AS `division_name`,`courtcases`.`street_ad` AS `street_address`,`courtcases`.`address_too` AS `street_address2`,`courtcases`.`city` AS `city`,`courtcases`.`zip` AS `zip`,`courtcases`.`phone` AS `phone`,`courtcases`.`fax` AS `fax`,`courtcases`.`email` AS `email`,`courtcases`.`email_filing_allowed` AS `email_filing_allowed`,`courtcases`.`faxfile_allowed` AS `faxfile_allowed`,`courtcases`.`efile_mandatory` AS `efile_mandatory`,`courtcases`.`geo_jurisdiction_statute` AS `geo_jurisdiction_statute`,`courtcases`.`geographic_jurisdiction` AS `geographic_jurisdiction`,`courtcases`.`cap1` AS `cap1`,`courtcases`.`cap2` AS `cap2`,`courtcases`.`cap3` AS `cap3`,`courtcases`.`cap4` AS `cap4`,`courtcases`.`clerk_name` AS `courtcase_clerkname`,`courtcases`.`clerk_title` AS `courtcase_clerktitle`,`courtcases`.`case_type_ids` AS `case_type_ids`,`courtcases`.`case_type_titles` AS `case_type_titles`,`courtcases`.`other_case_type` AS `other_case_type`,`courtcases`.`judge_fullname` AS `judge_fullname`,`courtcases`.`magistrate_fullname` AS `magistrate_fullname`,`courtcases`.`jury_demand` AS `jury_demand`,`courtcases`.`sets` AS `sets`,`courtcases`.`initial_service_types` AS `initial_service_types`,`courtcases`.`payment_status` AS `payment_status`,`courtcases`.`is_approved` AS `is_approved`,`courtcases`.`filing_type` AS `filing_type`,`courtcases`.`top_party_type` AS `top_party_type`,`courtcases`.`bottom_party_type` AS `bottom_party_type`,`courtcases`.`number_top_party_type` AS `number_top_party_type`,`courtcases`.`number_bottom_party_type` AS `number_bottom_party_type`,`courtcases`.`case_number` AS `case_number`,`courtcases`.`date_filed` AS `date_filed`,`courtcases`.`date_served` AS `date_served`,`courtcases`.`final_hearing_date` AS `final_hearing_date`,`courtcases`.`original_top_party_type` AS `original_top_party_type`,`courtcases`.`original_bottom_party_type` AS `original_bottom_party_type`,`courtcases`.`original_number_top_party_type` AS `original_number_top_party_type`,`courtcases`.`original_number_bottom_party_type` AS `original_number_bottom_party_type`,`courtcases`.`original_case_number` AS `original_case_number`,`courtcases`.`courtcase_original_county_name` AS `original_county`,`courtcases`.`courtcase_original_state_name` AS `original_state`,`courtcases`.`original_court_name` AS `original_court_name`,`courtcases`.`original_division_name` AS `original_division_name`,`courtcases`.`original_date_filed` AS `original_date_filed`,`courtcases`.`original_date_served` AS `original_date_served`,`courtcases`.`original_final_hearing_date` AS `original_final_hearing_date`,`courtcases`.`original_journalization_date` AS `original_journalization_date`,`courtcases`.`original_judge_fullname` AS `original_judge_fullname`,`courtcases`.`original_magistrate_fullname` AS `original_magistrate_fullname`,`courtcases`.`short_caption` AS `short_caption`,`courtcases`.`case_type_id1` AS `case_type_id1`,`courtcases`.`case_type_id2` AS `case_type_id2`,`courtcases`.`case_type_id3` AS `case_type_id3`,`courtcases`.`case_type_id4` AS `case_type_id4`,`courtcases`.`case_type_id5` AS `case_type_id5`,`courtcases`.`case_type_id6` AS `case_type_id6`,`courtcases`.`case_type_id7` AS `case_type_id7`,`courtcases`.`case_type_id8` AS `case_type_id8`,`courtcases`.`case_type_id9` AS `case_type_id9`,`courtcases`.`case_type_id10` AS `case_type_id10`,`courtcases`.`total_case_id` AS `total_case_id`,`courtcases`.`case_payment_package_id` AS `case_payment_package_id`,`courtcases`.`created_at` AS `courtcase_created_at`,`courtcases`.`updated_at` AS `courtcase_updated_at`,`case_parties_info`.`topparty1_type` AS `topparty1_type`,`case_parties_info`.`topparty1_prefix` AS `topparty1_prefix`,`case_parties_info`.`topparty1_name` AS `topparty1_name`,`case_parties_info`.`topparty1_fname` AS `topparty1_fname`,`case_parties_info`.`topparty1_mname` AS `topparty1_mname`,`case_parties_info`.`topparty1_lname` AS `topparty1_lname`,`case_parties_info`.`topparty1_suffix` AS `topparty1_suffix`,`case_parties_info`.`topparty1_org_comp_name` AS `topparty1_org_comp_name`,`case_parties_info`.`topparty1_care_of` AS `topparty1_care_of`,`case_parties_info`.`topparty1_short_name` AS `topparty1_short_name`,`case_parties_info`.`topparty1_zipcode` AS `topparty1_zipcode`,`case_parties_info`.`topparty1_street_address` AS `topparty1_street_address`,`case_parties_info`.`topparty1_city_name` AS `topparty1_city_name`,`case_parties_info`.`topparty1_state_name` AS `topparty1_state_name`,`case_parties_info`.`topparty1_county_name` AS `topparty1_county_name`,`case_parties_info`.`topparty1_phone` AS `topparty1_phone`,`case_parties_info`.`topparty1_fax` AS `topparty1_fax`,`case_parties_info`.`topparty1_gender` AS `topparty1_gender`,`case_parties_info`.`topparty1_pauperis` AS `topparty1_pauperis`,`case_parties_info`.`topparty1_num_attys` AS `topparty1_num_attys`,`case_parties_info`.`topparty2_prefix` AS `topparty2_prefix`,`case_parties_info`.`topparty2_type` AS `topparty2_type`,`case_parties_info`.`topparty2_name` AS `topparty2_name`,`case_parties_info`.`topparty2_fname` AS `topparty2_fname`,`case_parties_info`.`topparty2_mname` AS `topparty2_mname`,`case_parties_info`.`topparty2_lname` AS `topparty2_lname`,`case_parties_info`.`topparty2_suffix` AS `topparty2_suffix`,`case_parties_info`.`topparty2_org_comp_name` AS `topparty2_org_comp_name`,`case_parties_info`.`topparty2_care_of` AS `topparty2_care_of`,`case_parties_info`.`topparty2_short_name` AS `topparty2_short_name`,`case_parties_info`.`topparty2_zipcode` AS `topparty2_zipcode`,`case_parties_info`.`topparty2_street_address` AS `topparty2_street_address`,`case_parties_info`.`topparty2_city_name` AS `topparty2_city_name`,`case_parties_info`.`topparty2_state_name` AS `topparty2_state_name`,`case_parties_info`.`topparty2_county_name` AS `topparty2_county_name`,`case_parties_info`.`topparty2_phone` AS `topparty2_phone`,`case_parties_info`.`topparty2_fax` AS `topparty2_fax`,`case_parties_info`.`topparty2_gender` AS `topparty2_gender`,`case_parties_info`.`topparty2_pauperis` AS `topparty2_pauperis`,`case_parties_info`.`topparty2_num_attys` AS `topparty2_num_attys`,`case_parties_info`.`topparty3_type` AS `topparty3_type`,`case_parties_info`.`topparty3_prefix` AS `topparty3_prefix`,`case_parties_info`.`topparty3_name` AS `topparty3_name`,`case_parties_info`.`topparty3_fname` AS `topparty3_fname`,`case_parties_info`.`topparty3_mname` AS `topparty3_mname`,`case_parties_info`.`topparty3_lname` AS `topparty3_lname`,`case_parties_info`.`topparty3_suffix` AS `topparty3_suffix`,`case_parties_info`.`topparty3_org_comp_name` AS `topparty3_org_comp_name`,`case_parties_info`.`topparty3_care_of` AS `topparty3_care_of`,`case_parties_info`.`topparty3_short_name` AS `topparty3_short_name`,`case_parties_info`.`topparty3_zipcode` AS `topparty3_zipcode`,`case_parties_info`.`topparty3_street_address` AS `topparty3_street_address`,`case_parties_info`.`topparty3_city_name` AS `topparty3_city_name`,`case_parties_info`.`topparty3_state_name` AS `topparty3_state_name`,`case_parties_info`.`topparty3_county_name` AS `topparty3_county_name`,`case_parties_info`.`topparty3_phone` AS `topparty3_phone`,`case_parties_info`.`topparty3_fax` AS `topparty3_fax`,`case_parties_info`.`topparty3_gender` AS `topparty3_gender`,`case_parties_info`.`topparty3_pauperis` AS `topparty3_pauperis`,`case_parties_info`.`topparty3_num_attys` AS `topparty3_num_attys`,`case_parties_info`.`topparty4_type` AS `topparty4_type`,`case_parties_info`.`topparty4_prefix` AS `topparty4_prefix`,`case_parties_info`.`topparty4_name` AS `topparty4_name`,`case_parties_info`.`topparty4_fname` AS `topparty4_fname`,`case_parties_info`.`topparty4_mname` AS `topparty4_mname`,`case_parties_info`.`topparty4_lname` AS `topparty4_lname`,`case_parties_info`.`topparty4_suffix` AS `topparty4_suffix`,`case_parties_info`.`topparty4_org_comp_name` AS `topparty4_org_comp_name`,`case_parties_info`.`topparty4_care_of` AS `topparty4_care_of`,`case_parties_info`.`topparty4_short_name` AS `topparty4_short_name`,`case_parties_info`.`topparty4_zipcode` AS `topparty4_zipcode`,`case_parties_info`.`topparty4_street_address` AS `topparty4_street_address`,`case_parties_info`.`topparty4_city_name` AS `topparty4_city_name`,`case_parties_info`.`topparty4_state_name` AS `topparty4_state_name`,`case_parties_info`.`topparty4_county_name` AS `topparty4_county_name`,`case_parties_info`.`topparty4_phone` AS `topparty4_phone`,`case_parties_info`.`topparty4_fax` AS `topparty4_fax`,`case_parties_info`.`topparty4_gender` AS `topparty4_gender`,`case_parties_info`.`topparty4_pauperis` AS `topparty4_pauperis`,`case_parties_info`.`topparty4_num_attys` AS `topparty4_num_attys`,`case_parties_info`.`topparty5_type` AS `topparty5_type`,`case_parties_info`.`topparty5_prefix` AS `topparty5_prefix`,`case_parties_info`.`topparty5_name` AS `topparty5_name`,`case_parties_info`.`topparty5_fname` AS `topparty5_fname`,`case_parties_info`.`topparty5_mname` AS `topparty5_mname`,`case_parties_info`.`topparty5_lname` AS `topparty5_lname`,`case_parties_info`.`topparty5_suffix` AS `topparty5_suffix`,`case_parties_info`.`topparty5_org_comp_name` AS `topparty5_org_comp_name`,`case_parties_info`.`topparty5_care_of` AS `topparty5_care_of`,`case_parties_info`.`topparty5_short_name` AS `topparty5_short_name`,`case_parties_info`.`topparty5_zipcode` AS `topparty5_zipcode`,`case_parties_info`.`topparty5_street_address` AS `topparty5_street_address`,`case_parties_info`.`topparty5_city_name` AS `topparty5_city_name`,`case_parties_info`.`topparty5_state_name` AS `topparty5_state_name`,`case_parties_info`.`topparty5_county_name` AS `topparty5_county_name`,`case_parties_info`.`topparty5_phone` AS `topparty5_phone`,`case_parties_info`.`topparty5_fax` AS `topparty5_fax`,`case_parties_info`.`topparty5_gender` AS `topparty5_gender`,`case_parties_info`.`topparty5_pauperis` AS `topparty5_pauperis`,`case_parties_info`.`topparty5_num_attys` AS `topparty5_num_attys`,`case_parties_info`.`topparty6_type` AS `topparty6_type`,`case_parties_info`.`topparty6_prefix` AS `topparty6_prefix`,`case_parties_info`.`topparty6_name` AS `topparty6_name`,`case_parties_info`.`topparty6_fname` AS `topparty6_fname`,`case_parties_info`.`topparty6_mname` AS `topparty6_mname`,`case_parties_info`.`topparty6_lname` AS `topparty6_lname`,`case_parties_info`.`topparty6_suffix` AS `topparty6_suffix`,`case_parties_info`.`topparty6_org_comp_name` AS `topparty6_org_comp_name`,`case_parties_info`.`topparty6_care_of` AS `topparty6_care_of`,`case_parties_info`.`topparty6_short_name` AS `topparty6_short_name`,`case_parties_info`.`topparty6_zipcode` AS `topparty6_zipcode`,`case_parties_info`.`topparty6_street_address` AS `topparty6_street_address`,`case_parties_info`.`topparty6_city_name` AS `topparty6_city_name`,`case_parties_info`.`topparty6_state_name` AS `topparty6_state_name`,`case_parties_info`.`topparty6_county_name` AS `topparty6_county_name`,`case_parties_info`.`topparty6_phone` AS `topparty6_phone`,`case_parties_info`.`topparty6_fax` AS `topparty6_fax`,`case_parties_info`.`topparty6_gender` AS `topparty6_gender`,`case_parties_info`.`topparty6_pauperis` AS `topparty6_pauperis`,`case_parties_info`.`topparty6_num_attys` AS `topparty6_num_attys`,`case_parties_info`.`bottomparty1_type` AS `bottomparty1_type`,`case_parties_info`.`bottomparty1_prefix` AS `bottomparty1_prefix`,`case_parties_info`.`bottomparty1_name` AS `bottomparty1_name`,`case_parties_info`.`bottomparty1_fname` AS `bottomparty1_fname`,`case_parties_info`.`bottomparty1_mname` AS `bottomparty1_mname`,`case_parties_info`.`bottomparty1_lname` AS `bottomparty1_lname`,`case_parties_info`.`bottomparty1_suffix` AS `bottomparty1_suffix`,`case_parties_info`.`bottomparty1_org_comp_name` AS `bottomparty1_org_comp_name`,`case_parties_info`.`bottomparty1_care_of` AS `bottomparty1_care_of`,`case_parties_info`.`bottomparty1_short_name` AS `bottomparty1_short_name`,`case_parties_info`.`bottomparty1_zipcode` AS `bottomparty1_zipcode`,`case_parties_info`.`bottomparty1_street_address` AS `bottomparty1_street_address`,`case_parties_info`.`bottomparty1_city_name` AS `bottomparty1_city_name`,`case_parties_info`.`bottomparty1_state_name` AS `bottomparty1_state_name`,`case_parties_info`.`bottomparty1_county_name` AS `bottomparty1_county_name`,`case_parties_info`.`bottomparty1_phone` AS `bottomparty1_phone`,`case_parties_info`.`bottomparty1_fax` AS `bottomparty1_fax`,`case_parties_info`.`bottomparty1_gender` AS `bottomparty1_gender`,`case_parties_info`.`bottomparty1_pauperis` AS `bottomparty1_pauperis`,`case_parties_info`.`bottomparty1_num_attys` AS `bottomparty1_num_attys`,`case_parties_info`.`bottomparty2_type` AS `bottomparty2_type`,`case_parties_info`.`bottomparty2_prefix` AS `bottomparty2_prefix`,`case_parties_info`.`bottomparty2_name` AS `bottomparty2_name`,`case_parties_info`.`bottomparty2_fname` AS `bottomparty2_fname`,`case_parties_info`.`bottomparty2_mname` AS `bottomparty2_mname`,`case_parties_info`.`bottomparty2_lname` AS `bottomparty2_lname`,`case_parties_info`.`bottomparty2_suffix` AS `bottomparty2_suffix`,`case_parties_info`.`bottomparty2_org_comp_name` AS `bottomparty2_org_comp_name`,`case_parties_info`.`bottomparty2_care_of` AS `bottomparty2_care_of`,`case_parties_info`.`bottomparty2_short_name` AS `bottomparty2_short_name`,`case_parties_info`.`bottomparty2_zipcode` AS `bottomparty2_zipcode`,`case_parties_info`.`bottomparty2_street_address` AS `bottomparty2_street_address`,`case_parties_info`.`bottomparty2_city_name` AS `bottomparty2_city_name`,`case_parties_info`.`bottomparty2_state_name` AS `bottomparty2_state_name`,`case_parties_info`.`bottomparty2_county_name` AS `bottomparty2_county_name`,`case_parties_info`.`bottomparty2_phone` AS `bottomparty2_phone`,`case_parties_info`.`bottomparty2_fax` AS `bottomparty2_fax`,`case_parties_info`.`bottomparty2_gender` AS `bottomparty2_gender`,`case_parties_info`.`bottomparty2_pauperis` AS `bottomparty2_pauperis`,`case_parties_info`.`bottomparty2_num_attys` AS `bottomparty2_num_attys`,`case_parties_info`.`bottomparty3_type` AS `bottomparty3_type`,`case_parties_info`.`bottomparty3_prefix` AS `bottomparty3_prefix`,`case_parties_info`.`bottomparty3_name` AS `bottomparty3_name`,`case_parties_info`.`bottomparty3_fname` AS `bottomparty3_fname`,`case_parties_info`.`bottomparty3_mname` AS `bottomparty3_mname`,`case_parties_info`.`bottomparty3_lname` AS `bottomparty3_lname`,`case_parties_info`.`bottomparty3_suffix` AS `bottomparty3_suffix`,`case_parties_info`.`bottomparty3_org_comp_name` AS `bottomparty3_org_comp_name`,`case_parties_info`.`bottomparty3_care_of` AS `bottomparty3_care_of`,`case_parties_info`.`bottomparty3_short_name` AS `bottomparty3_short_name`,`case_parties_info`.`bottomparty3_zipcode` AS `bottomparty3_zipcode`,`case_parties_info`.`bottomparty3_street_address` AS `bottomparty3_street_address`,`case_parties_info`.`bottomparty3_city_name` AS `bottomparty3_city_name`,`case_parties_info`.`bottomparty3_state_name` AS `bottomparty3_state_name`,`case_parties_info`.`bottomparty3_county_name` AS `bottomparty3_county_name`,`case_parties_info`.`bottomparty3_phone` AS `bottomparty3_phone`,`case_parties_info`.`bottomparty3_fax` AS `bottomparty3_fax`,`case_parties_info`.`bottomparty3_gender` AS `bottomparty3_gender`,`case_parties_info`.`bottomparty3_pauperis` AS `bottomparty3_pauperis`,`case_parties_info`.`bottomparty3_num_attys` AS `bottomparty3_num_attys`,`case_parties_info`.`bottomparty4_type` AS `bottomparty4_type`,`case_parties_info`.`bottomparty4_prefix` AS `bottomparty4_prefix`,`case_parties_info`.`bottomparty4_name` AS `bottomparty4_name`,`case_parties_info`.`bottomparty4_fname` AS `bottomparty4_fname`,`case_parties_info`.`bottomparty4_mname` AS `bottomparty4_mname`,`case_parties_info`.`bottomparty4_lname` AS `bottomparty4_lname`,`case_parties_info`.`bottomparty4_suffix` AS `bottomparty4_suffix`,`case_parties_info`.`bottomparty4_org_comp_name` AS `bottomparty4_org_comp_name`,`case_parties_info`.`bottomparty4_care_of` AS `bottomparty4_care_of`,`case_parties_info`.`bottomparty4_short_name` AS `bottomparty4_short_name`,`case_parties_info`.`bottomparty4_zipcode` AS `bottomparty4_zipcode`,`case_parties_info`.`bottomparty4_street_address` AS `bottomparty4_street_address`,`case_parties_info`.`bottomparty4_city_name` AS `bottomparty4_city_name`,`case_parties_info`.`bottomparty4_state_name` AS `bottomparty4_state_name`,`case_parties_info`.`bottomparty4_county_name` AS `bottomparty4_county_name`,`case_parties_info`.`bottomparty4_phone` AS `bottomparty4_phone`,`case_parties_info`.`bottomparty4_fax` AS `bottomparty4_fax`,`case_parties_info`.`bottomparty4_gender` AS `bottomparty4_gender`,`case_parties_info`.`bottomparty4_pauperis` AS `bottomparty4_pauperis`,`case_parties_info`.`bottomparty4_num_attys` AS `bottomparty4_num_attys`,`case_parties_info`.`bottomparty5_type` AS `bottomparty5_type`,`case_parties_info`.`bottomparty5_prefix` AS `bottomparty5_prefix`,`case_parties_info`.`bottomparty5_name` AS `bottomparty5_name`,`case_parties_info`.`bottomparty5_fname` AS `bottomparty5_fname`,`case_parties_info`.`bottomparty5_mname` AS `bottomparty5_mname`,`case_parties_info`.`bottomparty5_lname` AS `bottomparty5_lname`,`case_parties_info`.`bottomparty5_suffix` AS `bottomparty5_suffix`,`case_parties_info`.`bottomparty5_org_comp_name` AS `bottomparty5_org_comp_name`,`case_parties_info`.`bottomparty5_care_of` AS `bottomparty5_care_of`,`case_parties_info`.`bottomparty5_short_name` AS `bottomparty5_short_name`,`case_parties_info`.`bottomparty5_zipcode` AS `bottomparty5_zipcode`,`case_parties_info`.`bottomparty5_street_address` AS `bottomparty5_street_address`,`case_parties_info`.`bottomparty5_city_name` AS `bottomparty5_city_name`,`case_parties_info`.`bottomparty5_state_name` AS `bottomparty5_state_name`,`case_parties_info`.`bottomparty5_county_name` AS `bottomparty5_county_name`,`case_parties_info`.`bottomparty5_phone` AS `bottomparty5_phone`,`case_parties_info`.`bottomparty5_fax` AS `bottomparty5_fax`,`case_parties_info`.`bottomparty5_gender` AS `bottomparty5_gender`,`case_parties_info`.`bottomparty5_pauperis` AS `bottomparty5_pauperis`,`case_parties_info`.`bottomparty5_num_attys` AS `bottomparty5_num_attys`,`case_parties_info`.`bottomparty6_type` AS `bottomparty6_type`,`case_parties_info`.`bottomparty6_prefix` AS `bottomparty6_prefix`,`case_parties_info`.`bottomparty6_name` AS `bottomparty6_name`,`case_parties_info`.`bottomparty6_fname` AS `bottomparty6_fname`,`case_parties_info`.`bottomparty6_mname` AS `bottomparty6_mname`,`case_parties_info`.`bottomparty6_lname` AS `bottomparty6_lname`,`case_parties_info`.`bottomparty6_suffix` AS `bottomparty6_suffix`,`case_parties_info`.`bottomparty6_org_comp_name` AS `bottomparty6_org_comp_name`,`case_parties_info`.`bottomparty6_care_of` AS `bottomparty6_care_of`,`case_parties_info`.`bottomparty6_short_name` AS `bottomparty6_short_name`,`case_parties_info`.`bottomparty6_zipcode` AS `bottomparty6_zipcode`,`case_parties_info`.`bottomparty6_street_address` AS `bottomparty6_street_address`,`case_parties_info`.`bottomparty6_city_name` AS `bottomparty6_city_name`,`case_parties_info`.`bottomparty6_state_name` AS `bottomparty6_state_name`,`case_parties_info`.`bottomparty6_county_name` AS `bottomparty6_county_name`,`case_parties_info`.`bottomparty6_phone` AS `bottomparty6_phone`,`case_parties_info`.`bottomparty6_fax` AS `bottomparty6_fax`,`case_parties_info`.`bottomparty6_gender` AS `bottomparty6_gender`,`case_parties_info`.`bottomparty6_pauperis` AS `bottomparty6_pauperis`,`case_parties_info`.`bottomparty6_num_attys` AS `bottomparty6_num_attys`,`case_parties_info`.`top_thirdparty1_type` AS `top_thirdparty1_type`,`case_parties_info`.`top_thirdparty1_prefix` AS `top_thirdparty1_prefix`,`case_parties_info`.`top_thirdparty1_name` AS `top_thirdparty1_name`,`case_parties_info`.`top_thirdparty1_fname` AS `top_thirdparty1_fname`,`case_parties_info`.`top_thirdparty1_mname` AS `top_thirdparty1_mname`,`case_parties_info`.`top_thirdparty1_lname` AS `top_thirdparty1_lname`,`case_parties_info`.`top_thirdparty1_suffix` AS `top_thirdparty1_suffix`,`case_parties_info`.`top_thirdparty1_org_comp_name` AS `top_thirdparty1_org_comp_name`,`case_parties_info`.`top_thirdparty1_care_of` AS `top_thirdparty1_care_of`,`case_parties_info`.`top_thirdparty1_short_name` AS `top_thirdparty1_short_name`,`case_parties_info`.`top_thirdparty1_zipcode` AS `top_thirdparty1_zipcode`,`case_parties_info`.`top_thirdparty1_street_address` AS `top_thirdparty1_street_address`,`case_parties_info`.`top_thirdparty1_city_name` AS `top_thirdparty1_city_name`,`case_parties_info`.`top_thirdparty1_state_name` AS `top_thirdparty1_state_name`,`case_parties_info`.`top_thirdparty1_county_name` AS `top_thirdparty1_county_name`,`case_parties_info`.`top_thirdparty1_phone` AS `top_thirdparty1_phone`,`case_parties_info`.`top_thirdparty1_fax` AS `top_thirdparty1_fax`,`case_parties_info`.`top_thirdparty1_gender` AS `top_thirdparty1_gender`,`case_parties_info`.`top_thirdparty1_pauperis` AS `top_thirdparty1_pauperis`,`case_parties_info`.`top_thirdparty1_num_attys` AS `top_thirdparty1_num_attys`,`case_parties_info`.`top_thirdparty2_type` AS `top_thirdparty2_type`,`case_parties_info`.`top_thirdparty2_prefix` AS `top_thirdparty2_prefix`,`case_parties_info`.`top_thirdparty2_name` AS `top_thirdparty2_name`,`case_parties_info`.`top_thirdparty2_fname` AS `top_thirdparty2_fname`,`case_parties_info`.`top_thirdparty2_mname` AS `top_thirdparty2_mname`,`case_parties_info`.`top_thirdparty2_lname` AS `top_thirdparty2_lname`,`case_parties_info`.`top_thirdparty2_suffix` AS `top_thirdparty2_suffix`,`case_parties_info`.`top_thirdparty2_org_comp_name` AS `top_thirdparty2_org_comp_name`,`case_parties_info`.`top_thirdparty2_care_of` AS `top_thirdparty2_care_of`,`case_parties_info`.`top_thirdparty2_short_name` AS `top_thirdparty2_short_name`,`case_parties_info`.`top_thirdparty2_zipcode` AS `top_thirdparty2_zipcode`,`case_parties_info`.`top_thirdparty2_street_address` AS `top_thirdparty2_street_address`,`case_parties_info`.`top_thirdparty2_city_name` AS `top_thirdparty2_city_name`,`case_parties_info`.`top_thirdparty2_state_name` AS `top_thirdparty2_state_name`,`case_parties_info`.`top_thirdparty2_county_name` AS `top_thirdparty2_county_name`,`case_parties_info`.`top_thirdparty2_phone` AS `top_thirdparty2_phone`,`case_parties_info`.`top_thirdparty2_fax` AS `top_thirdparty2_fax`,`case_parties_info`.`top_thirdparty2_gender` AS `top_thirdparty2_gender`,`case_parties_info`.`top_thirdparty2_pauperis` AS `top_thirdparty2_pauperis`,`case_parties_info`.`top_thirdparty2_num_attys` AS `top_thirdparty2_num_attys`,`case_parties_info`.`top_thirdparty3_type` AS `top_thirdparty3_type`,`case_parties_info`.`top_thirdparty3_prefix` AS `top_thirdparty3_prefix`,`case_parties_info`.`top_thirdparty3_name` AS `top_thirdparty3_name`,`case_parties_info`.`top_thirdparty3_fname` AS `top_thirdparty3_fname`,`case_parties_info`.`top_thirdparty3_mname` AS `top_thirdparty3_mname`,`case_parties_info`.`top_thirdparty3_lname` AS `top_thirdparty3_lname`,`case_parties_info`.`top_thirdparty3_suffix` AS `top_thirdparty3_suffix`,`case_parties_info`.`top_thirdparty3_org_comp_name` AS `top_thirdparty3_org_comp_name`,`case_parties_info`.`top_thirdparty3_care_of` AS `top_thirdparty3_care_of`,`case_parties_info`.`top_thirdparty3_short_name` AS `top_thirdparty3_short_name`,`case_parties_info`.`top_thirdparty3_zipcode` AS `top_thirdparty3_zipcode`,`case_parties_info`.`top_thirdparty3_street_address` AS `top_thirdparty3_street_address`,`case_parties_info`.`top_thirdparty3_city_name` AS `top_thirdparty3_city_name`,`case_parties_info`.`top_thirdparty3_state_name` AS `top_thirdparty3_state_name`,`case_parties_info`.`top_thirdparty3_county_name` AS `top_thirdparty3_county_name`,`case_parties_info`.`top_thirdparty3_phone` AS `top_thirdparty3_phone`,`case_parties_info`.`top_thirdparty3_fax` AS `top_thirdparty3_fax`,`case_parties_info`.`top_thirdparty3_gender` AS `top_thirdparty3_gender`,`case_parties_info`.`top_thirdparty3_pauperis` AS `top_thirdparty3_pauperis`,`case_parties_info`.`top_thirdparty3_num_attys` AS `top_thirdparty3_num_attys`,`case_parties_info`.`bottom_thirdparty1_type` AS `bottom_thirdparty1_type`,`case_parties_info`.`bottom_thirdparty1_prefix` AS `bottom_thirdparty1_prefix`,`case_parties_info`.`bottom_thirdparty1_name` AS `bottom_thirdparty1_name`,`case_parties_info`.`bottom_thirdparty1_fname` AS `bottom_thirdparty1_fname`,`case_parties_info`.`bottom_thirdparty1_mname` AS `bottom_thirdparty1_mname`,`case_parties_info`.`bottom_thirdparty1_lname` AS `bottom_thirdparty1_lname`,`case_parties_info`.`bottom_thirdparty1_suffix` AS `bottom_thirdparty1_suffix`,`case_parties_info`.`bottom_thirdparty1_org_comp_name` AS `bottom_thirdparty1_org_comp_name`,`case_parties_info`.`bottom_thirdparty1_care_of` AS `bottom_thirdparty1_care_of`,`case_parties_info`.`bottom_thirdparty1_short_name` AS `bottom_thirdparty1_short_name`,`case_parties_info`.`bottom_thirdparty1_zipcode` AS `bottom_thirdparty1_zipcode`,`case_parties_info`.`bottom_thirdparty1_street_address` AS `bottom_thirdparty1_street_address`,`case_parties_info`.`bottom_thirdparty1_city_name` AS `bottom_thirdparty1_city_name`,`case_parties_info`.`bottom_thirdparty1_state_name` AS `bottom_thirdparty1_state_name`,`case_parties_info`.`bottom_thirdparty1_county_name` AS `bottom_thirdparty1_county_name`,`case_parties_info`.`bottom_thirdparty1_phone` AS `bottom_thirdparty1_phone`,`case_parties_info`.`bottom_thirdparty1_fax` AS `bottom_thirdparty1_fax`,`case_parties_info`.`bottom_thirdparty1_gender` AS `bottom_thirdparty1_gender`,`case_parties_info`.`bottom_thirdparty1_pauperis` AS `bottom_thirdparty1_pauperis`,`case_parties_info`.`bottom_thirdparty1_num_attys` AS `bottom_thirdparty1_num_attys`,`case_parties_info`.`bottom_thirdparty2_type` AS `bottom_thirdparty2_type`,`case_parties_info`.`bottom_thirdparty2_prefix` AS `bottom_thirdparty2_prefix`,`case_parties_info`.`bottom_thirdparty2_name` AS `bottom_thirdparty2_name`,`case_parties_info`.`bottom_thirdparty2_fname` AS `bottom_thirdparty2_fname`,`case_parties_info`.`bottom_thirdparty2_mname` AS `bottom_thirdparty2_mname`,`case_parties_info`.`bottom_thirdparty2_lname` AS `bottom_thirdparty2_lname`,`case_parties_info`.`bottom_thirdparty2_suffix` AS `bottom_thirdparty2_suffix`,`case_parties_info`.`bottom_thirdparty2_org_comp_name` AS `bottom_thirdparty2_org_comp_name`,`case_parties_info`.`bottom_thirdparty2_care_of` AS `bottom_thirdparty2_care_of`,`case_parties_info`.`bottom_thirdparty2_short_name` AS `bottom_thirdparty2_short_name`,`case_parties_info`.`bottom_thirdparty2_zipcode` AS `bottom_thirdparty2_zipcode`,`case_parties_info`.`bottom_thirdparty2_street_address` AS `bottom_thirdparty2_street_address`,`case_parties_info`.`bottom_thirdparty2_city_name` AS `bottom_thirdparty2_city_name`,`case_parties_info`.`bottom_thirdparty2_state_name` AS `bottom_thirdparty2_state_name`,`case_parties_info`.`bottom_thirdparty2_county_name` AS `bottom_thirdparty2_county_name`,`case_parties_info`.`bottom_thirdparty2_phone` AS `bottom_thirdparty2_phone`,`case_parties_info`.`bottom_thirdparty2_fax` AS `bottom_thirdparty2_fax`,`case_parties_info`.`bottom_thirdparty2_gender` AS `bottom_thirdparty2_gender`,`case_parties_info`.`bottom_thirdparty2_pauperis` AS `bottom_thirdparty2_pauperis`,`case_parties_info`.`bottom_thirdparty2_num_attys` AS `bottom_thirdparty2_num_attys`,`case_parties_info`.`bottom_thirdparty3_type` AS `bottom_thirdparty3_type`,`case_parties_info`.`bottom_thirdparty3_prefix` AS `bottom_thirdparty3_prefix`,`case_parties_info`.`bottom_thirdparty3_name` AS `bottom_thirdparty3_name`,`case_parties_info`.`bottom_thirdparty3_fname` AS `bottom_thirdparty3_fname`,`case_parties_info`.`bottom_thirdparty3_mname` AS `bottom_thirdparty3_mname`,`case_parties_info`.`bottom_thirdparty3_lname` AS `bottom_thirdparty3_lname`,`case_parties_info`.`bottom_thirdparty3_suffix` AS `bottom_thirdparty3_suffix`,`case_parties_info`.`bottom_thirdparty3_org_comp_name` AS `bottom_thirdparty3_org_comp_name`,`case_parties_info`.`bottom_thirdparty3_care_of` AS `bottom_thirdparty3_care_of`,`case_parties_info`.`bottom_thirdparty3_short_name` AS `bottom_thirdparty3_short_name`,`case_parties_info`.`bottom_thirdparty3_zipcode` AS `bottom_thirdparty3_zipcode`,`case_parties_info`.`bottom_thirdparty3_street_address` AS `bottom_thirdparty3_street_address`,`case_parties_info`.`bottom_thirdparty3_city_name` AS `bottom_thirdparty3_city_name`,`case_parties_info`.`bottom_thirdparty3_state_name` AS `bottom_thirdparty3_state_name`,`case_parties_info`.`bottom_thirdparty3_county_name` AS `bottom_thirdparty3_county_name`,`case_parties_info`.`bottom_thirdparty3_phone` AS `bottom_thirdparty3_phone`,`case_parties_info`.`bottom_thirdparty3_fax` AS `bottom_thirdparty3_fax`,`case_parties_info`.`bottom_thirdparty3_gender` AS `bottom_thirdparty3_gender`,`case_parties_info`.`bottom_thirdparty3_pauperis` AS `bottom_thirdparty3_pauperis`,`case_parties_info`.`bottom_thirdparty3_num_attys` AS `bottom_thirdparty3_num_attys`,`case_party_attorneys_info`.`topparty1_attorney1_name` AS `topparty1_attorney1_name`,`case_party_attorneys_info`.`topparty1_attorney1_email` AS `topparty1_attorney1_email`,`case_party_attorneys_info`.`topparty1_attorney1_document_sign_name` AS `topparty1_attorney1_document_sign_name`,`case_party_attorneys_info`.`topparty1_attorney1_firm_name` AS `topparty1_attorney1_firm_name`,`case_party_attorneys_info`.`topparty1_attorney1_firm_street_address` AS `topparty1_attorney1_firm_street_address`,`case_party_attorneys_info`.`topparty1_attorney1_firm_suite_unit_mailcode` AS `topparty1_attorney1_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty1_attorney1_po_box` AS `topparty1_attorney1_po_box`,`case_party_attorneys_info`.`topparty1_attorney1_firm_city` AS `topparty1_attorney1_firm_city`,`case_party_attorneys_info`.`topparty1_attorney1_firm_state` AS `topparty1_attorney1_firm_state`,`case_party_attorneys_info`.`topparty1_attorney1_firm_county` AS `topparty1_attorney1_firm_county`,`case_party_attorneys_info`.`topparty1_attorney1_firm_zipcode` AS `topparty1_attorney1_firm_zipcode`,`case_party_attorneys_info`.`topparty1_attorney1_firm_telephone` AS `topparty1_attorney1_firm_telephone`,`case_party_attorneys_info`.`topparty1_attorney1_firm_fax` AS `topparty1_attorney1_firm_fax`,`case_party_attorneys_info`.`topparty1_attorney1_reg_1_num` AS `topparty1_attorney1_reg_1_num`,`case_party_attorneys_info`.`topparty1_attorney1_trial_attorney` AS `topparty1_attorney1_trial_attorney`,`case_party_attorneys_info`.`topparty1_attorney1_caseattytitle` AS `topparty1_attorney1_caseattytitle`,`case_party_attorneys_info`.`topparty1_attorney2_name` AS `topparty1_attorney2_name`,`case_party_attorneys_info`.`topparty1_attorney2_email` AS `topparty1_attorney2_email`,`case_party_attorneys_info`.`topparty1_attorney2_document_sign_name` AS `topparty1_attorney2_document_sign_name`,`case_party_attorneys_info`.`topparty1_attorney2_firm_name` AS `topparty1_attorney2_firm_name`,`case_party_attorneys_info`.`topparty1_attorney2_firm_street_address` AS `topparty1_attorney2_firm_street_address`,`case_party_attorneys_info`.`topparty1_attorney2_firm_suite_unit_mailcode` AS `topparty1_attorney2_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty1_attorney2_po_box` AS `topparty1_attorney2_po_box`,`case_party_attorneys_info`.`topparty1_attorney2_firm_city` AS `topparty1_attorney2_firm_city`,`case_party_attorneys_info`.`topparty1_attorney2_firm_state` AS `topparty1_attorney2_firm_state`,`case_party_attorneys_info`.`topparty1_attorney2_firm_county` AS `topparty1_attorney2_firm_county`,`case_party_attorneys_info`.`topparty1_attorney2_firm_zipcode` AS `topparty1_attorney2_firm_zipcode`,`case_party_attorneys_info`.`topparty1_attorney2_firm_telephone` AS `topparty1_attorney2_firm_telephone`,`case_party_attorneys_info`.`topparty1_attorney2_firm_fax` AS `topparty1_attorney2_firm_fax`,`case_party_attorneys_info`.`topparty1_attorney2_reg_1_num` AS `topparty1_attorney2_reg_1_num`,`case_party_attorneys_info`.`topparty1_attorney2_trial_attorney` AS `topparty1_attorney2_trial_attorney`,`case_party_attorneys_info`.`topparty1_attorney2_caseattytitle` AS `topparty1_attorney2_caseattytitle`,`case_party_attorneys_info`.`topparty1_attorney3_name` AS `topparty1_attorney3_name`,`case_party_attorneys_info`.`topparty1_attorney3_email` AS `topparty1_attorney3_email`,`case_party_attorneys_info`.`topparty1_attorney3_document_sign_name` AS `topparty1_attorney3_document_sign_name`,`case_party_attorneys_info`.`topparty1_attorney3_firm_name` AS `topparty1_attorney3_firm_name`,`case_party_attorneys_info`.`topparty1_attorney3_firm_street_address` AS `topparty1_attorney3_firm_street_address`,`case_party_attorneys_info`.`topparty1_attorney3_firm_suite_unit_mailcode` AS `topparty1_attorney3_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty1_attorney3_po_box` AS `topparty1_attorney3_po_box`,`case_party_attorneys_info`.`topparty1_attorney3_firm_city` AS `topparty1_attorney3_firm_city`,`case_party_attorneys_info`.`topparty1_attorney3_firm_state` AS `topparty1_attorney3_firm_state`,`case_party_attorneys_info`.`topparty1_attorney3_firm_county` AS `topparty1_attorney3_firm_county`,`case_party_attorneys_info`.`topparty1_attorney3_firm_zipcode` AS `topparty1_attorney3_firm_zipcode`,`case_party_attorneys_info`.`topparty1_attorney3_firm_telephone` AS `topparty1_attorney3_firm_telephone`,`case_party_attorneys_info`.`topparty1_attorney3_firm_fax` AS `topparty1_attorney3_firm_fax`,`case_party_attorneys_info`.`topparty1_attorney3_reg_1_num` AS `topparty1_attorney3_reg_1_num`,`case_party_attorneys_info`.`topparty1_attorney3_trial_attorney` AS `topparty1_attorney3_trial_attorney`,`case_party_attorneys_info`.`topparty1_attorney3_caseattytitle` AS `topparty1_attorney3_caseattytitle`,`case_party_attorneys_info`.`topparty2_attorney1_name` AS `topparty2_attorney1_name`,`case_party_attorneys_info`.`topparty2_attorney1_email` AS `topparty2_attorney1_email`,`case_party_attorneys_info`.`topparty2_attorney1_document_sign_name` AS `topparty2_attorney1_document_sign_name`,`case_party_attorneys_info`.`topparty2_attorney1_firm_name` AS `topparty2_attorney1_firm_name`,`case_party_attorneys_info`.`topparty2_attorney1_firm_street_address` AS `topparty2_attorney1_firm_street_address`,`case_party_attorneys_info`.`topparty2_attorney1_firm_suite_unit_mailcode` AS `topparty2_attorney1_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty2_attorney1_po_box` AS `topparty2_attorney1_po_box`,`case_party_attorneys_info`.`topparty2_attorney1_firm_city` AS `topparty2_attorney1_firm_city`,`case_party_attorneys_info`.`topparty2_attorney1_firm_state` AS `topparty2_attorney1_firm_state`,`case_party_attorneys_info`.`topparty2_attorney1_firm_county` AS `topparty2_attorney1_firm_county`,`case_party_attorneys_info`.`topparty2_attorney1_firm_zipcode` AS `topparty2_attorney1_firm_zipcode`,`case_party_attorneys_info`.`topparty2_attorney1_firm_telephone` AS `topparty2_attorney1_firm_telephone`,`case_party_attorneys_info`.`topparty2_attorney1_firm_fax` AS `topparty2_attorney1_firm_fax`,`case_party_attorneys_info`.`topparty2_attorney1_reg_1_num` AS `topparty2_attorney1_reg_1_num`,`case_party_attorneys_info`.`topparty2_attorney1_trial_attorney` AS `topparty2_attorney1_trial_attorney`,`case_party_attorneys_info`.`topparty2_attorney1_caseattytitle` AS `topparty2_attorney1_caseattytitle`,`case_party_attorneys_info`.`topparty2_attorney2_name` AS `topparty2_attorney2_name`,`case_party_attorneys_info`.`topparty2_attorney2_email` AS `topparty2_attorney2_email`,`case_party_attorneys_info`.`topparty2_attorney2_document_sign_name` AS `topparty2_attorney2_document_sign_name`,`case_party_attorneys_info`.`topparty2_attorney2_firm_name` AS `topparty2_attorney2_firm_name`,`case_party_attorneys_info`.`topparty2_attorney2_firm_street_address` AS `topparty2_attorney2_firm_street_address`,`case_party_attorneys_info`.`topparty2_attorney2_firm_suite_unit_mailcode` AS `topparty2_attorney2_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty2_attorney2_po_box` AS `topparty2_attorney2_po_box`,`case_party_attorneys_info`.`topparty2_attorney2_firm_city` AS `topparty2_attorney2_firm_city`,`case_party_attorneys_info`.`topparty2_attorney2_firm_state` AS `topparty2_attorney2_firm_state`,`case_party_attorneys_info`.`topparty2_attorney2_firm_county` AS `topparty2_attorney2_firm_county`,`case_party_attorneys_info`.`topparty2_attorney2_firm_zipcode` AS `topparty2_attorney2_firm_zipcode`,`case_party_attorneys_info`.`topparty2_attorney2_firm_telephone` AS `topparty2_attorney2_firm_telephone`,`case_party_attorneys_info`.`topparty2_attorney2_firm_fax` AS `topparty2_attorney2_firm_fax`,`case_party_attorneys_info`.`topparty2_attorney2_reg_1_num` AS `topparty2_attorney2_reg_1_num`,`case_party_attorneys_info`.`topparty2_attorney2_trial_attorney` AS `topparty2_attorney2_trial_attorney`,`case_party_attorneys_info`.`topparty2_attorney2_caseattytitle` AS `topparty2_attorney2_caseattytitle`,`case_party_attorneys_info`.`topparty2_attorney3_name` AS `topparty2_attorney3_name`,`case_party_attorneys_info`.`topparty2_attorney3_email` AS `topparty2_attorney3_email`,`case_party_attorneys_info`.`topparty2_attorney3_document_sign_name` AS `topparty2_attorney3_document_sign_name`,`case_party_attorneys_info`.`topparty2_attorney3_firm_name` AS `topparty2_attorney3_firm_name`,`case_party_attorneys_info`.`topparty2_attorney3_firm_street_address` AS `topparty2_attorney3_firm_street_address`,`case_party_attorneys_info`.`topparty2_attorney3_firm_suite_unit_mailcode` AS `topparty2_attorney3_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty2_attorney3_po_box` AS `topparty2_attorney3_po_box`,`case_party_attorneys_info`.`topparty2_attorney3_firm_city` AS `topparty2_attorney3_firm_city`,`case_party_attorneys_info`.`topparty2_attorney3_firm_state` AS `topparty2_attorney3_firm_state`,`case_party_attorneys_info`.`topparty2_attorney3_firm_county` AS `topparty2_attorney3_firm_county`,`case_party_attorneys_info`.`topparty2_attorney3_firm_zipcode` AS `topparty2_attorney3_firm_zipcode`,`case_party_attorneys_info`.`topparty2_attorney3_firm_telephone` AS `topparty2_attorney3_firm_telephone`,`case_party_attorneys_info`.`topparty2_attorney3_firm_fax` AS `topparty2_attorney3_firm_fax`,`case_party_attorneys_info`.`topparty2_attorney3_reg_1_num` AS `topparty2_attorney3_reg_1_num`,`case_party_attorneys_info`.`topparty2_attorney3_trial_attorney` AS `topparty2_attorney3_trial_attorney`,`case_party_attorneys_info`.`topparty2_attorney3_caseattytitle` AS `topparty2_attorney3_caseattytitle`,`case_party_attorneys_info`.`topparty3_attorney1_name` AS `topparty3_attorney1_name`,`case_party_attorneys_info`.`topparty3_attorney1_email` AS `topparty3_attorney1_email`,`case_party_attorneys_info`.`topparty3_attorney1_document_sign_name` AS `topparty3_attorney1_document_sign_name`,`case_party_attorneys_info`.`topparty3_attorney1_firm_name` AS `topparty3_attorney1_firm_name`,`case_party_attorneys_info`.`topparty3_attorney1_firm_street_address` AS `topparty3_attorney1_firm_street_address`,`case_party_attorneys_info`.`topparty3_attorney1_firm_suite_unit_mailcode` AS `topparty3_attorney1_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty3_attorney1_po_box` AS `topparty3_attorney1_po_box`,`case_party_attorneys_info`.`topparty3_attorney1_firm_city` AS `topparty3_attorney1_firm_city`,`case_party_attorneys_info`.`topparty3_attorney1_firm_state` AS `topparty3_attorney1_firm_state`,`case_party_attorneys_info`.`topparty3_attorney1_firm_county` AS `topparty3_attorney1_firm_county`,`case_party_attorneys_info`.`topparty3_attorney1_firm_zipcode` AS `topparty3_attorney1_firm_zipcode`,`case_party_attorneys_info`.`topparty3_attorney1_firm_telephone` AS `topparty3_attorney1_firm_telephone`,`case_party_attorneys_info`.`topparty3_attorney1_firm_fax` AS `topparty3_attorney1_firm_fax`,`case_party_attorneys_info`.`topparty3_attorney1_reg_1_num` AS `topparty3_attorney1_reg_1_num`,`case_party_attorneys_info`.`topparty3_attorney1_trial_attorney` AS `topparty3_attorney1_trial_attorney`,`case_party_attorneys_info`.`topparty3_attorney1_caseattytitle` AS `topparty3_attorney1_caseattytitle`,`case_party_attorneys_info`.`topparty3_attorney2_name` AS `topparty3_attorney2_name`,`case_party_attorneys_info`.`topparty3_attorney2_email` AS `topparty3_attorney2_email`,`case_party_attorneys_info`.`topparty3_attorney2_document_sign_name` AS `topparty3_attorney2_document_sign_name`,`case_party_attorneys_info`.`topparty3_attorney2_firm_name` AS `topparty3_attorney2_firm_name`,`case_party_attorneys_info`.`topparty3_attorney2_firm_street_address` AS `topparty3_attorney2_firm_street_address`,`case_party_attorneys_info`.`topparty3_attorney2_firm_suite_unit_mailcode` AS `topparty3_attorney2_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty3_attorney2_po_box` AS `topparty3_attorney2_po_box`,`case_party_attorneys_info`.`topparty3_attorney2_firm_city` AS `topparty3_attorney2_firm_city`,`case_party_attorneys_info`.`topparty3_attorney2_firm_state` AS `topparty3_attorney2_firm_state`,`case_party_attorneys_info`.`topparty3_attorney2_firm_county` AS `topparty3_attorney2_firm_county`,`case_party_attorneys_info`.`topparty3_attorney2_firm_zipcode` AS `topparty3_attorney2_firm_zipcode`,`case_party_attorneys_info`.`topparty3_attorney2_firm_telephone` AS `topparty3_attorney2_firm_telephone`,`case_party_attorneys_info`.`topparty3_attorney2_firm_fax` AS `topparty3_attorney2_firm_fax`,`case_party_attorneys_info`.`topparty3_attorney2_reg_1_num` AS `topparty3_attorney2_reg_1_num`,`case_party_attorneys_info`.`topparty3_attorney2_trial_attorney` AS `topparty3_attorney2_trial_attorney`,`case_party_attorneys_info`.`topparty3_attorney2_caseattytitle` AS `topparty3_attorney2_caseattytitle`,`case_party_attorneys_info`.`topparty3_attorney3_name` AS `topparty3_attorney3_name`,`case_party_attorneys_info`.`topparty3_attorney3_email` AS `topparty3_attorney3_email`,`case_party_attorneys_info`.`topparty3_attorney3_document_sign_name` AS `topparty3_attorney3_document_sign_name`,`case_party_attorneys_info`.`topparty3_attorney3_firm_name` AS `topparty3_attorney3_firm_name`,`case_party_attorneys_info`.`topparty3_attorney3_firm_street_address` AS `topparty3_attorney3_firm_street_address`,`case_party_attorneys_info`.`topparty3_attorney3_firm_suite_unit_mailcode` AS `topparty3_attorney3_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty3_attorney3_po_box` AS `topparty3_attorney3_po_box`,`case_party_attorneys_info`.`topparty3_attorney3_firm_city` AS `topparty3_attorney3_firm_city`,`case_party_attorneys_info`.`topparty3_attorney3_firm_state` AS `topparty3_attorney3_firm_state`,`case_party_attorneys_info`.`topparty3_attorney3_firm_county` AS `topparty3_attorney3_firm_county`,`case_party_attorneys_info`.`topparty3_attorney3_firm_zipcode` AS `topparty3_attorney3_firm_zipcode`,`case_party_attorneys_info`.`topparty3_attorney3_firm_telephone` AS `topparty3_attorney3_firm_telephone`,`case_party_attorneys_info`.`topparty3_attorney3_firm_fax` AS `topparty3_attorney3_firm_fax`,`case_party_attorneys_info`.`topparty3_attorney3_reg_1_num` AS `topparty3_attorney3_reg_1_num`,`case_party_attorneys_info`.`topparty3_attorney3_trial_attorney` AS `topparty3_attorney3_trial_attorney`,`case_party_attorneys_info`.`topparty3_attorney3_caseattytitle` AS `topparty3_attorney3_caseattytitle`,`case_party_attorneys_info`.`topparty4_attorney1_name` AS `topparty4_attorney1_name`,`case_party_attorneys_info`.`topparty4_attorney1_email` AS `topparty4_attorney1_email`,`case_party_attorneys_info`.`topparty4_attorney1_document_sign_name` AS `topparty4_attorney1_document_sign_name`,`case_party_attorneys_info`.`topparty4_attorney1_firm_name` AS `topparty4_attorney1_firm_name`,`case_party_attorneys_info`.`topparty4_attorney1_firm_street_address` AS `topparty4_attorney1_firm_street_address`,`case_party_attorneys_info`.`topparty4_attorney1_firm_suite_unit_mailcode` AS `topparty4_attorney1_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty4_attorney1_po_box` AS `topparty4_attorney1_po_box`,`case_party_attorneys_info`.`topparty4_attorney1_firm_city` AS `topparty4_attorney1_firm_city`,`case_party_attorneys_info`.`topparty4_attorney1_firm_state` AS `topparty4_attorney1_firm_state`,`case_party_attorneys_info`.`topparty4_attorney1_firm_county` AS `topparty4_attorney1_firm_county`,`case_party_attorneys_info`.`topparty4_attorney1_firm_zipcode` AS `topparty4_attorney1_firm_zipcode`,`case_party_attorneys_info`.`topparty4_attorney1_firm_telephone` AS `topparty4_attorney1_firm_telephone`,`case_party_attorneys_info`.`topparty4_attorney1_firm_fax` AS `topparty4_attorney1_firm_fax`,`case_party_attorneys_info`.`topparty4_attorney1_reg_1_num` AS `topparty4_attorney1_reg_1_num`,`case_party_attorneys_info`.`topparty4_attorney1_trial_attorney` AS `topparty4_attorney1_trial_attorney`,`case_party_attorneys_info`.`topparty4_attorney1_caseattytitle` AS `topparty4_attorney1_caseattytitle`,`case_party_attorneys_info`.`topparty4_attorney2_name` AS `topparty4_attorney2_name`,`case_party_attorneys_info`.`topparty4_attorney2_email` AS `topparty4_attorney2_email`,`case_party_attorneys_info`.`topparty4_attorney2_document_sign_name` AS `topparty4_attorney2_document_sign_name`,`case_party_attorneys_info`.`topparty4_attorney2_firm_name` AS `topparty4_attorney2_firm_name`,`case_party_attorneys_info`.`topparty4_attorney2_firm_street_address` AS `topparty4_attorney2_firm_street_address`,`case_party_attorneys_info`.`topparty4_attorney2_firm_suite_unit_mailcode` AS `topparty4_attorney2_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty4_attorney2_po_box` AS `topparty4_attorney2_po_box`,`case_party_attorneys_info`.`topparty4_attorney2_firm_city` AS `topparty4_attorney2_firm_city`,`case_party_attorneys_info`.`topparty4_attorney2_firm_state` AS `topparty4_attorney2_firm_state`,`case_party_attorneys_info`.`topparty4_attorney2_firm_county` AS `topparty4_attorney2_firm_county`,`case_party_attorneys_info`.`topparty4_attorney2_firm_zipcode` AS `topparty4_attorney2_firm_zipcode`,`case_party_attorneys_info`.`topparty4_attorney2_firm_telephone` AS `topparty4_attorney2_firm_telephone`,`case_party_attorneys_info`.`topparty4_attorney2_firm_fax` AS `topparty4_attorney2_firm_fax`,`case_party_attorneys_info`.`topparty4_attorney2_reg_1_num` AS `topparty4_attorney2_reg_1_num`,`case_party_attorneys_info`.`topparty4_attorney2_trial_attorney` AS `topparty4_attorney2_trial_attorney`,`case_party_attorneys_info`.`topparty4_attorney2_caseattytitle` AS `topparty4_attorney2_caseattytitle`,`case_party_attorneys_info`.`topparty4_attorney3_name` AS `topparty4_attorney3_name`,`case_party_attorneys_info`.`topparty4_attorney3_email` AS `topparty4_attorney3_email`,`case_party_attorneys_info`.`topparty4_attorney3_document_sign_name` AS `topparty4_attorney3_document_sign_name`,`case_party_attorneys_info`.`topparty4_attorney3_firm_name` AS `topparty4_attorney3_firm_name`,`case_party_attorneys_info`.`topparty4_attorney3_firm_street_address` AS `topparty4_attorney3_firm_street_address`,`case_party_attorneys_info`.`topparty4_attorney3_firm_suite_unit_mailcode` AS `topparty4_attorney3_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty4_attorney3_po_box` AS `topparty4_attorney3_po_box`,`case_party_attorneys_info`.`topparty4_attorney3_firm_city` AS `topparty4_attorney3_firm_city`,`case_party_attorneys_info`.`topparty4_attorney3_firm_state` AS `topparty4_attorney3_firm_state`,`case_party_attorneys_info`.`topparty4_attorney3_firm_county` AS `topparty4_attorney3_firm_county`,`case_party_attorneys_info`.`topparty4_attorney3_firm_zipcode` AS `topparty4_attorney3_firm_zipcode`,`case_party_attorneys_info`.`topparty4_attorney3_firm_telephone` AS `topparty4_attorney3_firm_telephone`,`case_party_attorneys_info`.`topparty4_attorney3_firm_fax` AS `topparty4_attorney3_firm_fax`,`case_party_attorneys_info`.`topparty4_attorney3_reg_1_num` AS `topparty4_attorney3_reg_1_num`,`case_party_attorneys_info`.`topparty4_attorney3_trial_attorney` AS `topparty4_attorney3_trial_attorney`,`case_party_attorneys_info`.`topparty4_attorney3_caseattytitle` AS `topparty4_attorney3_caseattytitle`,`case_party_attorneys_info`.`topparty5_attorney1_name` AS `topparty5_attorney1_name`,`case_party_attorneys_info`.`topparty5_attorney1_email` AS `topparty5_attorney1_email`,`case_party_attorneys_info`.`topparty5_attorney1_document_sign_name` AS `topparty5_attorney1_document_sign_name`,`case_party_attorneys_info`.`topparty5_attorney1_firm_name` AS `topparty5_attorney1_firm_name`,`case_party_attorneys_info`.`topparty5_attorney1_firm_street_address` AS `topparty5_attorney1_firm_street_address`,`case_party_attorneys_info`.`topparty5_attorney1_firm_suite_unit_mailcode` AS `topparty5_attorney1_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty5_attorney1_po_box` AS `topparty5_attorney1_po_box`,`case_party_attorneys_info`.`topparty5_attorney1_firm_city` AS `topparty5_attorney1_firm_city`,`case_party_attorneys_info`.`topparty5_attorney1_firm_state` AS `topparty5_attorney1_firm_state`,`case_party_attorneys_info`.`topparty5_attorney1_firm_county` AS `topparty5_attorney1_firm_county`,`case_party_attorneys_info`.`topparty5_attorney1_firm_zipcode` AS `topparty5_attorney1_firm_zipcode`,`case_party_attorneys_info`.`topparty5_attorney1_firm_telephone` AS `topparty5_attorney1_firm_telephone`,`case_party_attorneys_info`.`topparty5_attorney1_firm_fax` AS `topparty5_attorney1_firm_fax`,`case_party_attorneys_info`.`topparty5_attorney1_reg_1_num` AS `topparty5_attorney1_reg_1_num`,`case_party_attorneys_info`.`topparty5_attorney1_trial_attorney` AS `topparty5_attorney1_trial_attorney`,`case_party_attorneys_info`.`topparty5_attorney1_caseattytitle` AS `topparty5_attorney1_caseattytitle`,`case_party_attorneys_info`.`topparty5_attorney2_name` AS `topparty5_attorney2_name`,`case_party_attorneys_info`.`topparty5_attorney2_email` AS `topparty5_attorney2_email`,`case_party_attorneys_info`.`topparty5_attorney2_document_sign_name` AS `topparty5_attorney2_document_sign_name`,`case_party_attorneys_info`.`topparty5_attorney2_firm_name` AS `topparty5_attorney2_firm_name`,`case_party_attorneys_info`.`topparty5_attorney2_firm_street_address` AS `topparty5_attorney2_firm_street_address`,`case_party_attorneys_info`.`topparty5_attorney2_firm_suite_unit_mailcode` AS `topparty5_attorney2_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty5_attorney2_po_box` AS `topparty5_attorney2_po_box`,`case_party_attorneys_info`.`topparty5_attorney2_firm_city` AS `topparty5_attorney2_firm_city`,`case_party_attorneys_info`.`topparty5_attorney2_firm_state` AS `topparty5_attorney2_firm_state`,`case_party_attorneys_info`.`topparty5_attorney2_firm_county` AS `topparty5_attorney2_firm_county`,`case_party_attorneys_info`.`topparty5_attorney2_firm_zipcode` AS `topparty5_attorney2_firm_zipcode`,`case_party_attorneys_info`.`topparty5_attorney2_firm_telephone` AS `topparty5_attorney2_firm_telephone`,`case_party_attorneys_info`.`topparty5_attorney2_firm_fax` AS `topparty5_attorney2_firm_fax`,`case_party_attorneys_info`.`topparty5_attorney2_reg_1_num` AS `topparty5_attorney2_reg_1_num`,`case_party_attorneys_info`.`topparty5_attorney2_trial_attorney` AS `topparty5_attorney2_trial_attorney`,`case_party_attorneys_info`.`topparty5_attorney2_caseattytitle` AS `topparty5_attorney2_caseattytitle`,`case_party_attorneys_info`.`topparty5_attorney3_name` AS `topparty5_attorney3_name`,`case_party_attorneys_info`.`topparty5_attorney3_email` AS `topparty5_attorney3_email`,`case_party_attorneys_info`.`topparty5_attorney3_document_sign_name` AS `topparty5_attorney3_document_sign_name`,`case_party_attorneys_info`.`topparty5_attorney3_firm_name` AS `topparty5_attorney3_firm_name`,`case_party_attorneys_info`.`topparty5_attorney3_firm_street_address` AS `topparty5_attorney3_firm_street_address`,`case_party_attorneys_info`.`topparty5_attorney3_firm_suite_unit_mailcode` AS `topparty5_attorney3_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty5_attorney3_po_box` AS `topparty5_attorney3_po_box`,`case_party_attorneys_info`.`topparty5_attorney3_firm_city` AS `topparty5_attorney3_firm_city`,`case_party_attorneys_info`.`topparty5_attorney3_firm_state` AS `topparty5_attorney3_firm_state`,`case_party_attorneys_info`.`topparty5_attorney3_firm_county` AS `topparty5_attorney3_firm_county`,`case_party_attorneys_info`.`topparty5_attorney3_firm_zipcode` AS `topparty5_attorney3_firm_zipcode`,`case_party_attorneys_info`.`topparty5_attorney3_firm_telephone` AS `topparty5_attorney3_firm_telephone`,`case_party_attorneys_info`.`topparty5_attorney3_firm_fax` AS `topparty5_attorney3_firm_fax`,`case_party_attorneys_info`.`topparty5_attorney3_reg_1_num` AS `topparty5_attorney3_reg_1_num`,`case_party_attorneys_info`.`topparty5_attorney3_trial_attorney` AS `topparty5_attorney3_trial_attorney`,`case_party_attorneys_info`.`topparty5_attorney3_caseattytitle` AS `topparty5_attorney3_caseattytitle`,`case_party_attorneys_info`.`topparty6_attorney1_name` AS `topparty6_attorney1_name`,`case_party_attorneys_info`.`topparty6_attorney1_email` AS `topparty6_attorney1_email`,`case_party_attorneys_info`.`topparty6_attorney1_document_sign_name` AS `topparty6_attorney1_document_sign_name`,`case_party_attorneys_info`.`topparty6_attorney1_firm_name` AS `topparty6_attorney1_firm_name`,`case_party_attorneys_info`.`topparty6_attorney1_firm_street_address` AS `topparty6_attorney1_firm_street_address`,`case_party_attorneys_info`.`topparty6_attorney1_firm_suite_unit_mailcode` AS `topparty6_attorney1_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty6_attorney1_po_box` AS `topparty6_attorney1_po_box`,`case_party_attorneys_info`.`topparty6_attorney1_firm_city` AS `topparty6_attorney1_firm_city`,`case_party_attorneys_info`.`topparty6_attorney1_firm_state` AS `topparty6_attorney1_firm_state`,`case_party_attorneys_info`.`topparty6_attorney1_firm_county` AS `topparty6_attorney1_firm_county`,`case_party_attorneys_info`.`topparty6_attorney1_firm_zipcode` AS `topparty6_attorney1_firm_zipcode`,`case_party_attorneys_info`.`topparty6_attorney1_firm_telephone` AS `topparty6_attorney1_firm_telephone`,`case_party_attorneys_info`.`topparty6_attorney1_firm_fax` AS `topparty6_attorney1_firm_fax`,`case_party_attorneys_info`.`topparty6_attorney1_reg_1_num` AS `topparty6_attorney1_reg_1_num`,`case_party_attorneys_info`.`topparty6_attorney1_trial_attorney` AS `topparty6_attorney1_trial_attorney`,`case_party_attorneys_info`.`topparty6_attorney1_caseattytitle` AS `topparty6_attorney1_caseattytitle`,`case_party_attorneys_info`.`topparty6_attorney2_name` AS `topparty6_attorney2_name`,`case_party_attorneys_info`.`topparty6_attorney2_email` AS `topparty6_attorney2_email`,`case_party_attorneys_info`.`topparty6_attorney2_document_sign_name` AS `topparty6_attorney2_document_sign_name`,`case_party_attorneys_info`.`topparty6_attorney2_firm_name` AS `topparty6_attorney2_firm_name`,`case_party_attorneys_info`.`topparty6_attorney2_firm_street_address` AS `topparty6_attorney2_firm_street_address`,`case_party_attorneys_info`.`topparty6_attorney2_firm_suite_unit_mailcode` AS `topparty6_attorney2_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty6_attorney2_po_box` AS `topparty6_attorney2_po_box`,`case_party_attorneys_info`.`topparty6_attorney2_firm_city` AS `topparty6_attorney2_firm_city`,`case_party_attorneys_info`.`topparty6_attorney2_firm_state` AS `topparty6_attorney2_firm_state`,`case_party_attorneys_info`.`topparty6_attorney2_firm_county` AS `topparty6_attorney2_firm_county`,`case_party_attorneys_info`.`topparty6_attorney2_firm_zipcode` AS `topparty6_attorney2_firm_zipcode`,`case_party_attorneys_info`.`topparty6_attorney2_firm_telephone` AS `topparty6_attorney2_firm_telephone`,`case_party_attorneys_info`.`topparty6_attorney2_firm_fax` AS `topparty6_attorney2_firm_fax`,`case_party_attorneys_info`.`topparty6_attorney2_reg_1_num` AS `topparty6_attorney2_reg_1_num`,`case_party_attorneys_info`.`topparty6_attorney2_trial_attorney` AS `topparty6_attorney2_trial_attorney`,`case_party_attorneys_info`.`topparty6_attorney2_caseattytitle` AS `topparty6_attorney2_caseattytitle`,`case_party_attorneys_info`.`topparty6_attorney3_name` AS `topparty6_attorney3_name`,`case_party_attorneys_info`.`topparty6_attorney3_email` AS `topparty6_attorney3_email`,`case_party_attorneys_info`.`topparty6_attorney3_document_sign_name` AS `topparty6_attorney3_document_sign_name`,`case_party_attorneys_info`.`topparty6_attorney3_firm_name` AS `topparty6_attorney3_firm_name`,`case_party_attorneys_info`.`topparty6_attorney3_firm_street_address` AS `topparty6_attorney3_firm_street_address`,`case_party_attorneys_info`.`topparty6_attorney3_firm_suite_unit_mailcode` AS `topparty6_attorney3_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`topparty6_attorney3_po_box` AS `topparty6_attorney3_po_box`,`case_party_attorneys_info`.`topparty6_attorney3_firm_city` AS `topparty6_attorney3_firm_city`,`case_party_attorneys_info`.`topparty6_attorney3_firm_state` AS `topparty6_attorney3_firm_state`,`case_party_attorneys_info`.`topparty6_attorney3_firm_county` AS `topparty6_attorney3_firm_county`,`case_party_attorneys_info`.`topparty6_attorney3_firm_zipcode` AS `topparty6_attorney3_firm_zipcode`,`case_party_attorneys_info`.`topparty6_attorney3_firm_telephone` AS `topparty6_attorney3_firm_telephone`,`case_party_attorneys_info`.`topparty6_attorney3_firm_fax` AS `topparty6_attorney3_firm_fax`,`case_party_attorneys_info`.`topparty6_attorney3_reg_1_num` AS `topparty6_attorney3_reg_1_num`,`case_party_attorneys_info`.`topparty6_attorney3_trial_attorney` AS `topparty6_attorney3_trial_attorney`,`case_party_attorneys_info`.`topparty6_attorney3_caseattytitle` AS `topparty6_attorney3_caseattytitle`,`case_party_attorneys_info`.`bottomparty1_attorney1_name` AS `bottomparty1_attorney1_name`,`case_party_attorneys_info`.`bottomparty1_attorney1_email` AS `bottomparty1_attorney1_email`,`case_party_attorneys_info`.`bottomparty1_attorney1_document_sign_name` AS `bottomparty1_attorney1_document_sign_name`,`case_party_attorneys_info`.`bottomparty1_attorney1_firm_name` AS `bottomparty1_attorney1_firm_name`,`case_party_attorneys_info`.`bottomparty1_attorney1_firm_street_address` AS `bottomparty1_attorney1_firm_street_address`,`case_party_attorneys_info`.`bottomparty1_attorney1_firm_suite_unit_mailcode` AS `bottomparty1_attorney1_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty1_attorney1_po_box` AS `bottomparty1_attorney1_po_box`,`case_party_attorneys_info`.`bottomparty1_attorney1_firm_city` AS `bottomparty1_attorney1_firm_city`,`case_party_attorneys_info`.`bottomparty1_attorney1_firm_state` AS `bottomparty1_attorney1_firm_state`,`case_party_attorneys_info`.`bottomparty1_attorney1_firm_county` AS `bottomparty1_attorney1_firm_county`,`case_party_attorneys_info`.`bottomparty1_attorney1_firm_zipcode` AS `bottomparty1_attorney1_firm_zipcode`,`case_party_attorneys_info`.`bottomparty1_attorney1_firm_telephone` AS `bottomparty1_attorney1_firm_telephone`,`case_party_attorneys_info`.`bottomparty1_attorney1_firm_fax` AS `bottomparty1_attorney1_firm_fax`,`case_party_attorneys_info`.`bottomparty1_attorney1_reg_1_num` AS `bottomparty1_attorney1_reg_1_num`,`case_party_attorneys_info`.`bottomparty1_attorney1_trial_attorney` AS `bottomparty1_attorney1_trial_attorney`,`case_party_attorneys_info`.`bottomparty1_attorney1_caseattytitle` AS `bottomparty1_attorney1_caseattytitle`,`case_party_attorneys_info`.`bottomparty1_attorney2_name` AS `bottomparty1_attorney2_name`,`case_party_attorneys_info`.`bottomparty1_attorney2_email` AS `bottomparty1_attorney2_email`,`case_party_attorneys_info`.`bottomparty1_attorney2_document_sign_name` AS `bottomparty1_attorney2_document_sign_name`,`case_party_attorneys_info`.`bottomparty1_attorney2_firm_name` AS `bottomparty1_attorney2_firm_name`,`case_party_attorneys_info`.`bottomparty1_attorney2_firm_street_address` AS `bottomparty1_attorney2_firm_street_address`,`case_party_attorneys_info`.`bottomparty1_attorney2_firm_suite_unit_mailcode` AS `bottomparty1_attorney2_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty1_attorney2_po_box` AS `bottomparty1_attorney2_po_box`,`case_party_attorneys_info`.`bottomparty1_attorney2_firm_city` AS `bottomparty1_attorney2_firm_city`,`case_party_attorneys_info`.`bottomparty1_attorney2_firm_state` AS `bottomparty1_attorney2_firm_state`,`case_party_attorneys_info`.`bottomparty1_attorney2_firm_county` AS `bottomparty1_attorney2_firm_county`,`case_party_attorneys_info`.`bottomparty1_attorney2_firm_zipcode` AS `bottomparty1_attorney2_firm_zipcode`,`case_party_attorneys_info`.`bottomparty1_attorney2_firm_telephone` AS `bottomparty1_attorney2_firm_telephone`,`case_party_attorneys_info`.`bottomparty1_attorney2_firm_fax` AS `bottomparty1_attorney2_firm_fax`,`case_party_attorneys_info`.`bottomparty1_attorney2_reg_1_num` AS `bottomparty1_attorney2_reg_1_num`,`case_party_attorneys_info`.`bottomparty1_attorney2_trial_attorney` AS `bottomparty1_attorney2_trial_attorney`,`case_party_attorneys_info`.`bottomparty1_attorney2_caseattytitle` AS `bottomparty1_attorney2_caseattytitle`,`case_party_attorneys_info`.`bottomparty1_attorney3_name` AS `bottomparty1_attorney3_name`,`case_party_attorneys_info`.`bottomparty1_attorney3_email` AS `bottomparty1_attorney3_email`,`case_party_attorneys_info`.`bottomparty1_attorney3_document_sign_name` AS `bottomparty1_attorney3_document_sign_name`,`case_party_attorneys_info`.`bottomparty1_attorney3_firm_name` AS `bottomparty1_attorney3_firm_name`,`case_party_attorneys_info`.`bottomparty1_attorney3_firm_street_address` AS `bottomparty1_attorney3_firm_street_address`,`case_party_attorneys_info`.`bottomparty1_attorney3_firm_suite_unit_mailcode` AS `bottomparty1_attorney3_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty1_attorney3_po_box` AS `bottomparty1_attorney3_po_box`,`case_party_attorneys_info`.`bottomparty1_attorney3_firm_city` AS `bottomparty1_attorney3_firm_city`,`case_party_attorneys_info`.`bottomparty1_attorney3_firm_state` AS `bottomparty1_attorney3_firm_state`,`case_party_attorneys_info`.`bottomparty1_attorney3_firm_county` AS `bottomparty1_attorney3_firm_county`,`case_party_attorneys_info`.`bottomparty1_attorney3_firm_zipcode` AS `bottomparty1_attorney3_firm_zipcode`,`case_party_attorneys_info`.`bottomparty1_attorney3_firm_telephone` AS `bottomparty1_attorney3_firm_telephone`,`case_party_attorneys_info`.`bottomparty1_attorney3_firm_fax` AS `bottomparty1_attorney3_firm_fax`,`case_party_attorneys_info`.`bottomparty1_attorney3_reg_1_num` AS `bottomparty1_attorney3_reg_1_num`,`case_party_attorneys_info`.`bottomparty1_attorney3_trial_attorney` AS `bottomparty1_attorney3_trial_attorney`,`case_party_attorneys_info`.`bottomparty1_attorney3_caseattytitle` AS `bottomparty1_attorney3_caseattytitle`,`case_party_attorneys_info`.`bottomparty2_attorney1_name` AS `bottomparty2_attorney1_name`,`case_party_attorneys_info`.`bottomparty2_attorney1_email` AS `bottomparty2_attorney1_email`,`case_party_attorneys_info`.`bottomparty2_attorney1_document_sign_name` AS `bottomparty2_attorney1_document_sign_name`,`case_party_attorneys_info`.`bottomparty2_attorney1_firm_name` AS `bottomparty2_attorney1_firm_name`,`case_party_attorneys_info`.`bottomparty2_attorney1_firm_street_address` AS `bottomparty2_attorney1_firm_street_address`,`case_party_attorneys_info`.`bottomparty2_attorney1_firm_suite_unit_mailcode` AS `bottomparty2_attorney1_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty2_attorney1_po_box` AS `bottomparty2_attorney1_po_box`,`case_party_attorneys_info`.`bottomparty2_attorney1_firm_city` AS `bottomparty2_attorney1_firm_city`,`case_party_attorneys_info`.`bottomparty2_attorney1_firm_state` AS `bottomparty2_attorney1_firm_state`,`case_party_attorneys_info`.`bottomparty2_attorney1_firm_county` AS `bottomparty2_attorney1_firm_county`,`case_party_attorneys_info`.`bottomparty2_attorney1_firm_zipcode` AS `bottomparty2_attorney1_firm_zipcode`,`case_party_attorneys_info`.`bottomparty2_attorney1_firm_telephone` AS `bottomparty2_attorney1_firm_telephone`,`case_party_attorneys_info`.`bottomparty2_attorney1_firm_fax` AS `bottomparty2_attorney1_firm_fax`,`case_party_attorneys_info`.`bottomparty2_attorney1_reg_1_num` AS `bottomparty2_attorney1_reg_1_num`,`case_party_attorneys_info`.`bottomparty2_attorney1_trial_attorney` AS `bottomparty2_attorney1_trial_attorney`,`case_party_attorneys_info`.`bottomparty2_attorney1_caseattytitle` AS `bottomparty2_attorney1_caseattytitle`,`case_party_attorneys_info`.`bottomparty2_attorney2_name` AS `bottomparty2_attorney2_name`,`case_party_attorneys_info`.`bottomparty2_attorney2_email` AS `bottomparty2_attorney2_email`,`case_party_attorneys_info`.`bottomparty2_attorney2_document_sign_name` AS `bottomparty2_attorney2_document_sign_name`,`case_party_attorneys_info`.`bottomparty2_attorney2_firm_name` AS `bottomparty2_attorney2_firm_name`,`case_party_attorneys_info`.`bottomparty2_attorney2_firm_street_address` AS `bottomparty2_attorney2_firm_street_address`,`case_party_attorneys_info`.`bottomparty2_attorney2_firm_suite_unit_mailcode` AS `bottomparty2_attorney2_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty2_attorney2_po_box` AS `bottomparty2_attorney2_po_box`,`case_party_attorneys_info`.`bottomparty2_attorney2_firm_city` AS `bottomparty2_attorney2_firm_city`,`case_party_attorneys_info`.`bottomparty2_attorney2_firm_state` AS `bottomparty2_attorney2_firm_state`,`case_party_attorneys_info`.`bottomparty2_attorney2_firm_county` AS `bottomparty2_attorney2_firm_county`,`case_party_attorneys_info`.`bottomparty2_attorney2_firm_zipcode` AS `bottomparty2_attorney2_firm_zipcode`,`case_party_attorneys_info`.`bottomparty2_attorney2_firm_telephone` AS `bottomparty2_attorney2_firm_telephone`,`case_party_attorneys_info`.`bottomparty2_attorney2_firm_fax` AS `bottomparty2_attorney2_firm_fax`,`case_party_attorneys_info`.`bottomparty2_attorney2_reg_1_num` AS `bottomparty2_attorney2_reg_1_num`,`case_party_attorneys_info`.`bottomparty2_attorney2_trial_attorney` AS `bottomparty2_attorney2_trial_attorney`,`case_party_attorneys_info`.`bottomparty2_attorney2_caseattytitle` AS `bottomparty2_attorney2_caseattytitle`,`case_party_attorneys_info`.`bottomparty2_attorney3_name` AS `bottomparty2_attorney3_name`,`case_party_attorneys_info`.`bottomparty2_attorney3_email` AS `bottomparty2_attorney3_email`,`case_party_attorneys_info`.`bottomparty2_attorney3_document_sign_name` AS `bottomparty2_attorney3_document_sign_name`,`case_party_attorneys_info`.`bottomparty2_attorney3_firm_name` AS `bottomparty2_attorney3_firm_name`,`case_party_attorneys_info`.`bottomparty2_attorney3_firm_street_address` AS `bottomparty2_attorney3_firm_street_address`,`case_party_attorneys_info`.`bottomparty2_attorney3_firm_suite_unit_mailcode` AS `bottomparty2_attorney3_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty2_attorney3_po_box` AS `bottomparty2_attorney3_po_box`,`case_party_attorneys_info`.`bottomparty2_attorney3_firm_city` AS `bottomparty2_attorney3_firm_city`,`case_party_attorneys_info`.`bottomparty2_attorney3_firm_state` AS `bottomparty2_attorney3_firm_state`,`case_party_attorneys_info`.`bottomparty2_attorney3_firm_county` AS `bottomparty2_attorney3_firm_county`,`case_party_attorneys_info`.`bottomparty2_attorney3_firm_zipcode` AS `bottomparty2_attorney3_firm_zipcode`,`case_party_attorneys_info`.`bottomparty2_attorney3_firm_telephone` AS `bottomparty2_attorney3_firm_telephone`,`case_party_attorneys_info`.`bottomparty2_attorney3_firm_fax` AS `bottomparty2_attorney3_firm_fax`,`case_party_attorneys_info`.`bottomparty2_attorney3_reg_1_num` AS `bottomparty2_attorney3_reg_1_num`,`case_party_attorneys_info`.`bottomparty2_attorney3_trial_attorney` AS `bottomparty2_attorney3_trial_attorney`,`case_party_attorneys_info`.`bottomparty2_attorney3_caseattytitle` AS `bottomparty2_attorney3_caseattytitle`,`case_party_attorneys_info`.`bottomparty3_attorney1_name` AS `bottomparty3_attorney1_name`,`case_party_attorneys_info`.`bottomparty3_attorney1_email` AS `bottomparty3_attorney1_email`,`case_party_attorneys_info`.`bottomparty3_attorney1_document_sign_name` AS `bottomparty3_attorney1_document_sign_name`,`case_party_attorneys_info`.`bottomparty3_attorney1_firm_name` AS `bottomparty3_attorney1_firm_name`,`case_party_attorneys_info`.`bottomparty3_attorney1_firm_street_address` AS `bottomparty3_attorney1_firm_street_address`,`case_party_attorneys_info`.`bottomparty3_attorney1_firm_suite_unit_mailcode` AS `bottomparty3_attorney1_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty3_attorney1_po_box` AS `bottomparty3_attorney1_po_box`,`case_party_attorneys_info`.`bottomparty3_attorney1_firm_city` AS `bottomparty3_attorney1_firm_city`,`case_party_attorneys_info`.`bottomparty3_attorney1_firm_state` AS `bottomparty3_attorney1_firm_state`,`case_party_attorneys_info`.`bottomparty3_attorney1_firm_county` AS `bottomparty3_attorney1_firm_county`,`case_party_attorneys_info`.`bottomparty3_attorney1_firm_zipcode` AS `bottomparty3_attorney1_firm_zipcode`,`case_party_attorneys_info`.`bottomparty3_attorney1_firm_telephone` AS `bottomparty3_attorney1_firm_telephone`,`case_party_attorneys_info`.`bottomparty3_attorney1_firm_fax` AS `bottomparty3_attorney1_firm_fax`,`case_party_attorneys_info`.`bottomparty3_attorney1_reg_1_num` AS `bottomparty3_attorney1_reg_1_num`,`case_party_attorneys_info`.`bottomparty3_attorney1_trial_attorney` AS `bottomparty3_attorney1_trial_attorney`,`case_party_attorneys_info`.`bottomparty3_attorney1_caseattytitle` AS `bottomparty3_attorney1_caseattytitle`,`case_party_attorneys_info`.`bottomparty3_attorney2_name` AS `bottomparty3_attorney2_name`,`case_party_attorneys_info`.`bottomparty3_attorney2_email` AS `bottomparty3_attorney2_email`,`case_party_attorneys_info`.`bottomparty3_attorney2_document_sign_name` AS `bottomparty3_attorney2_document_sign_name`,`case_party_attorneys_info`.`bottomparty3_attorney2_firm_name` AS `bottomparty3_attorney2_firm_name`,`case_party_attorneys_info`.`bottomparty3_attorney2_firm_street_address` AS `bottomparty3_attorney2_firm_street_address`,`case_party_attorneys_info`.`bottomparty3_attorney2_firm_suite_unit_mailcode` AS `bottomparty3_attorney2_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty3_attorney2_po_box` AS `bottomparty3_attorney2_po_box`,`case_party_attorneys_info`.`bottomparty3_attorney2_firm_city` AS `bottomparty3_attorney2_firm_city`,`case_party_attorneys_info`.`bottomparty3_attorney2_firm_state` AS `bottomparty3_attorney2_firm_state`,`case_party_attorneys_info`.`bottomparty3_attorney2_firm_county` AS `bottomparty3_attorney2_firm_county`,`case_party_attorneys_info`.`bottomparty3_attorney2_firm_zipcode` AS `bottomparty3_attorney2_firm_zipcode`,`case_party_attorneys_info`.`bottomparty3_attorney2_firm_telephone` AS `bottomparty3_attorney2_firm_telephone`,`case_party_attorneys_info`.`bottomparty3_attorney2_firm_fax` AS `bottomparty3_attorney2_firm_fax`,`case_party_attorneys_info`.`bottomparty3_attorney2_reg_1_num` AS `bottomparty3_attorney2_reg_1_num`,`case_party_attorneys_info`.`bottomparty3_attorney2_trial_attorney` AS `bottomparty3_attorney2_trial_attorney`,`case_party_attorneys_info`.`bottomparty3_attorney2_caseattytitle` AS `bottomparty3_attorney2_caseattytitle`,`case_party_attorneys_info`.`bottomparty3_attorney3_name` AS `bottomparty3_attorney3_name`,`case_party_attorneys_info`.`bottomparty3_attorney3_email` AS `bottomparty3_attorney3_email`,`case_party_attorneys_info`.`bottomparty3_attorney3_document_sign_name` AS `bottomparty3_attorney3_document_sign_name`,`case_party_attorneys_info`.`bottomparty3_attorney3_firm_name` AS `bottomparty3_attorney3_firm_name`,`case_party_attorneys_info`.`bottomparty3_attorney3_firm_street_address` AS `bottomparty3_attorney3_firm_street_address`,`case_party_attorneys_info`.`bottomparty3_attorney3_firm_suite_unit_mailcode` AS `bottomparty3_attorney3_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty3_attorney3_po_box` AS `bottomparty3_attorney3_po_box`,`case_party_attorneys_info`.`bottomparty3_attorney3_firm_city` AS `bottomparty3_attorney3_firm_city`,`case_party_attorneys_info`.`bottomparty3_attorney3_firm_state` AS `bottomparty3_attorney3_firm_state`,`case_party_attorneys_info`.`bottomparty3_attorney3_firm_county` AS `bottomparty3_attorney3_firm_county`,`case_party_attorneys_info`.`bottomparty3_attorney3_firm_zipcode` AS `bottomparty3_attorney3_firm_zipcode`,`case_party_attorneys_info`.`bottomparty3_attorney3_firm_telephone` AS `bottomparty3_attorney3_firm_telephone`,`case_party_attorneys_info`.`bottomparty3_attorney3_firm_fax` AS `bottomparty3_attorney3_firm_fax`,`case_party_attorneys_info`.`bottomparty3_attorney3_reg_1_num` AS `bottomparty3_attorney3_reg_1_num`,`case_party_attorneys_info`.`bottomparty3_attorney3_trial_attorney` AS `bottomparty3_attorney3_trial_attorney`,`case_party_attorneys_info`.`bottomparty3_attorney3_caseattytitle` AS `bottomparty3_attorney3_caseattytitle`,`case_party_attorneys_info`.`bottomparty4_attorney1_name` AS `bottomparty4_attorney1_name`,`case_party_attorneys_info`.`bottomparty4_attorney1_email` AS `bottomparty4_attorney1_email`,`case_party_attorneys_info`.`bottomparty4_attorney1_document_sign_name` AS `bottomparty4_attorney1_document_sign_name`,`case_party_attorneys_info`.`bottomparty4_attorney1_firm_name` AS `bottomparty4_attorney1_firm_name`,`case_party_attorneys_info`.`bottomparty4_attorney1_firm_street_address` AS `bottomparty4_attorney1_firm_street_address`,`case_party_attorneys_info`.`bottomparty4_attorney1_firm_suite_unit_mailcode` AS `bottomparty4_attorney1_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty4_attorney1_po_box` AS `bottomparty4_attorney1_po_box`,`case_party_attorneys_info`.`bottomparty4_attorney1_firm_city` AS `bottomparty4_attorney1_firm_city`,`case_party_attorneys_info`.`bottomparty4_attorney1_firm_state` AS `bottomparty4_attorney1_firm_state`,`case_party_attorneys_info`.`bottomparty4_attorney1_firm_county` AS `bottomparty4_attorney1_firm_county`,`case_party_attorneys_info`.`bottomparty4_attorney1_firm_zipcode` AS `bottomparty4_attorney1_firm_zipcode`,`case_party_attorneys_info`.`bottomparty4_attorney1_firm_telephone` AS `bottomparty4_attorney1_firm_telephone`,`case_party_attorneys_info`.`bottomparty4_attorney1_firm_fax` AS `bottomparty4_attorney1_firm_fax`,`case_party_attorneys_info`.`bottomparty4_attorney1_reg_1_num` AS `bottomparty4_attorney1_reg_1_num`,`case_party_attorneys_info`.`bottomparty4_attorney1_trial_attorney` AS `bottomparty4_attorney1_trial_attorney`,`case_party_attorneys_info`.`bottomparty4_attorney1_caseattytitle` AS `bottomparty4_attorney1_caseattytitle`,`case_party_attorneys_info`.`bottomparty4_attorney2_name` AS `bottomparty4_attorney2_name`,`case_party_attorneys_info`.`bottomparty4_attorney2_email` AS `bottomparty4_attorney2_email`,`case_party_attorneys_info`.`bottomparty4_attorney2_document_sign_name` AS `bottomparty4_attorney2_document_sign_name`,`case_party_attorneys_info`.`bottomparty4_attorney2_firm_name` AS `bottomparty4_attorney2_firm_name`,`case_party_attorneys_info`.`bottomparty4_attorney2_firm_street_address` AS `bottomparty4_attorney2_firm_street_address`,`case_party_attorneys_info`.`bottomparty4_attorney2_firm_suite_unit_mailcode` AS `bottomparty4_attorney2_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty4_attorney2_po_box` AS `bottomparty4_attorney2_po_box`,`case_party_attorneys_info`.`bottomparty4_attorney2_firm_city` AS `bottomparty4_attorney2_firm_city`,`case_party_attorneys_info`.`bottomparty4_attorney2_firm_state` AS `bottomparty4_attorney2_firm_state`,`case_party_attorneys_info`.`bottomparty4_attorney2_firm_county` AS `bottomparty4_attorney2_firm_county`,`case_party_attorneys_info`.`bottomparty4_attorney2_firm_zipcode` AS `bottomparty4_attorney2_firm_zipcode`,`case_party_attorneys_info`.`bottomparty4_attorney2_firm_telephone` AS `bottomparty4_attorney2_firm_telephone`,`case_party_attorneys_info`.`bottomparty4_attorney2_firm_fax` AS `bottomparty4_attorney2_firm_fax`,`case_party_attorneys_info`.`bottomparty4_attorney2_reg_1_num` AS `bottomparty4_attorney2_reg_1_num`,`case_party_attorneys_info`.`bottomparty4_attorney2_trial_attorney` AS `bottomparty4_attorney2_trial_attorney`,`case_party_attorneys_info`.`bottomparty4_attorney2_caseattytitle` AS `bottomparty4_attorney2_caseattytitle`,`case_party_attorneys_info`.`bottomparty4_attorney3_name` AS `bottomparty4_attorney3_name`,`case_party_attorneys_info`.`bottomparty4_attorney3_email` AS `bottomparty4_attorney3_email`,`case_party_attorneys_info`.`bottomparty4_attorney3_document_sign_name` AS `bottomparty4_attorney3_document_sign_name`,`case_party_attorneys_info`.`bottomparty4_attorney3_firm_name` AS `bottomparty4_attorney3_firm_name`,`case_party_attorneys_info`.`bottomparty4_attorney3_firm_street_address` AS `bottomparty4_attorney3_firm_street_address`,`case_party_attorneys_info`.`bottomparty4_attorney3_firm_suite_unit_mailcode` AS `bottomparty4_attorney3_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty4_attorney3_po_box` AS `bottomparty4_attorney3_po_box`,`case_party_attorneys_info`.`bottomparty4_attorney3_firm_city` AS `bottomparty4_attorney3_firm_city`,`case_party_attorneys_info`.`bottomparty4_attorney3_firm_state` AS `bottomparty4_attorney3_firm_state`,`case_party_attorneys_info`.`bottomparty4_attorney3_firm_county` AS `bottomparty4_attorney3_firm_county`,`case_party_attorneys_info`.`bottomparty4_attorney3_firm_zipcode` AS `bottomparty4_attorney3_firm_zipcode`,`case_party_attorneys_info`.`bottomparty4_attorney3_firm_telephone` AS `bottomparty4_attorney3_firm_telephone`,`case_party_attorneys_info`.`bottomparty4_attorney3_firm_fax` AS `bottomparty4_attorney3_firm_fax`,`case_party_attorneys_info`.`bottomparty4_attorney3_reg_1_num` AS `bottomparty4_attorney3_reg_1_num`,`case_party_attorneys_info`.`bottomparty4_attorney3_trial_attorney` AS `bottomparty4_attorney3_trial_attorney`,`case_party_attorneys_info`.`bottomparty4_attorney3_caseattytitle` AS `bottomparty4_attorney3_caseattytitle`,`case_party_attorneys_info`.`bottomparty5_attorney1_name` AS `bottomparty5_attorney1_name`,`case_party_attorneys_info`.`bottomparty5_attorney1_email` AS `bottomparty5_attorney1_email`,`case_party_attorneys_info`.`bottomparty5_attorney1_document_sign_name` AS `bottomparty5_attorney1_document_sign_name`,`case_party_attorneys_info`.`bottomparty5_attorney1_firm_name` AS `bottomparty5_attorney1_firm_name`,`case_party_attorneys_info`.`bottomparty5_attorney1_firm_street_address` AS `bottomparty5_attorney1_firm_street_address`,`case_party_attorneys_info`.`bottomparty5_attorney1_firm_suite_unit_mailcode` AS `bottomparty5_attorney1_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty5_attorney1_po_box` AS `bottomparty5_attorney1_po_box`,`case_party_attorneys_info`.`bottomparty5_attorney1_firm_city` AS `bottomparty5_attorney1_firm_city`,`case_party_attorneys_info`.`bottomparty5_attorney1_firm_state` AS `bottomparty5_attorney1_firm_state`,`case_party_attorneys_info`.`bottomparty5_attorney1_firm_county` AS `bottomparty5_attorney1_firm_county`,`case_party_attorneys_info`.`bottomparty5_attorney1_firm_zipcode` AS `bottomparty5_attorney1_firm_zipcode`,`case_party_attorneys_info`.`bottomparty5_attorney1_firm_telephone` AS `bottomparty5_attorney1_firm_telephone`,`case_party_attorneys_info`.`bottomparty5_attorney1_firm_fax` AS `bottomparty5_attorney1_firm_fax`,`case_party_attorneys_info`.`bottomparty5_attorney1_reg_1_num` AS `bottomparty5_attorney1_reg_1_num`,`case_party_attorneys_info`.`bottomparty5_attorney1_trial_attorney` AS `bottomparty5_attorney1_trial_attorney`,`case_party_attorneys_info`.`bottomparty5_attorney1_caseattytitle` AS `bottomparty5_attorney1_caseattytitle`,`case_party_attorneys_info`.`bottomparty5_attorney2_name` AS `bottomparty5_attorney2_name`,`case_party_attorneys_info`.`bottomparty5_attorney2_email` AS `bottomparty5_attorney2_email`,`case_party_attorneys_info`.`bottomparty5_attorney2_document_sign_name` AS `bottomparty5_attorney2_document_sign_name`,`case_party_attorneys_info`.`bottomparty5_attorney2_firm_name` AS `bottomparty5_attorney2_firm_name`,`case_party_attorneys_info`.`bottomparty5_attorney2_firm_street_address` AS `bottomparty5_attorney2_firm_street_address`,`case_party_attorneys_info`.`bottomparty5_attorney2_firm_suite_unit_mailcode` AS `bottomparty5_attorney2_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty5_attorney2_po_box` AS `bottomparty5_attorney2_po_box`,`case_party_attorneys_info`.`bottomparty5_attorney2_firm_city` AS `bottomparty5_attorney2_firm_city`,`case_party_attorneys_info`.`bottomparty5_attorney2_firm_state` AS `bottomparty5_attorney2_firm_state`,`case_party_attorneys_info`.`bottomparty5_attorney2_firm_county` AS `bottomparty5_attorney2_firm_county`,`case_party_attorneys_info`.`bottomparty5_attorney2_firm_zipcode` AS `bottomparty5_attorney2_firm_zipcode`,`case_party_attorneys_info`.`bottomparty5_attorney2_firm_telephone` AS `bottomparty5_attorney2_firm_telephone`,`case_party_attorneys_info`.`bottomparty5_attorney2_firm_fax` AS `bottomparty5_attorney2_firm_fax`,`case_party_attorneys_info`.`bottomparty5_attorney2_reg_1_num` AS `bottomparty5_attorney2_reg_1_num`,`case_party_attorneys_info`.`bottomparty5_attorney2_trial_attorney` AS `bottomparty5_attorney2_trial_attorney`,`case_party_attorneys_info`.`bottomparty5_attorney2_caseattytitle` AS `bottomparty5_attorney2_caseattytitle`,`case_party_attorneys_info`.`bottomparty5_attorney3_name` AS `bottomparty5_attorney3_name`,`case_party_attorneys_info`.`bottomparty5_attorney3_email` AS `bottomparty5_attorney3_email`,`case_party_attorneys_info`.`bottomparty5_attorney3_document_sign_name` AS `bottomparty5_attorney3_document_sign_name`,`case_party_attorneys_info`.`bottomparty5_attorney3_firm_name` AS `bottomparty5_attorney3_firm_name`,`case_party_attorneys_info`.`bottomparty5_attorney3_firm_street_address` AS `bottomparty5_attorney3_firm_street_address`,`case_party_attorneys_info`.`bottomparty5_attorney3_firm_suite_unit_mailcode` AS `bottomparty5_attorney3_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty5_attorney3_po_box` AS `bottomparty5_attorney3_po_box`,`case_party_attorneys_info`.`bottomparty5_attorney3_firm_city` AS `bottomparty5_attorney3_firm_city`,`case_party_attorneys_info`.`bottomparty5_attorney3_firm_state` AS `bottomparty5_attorney3_firm_state`,`case_party_attorneys_info`.`bottomparty5_attorney3_firm_county` AS `bottomparty5_attorney3_firm_county`,`case_party_attorneys_info`.`bottomparty5_attorney3_firm_zipcode` AS `bottomparty5_attorney3_firm_zipcode`,`case_party_attorneys_info`.`bottomparty5_attorney3_firm_telephone` AS `bottomparty5_attorney3_firm_telephone`,`case_party_attorneys_info`.`bottomparty5_attorney3_firm_fax` AS `bottomparty5_attorney3_firm_fax`,`case_party_attorneys_info`.`bottomparty5_attorney3_reg_1_num` AS `bottomparty5_attorney3_reg_1_num`,`case_party_attorneys_info`.`bottomparty5_attorney3_trial_attorney` AS `bottomparty5_attorney3_trial_attorney`,`case_party_attorneys_info`.`bottomparty5_attorney3_caseattytitle` AS `bottomparty5_attorney3_caseattytitle`,`case_party_attorneys_info`.`bottomparty6_attorney1_name` AS `bottomparty6_attorney1_name`,`case_party_attorneys_info`.`bottomparty6_attorney1_email` AS `bottomparty6_attorney1_email`,`case_party_attorneys_info`.`bottomparty6_attorney1_document_sign_name` AS `bottomparty6_attorney1_document_sign_name`,`case_party_attorneys_info`.`bottomparty6_attorney1_firm_name` AS `bottomparty6_attorney1_firm_name`,`case_party_attorneys_info`.`bottomparty6_attorney1_firm_street_address` AS `bottomparty6_attorney1_firm_street_address`,`case_party_attorneys_info`.`bottomparty6_attorney1_firm_suite_unit_mailcode` AS `bottomparty6_attorney1_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty6_attorney1_po_box` AS `bottomparty6_attorney1_po_box`,`case_party_attorneys_info`.`bottomparty6_attorney1_firm_city` AS `bottomparty6_attorney1_firm_city`,`case_party_attorneys_info`.`bottomparty6_attorney1_firm_state` AS `bottomparty6_attorney1_firm_state`,`case_party_attorneys_info`.`bottomparty6_attorney1_firm_county` AS `bottomparty6_attorney1_firm_county`,`case_party_attorneys_info`.`bottomparty6_attorney1_firm_zipcode` AS `bottomparty6_attorney1_firm_zipcode`,`case_party_attorneys_info`.`bottomparty6_attorney1_firm_telephone` AS `bottomparty6_attorney1_firm_telephone`,`case_party_attorneys_info`.`bottomparty6_attorney1_firm_fax` AS `bottomparty6_attorney1_firm_fax`,`case_party_attorneys_info`.`bottomparty6_attorney1_reg_1_num` AS `bottomparty6_attorney1_reg_1_num`,`case_party_attorneys_info`.`bottomparty6_attorney1_trial_attorney` AS `bottomparty6_attorney1_trial_attorney`,`case_party_attorneys_info`.`bottomparty6_attorney1_caseattytitle` AS `bottomparty6_attorney1_caseattytitle`,`case_party_attorneys_info`.`bottomparty6_attorney2_name` AS `bottomparty6_attorney2_name`,`case_party_attorneys_info`.`bottomparty6_attorney2_email` AS `bottomparty6_attorney2_email`,`case_party_attorneys_info`.`bottomparty6_attorney2_document_sign_name` AS `bottomparty6_attorney2_document_sign_name`,`case_party_attorneys_info`.`bottomparty6_attorney2_firm_name` AS `bottomparty6_attorney2_firm_name`,`case_party_attorneys_info`.`bottomparty6_attorney2_firm_street_address` AS `bottomparty6_attorney2_firm_street_address`,`case_party_attorneys_info`.`bottomparty6_attorney2_firm_suite_unit_mailcode` AS `bottomparty6_attorney2_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty6_attorney2_po_box` AS `bottomparty6_attorney2_po_box`,`case_party_attorneys_info`.`bottomparty6_attorney2_firm_city` AS `bottomparty6_attorney2_firm_city`,`case_party_attorneys_info`.`bottomparty6_attorney2_firm_state` AS `bottomparty6_attorney2_firm_state`,`case_party_attorneys_info`.`bottomparty6_attorney2_firm_county` AS `bottomparty6_attorney2_firm_county`,`case_party_attorneys_info`.`bottomparty6_attorney2_firm_zipcode` AS `bottomparty6_attorney2_firm_zipcode`,`case_party_attorneys_info`.`bottomparty6_attorney2_firm_telephone` AS `bottomparty6_attorney2_firm_telephone`,`case_party_attorneys_info`.`bottomparty6_attorney2_firm_fax` AS `bottomparty6_attorney2_firm_fax`,`case_party_attorneys_info`.`bottomparty6_attorney2_reg_1_num` AS `bottomparty6_attorney2_reg_1_num`,`case_party_attorneys_info`.`bottomparty6_attorney2_trial_attorney` AS `bottomparty6_attorney2_trial_attorney`,`case_party_attorneys_info`.`bottomparty6_attorney2_caseattytitle` AS `bottomparty6_attorney2_caseattytitle`,`case_party_attorneys_info`.`bottomparty6_attorney3_name` AS `bottomparty6_attorney3_name`,`case_party_attorneys_info`.`bottomparty6_attorney3_email` AS `bottomparty6_attorney3_email`,`case_party_attorneys_info`.`bottomparty6_attorney3_document_sign_name` AS `bottomparty6_attorney3_document_sign_name`,`case_party_attorneys_info`.`bottomparty6_attorney3_firm_name` AS `bottomparty6_attorney3_firm_name`,`case_party_attorneys_info`.`bottomparty6_attorney3_firm_street_address` AS `bottomparty6_attorney3_firm_street_address`,`case_party_attorneys_info`.`bottomparty6_attorney3_firm_suite_unit_mailcode` AS `bottomparty6_attorney3_firm_suite_unit_mailcode`,`case_party_attorneys_info`.`bottomparty6_attorney3_po_box` AS `bottomparty6_attorney3_po_box`,`case_party_attorneys_info`.`bottomparty6_attorney3_firm_city` AS `bottomparty6_attorney3_firm_city`,`case_party_attorneys_info`.`bottomparty6_attorney3_firm_state` AS `bottomparty6_attorney3_firm_state`,`case_party_attorneys_info`.`bottomparty6_attorney3_firm_county` AS `bottomparty6_attorney3_firm_county`,`case_party_attorneys_info`.`bottomparty6_attorney3_firm_zipcode` AS `bottomparty6_attorney3_firm_zipcode`,`case_party_attorneys_info`.`bottomparty6_attorney3_firm_telephone` AS `bottomparty6_attorney3_firm_telephone`,`case_party_attorneys_info`.`bottomparty6_attorney3_firm_fax` AS `bottomparty6_attorney3_firm_fax`,`case_party_attorneys_info`.`bottomparty6_attorney3_reg_1_num` AS `bottomparty6_attorney3_reg_1_num`,`case_party_attorneys_info`.`bottomparty6_attorney3_trial_attorney` AS `bottomparty6_attorney3_trial_attorney`,`case_party_attorneys_info`.`bottomparty6_attorney3_caseattytitle` AS `bottomparty6_attorney3_caseattytitle` from (((`courtcases` join `attorneys` on(`courtcases`.`attorney_id` = `attorneys`.`user_id`)) left join `case_parties_info` on(`case_parties_info`.`case_id` = `courtcases`.`id`)) left join `case_party_attorneys_info` on(`case_party_attorneys_info`.`case_id` = `courtcases`.`id` )) where `courtcases`.`id` = ? ",[$case_id]);

        $yourname = "hegwgeri";
        global $court_name;
        global $division_name;
        global $courtcase_attorney_firm_tagline;
        $court_name = ($row[0]->court_name) ? $row[0]->court_name : '';

        $division_name = ($row[0]->division_name)? $row[0]->division_name : '';

        $courtcase_attorney_firm_tagline = ($row[0]->courtcase_attorney_firm_tagline) ? $row[0]->courtcase_attorney_firm_tagline : 'not found';
        global $courtcase_attorney_firm_street_address;
        $courtcase_attorney_firm_street_address = ($row[0]->courtcase_attorney_firm_street_address) ? $row[0]->courtcase_attorney_firm_street_address : 'fsd' ;
        global $courtcase_attorney_firm_suite_unit_mailcode;
        $courtcase_attorney_firm_suite_unit_mailcode = ($row[0]->courtcase_attorney_firm_suite_unit_mailcode) ? $row[0]->courtcase_attorney_firm_suite_unit_mailcode : 'not found';
        global $courtcase_attorney_po_box;
        $courtcase_attorney_po_box = ($row[0]->courtcase_attorney_po_box) ? $row[0]->courtcase_attorney_po_box : 'not found' ;
        global $courtcase_attorney_firm_city;
        $courtcase_attorney_firm_city = ($row[0]->courtcase_attorney_firm_city) ? $row[0]->courtcase_attorney_firm_city : 'not found';
        global $courtcase_attorney_firm_state;
        $courtcase_attorney_firm_state = ($row[0]->courtcase_attorney_firm_state) ? $row[0]->courtcase_attorney_firm_state : 'not found';
        global $courtcase_attorney_firm_zipcode;
        $courtcase_attorney_firm_zipcode = ($row[0]->courtcase_attorney_firm_zipcode) ?  $row[0]->courtcase_attorney_firm_zipcode : 'not found';
        global $courtcase_attorney_firm_telephone;
        $courtcase_attorney_firm_telephone = ($row[0]->courtcase_attorney_firm_telephone) ? $row[0]->courtcase_attorney_firm_telephone : 'not found' ;
        global $courtcase_attorney_firm_fax;
        $courtcase_attorney_firm_fax = ($row[0]->courtcase_attorney_firm_fax) ? $row[0]->courtcase_attorney_firm_fax : 'not found';
        global $courtcase_attorney_email;
        $courtcase_attorney_email = ($row[0]->courtcase_attorney_email) ? $row[0]->courtcase_attorney_email : 'not found';
        global $courtcase_clerkname;
        $courtcase_clerkname = ($row[0]->courtcase_clerkname) ? $row[0]->courtcase_clerkname : 'not found';
        global $courtcase_clerktitle;
        $courtcase_clerktitle = ($row[0]->courtcase_clerktitle) ? $row[0]->courtcase_clerktitle : 'not found' ;
        global $street_address;
        $street_address = ($row[0]->street_address) ? $row[0]->street_address : 'not found';
        global $street_address2;
        $street_address2 = ($row[0]->street_address2) ? $row[0]->street_address2 : 'not found';
        global $city;
        $city = ($row[0]->city) ? $row[0]->city : 'not found';
        global $state;
        $state = ($row[0]->state) ? $row[0]->state : 'not found';
        global $zip;
        $zip = ($row[0]->zip) ? $row[0]->zip : 'not found';
        global $fax;
        $fax = ($row[0]->fax) ? $row[0]->fax : 'not found';
        global $phone;
        $phone = ($row[0]->phone) ? $row[0]->phone : 'not found';
        global $courtcase_clerkname;
        $courtcase_clerkname = ($row[0]->courtcase_clerkname) ? $row[0]->courtcase_clerkname : 'not found' ;
        global $courtcase_clerktitle;
        $courtcase_clerktitle = ($row[0]->courtcase_clerktitle) ? $row[0]->courtcase_clerktitle : 'not found';
        global $courtcase_attorney_firm_fax;
        $courtcase_attorney_firm_fax = ($row[0]->courtcase_attorney_firm_fax) ? $row[0]->courtcase_attorney_firm_fax :'not found';
        global $courtcase_attorney_firm_telephone;
        $courtcase_attorney_firm_telephone = ($row[0]->courtcase_attorney_firm_telephone) ?  $row[0]->courtcase_attorney_firm_telephone : 'not found';
        global $courtcase_attorney_doc_sign_name;
        $courtcase_attorney_doc_sign_name = ($row[0]->courtcase_attorney_doc_sign_name) ? $row[0]->courtcase_attorney_doc_sign_name : 'not found';
        global $courtcase_attorney_firm_name;
        $courtcase_attorney_firm_name = ($row[0]->courtcase_attorney_firm_name) ? $row[0]->courtcase_attorney_firm_name : 'not found';
        global $topparty1_name;
        $topparty1_name = ($row[0]->topparty1_name) ? $row[0]->topparty1_name : 'not found';
        global $topparty1_street_address;
        $topparty1_street_address = ($row[0]->topparty1_street_address) ? $row[0]->topparty1_street_address : 'not found';
        global $topparty1_city_name;
        $topparty1_city_name = ($row[0]->topparty1_city_name) ? $row[0]->topparty1_city_name : 'not found';
        global $topparty1_state_name;
        $topparty1_state_name = ($row[0]->topparty1_state_name) ? $row[0]->topparty1_state_name : 'not found';
        global $topparty1_zipcode;
        $topparty1_zipcode = ($row[0]->topparty1_zipcode) ? $row[0]->topparty1_zipcode : 'not found';
        global $bottomparty1_name;
        $bottomparty1_name = ($row[0]->bottomparty1_name) ? $row[0]->bottomparty1_name : 'not found' ;
        global $bottomparty1_street_address;
        $bottomparty1_street_address = ($row[0]->bottomparty1_street_address) ? $row[0]->bottomparty1_street_address : 'not found';
        global $bottomparty1_city_name;
        $bottomparty1_city_name = ($row[0]->bottomparty1_city_name) ? $row[0]->bottomparty1_city_name : 'not found' ;
        global $bottomparty1_state_name;
        $bottomparty1_state_name = ($row[0]->bottomparty1_state_name) ? $row[0]->bottomparty1_state_name : 'not found';
        global $bottomparty1_zipcode;
        $bottomparty1_zipcode = ($row[0]->bottomparty1_zipcode) ? $row[0]->bottomparty1_zipcode : 'not found';
        global $topparty2_name;
        $topparty2_name = ($row[0]->topparty2_name) ? $row[0]->topparty2_name : 'not found';
        global $topparty2_street_address;
        $topparty2_street_address = ($row[0]->topparty2_street_address) ? $row[0]->topparty2_street_address : 'not found';
        global $topparty2_city_name;
        $topparty2_city_name = ($row[0]->topparty2_city_name) ? $row[0]->topparty2_city_name : 'not found' ;
        global $topparty2_state_name;
        $topparty2_state_name = ($row[0]->topparty2_state_name) ? $row[0]->topparty2_state_name : 'not found' ;
        global $topparty2_zipcode;
        $topparty2_zipcode = ($row[0]->topparty2_zipcode) ? $row[0]->topparty2_zipcode : 'not found';
        global $bottomparty2_name;
        $bottomparty2_name = ($row[0]->bottomparty2_name) ? $row[0]->bottomparty2_name: 'not found';
        global $bottomparty2_street_address;
        $bottomparty2_street_address = ($row[0]->bottomparty2_street_address) ? $row[0]->bottomparty2_street_address : 'not found' ;
        global $bottomparty2_city_name;
        $bottomparty2_city_name = ($row[0]->bottomparty2_city_name) ? $row[0]->bottomparty2_city_name:'not found' ;
        global $bottomparty2_state_name;
        $bottomparty2_state_name = ($row[0]->bottomparty2_state_name) ? $row[0]->bottomparty2_state_name : 'not found';
        global $bottomparty2_zipcode;
        $bottomparty2_zipcode = ($row[0]->bottomparty2_zipcode) ? $row[0]->bottomparty2_zipcode : 'not found';
        global $topparty3_name;
        $topparty3_name = ($row[0]->topparty3_name) ? $row[0]->topparty3_name : 'not found';
        global $topparty3_street_address;
        $topparty3_street_address = ($row[0]->topparty3_street_address) ? $row[0]->topparty3_street_address : 'not found';
        global $topparty3_city_name;
        $topparty3_city_name = ($row[0]->topparty3_city_name) ? $row[0]->topparty3_city_name : 'not found';
        global $topparty3_state_name;
        $topparty3_state_name = ($row[0]->topparty3_state_name) ? $row[0]->topparty3_state_name : 'not found';
        global $topparty3_zipcode;
        $topparty3_zipcode = ($row[0]->topparty3_zipcode) ? $row[0]->topparty3_zipcode : 'not found' ;
        global $bottomparty3_name;
        $bottomparty3_name = ($row[0]->bottomparty3_name) ? $row[0]->bottomparty3_name : 'not found';
        global $bottomparty3_street_address;
        $bottomparty3_street_address = ($row[0]->bottomparty3_street_address) ? $row[0]->bottomparty3_street_address : 'not found';
        global $bottomparty3_city_name;
        $bottomparty3_city_name = ($row[0]->bottomparty3_city_name) ? $row[0]->bottomparty3_city_name : 'not found';
        global $bottomparty3_state_name;
        $bottomparty3_state_name = ($row[0]->bottomparty3_state_name) ? $row[0]->bottomparty3_state_name : 'not found' ;
        global $bottomparty3_zipcode;
        $bottomparty3_zipcode = ($row[0]->bottomparty3_zipcode) ? $row[0]->bottomparty3_zipcode : 'not found';
        global $topparty4_name;
        $topparty4_name = ($row[0]->topparty4_name) ? $row[0]->topparty4_name : 'not found' ;
        global $topparty4_street_address;
        $topparty4_street_address = ($row[0]->topparty4_street_address) ? $row[0]->topparty4_street_address : 'not found' ;
        global $topparty4_city_name;
        $topparty4_city_name = ($row[0]->topparty4_city_name) ? $row[0]->topparty4_city_name : 'not found';
        global $topparty4_state_name;
        $topparty4_state_name = ($row[0]->topparty4_state_name) ? $row[0]->topparty4_state_name : 'not found';
        global $topparty4_zipcode;
        $topparty4_zipcode = ($row[0]->topparty4_zipcode) ? $row[0]->topparty4_zipcode: 'not found';
        global $bottomparty4_name;
        $bottomparty4_name = ($row[0]->bottomparty4_name) ? $row[0]->bottomparty4_name : 'not found';
        global $bottomparty4_street_address;
        $bottomparty4_street_address = ($row[0]->bottomparty4_street_address) ? $row[0]->bottomparty4_street_address : 'not found';
        global $bottomparty4_city_name;
        $bottomparty4_city_name = ($row[0]->bottomparty4_city_name) ? $row[0]->bottomparty4_city_name : 'not found';
        global $bottomparty4_state_name;
        $bottomparty4_state_name = ($row[0]->bottomparty4_state_name) ? $row[0]->bottomparty4_state_name : 'not found';
        global $bottomparty4_zipcode;
        $bottomparty4_zipcode = ($row[0]->bottomparty4_zipcode) ? $row[0]->bottomparty4_zipcode: 'not found';
        global $topparty5_name;
        $topparty5_name = ($row[0]->topparty5_name) ? $row[0]->topparty5_name : 'not found';
        global $topparty5_street_address;
        $topparty5_street_address = ($row[0]->topparty5_street_address) ? $row[0]->topparty5_street_address : 'not found';
        global $topparty5_city_name;
        $topparty5_city_name = ($row[0]->topparty5_city_name) ? $row[0]->topparty5_city_name : 'not found' ;
        global $topparty5_state_name;
        $topparty5_state_name = ($row[0]->topparty5_state_name) ? $row[0]->topparty5_state_name : 'not found' ;
        global $topparty5_zipcode;
        $topparty5_zipcode = ($row[0]->topparty5_zipcode) ? $row[0]->topparty5_zipcode : 'not found';
        global $bottomparty5_name;
        $bottomparty5_name = ($row[0]->bottomparty5_name) ? $row[0]->bottomparty5_name : 'not found';
        global $bottomparty5_street_address;
        $bottomparty5_street_address = ($row[0]->bottomparty5_street_address) ? $row[0]->bottomparty5_street_address : 'not found';
        global $bottomparty5_city_name;
        $bottomparty5_city_name = ($row[0]->bottomparty5_city_name) ? $row[0]->bottomparty5_city_name : 'not found';
        global $bottomparty5_state_name;
        $bottomparty5_state_name = ($row[0]->bottomparty5_state_name) ? $row[0]->bottomparty5_state_name : 'not found';
        global $bottomparty5_zipcode;
        $bottomparty5_zipcode = ($row[0]->bottomparty5_zipcode) ? $row[0]->bottomparty5_zipcode : 'not found';
        global $topparty6_name;
        $topparty6_name = ($row[0]->topparty6_name) ? $row[0]->topparty6_name : 'not found';
        global $topparty6_street_address;
        $topparty6_street_address = ($row[0]->topparty6_street_address) ? $row[0]->topparty6_street_address : 'not found';
        global $topparty6_city_name;
        $topparty6_city_name = ($row[0]->topparty6_city_name) ? $row[0]->topparty6_city_name : 'not found';
        global $topparty6_state_name;
        $topparty6_state_name =($row[0]->topparty6_state_name) ? $row[0]->topparty6_state_name :'not found';
        global $topparty6_zipcode;
        $topparty6_zipcode= ($row[0]->topparty6_zipcode) ? $row[0]->topparty6_zipcode : 'not found';
        global $bottomparty6_name;
        $bottomparty6_name = ($row[0]->bottomparty6_name) ? $row[0]->bottomparty6_name : 'not found';
        global $bottomparty6_street_address;
        $bottomparty6_street_address = ($row[0]->bottomparty6_street_address) ? $row[0]->bottomparty6_street_address : 'not found';
        global $bottomparty6_city_name;
        $bottomparty6_city_name = ($row[0]->bottomparty6_city_name) ? $row[0]->bottomparty6_city_name : 'not found';
        global $bottomparty6_state_name;
        $bottomparty6_state_name = ($row[0]->bottomparty6_state_name) ? $row[0]->bottomparty6_state_name : 'not found';
        global $bottomparty6_zipcode;
        $bottomparty6_zipcode = ($row[0]->bottomparty6_zipcode) ? $row[0]->bottomparty6_zipcode : 'not found' ;
        global $case_number;
        $case_number = ($row[0]->case_number) ? $row[0]->case_number : 'not found';

        $template  = public_path('/thinyputstrong/demo_ms_word.docx');
        $TBS->LoadTemplate($template,OPENTBS_ALREADY_UTF8);
        // replace variables
       // $TBS->MergeField('client', array('name' => 'Ford Prefect'));
        // send the file
        $save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';

        $output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template);
         // Delete comments
            $TBS->PlugIn(OPENTBS_DELETE_COMMENTS);

            $TBS->Show(OPENTBS_DOWNLOAD,$output_file_name);
            exit("document download successfully'");
        }
        else{
            exit("please add case id in url like as ?case_id=22.");
         }
    }

public function demorecoll(Request $request){
    $output_array = array();

    if($request->search){
   $output = shell_exec("recollq -b 'Orchard'");


    $output = str_replace(".pdf",".pdf ",$output);
    $output = str_replace(".zip",".zip ",$output);
   $output_array = explode(" ",$output);
   $output_array = array_filter($output_array);

//    print_r($output_array);die();
    }



  return view('recollmanage',compact('output_array'));
  }

public function UploadNewDocument(Request $request){
    return view('uploadnewdocument');
}

public function UploadDocument(Request $request){

    CustomerUploads::Formvalidation($request);

    if($request->has('upload_document')){

        $destinationPath = public_path('/uiodirs/OrchardSubmissions/');
        $image = $request->file('upload_document');
        $name = $image->getClientOriginalName();
        if($image->move($destinationPath,$name))
        {
           $custom_upload = new CustomerUploads;
           $custom_upload->document_title =  $request->document_title;
           $custom_upload->upload_document = $name;
            $custom_upload->user_id = Auth::user()->id;
            $custom_upload->save();
            return redirect()->route('uploadnewdocument')->with('success','Document Uploaded successfully');

        }else{
            return redirect()->route('uploadnewdocument')->with('error','Document not Uploaded successfully');
        }
    }
}




}
