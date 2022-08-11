<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\State;
use App\CasePaymentPackage;
use App\County;
use App\Attorney;
use App\Courtcase;
use App\DrChildren;
use App\Clerk;
use Auth;
use Carbon\Carbon;

class AjaxController extends Controller

{
    /* This controller is for ajax methods to fetch data from database */

    public function get_states()
    {
    	$states= State::all()->pluck('state','id');
    	
        if($states)
        {
	    	echo json_encode($states);
    	} else {
            echo "null";
        }
    }

    public function get_counties_by_state(Request $request)
    {
    	$id=$request->id;
        if(isset($request->advertise_id) && !empty($request->advertise_id)){
             $listing = DB::table('advertiser_listings')->where('advertiser_id',$request->advertise_id)->get()->pluck('county_id');
             $get_counties= County::where('state_id',$id)->whereNotIn('id',$listing)->get()->pluck('county_name','id');

        }else{
            $get_counties= County::where('state_id',$id)->get()->pluck('county_name','id');    
        }
    	
    	
        if($get_counties)
        {
	    	echo json_encode($get_counties);
    	} else {
            echo "null";
        }
    }

    public function get_causes_of_action(Request $request){
        $option_id = $request->option_id;
        $division_id = $request->devision_id;
        $case_type = DB::table('case_types')->where('id',$option_id)->first();
        $option_name = $case_type->case_type;
        $get_aution = DB::table('causes_of_action')->join('divcoa_corr_table','divcoa_corr_table.coa_id','=','causes_of_action.coa_id')->where(['case_type'=>$option_name,'divcoa_corr_table.ct_division_id'=>$division_id])->select('causes_of_action.coa','causes_of_action.coa_id')->orderBy('ct_division_id','ASC')->get();
       
        if($get_aution){
            echo json_encode($get_aution);
        }else{
            echo "null";
        }

    }
    public function get_attorney_by_reg_num(Request $request)
    {
        $reg_num=$request->reg_num;
        $state_id=$request->state_id;
        // $get_attornies = DB::table('attorney_table_active')
        //                         ->where([['ohregnum', '=', $reg_num],['state_id', '=', $state_id],])
        //                         ->orWhere([['ohioregistrationnumber', '=', $reg_num],['state_id', '=', $state_id],])
        //                         ->first();
         $get_attornies = DB::table('attorney_table_active')
                                // ->where([['registrationnumber_state1', $reg_num],['registration_state_id', $state_id]])
                                    //->where([['registrationnumber', $request->reg_num],['registration_state_id', $request->state_id]])
                                    ->where('registrationnumber',$request->reg_num)
                                    ->orWhere('registrationnumber_state1',$request->reg_num)
                                    ->where('registration_state_id',$request->state_id)
                                ->first();
        
        if($get_attornies)
        {
            echo json_encode($get_attornies);
        } else {
            echo "null";
        }
    }
    /******************Get list of addess using clerk id**********************/
    public function getClerkdatabyclerkid(Request $request){

        $court_id = $request->court_id;
        $clerk_name = $request->clerk_id;
        $country_id = $request->country_id;
        $division_id=$request->division_id;
        $clerk_data = DB::table('clerks')->where('clerkname',$clerk_name)->first();
        $clerk_id = $clerk_data->id;
        $clerk_title = $clerk_data->clerktitle;
         $court_correlation_table_data = DB::table('court_correlation_table')
        ->where([['court_id', $court_id],['division_id', $division_id],['clerk_id', $clerk_id],['county_id',$country_id]])
        ->get()->all();
        $output=array();
        if($court_correlation_table_data){
            foreach($court_correlation_table_data as $key=>$val){
            $val->clerk_title = $clerk_title;
        }
            $output['court_correlation_table_data'] = $court_correlation_table_data;
        }else{
            $output['court_correlation_table_data'] = 'null';
        }

        echo json_encode($output);
    }
    /************ Get attorney data from checkbox ******/

    public function get_attorney_by_checkbox(Request $request){
        $id = $request->id;
        $reg = $request->reg_num;
        $state_id=$request->state_id;
        $attorney=User::find($id);
        //$attorney_data = User::find($id)->attorney;
        
        $attorney_active_data = DB::table('attorneys')->where(['attorney_reg_1_num'=>$reg,'user_id'=>$id])->first();
        
        /*if($attorney_data){
          $attorney_active_data=DB::table('attorney_table_active')
                              ->where([['registrationnumber', $attorney_data->attorney_reg_1_num],['registration_state_id', $state_id]])
                              // ->orWhere('registrationnumber_state1', $attorney_data->attorney_reg_1_num)
                              ->first();
          print_r($attorney_active_data);
          die;*/
         if($attorney_active_data){
            echo json_encode($attorney_active_data);
         }else{
            echo "null";
         }

       
    }

    /**************** following functions are for case registration steps ****************/

    public function getCityStateCountyByZipCode(Request $request){
        $zip=$request->zip;
        $data = DB::table('zipcodes')
            ->join('states', 'zipcodes.state_id', '=', 'states.id')
            ->join('counties', [['zipcodes.county_name', '=', 'counties.county_name'],['zipcodes.state_id', '=', 'counties.state_id']])
            ->where('zipcodes.zipcode', '=', $zip)
            ->select('zipcodes.city', 'zipcodes.state_id','states.state', 'counties.id','counties.county_name')
            ->get();
        if($data)
        {
            echo json_encode($data);
        } else {
            echo "null";
        }
    }

    public function getLanguages(){
        $get_languages = DB::table('languages')->get()->pluck('language');
        if($get_languages)
        {
            echo json_encode($get_languages);
        } else {
            echo "null";
        }
    }

    /* Get Active States for attorneys for which he has purchased the state seat license */
    public function getActiveStates(){
        $user=User::find(Auth::user()->id);
        $attorney_states=array();
        if($user->active=='1' && $user->subscribed('second_state_seat_license_plan') && $user->subscribed('third_state_seat_license_plan')){
            $attorney_states=Attorney::where('user_id', $user->id)
                            ->get(['attorney_reg_1_state_id', 'attorney_reg_2_state_id', 'attorney_reg_3_state_id'])->first();
        }elseif($user->active=='1' && $user->subscribed('second_state_seat_license_plan') && !$user->subscribed('third_state_seat_license_plan')){
            $attorney_states=Attorney::where('user_id', $user->id)
                            ->get(['attorney_reg_1_state_id', 'attorney_reg_2_state_id'])->first();
        } elseif($user->active=='1' && !$user->subscribed('second_state_seat_license_plan') && $user->subscribed('third_state_seat_license_plan')){
            $attorney_states=Attorney::where('user_id', $user->id)
                            ->get(['attorney_reg_1_state_id', 'attorney_reg_3_state_id'])->first();
        } elseif($user->active=='1' && !$user->subscribed('second_state_seat_license_plan') && !$user->subscribed('third_state_seat_license_plan')){
            $attorney_states=Attorney::where('user_id', $user->id)
                            ->get(['attorney_reg_1_state_id'])->first();
        }

        $get_active_states = DB::table('states')
        ->whereIn('id', $attorney_states)
        ->get()->pluck('state','id');
        if($get_active_states)
        {
            echo json_encode($get_active_states);
        } else {
            echo "null";
        }
    }

    /* Get List of states with status active=1 */
    public function getDBActiveStates(){

        $get_active_states = DB::table('states')
        ->where('active', '1')
        ->get()->pluck('state','state_abbreviation');
        if($get_active_states)
        {
            echo json_encode($get_active_states);
        } else {
            echo "null";
        }
    }

    /* Get list of courts based on County and State */
    public function getCourtByCountyState(Request $request){
        $county_id=$request->county_id;
        $state_id=$request->state_id;
        $get_courts = DB::table('court_correlation_table')
        ->where([['state_id', $state_id],['county_id', $county_id]])
        ->get()->pluck('court','court_id');
        if(count($get_courts))
        {
            echo json_encode($get_courts);
        } else {
            echo "null";
        }
    }

    /* Get list of divisions based on Court */
    public function getDivisionByCourt(Request $request){
        $court_id=$request->court_id;
        $get_divisions = DB::table('court_correlation_table')
        ->where('court_id', $court_id)
        ->distinct()->get()->pluck('court_division','division_id');
        if(count($get_divisions))
        {
            echo json_encode($get_divisions);
        } else {
            echo "null";
        }
    }

    /* Get list of courts based on County and State */
    public function getAffidavitCourtByCountyState(Request $request){
        $county_id=$request->county_id;
        $state_id=$request->state_id;
        $division_ids=['6', '7', '8'];
        $get_courts = DB::table('court_correlation_table')
        ->where([['state_id', $state_id],['county_id', $county_id]])
        ->whereIn('division_id', $division_ids)
        ->get()->pluck('court','court_id');
        if(count($get_courts))
        {
            echo json_encode($get_courts);
        } else {
            echo "null";
        }
    }

    /* Get list of divisions based on Court */
    public function getAffidavitDivisionByCourt(Request $request){
        $court_id=$request->court_id;
        $division_ids=['6', '7', '8'];
        $get_divisions = DB::table('court_correlation_table')
        ->where('court_id', $court_id)
        ->whereIn('division_id', $division_ids)
        ->distinct()->get()->pluck('court_division','division_id');
        if(count($get_divisions))
        {
            echo json_encode($get_divisions);
        } else {
            echo "null";
        }
    }

    /* Get list of Judges nd Magistrates based on Court and Division */
    public function getJudgeMagistrateCaseTypeByCourtDiv(Request $request){
        $court_id=$request->court_id;
        $division_id=$request->division_id;
        // to fetch judges
        $court_correlation_table_data = DB::table('court_correlation_table')
        ->where([['court_id', $court_id],['division_id', $division_id]])
        ->get()->all();
        $judge_ids = array_column($court_correlation_table_data, 'judge_id');
        $clerk_ids = array_column($court_correlation_table_data, 'clerk_id');
        $output=array();
        if(count($judge_ids)){
           $get_judges = DB::table('judges')
            ->whereIn('id', $judge_ids)
            ->get()->pluck('adjudicator','id')->all();
            if(count($get_judges)){
                $output['judges']=$get_judges;
            }

        } else {
            $$output['judges']='null';
        }

        // to fetch clerk and other information
        if(count($clerk_ids)){
           $get_clerks = Clerk::whereIn('id', $clerk_ids)
            ->get()->all();
            if(count($get_clerks)){
                $output['clerks']=$get_clerks;
            }

        } else {
            $$output['clerks']='null';
        }

        if(count($court_correlation_table_data)){
            $output['court_correlation_table_data']=$court_correlation_table_data;
        } else {
            $$output['court_correlation_table_data']='null';
        }



        // to fetch magistrates
        $magistrate_ids = DB::table('magistrate_court_correlation')
        ->where([['court_id', $court_id],['division_id', $division_id]])
        ->get()->pluck('magistrate_id')->all();
        if(count($magistrate_ids)){
           $get_magistrates = DB::table('magistrates')
            ->whereIn('id', $magistrate_ids)
            ->get()->pluck('mag_name','id')->all();
            if(count($get_magistrates)){
                $output['magistrates']=$get_magistrates;
            }

        } else {
            $output['magistrates']='null';
        }

        // to fetch case types
        /*$casetype_ids = DB::table('division_case_type')
        ->where('division_id', $division_id)
        ->get()->pluck('case_type_id')->all();*/
        $caseaction_id = DB::table('divcoa_corr_table')
        ->where('ct_division_id',$division_id)
        ->get()->pluck('coa_id')->all();
        if(count($caseaction_id)){
           /*$get_case_types = DB::table('case_types')
            ->whereIn('id', $casetype_ids)
            ->get()->pluck('case_type','id')->all();*/
            $get_case_action = DB::table('causes_of_action')
            ->whereIn('coa_id',$caseaction_id)
            ->orderBy('coa','asc')->pluck('coa');
            //return $get_case_action;
            $get_case_id = DB::table('causes_of_action')
            ->whereIn('coa_id',$caseaction_id)
            ->orderBy('coa','asc')->pluck('coa_id');
            
            if(count($get_case_action)){
                $output['case_types']=$get_case_action;
                $output['coa_id'] = $get_case_id;
            }

        } else {
            $output['case_types']='null';
        }

        echo json_encode($output);

    }
    /**************** end of functions for case registration steps ****************/

    // To fetch response date based on file date for pleadings
    public function getResponseDateByFileDate(Request $request)
    {
        $file_date=$request->file_date;
        $file_date=date('Y-m-d', strtotime($file_date));
        $response_date = DB::table('oh_deadlines')
        ->whereDate('date_filed', $file_date)
        ->distinct()->get()->pluck('oh_deadline_14d');
        if(count($response_date))
        {
            echo $response_date=date('m/d/Y', strtotime($response_date[0]));
        } else {
            echo "null";
        }
    }

    // To fetch deadlines for different pleadings inputs
    public function getPleadingDeadlines(Request $request)
    {
        $start_date=$request->start_date;
        $start_date=date('Y-m-d', strtotime($start_date));
        $end_date = DB::table('oh_deadlines')
        ->whereDate('date_filed', $start_date)
        ->distinct()->get()->pluck('oh_deadline_28d');
        if(count($end_date))
        {
            echo $end_date=date('m/d/Y', strtotime($end_date[0]));
        } else {
            echo "null";
        }
    }

    /* Get Months Difference between two dates */
    public function getMonthDifference(Request $request)
    {
        $max_date=$request->max_date;
        $min_date=$request->min_date;
        // SELECT DATEDIFF(month, '2017/08/25', '2011/08/25') AS DateDiff;
        // echo $max_date=Carbon::parse($max_date)->toDateTimeString();
        // $min_date=Carbon::parse($min_date)->toDateTimeString();
        if($max_date && $min_date){
            $to = Carbon::createFromFormat('m/d/Y', $min_date);
            $from = Carbon::createFromFormat('m/d/Y', $max_date);
            $diff_in_months = $to->diffInMonths($from);
            echo $diff_in_months; // Output: 1
            
        } else {
            echo "null";
        }

    }

    /* Get period difference between two Dates */
    public function getPeriodDifference(Request $request)
    {
        $max_date=$request->max_date;
        $min_date=$request->min_date;
        // SELECT DATEDIFF(month, '2017/08/25', '2011/08/25') AS DateDiff;
        // echo $max_date=Carbon::parse($max_date)->toDateTimeString();
        // $min_date=Carbon::parse($min_date)->toDateTimeString();
        if($max_date && $min_date){
            $to = Carbon::createFromFormat('m/Y', $min_date);
            $from = Carbon::createFromFormat('m/Y', $max_date);
            $diff_in_months = $to->diffInMonths($from);
            echo $diff_in_months; // Output: 1
            
        } else {
            echo "0";
        }

    }

    /* Get Letter Dropdown Options for Prospects */
    public function getProspectLetterDropdown(Request $request)
    {
        $state=$request->state;
        $button_ref=$request->button_ref;
        $view_needed=$request->view_needed;
        
        // $dropdown = DB::table('document_table')
        // ->where([['state_id', $state],['button_ref', $button_ref],['view_needed', $view_needed]])
        // ->get()->all();

        $dropdown=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Prospect_Practice_Aids')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->get();
         foreach($dropdown as $key=>$val){
          $doctypecc = DB::table('document_table')->where('doc_disp_name',$val->package_name)->pluck('document_out_format')->first();

          $val->document_out_format = $doctypecc;
        }
        if(count($dropdown))
        {
            echo json_encode($dropdown);
        } else {
            echo "null";
        }

    }

    /* Get Intake Dropdown Options for Prospects */
    public function getProspectIntakeDropdown(Request $request)
    {
        $state=$request->state;
        $button_ref=$request->button_ref;
        $view_needed=$request->view_needed;

        $dropdown = DB::table('document_table')
        ->where([['state_id', $state],['button_ref', $button_ref],['view_needed', $view_needed]])
        ->get()->all();
        if(count($dropdown))
        {
            echo json_encode($dropdown);
        } else {
            echo "null";
        }

    }

    // to handle change of obligee/obligor of computed sheet
    public function updateObligeeObligorDrChildren(Request $request)
    {
        $case_details=Courtcase::find($request->case_id);
        if($case_details && $case_details->attorney_id==Auth::user()->id){
            $case_id=$request->case_id;
            $old_obligee_name=$request->obligee_name;
            $old_obligor_name=$request->obligor_name;

            $childreninfo=DrChildren::where('case_id',$request->case_id)->get()->first();
            if(isset($childreninfo)){
                $childreninfo->This_Marriage_Child_Support_Obligor_CLient_OP=$old_obligee_name;
                $children_length=array('First','Second','Third','Fourth','Fifth','Sixth','Seventh','Eigth');
                for ($i=0; $i < $childreninfo->Num_Children_ONLY_This_Marriage; $i++) {
                    $obj_key='This_Marriage_'.$children_length[$i].'_Child_WILL_Resides_With';
                    $childreninfo->{$obj_key}=$old_obligor_name;
                }                    
                $childreninfo->save();
                echo "success";
            } else {
                echo "null";
                exit;
            }

        } else {
            echo "null";
            exit;
        }

    }

    // to handle change of computed sheet custody
    public function updateCustodyArrangementDrChildren(Request $request)
    {
        $case_details=Courtcase::find($request->case_id);
        if($case_details && $case_details->attorney_id==Auth::user()->id){
            $case_id=$request->case_id;
            $sheet_state=$request->sheet_state;
            $change_sheet_custody=$request->change_sheet_custody;
            $obligee_name=$request->obligee_name_custody;

            $childreninfo=DrChildren::where('case_id',$request->case_id)->get()->first();
            if(isset($childreninfo)){
                $childreninfo->This_Marriage_Custody_Arrangement=ucfirst($change_sheet_custody);
                if($change_sheet_custody=='sole' || $change_sheet_custody=='shared'){
                    $childreninfo->This_Marriage_Child_Support_Obligor_CLient_OP=$request->obligor_name_custody;

                    $children_length=array('First','Second','Third','Fourth','Fifth','Sixth','Seventh','Eigth');
                    for ($i=0; $i < $childreninfo->Num_Children_ONLY_This_Marriage; $i++) {
                        $obj_key='This_Marriage_'.$children_length[$i].'_Child_WILL_Resides_With';
                        $childreninfo->{$obj_key}=$obligee_name;
                    }             
                }
                $childreninfo->save();
                // echo "success";
                return view('computations.computed.custody_based_redirect',['form_state' =>$sheet_state, 'case_id' =>$case_id]);

            } else {
                echo "null";
                exit;
            }

        } else {
            echo "null";
            exit;
        }

    }

    // to update children will reside with info of dr children based on split sheet changes
    public function updateChildrenWillResideWithDrChildren(Request $request)
    {
        $case_details=Courtcase::find($request->case_id);
        if($case_details && $case_details->attorney_id==Auth::user()->id){
            $case_id=$request->case_id;
            $form_state=$request->form_state;

            $childreninfo=DrChildren::where('case_id',$request->case_id)->get()->first();
            if(isset($childreninfo)){
                $children_length=array('First','Second','Third','Fourth','Fifth','Sixth','Seventh','Eigth');
                for ($i=0; $i < $childreninfo->Num_Children_ONLY_This_Marriage; $i++) {
                    $obj_key='This_Marriage_'.$children_length[$i].'_Child_WILL_Resides_With';
                    $childreninfo->{$obj_key}=$request->{$obj_key};
                }
                $childreninfo->save();
                return view('computations.computed.custody_based_redirect',['form_state' =>$form_state, 'case_id' =>$case_id]);
            } else {
                echo "null";
                exit;
            }

        } else {
            echo "null";
            exit;
        }

    }

    // get case payment package detail by id
    public function getCasePackageDetailsById($package_id)
    {
        $case_package= CasePaymentPackage::find($package_id);
        
        if($case_package)
        {
            echo json_encode($case_package);
        } else {
            echo "null";
        }
    }

    // get case  pleading new popup select options
    public function getPopupSelectOptions(Request $request)
    {
        if(Auth::user() && Auth::user()->hasRole('attorney')){
            $type=$request->type;
            $options = "null";
            if(isset($type)){
                if($type == 'notices-nonfamlaw'){
                    $options=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'CaseNotices_NOT_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
                }
                if($type == 'notices-famlaw'){
                    $options=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'CaseNotices_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
                }
                if($type == 'correspondence-famlaw-nonfamlaw'){
                    $options=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'CaseCorrespondence')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
                }
                if($type == 'discovery-nonfamlaw'){
                    $options=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Discovery_NOT_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
                }
                if($type == 'discovery-famlaw'){
                    $options=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'Discovery_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
                }
                if($type == 'forms-and-affidavits-nonfamlaw'){
                    $options=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'FormsAffs_NOT_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
                }
                if($type == 'forms-and-affidavits-famlaw'){
                    $options=DB::table('document_package_table')->select('package_name')->where('dropdown_name', 'FormsAffs_FamLaw')->groupBy('package_name')->orderBy('dropdown_priority', 'ASC')->orderBy('hash_id', 'ASC')->get();
                }
            }
        } else {
            $options= "Unauthorized";
        }

        echo $options;
    }

     /**
    * Display Search Results
    *
    * @param  serach parameter
    * @return \Illuminate\Http\Response
    */
    public function AjaxGetSearchData(Request $request){
        $registrationnumber = $request->search_tag;
        $first_name = $request->first_name;
        $last_name = $request->last_name;
        $state_id = $request->state_id;
       
        $results = []; 

            if(empty($registrationnumber) && empty($first_name) && empty($last_name)){
                $results = []; 
            }else{

            $sql = "select registration_state,registrationnumber,fname,mname,lname from attorney_table_active where ";
            // $results = DB::table('attorney_table_active')->select('registration_state','registrationnumber','fname','mname','lname','mname')->where('registration_state_id', $state_id);
            if(!empty($registrationnumber) && isset($registrationnumber)){
               
                $sql = $sql."  registrationnumber Like '%".$registrationnumber."%' and ";
               // ->where('registrationnumber','like','%'.$registrationnumber.'%')
                
                //->get();  ,
            }
             if(!empty($first_name) && isset($first_name)){
               /* $results = DB::table('attorney_table_active')
                ->select('registration_state','registrationnumber','fname','mname','lname','mname')
                ->where('fname','like','%'.$first_name.'%')
                ->where('registration_state_id', $state_id)
                ->get();*/
                $sql = $sql."  fname Like '".$first_name."%' and";
            }
             if(!empty($last_name) && isset($last_name)){
               /* $results = DB::table('attorney_table_active')
                ->select('registration_state','registrationnumber','fname','mname','lname','mname')
                ->where('lname','like','%'.$last_name.'%')
                ->where('registration_state_id', $state_id)
                ->get();*/
                $sql = $sql." lname Like '".$last_name."%' and ";
            }
            
            $sql = $sql ."  registration_state_id = ".$state_id;

            $results =  DB::select($sql);
        }

        
      
       if($results)
        {
            echo json_encode($results);
        } else {
            echo "null";
        }
    }
}