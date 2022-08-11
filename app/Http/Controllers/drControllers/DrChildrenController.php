<?php

namespace App\Http\Controllers\drControllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Auth;
use App\User;
use App\Courtcase;
use App\Caseuser;
use App\DrChildren;
use App\DrCaseOverview;
use DateTime;

class DrChildrenController extends Controller
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

    // to fetch all records
    public function index($case_id)
    {
        $data=DrChildren::orderBy('id','DESC')->get();
        echo "<pre>";print_r($data);die;
    }


    public function create($case_id)
    {   
        // $case_attorney=Courtcase::where([['id', $case_id],['attorney_id', Auth::user()->id]])->pluck('attorney_id');
        // if(isset($case_attorney['0'])){
        // } else {
        //     return redirect()->route('home');
        // }
        $user_role=Auth::user()->roles->first()->name;
        if($user_role=='client'){
            $client_attorney = Caseuser::where([['case_id', $case_id],['user_id', Auth::user()->id]])->get()->pluck('attorney_id')->first();
            if($client_attorney){
                // $case_info=Courtcase::where([['id', $case_id],['attorney_id', $client_attorney]])->first();
                $case_attorney=Courtcase::where([['id', $case_id],['attorney_id', $client_attorney]])->pluck('attorney_id');
                if(isset($case_attorney['0'])){
                } else {
                    return redirect()->route('home');
                }
            } else {
                return redirect()->route('client.cases');
            }
        } else {
            $case_attorney=Courtcase::where([['id', $case_id],['attorney_id', Auth::user()->id]])->pluck('attorney_id');
            if(isset($case_attorney['0'])){
            } else {
                return redirect()->route('home');
            }
        }

        $drchildren=DrChildren::where('case_id',$case_id)->get()->pluck('case_id');
        if(isset($drchildren['0'])){
            return redirect()->route('home');
        }
        $drcaseoverview=DrCaseOverview::where('case_id',$case_id)->get()->first();
        if(isset($drcaseoverview)){
        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Case Overview Info Section First.');
        }
        $caseuser=DB::table('caseusers')
            ->join('users', 'caseusers.user_id', '=', 'users.id')
            ->where([['caseusers.case_id', $case_id],['caseusers.party_group', 'top']])
            ->select('users.name', 'caseusers.party_entity', 'caseusers.mname', 'caseusers.org_comp_name')
            ->first();
        if(isset($caseuser->name)){
            $client_name=$caseuser->name;
            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                $client_name=$caseuser->org_comp_name;
            } else {
                $mname=$caseuser->mname;
                if(isset($mname) && $mname !='') {
                    $namearray = explode(' ', $caseuser->name, 2);
                    if(count($namearray) > 1) {
                        $client_name=$namearray[0].' '.$mname.' '.$namearray[1];
                    } else {
                        $client_name=$caseuser->name.' '.$mname;
                    }
                }
            }
        }else {
            $client_name='ClientName';
        }
        $caseuser=DB::table('caseusers')
            ->join('users', 'caseusers.user_id', '=', 'users.id')
            ->where([['caseusers.case_id', $case_id],['caseusers.party_group', 'bottom']])
            ->select('users.name', 'caseusers.party_entity', 'caseusers.mname', 'caseusers.org_comp_name')
            ->first();
        if(isset($caseuser->name)){
            $opponent_name=$caseuser->name;
            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                $opponent_name=$caseuser->org_comp_name;
            } else {
                $mname=$caseuser->mname;
                if(isset($mname) && $mname !='') {
                    $namearray = explode(' ', $caseuser->name, 2);
                    if(count($namearray) > 1) {
                        $opponent_name=$namearray[0].' '.$mname.' '.$namearray[1];
                    } else {
                        $opponent_name=$caseuser->name.' '.$mname;
                    }
                }
            }
        }else {
            $opponent_name='OpName';
        }
       
        $marriage_data = DB::table('dr_MarriageInfo')->where('case_id',$case_id)->pluck('Marriage_Date')->first();
        
        if($marriage_data != ''){
            $marriage_date = $marriage_data;
        }else{
            $marriage_date = null;
        }
        // echo "<pre>";print_r($opponent_name);die;
        return view('dr_tables.dr_Children.create',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'drcaseoverview'=>$drcaseoverview,'marriage_date'=>$marriage_date]);
    }

    // save tab info in database table.
    public function store(Request $request)
    {

        $result = $request->except('submit');
        // parse string to date for client info section
        $length=array('First','Second','Third','Fourth','Fifth','Sixth','Seventh','Eighth');
        $marriage_data = DB::table('dr_MarriageInfo')->where('case_id',$result['case_id'])->pluck('Marriage_Date')->first();

        // during marriage child info
        for ($i=0; $i < 8; $i++) { 
            if(isset($result['This_Marriage_'.$length[$i].'_Child_DOB'])){
                $result['This_Marriage_'.$length[$i].'_Child_DOB']=date("Y-m-d",strtotime($result['This_Marriage_'.$length[$i].'_Child_DOB']));
                if($marriage_data != ''){
                    if($result['This_Marriage_'.$length[$i].'_Child_BornAdopted_during_Marriage_Y_N'] == "yes" ){
                        $r_childdob = strtotime($result['This_Marriage_'.$length[$i].'_Child_DOB']);
                        $marriage_date = strtotime($marriage_data);
                        if($r_childdob > $marriage_date){
                            $result['This_Marriage_'.$length[$i].'_Child_BornAdopted_during_Marriage_Y_N'] = "yes";
                        }else{
                            $result['This_Marriage_'.$length[$i].'_Child_BornAdopted_during_Marriage_Y_N'] = "No";
                        }
                    }
                }

                 $y = date('Y');
                 $childdob = $result['This_Marriage_'.$length[$i].'_Child_DOB'];
                 $dobyear = date('Y',strtotime($childdob));
                 
                 $y = $y-$dobyear;
                 if($y < 18){
                    $result['This_Marriage_'.$length[$i].'_Child_Minor']='Yes';
                }else{
                    $result['This_Marriage_'.$length[$i].'_Child_Minor']='No';
                }

            } else {
                $result['This_Marriage_'.$length[$i].'_Child_DOB']=NULL;
            }
            if(isset($result['This_Marriage_'.$length[$i].'_Child_WILL_Resides_With']) && $result['This_Marriage_'.$length[$i].'_Child_WILL_Resides_With']=='Other'){
                $result['This_Marriage_'.$length[$i].'_Child_WILL_Resides_With']=$result['This_Marriage_'.$length[$i].'_Child_WILL_Resides_With_Other'];
            }
            unset($result['This_Marriage_'.$length[$i].'_Child_WILL_Resides_With_Other']);

            // for child initials
            $result['This_Marriage_'.$length[$i].'_Child_Initials']='';
            if(isset($result['This_Marriage_'.$length[$i].'_Child_FirstName']) && $result['This_Marriage_'.$length[$i].'_Child_FirstName'] !=''){
                $result['This_Marriage_'.$length[$i].'_Child_Initials']=substr($result['This_Marriage_'.$length[$i].'_Child_FirstName'], 0, 1);
            }
            if(isset($result['This_Marriage_'.$length[$i].'_Child_MiddleName']) && $result['This_Marriage_'.$length[$i].'_Child_MiddleName'] !=''){
                $result['This_Marriage_'.$length[$i].'_Child_Initials']=$result['This_Marriage_'.$length[$i].'_Child_Initials'].''.substr($result['This_Marriage_'.$length[$i].'_Child_MiddleName'], 0, 1);
            }
            if(isset($result['This_Marriage_'.$length[$i].'_Child_LastName']) && $result['This_Marriage_'.$length[$i].'_Child_LastName'] !=''){
                $result['This_Marriage_'.$length[$i].'_Child_Initials']=$result['This_Marriage_'.$length[$i].'_Child_Initials'].''.substr($result['This_Marriage_'.$length[$i].'_Child_LastName'], 0, 1);
            }
        }

        // client before marriage child info
        $result['Client_Child_NOM_Total_Monthly_Child_Support_RECEIVED']=0.00;
        $result['Client_Child_NOM_Total_Monthly_Child_Support_PAID']=0.00;
        for ($i=0; $i < 6; $i++) { 
            if(isset($result['Client_'.$length[$i].'_Child_NOM_DOB'])){
                $result['Client_'.$length[$i].'_Child_NOM_DOB']=date("Y-m-d",strtotime($result['Client_'.$length[$i].'_Child_NOM_DOB']));
                
                if($marriage_data != ''){
                    $marrige_d = strtotime($marriage_data);
                    $r_date = strtotime($result['Client_'.$length[$i].'_Child_NOM_DOB']);
                    if($r_date > $marrige_d){
                        $result['Client_'.$length[$i].'_Child_NOM_Born_During_Marriage'] ="Yes";
                    }else{
                        $result['Client_'.$length[$i].'_Child_NOM_Born_During_Marriage'] = "No";
                    }
                }
            } else {
                $result['Client_'.$length[$i].'_Child_NOM_DOB']=NULL;
            }

            // for new calculations
            if(isset($result['Client_'.$length[$i].'_Child_NOM_Monthly_Child_Support_RECEIVED']) && $result['Client_'.$length[$i].'_Child_NOM_Monthly_Child_Support_RECEIVED'] !=''){
                $result['Client_Child_NOM_Total_Monthly_Child_Support_RECEIVED']=$result['Client_Child_NOM_Total_Monthly_Child_Support_RECEIVED']+$result['Client_'.$length[$i].'_Child_NOM_Monthly_Child_Support_RECEIVED'];
            }

            if(isset($result['Client_'.$length[$i].'_Child_NOM_Monthly_Child_Support_PAID']) && $result['Client_'.$length[$i].'_Child_NOM_Monthly_Child_Support_PAID'] !=''){
                $result['Client_Child_NOM_Total_Monthly_Child_Support_PAID']=$result['Client_Child_NOM_Total_Monthly_Child_Support_PAID']+$result['Client_'.$length[$i].'_Child_NOM_Monthly_Child_Support_PAID'];
            }

        }

        // opponent before marriage child info
        $result['Op_Child_NOM_Total_Monthly_Child_Support_RECEIVED']=0.00;
        $result['Op_Child_NOM_Total_Monthly_Child_Support_PAID']=0.00;
        for ($i=0; $i < 6; $i++) { 
            if(isset($result['Op_'.$length[$i].'_Child_NOM_DOB'])){
                $result['Op_'.$length[$i].'_Child_NOM_DOB']=date("Y-m-d",strtotime($result['Op_'.$length[$i].'_Child_NOM_DOB']));
            } else {
                $result['Op_'.$length[$i].'_Child_NOM_DOB']=NULL;
            }

            // for new calculations
            if(isset($result['Op_'.$length[$i].'_Child_NOM_Monthly_Child_Support_RECEIVED']) && $result['Op_'.$length[$i].'_Child_NOM_Monthly_Child_Support_RECEIVED'] !=''){
                $result['Op_Child_NOM_Total_Monthly_Child_Support_RECEIVED']=$result['Op_Child_NOM_Total_Monthly_Child_Support_RECEIVED']+$result['Op_'.$length[$i].'_Child_NOM_Monthly_Child_Support_RECEIVED'];
            }

            if(isset($result['Op_'.$length[$i].'_Child_NOM_Monthly_Child_Support_PAID']) && $result['Op_'.$length[$i].'_Child_NOM_Monthly_Child_Support_PAID'] !=''){
                $result['Op_Child_NOM_Total_Monthly_Child_Support_PAID']=$result['Op_Child_NOM_Total_Monthly_Child_Support_PAID']+$result['Op_'.$length[$i].'_Child_NOM_Monthly_Child_Support_PAID'];
            }
        }

        // to make unwanted fields null for during marriage child info
        $Num_Children_ONLY_This_Marriage=$result['Num_Children_ONLY_This_Marriage'];
        if($Num_Children_ONLY_This_Marriage=='0'){
            $result['This_Marriage_Custody_Arrangement']=NULL;
            $result['This_Marriage_Child_Support_Obligor_CLient_OP']=NULL;
            $result['This_Marriage_Health_Ins_Obligor_CLient_OP']=NULL;
            $result['Num_MinorDepChildren_ONLY_This_Marriage']=NULL;
            $result['Num_Client_Children_NOT_this_Marriage']=0;
            $result['Num_Op_Children_NOT_this_Marriage']=0;
        }
        for ($i=$Num_Children_ONLY_This_Marriage; $i < 8; $i++) { 
            $result['This_Marriage_'.$length[$i].'_Child_FirstName']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_MiddleName']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_LastName']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Initials']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Gender']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_DOB']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Disabled_Dependent_Y_N']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Paternity_Established_Y_N']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_SSN']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Resides_With']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_WILL_Resides_With']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Residential_Parent_School_Purposes']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Emp_or_School_Related_Childcare']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_School']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Grade']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Minor']='Yes';
            $result['This_Marriage_'.$length[$i].'_Child_Sub_to_Court_Order']='No';
            $result['This_Marriage_'.$length[$i].'_Child_Court']=Null;
            $result['This_Marriage_'.$length[$i].'_Child_Court_Case_Num']=Null;
            $result['This_Marriage_'.$length[$i].'_Child_Court_Case_Num']=Null;
            $result['This_Marriage_'.$length[$i].'_Child_Resides_With_Other_Name']=Null;



        }
        
        // to make unwanted fields null for client before marriage child info
        if(isset($result['Num_Client_Children_NOT_this_Marriage'])){
        } else {
            $result['Num_Client_Children_NOT_this_Marriage']='0';
        }
        $Num_Client_Children_NOT_this_Marriage=$result['Num_Client_Children_NOT_this_Marriage'];
        for ($i=$Num_Client_Children_NOT_this_Marriage; $i < 6; $i++) { 
            $result['Client_'.$length[$i].'_Child_NOM_FirstName']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_MiddleName']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_LastName']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_DOB']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_Disabled_Dependent_Y_N']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_Resides_with_Client_Y_N']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_Monthly_Child_Support_RECEIVED']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_Monthly_Child_Support_PAID']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_AbsentParent_Full_Name']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_AbsentParent_StreetAddress']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_AbsentParent_City_State_ZIP']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_AbsentParent_Phone']=NULL;
        }

        // to make unwanted fields null for opponent before marriage child info
        if(isset($result['Num_Op_Children_NOT_this_Marriage'])){
        } else {
            $result['Num_Op_Children_NOT_this_Marriage']='0';
        }
        $Num_Op_Children_NOT_this_Marriage=$result['Num_Op_Children_NOT_this_Marriage'];
        for ($i=$Num_Op_Children_NOT_this_Marriage; $i < 6; $i++) { 
            $result['Op_'.$length[$i].'_Child_NOM_FirstName']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_MiddleName']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_LastName']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_DOB']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_Disabled_Dependent_Y_N']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_Resides_with_Op_Y_N']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_Monthly_Child_Support_RECEIVED']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_Monthly_Child_Support_PAID']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_AbsentParent_Full_Name']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_AbsentParent_StreetAddress']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_AbsentParent_City_State_ZIP']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_AbsentParent_Phone']=NULL;
        }
        //return $result;
        //die;
        //echo "<pre>";print_r($result);die;
        $DrChildren=DrChildren::create($result);

        // update case overview info.
        $drcaseoverview=DrCaseOverview::where('case_id',$result['case_id'])->get()->first();
        if(isset($drcaseoverview)){
            $drcaseoverview->Num_Children_ONLY_This_Marriage=$result['Num_Children_ONLY_This_Marriage'];
            //$drcaseoverview->Num_MinorDepChildren_ONLY_This_Marriage=$result['Num_MinorDepChildren_ONLY_This_Marriage'];
            $drcaseoverview->Num_Client_Children_NOT_this_Marriage=$result['Num_Client_Children_NOT_this_Marriage'];
            $drcaseoverview->Num_Op_Children_NOT_this_Marriage=$result['Num_Op_Children_NOT_this_Marriage'];
             //$drcaseoverview->Num_Children_Born_ONLY_These_Parties_Before_Marriage = $result['Num_Children_Born_ONLY_These_Parties_Before_Marriage'];
            $drcaseoverview->save();
        } else {
            return redirect()->route('cases.family_law_interview_tabs',$case_id)->with('error', 'Complete Case Overview Info Section First.');
        }
        
        return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('success', 'Children Information Submitted Successfully.');
        
    }

    public function show($id)
    {

    }

    public function edit($case_id)
    {
        $user_role=Auth::user()->roles->first()->name;
        if($user_role=='client'){
            $client_attorney = Caseuser::where([['case_id', $case_id],['user_id', Auth::user()->id]])->get()->pluck('attorney_id')->first();
            if($client_attorney){
                // $case_info=Courtcase::where([['id', $case_id],['attorney_id', $client_attorney]])->first();
                $case_attorney=Courtcase::where([['id', $case_id],['attorney_id', $client_attorney]])->pluck('attorney_id');
                if(isset($case_attorney['0'])){
                } else {
                    return redirect()->route('home');
                }
            } else {
                return redirect()->route('client.cases');
            }
        } else {
            $case_attorney=Courtcase::where([['id', $case_id],['attorney_id', Auth::user()->id]])->pluck('attorney_id');
            if(isset($case_attorney['0'])){
            } else {
                return redirect()->route('home');
            }
        }
        
        $caseuser=DB::table('caseusers')
            ->join('users', 'caseusers.user_id', '=', 'users.id')
            ->where([['caseusers.case_id', $case_id],['caseusers.party_group', 'top']])
            ->select('users.name', 'caseusers.party_entity', 'caseusers.mname', 'caseusers.org_comp_name')
            ->first();
        if(isset($caseuser->name)){
            $client_name=$caseuser->name;
            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                $client_name=$caseuser->org_comp_name;
            } else {
                $mname=$caseuser->mname;
                if(isset($mname) && $mname !='') {
                    $namearray = explode(' ', $caseuser->name, 2);
                    if(count($namearray) > 1) {
                        $client_name=$namearray[0].' '.$mname.' '.$namearray[1];
                    } else {
                        $client_name=$caseuser->name.' '.$mname;
                    }
                }
            }
        }else {
            $client_name='ClientName';
        }
        $caseuser=DB::table('caseusers')
            ->join('users', 'caseusers.user_id', '=', 'users.id')
            ->where([['caseusers.case_id', $case_id],['caseusers.party_group', 'bottom']])
            ->select('users.name', 'caseusers.party_entity', 'caseusers.mname', 'caseusers.org_comp_name')
            ->first();
        if(isset($caseuser->name)){
            $opponent_name=$caseuser->name;
            if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                $opponent_name=$caseuser->org_comp_name;
            } else {
                $mname=$caseuser->mname;
                if(isset($mname) && $mname !='') {
                    $namearray = explode(' ', $caseuser->name, 2);
                    if(count($namearray) > 1) {
                        $opponent_name=$namearray[0].' '.$mname.' '.$namearray[1];
                    } else {
                        $opponent_name=$caseuser->name.' '.$mname;
                    }
                }
            }
        }else {
            $opponent_name='OpName';
        }
        // echo "<pre>";print_r($opponent_name);die;
        $drchildren=DrChildren::where('case_id',$case_id)->get()->first();
        $drcaseoverview=DrCaseOverview::where('case_id',$case_id)->get()->first();
        if($drchildren){
            if(isset($drcaseoverview)){
                if(isset($drcaseoverview) && $drcaseoverview->Num_Children_ONLY_This_Marriage==$drchildren->Num_Children_ONLY_This_Marriage && $drcaseoverview->Num_MinorDepChildren_ONLY_This_Marriage==$drchildren->Num_MinorDepChildren_ONLY_This_Marriage && $drcaseoverview->Num_Client_Children_NOT_this_Marriage==$drchildren->Num_Client_Children_NOT_this_Marriage && $drcaseoverview->Num_Op_Children_NOT_this_Marriage==$drchildren->Num_Op_Children_NOT_this_Marriage)
                {

                } else {
                    $drchildren->Num_Children_ONLY_This_Marriage=$drcaseoverview->Num_Children_ONLY_This_Marriage;
                    //$drchildren->Num_MinorDepChildren_ONLY_This_Marriage=$drcaseoverview->Num_MinorDepChildren_ONLY_This_Marriage;
                    $drchildren->Num_Client_Children_NOT_this_Marriage=$drcaseoverview->Num_Client_Children_NOT_this_Marriage;
                    $drchildren->Num_Op_Children_NOT_this_Marriage=$drcaseoverview->Num_Op_Children_NOT_this_Marriage;
                }

            }

            
            return view('dr_tables.dr_Children.edit',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'drchildren' => $drchildren]);
        } else {
            return redirect()->route('home');
        }

        
    }

    public function update(Request $request, $id)
    {

        $result = $request->except('submit','_method','_token');
        $length=array('First','Second','Third','Fourth','Fifth','Sixth','Seventh','Eighth');
        $marriage_data = DB::table('dr_MarriageInfo')->where('case_id',$result['case_id'])->pluck('Marriage_Date')->first();
        // during marriage child info
        for ($i=0; $i < 8; $i++) { 
            if(isset($result['This_Marriage_'.$length[$i].'_Child_DOB'])){
                $result['This_Marriage_'.$length[$i].'_Child_DOB']=date("Y-m-d",strtotime($result['This_Marriage_'.$length[$i].'_Child_DOB']));
                if($marriage_data != '' && $result['This_Marriage_'.$length[$i].'_Child_BornAdopted_during_Marriage_Y_N'] == "yes" ){
                    
                        $r_childdob = strtotime($result['This_Marriage_'.$length[$i].'_Child_DOB']);
                        $marriage_date = strtotime($marriage_data);
                        if($r_childdob > $marriage_date){
                            $result['This_Marriage_'.$length[$i].'_Child_BornAdopted_during_Marriage_Y_N'] = "yes";
                        }else{
                            $result['This_Marriage_'.$length[$i].'_Child_BornAdopted_during_Marriage_Y_N'] = "No";
                        }
                    
                }
            } else {
                $result['This_Marriage_'.$length[$i].'_Child_DOB']=NULL;
            }
            if(isset($result['This_Marriage_'.$length[$i].'_Child_WILL_Resides_With']) && $result['This_Marriage_'.$length[$i].'_Child_WILL_Resides_With']=='Other'){
                $result['This_Marriage_'.$length[$i].'_Child_WILL_Resides_With']=$result['This_Marriage_'.$length[$i].'_Child_WILL_Resides_With_Other'];
            }
            unset($result['This_Marriage_'.$length[$i].'_Child_WILL_Resides_With_Other']);

            // for child initials
            $result['This_Marriage_'.$length[$i].'_Child_Initials']='';
            if(isset($result['This_Marriage_'.$length[$i].'_Child_FirstName']) && $result['This_Marriage_'.$length[$i].'_Child_FirstName'] !=''){
                $result['This_Marriage_'.$length[$i].'_Child_Initials']=substr($result['This_Marriage_'.$length[$i].'_Child_FirstName'], 0, 1);
            }
            if(isset($result['This_Marriage_'.$length[$i].'_Child_MiddleName']) && $result['This_Marriage_'.$length[$i].'_Child_MiddleName'] !=''){
                $result['This_Marriage_'.$length[$i].'_Child_Initials']=$result['This_Marriage_'.$length[$i].'_Child_Initials'].''.substr($result['This_Marriage_'.$length[$i].'_Child_MiddleName'], 0, 1);
            }
            if(isset($result['This_Marriage_'.$length[$i].'_Child_LastName']) && $result['This_Marriage_'.$length[$i].'_Child_LastName'] !=''){
                $result['This_Marriage_'.$length[$i].'_Child_Initials']=$result['This_Marriage_'.$length[$i].'_Child_Initials'].''.substr($result['This_Marriage_'.$length[$i].'_Child_LastName'], 0, 1);
            }
        }

        // client before marriage child info
        $result['Client_Child_NOM_Total_Monthly_Child_Support_RECEIVED']=0.00;
        $result['Client_Child_NOM_Total_Monthly_Child_Support_PAID']=0.00;
        for ($i=0; $i < 6; $i++) { 
            if(isset($result['Client_'.$length[$i].'_Child_NOM_DOB'])){
                $result['Client_'.$length[$i].'_Child_NOM_DOB']=date("Y-m-d",strtotime($result['Client_'.$length[$i].'_Child_NOM_DOB']));
            } else {
                $result['Client_'.$length[$i].'_Child_NOM_DOB']=NULL;
            }

            // for new calculations
            if(isset($result['Client_'.$length[$i].'_Child_NOM_Monthly_Child_Support_RECEIVED']) && $result['Client_'.$length[$i].'_Child_NOM_Monthly_Child_Support_RECEIVED'] !=''){
                $result['Client_Child_NOM_Total_Monthly_Child_Support_RECEIVED']=$result['Client_Child_NOM_Total_Monthly_Child_Support_RECEIVED']+$result['Client_'.$length[$i].'_Child_NOM_Monthly_Child_Support_RECEIVED'];
            }

            if(isset($result['Client_'.$length[$i].'_Child_NOM_Monthly_Child_Support_PAID']) && $result['Client_'.$length[$i].'_Child_NOM_Monthly_Child_Support_PAID'] !=''){
                $result['Client_Child_NOM_Total_Monthly_Child_Support_PAID']=$result['Client_Child_NOM_Total_Monthly_Child_Support_PAID']+$result['Client_'.$length[$i].'_Child_NOM_Monthly_Child_Support_PAID'];
            }

        }

        // opponent before marriage child info
        $result['Op_Child_NOM_Total_Monthly_Child_Support_RECEIVED']=0.00;
        $result['Op_Child_NOM_Total_Monthly_Child_Support_PAID']=0.00;
        for ($i=0; $i < 6; $i++) { 
            if(isset($result['Op_'.$length[$i].'_Child_NOM_DOB'])){
                $result['Op_'.$length[$i].'_Child_NOM_DOB']=date("Y-m-d",strtotime($result['Op_'.$length[$i].'_Child_NOM_DOB']));
                if($marriage_data != ''){
                    $marrige_d = strtotime($marriage_data);
                    $r_date = strtotime($result['Client_'.$length[$i].'_Child_NOM_DOB']);
                    if($r_date > $marrige_d){
                        $result['Client_'.$length[$i].'_Child_NOM_Born_During_Marriage'] ="Yes";
                    }else{
                        $result['Client_'.$length[$i].'_Child_NOM_Born_During_Marriage'] = "No";
                    }
                }
            } else {
                $result['Op_'.$length[$i].'_Child_NOM_DOB']=NULL;
            }

            // for new calculations
            if(isset($result['Op_'.$length[$i].'_Child_NOM_Monthly_Child_Support_RECEIVED']) && $result['Op_'.$length[$i].'_Child_NOM_Monthly_Child_Support_RECEIVED'] !=''){
                $result['Op_Child_NOM_Total_Monthly_Child_Support_RECEIVED']=$result['Op_Child_NOM_Total_Monthly_Child_Support_RECEIVED']+$result['Op_'.$length[$i].'_Child_NOM_Monthly_Child_Support_RECEIVED'];
            }

            if(isset($result['Op_'.$length[$i].'_Child_NOM_Monthly_Child_Support_PAID']) && $result['Op_'.$length[$i].'_Child_NOM_Monthly_Child_Support_PAID'] !=''){
                $result['Op_Child_NOM_Total_Monthly_Child_Support_PAID']=$result['Op_Child_NOM_Total_Monthly_Child_Support_PAID']+$result['Op_'.$length[$i].'_Child_NOM_Monthly_Child_Support_PAID'];
            }
        }

        // to make unwanted fields null for during marriage child info
        $Num_Children_ONLY_This_Marriage=$result['Num_Children_ONLY_This_Marriage'];
        if($Num_Children_ONLY_This_Marriage=='0'){
            $result['This_Marriage_Custody_Arrangement']=NULL;
            $result['This_Marriage_Child_Support_Obligor_CLient_OP']=NULL;
            $result['This_Marriage_Health_Ins_Obligor_CLient_OP']=NULL;
            $result['Num_MinorDepChildren_ONLY_This_Marriage']=NULL;
            $result['Num_Client_Children_NOT_this_Marriage']=0;
            $result['Num_Op_Children_NOT_this_Marriage']=0;
        }
        for ($i=$Num_Children_ONLY_This_Marriage; $i < 8; $i++) { 
            $result['This_Marriage_'.$length[$i].'_Child_FirstName']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_MiddleName']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_LastName']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Initials']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Gender']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_DOB']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Disabled_Dependent_Y_N']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Paternity_Established_Y_N']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_SSN']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Resides_With']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_WILL_Resides_With']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Residential_Parent_School_Purposes']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Emp_or_School_Related_Childcare']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_School']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Grade']=NULL;
            $result['This_Marriage_'.$length[$i].'_Child_Minor']='Yes';
            $result['This_Marriage_'.$length[$i].'_Child_Sub_to_Court_Order']='No';
            $result['This_Marriage_'.$length[$i].'_Child_Court']=Null;
            $result['This_Marriage_'.$length[$i].'_Child_Court_Case_Num']=Null;
            $result['This_Marriage_'.$length[$i].'_Child_Resides_With_Other_Name']=Null;
        }
        
        // to make unwanted fields null for client before marriage child info
        if(isset($result['Num_Client_Children_NOT_this_Marriage'])){
        } else {
            $result['Num_Client_Children_NOT_this_Marriage']='0';
        }
        $Num_Client_Children_NOT_this_Marriage=$result['Num_Client_Children_NOT_this_Marriage'];
        for ($i=$Num_Client_Children_NOT_this_Marriage; $i < 6; $i++) { 
            $result['Client_'.$length[$i].'_Child_NOM_FirstName']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_MiddleName']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_LastName']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_DOB']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_Disabled_Dependent_Y_N']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_Resides_with_Client_Y_N']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_Monthly_Child_Support_RECEIVED']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_Monthly_Child_Support_PAID']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_AbsentParent_Full_Name']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_AbsentParent_StreetAddress']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_AbsentParent_City_State_ZIP']=NULL;
            $result['Client_'.$length[$i].'_Child_NOM_AbsentParent_Phone']=NULL;
        }

        // to make unwanted fields null for opponent before marriage child info
        if(isset($result['Num_Op_Children_NOT_this_Marriage'])){
        } else {
            $result['Num_Op_Children_NOT_this_Marriage']='0';
        }
        $Num_Op_Children_NOT_this_Marriage=$result['Num_Op_Children_NOT_this_Marriage'];
        for ($i=$Num_Op_Children_NOT_this_Marriage; $i < 6; $i++) { 
            $result['Op_'.$length[$i].'_Child_NOM_FirstName']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_MiddleName']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_LastName']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_DOB']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_Disabled_Dependent_Y_N']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_Resides_with_Op_Y_N']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_Monthly_Child_Support_RECEIVED']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_Monthly_Child_Support_PAID']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_AbsentParent_Full_Name']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_AbsentParent_StreetAddress']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_AbsentParent_City_State_ZIP']=NULL;
            $result['Op_'.$length[$i].'_Child_NOM_AbsentParent_Phone']=NULL;
        }
        // echo "<pre>";print_r($result);die;
        $DrChildren  = DrChildren::findOrFail($id);
        if($DrChildren){
            $DrChildren->fill($result)->save();
            // update case overview info.
            $drcaseoverview=DrCaseOverview::where('case_id',$result['case_id'])->get()->first();
            if(isset($drcaseoverview)){
                $drcaseoverview->Num_Children_ONLY_This_Marriage=$result['Num_Children_ONLY_This_Marriage'];
               // $drcaseoverview->Num_MinorDepChildren_ONLY_This_Marriage=$result['Num_MinorDepChildren_ONLY_This_Marriage'];
                $drcaseoverview->Num_Client_Children_NOT_this_Marriage=$result['Num_Client_Children_NOT_this_Marriage'];
                $drcaseoverview->Num_Op_Children_NOT_this_Marriage=$result['Num_Op_Children_NOT_this_Marriage'];
                $drcaseoverview->save();
            } else {
                return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('error', 'Complete Case Overview Info Section First.');
            }
            return redirect()->route('drchildren.edit',$result['case_id'])->with('success', 'Children Information Updated Successfully.');
        } else {
            return redirect()->route('drchildren.edit',$result['case_id'])->with('error', 'Something went wrong. Please try Again.');
        }
    }
    
    public function destroy($id)
    {

    }

}
