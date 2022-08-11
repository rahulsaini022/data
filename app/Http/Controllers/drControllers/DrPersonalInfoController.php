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
use App\DrPersonalInfo;
use App\State;
use App\County;
use App\DrCaseOverview;


class DrPersonalInfoController extends Controller
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
        $data=DrPersonalInfo::orderBy('id','DESC')->get();
        echo "<pre>";print_r($data);die;
    }


    public function create($case_id)
    {   
        $user_role=Auth::user()->roles->first()->name;
        if($user_role=='client'){
            $client_attorney = Caseuser::where([['case_id', $case_id],['user_id', Auth::user()->id]])->get()->pluck('attorney_id')->first();
            if($client_attorney){
                $case_info=Courtcase::where([['id', $case_id],['attorney_id', $client_attorney]])->first();
            } else {
                return redirect()->route('client.cases');
            }
        } else {
            $case_info=Courtcase::where([['id', $case_id],['attorney_id', Auth::user()->id]])->first();
        }

        $case_info->state_name= State::find($case_info->state_id)->state;
        $case_info->county_name= County::find($case_info->county_id)->county_name;

        $case_info->state_name= State::find($case_info->state_id)->state;
        $case_info->county_name= County::find($case_info->county_id)->county_name;
            
        $case_attorney=$case_info->attorney_id;
        if(isset($case_attorney)){
        } else {
            return redirect()->route('home');
        }
        $personalinfo=DrPersonalInfo::where('case_id',$case_id)->get()->pluck('case_id');
        if(isset($personalinfo['0'])){
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

        return view('dr_tables.dr_PersonalInfo.create',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'case_info' =>$case_info, 'drcaseoverview' =>$drcaseoverview]);
    }

    // save tab info in database table.
    public function store(Request $request)
    {
        $result = $request->except('submit');
        // parse string to date for client info section
        if(isset($result['Client_Info_Resident_of_Court_State_Since_Date'])){
            $result['Client_Info_Resident_of_Court_State_Since_Date']=date("Y-m-d",strtotime($result['Client_Info_Resident_of_Court_State_Since_Date']));
        } else {
            $result['Client_Info_Resident_of_Court_State_Since_Date']=NULL;
        }
        if(isset($result['Client_Info_Resident_of_Court_County_Since_Date'])){
            $result['Client_Info_Resident_of_Court_County_Since_Date']=date("Y-m-d",strtotime($result['Client_Info_Resident_of_Court_County_Since_Date']));
        } else {
            $result['Client_Info_Resident_of_Court_County_Since_Date']=NULL;
        }

        if(isset($result['Client_Info_Currently_Pregnant']) && $result['Client_Info_Currently_Pregnant']=='1'){
            if(isset($result['Client_Info_Due_Date'])){
                $result['Client_Info_Due_Date']=date("Y-m-d",strtotime($result['Client_Info_Due_Date']));
            } else {
                $result['Client_Info_Due_Date']=NULL;
            }
        } else {
            $result['Client_Info_Currently_Pregnant']='0';
            $result['Client_Info_Due_Date']=NULL;
        }

        if(isset($result['Client_Info_Restore_Former_Name']) && $result['Client_Info_Restore_Former_Name']=='1'){
            if(isset($result['Client_Info_Former_Name'])){
            } else {
                $result['Client_Info_Former_Name']=NULL;
            }
        } else {
            $result['Client_Info_Restore_Former_Name']='0';
            $result['Client_Info_Former_Name']=NULL;
        }

        if(isset($result['Client_Info_College1_Degree_Awarded']) && $result['Client_Info_College1_Degree_Awarded']=='1'){
            if(isset($result['Client_Info_College1_Degree'])){
            } else {
                $result['Client_Info_College1_Degree']=NULL;
            }
        } else {
            $result['Client_Info_College1_Degree_Awarded']='0';
            $result['Client_Info_College1_Degree']=NULL;
        }

        if(isset($result['Client_Info_College2_Degree_Awarded']) && $result['Client_Info_College2_Degree_Awarded']=='1'){
            if(isset($result['Client_Info_College2_Degree'])){
            } else {
                $result['Client_Info_College2_Degree']=NULL;
            }
        } else {
            $result['Client_Info_College2_Degree_Awarded']='0';
            $result['Client_Info_College2_Degree']=NULL;
        }

        if(isset($result['Client_Info_GradSchool1_Degree_Awarded']) && $result['Client_Info_GradSchool1_Degree_Awarded']=='1'){
            if(isset($result['Client_Info_Grad_School1_Degree'])){
            } else {
                $result['Client_Info_Grad_School1_Degree']=NULL;
            }
        } else {
            $result['Client_Info_GradSchool1_Degree_Awarded']='0';
            $result['Client_Info_Grad_School1_Degree']=NULL;
        }

        if(isset($result['Client_Info_GradSchool2_Degree_Awarded']) && $result['Client_Info_GradSchool2_Degree_Awarded']=='1'){
            if(isset($result['Client_Info_Grad_School2_Degree'])){
            } else {
                $result['Client_Info_Grad_School2_Degree']=NULL;
            }
        } else {
            $result['Client_Info_GradSchool2_Degree_Awarded']='0';
            $result['Client_Info_Grad_School2_Degree']=NULL;
        }

        if(isset($result['Client_Info_TechPro_School1_Degree_Awarded']) && $result['Client_Info_TechPro_School1_Degree_Awarded']=='1'){
            if(isset($result['Client_Info_TechPro_School1_Degree'])){
            } else {
                $result['Client_Info_TechPro_School1_Degree']=NULL;
            }
        } else {
            $result['Client_Info_TechPro_School1_Degree_Awarded']='0';
            $result['Client_Info_TechPro_School1_Degree']=NULL;
        }

        if(isset($result['Client_Info_TechPro_School2_Degree_Awarded']) && $result['Client_Info_TechPro_School2_Degree_Awarded']=='1'){
            if(isset($result['Client_Info_TechPro_School2_Degree'])){
            } else {
                $result['Client_Info_TechPro_School2_Degree']=NULL;
            }
        } else {
            $result['Client_Info_TechPro_School2_Degree_Awarded']='0';
            $result['Client_Info_TechPro_School2_Degree']=NULL;
        }

        if(isset($result['Client_Info_Active_Military']) && $result['Client_Info_Active_Military']=='1'){
            if(isset($result['SCRA_Prevents_Client']) && $result['SCRA_Prevents_Client']=='1'){
                if(isset($result['Client_Waive_SCRA_Rights']) && $result['Client_Waive_SCRA_Rights']=='1'){
                } else {
                    $result['Client_Waive_SCRA_Rights']='0';
                }
                $result['Client_Possible_SCRA_Issues']='1';
            } else {
                $result['Client_Possible_SCRA_Issues']='0';
                $result['SCRA_Prevents_Client']='0';
            }
        } else {
            $result['Client_Info_Active_Military']='0';
            $result['Client_Branch']=NULL;
            $result['SCRA_Prevents_Client']='0';
            $result['Client_Waive_SCRA_Rights']='0';
            $result['Client_Possible_SCRA_Issues']='0';
        }

        if(isset($result['Client_Divorced_Prior']) && $result['Client_Divorced_Prior']=='1'){
            if(isset($result['Client_Info_Prior_Divorce_Date1'])){
                $result['Client_Info_Prior_Divorce_Date1']=date("Y-m-d",strtotime($result['Client_Info_Prior_Divorce_Date1']));
            } else {
                $result['Client_Info_Prior_Divorce_Date1']=NULL;
            }
            if(isset($result['Client_Info_Prior_Divorce_Date2'])){
                $result['Client_Info_Prior_Divorce_Date2']=date("Y-m-d",strtotime($result['Client_Info_Prior_Divorce_Date2']));
            } else {
                $result['Client_Info_Prior_Divorce_Date2']=NULL;
            }

            // new calculations
            $result['Client_Total_Prior_Divorce_Support_PAID']=0.00;
            $result['Client_Total_Prior_Divorce_Support_RECEIVED']=0.00;
            if(isset($result['Client_Info_Prior_Divorce1_Support_PAID']) && $result['Client_Info_Prior_Divorce1_Support_PAID'] !=''){
                $result['Client_Total_Prior_Divorce_Support_PAID']=$result['Client_Total_Prior_Divorce_Support_PAID']+$result['Client_Info_Prior_Divorce1_Support_PAID'];
            }
            if(isset($result['Client_Info_Prior_Divorce2_Support_PAID']) && $result['Client_Info_Prior_Divorce2_Support_PAID'] !=''){
                $result['Client_Total_Prior_Divorce_Support_PAID']=$result['Client_Total_Prior_Divorce_Support_PAID']+$result['Client_Info_Prior_Divorce2_Support_PAID'];
            }

            if(isset($result['Client_Info_Prior_Divorce1_Support_RECEIVED']) && $result['Client_Info_Prior_Divorce1_Support_RECEIVED'] !=''){
                $result['Client_Total_Prior_Divorce_Support_RECEIVED']=$result['Client_Total_Prior_Divorce_Support_RECEIVED']+$result['Client_Info_Prior_Divorce1_Support_RECEIVED'];
            }
            if(isset($result['Client_Info_Prior_Divorce2_Support_RECEIVED']) && $result['Client_Info_Prior_Divorce2_Support_RECEIVED'] !=''){
                $result['Client_Total_Prior_Divorce_Support_RECEIVED']=$result['Client_Total_Prior_Divorce_Support_RECEIVED']+$result['Client_Info_Prior_Divorce2_Support_RECEIVED'];
            }
        } else {
            $result['Client_Divorced_Prior']='0';
            $result['Client_Info_Prior_Divorce_Date1']=NULL;
            $result['Client_Info_Prior_Divorce_Case_Num1']=NULL;
            $result['Client_Info_Prior_Divorce1_Support_PAID']=NULL;
            $result['Client_Info_Prior_Divorce1_Support_RECEIVED']=NULL;
            $result['Client_Info_Prior_Divorce_Place1']=NULL;
            $result['Client_Info_Prior_Divorce_Date2']=NULL;
            $result['Client_Info_Prior_Divorce_Case_Num2']=NULL;
            $result['Client_Info_Prior_Divorce2_Support_PAID']=NULL;
            $result['Client_Info_Prior_Divorce2_Support_RECEIVED']=NULL;
            $result['Client_Info_Prior_Divorce_Place2']=NULL;
            $result['Client_Total_Prior_Divorce_Support_PAID']=NULL;
            $result['Client_Total_Prior_Divorce_Support_RECEIVED']=NULL;
        }


        // parse string to date for opponent info section
        if(isset($result['Op_Info_Resident_of_Court_State_Since_Date'])){
            $result['Op_Info_Resident_of_Court_State_Since_Date']=date("Y-m-d",strtotime($result['Op_Info_Resident_of_Court_State_Since_Date']));
        } else {
            $result['Op_Info_Resident_of_Court_State_Since_Date']=NULL;
        }
        if(isset($result['Op_Info_Resident_of_Court_County_Since_Date'])){
            $result['Op_Info_Resident_of_Court_County_Since_Date']=date("Y-m-d",strtotime($result['Op_Info_Resident_of_Court_County_Since_Date']));
        } else {
            $result['Op_Info_Resident_of_Court_County_Since_Date']=NULL;
        }

        if(isset($result['Op_Info_Currently_Pregnant']) && $result['Op_Info_Currently_Pregnant']=='1'){
            if(isset($result['Op_Info_Due_Date'])){
                $result['Op_Info_Due_Date']=date("Y-m-d",strtotime($result['Op_Info_Due_Date']));
            } else {
                $result['Op_Info_Due_Date']=NULL;
            }
        } else {
            $result['Op_Info_Currently_Pregnant']='0';
            $result['Op_Info_Due_Date']=NULL;
        }

        if(isset($result['Op_Info_Restore_Former_Name']) && $result['Op_Info_Restore_Former_Name']=='1'){
            if(isset($result['Op_Info_Former_Name'])){
            } else {
                $result['Op_Info_Former_Name']=NULL;
            }
        } else {
            $result['Op_Info_Restore_Former_Name']='0';
            $result['Op_Info_Former_Name']=NULL;
        }

        if(isset($result['Op_Info_College1_Degree_Awarded']) && $result['Op_Info_College1_Degree_Awarded']=='1'){
            if(isset($result['Op_Info_College1_Degree'])){
            } else {
                $result['Op_Info_College1_Degree']=NULL;
            }
        } else {
            $result['Op_Info_College1_Degree_Awarded']='0';
            $result['Op_Info_College1_Degree']=NULL;
        }

        if(isset($result['Op_Info_College2_Degree_Awarded']) && $result['Op_Info_College2_Degree_Awarded']=='1'){
            if(isset($result['Op_Info_College2_Degree'])){
            } else {
                $result['Op_Info_College2_Degree']=NULL;
            }
        } else {
            $result['Op_Info_College2_Degree_Awarded']='0';
            $result['Op_Info_College2_Degree']=NULL;
        }

        if(isset($result['Op_Info_GradSchool1_Degree_Awarded']) && $result['Op_Info_GradSchool1_Degree_Awarded']=='1'){
            if(isset($result['Op_Info_Grad_School1_Degree'])){
            } else {
                $result['Op_Info_Grad_School1_Degree']=NULL;
            }
        } else {
            $result['Op_Info_GradSchool1_Degree_Awarded']='0';
            $result['Op_Info_Grad_School1_Degree']=NULL;
        }

        if(isset($result['Op_Info_GradSchool2_Degree_Awarded']) && $result['Op_Info_GradSchool2_Degree_Awarded']=='1'){
            if(isset($result['Op_Info_Grad_School2_Degree'])){
            } else {
                $result['Op_Info_Grad_School2_Degree']=NULL;
            }
        } else {
            $result['Op_Info_GradSchool2_Degree_Awarded']='0';
            $result['Op_Info_Grad_School2_Degree']=NULL;
        }

        if(isset($result['Op_Info_TechPro_School1_Degree_Awarded']) && $result['Op_Info_TechPro_School1_Degree_Awarded']=='1'){
            if(isset($result['Op_Info_TechPro_School1_Degree'])){
            } else {
                $result['Op_Info_TechPro_School1_Degree']=NULL;
            }
        } else {
            $result['Op_Info_TechPro_School1_Degree_Awarded']='0';
            $result['Op_Info_TechPro_School1_Degree']=NULL;
        }

        if(isset($result['Op_Info_TechPro_School2_Degree_Awarded']) && $result['Op_Info_TechPro_School2_Degree_Awarded']=='1'){
            if(isset($result['Op_Info_TechPro_School2_Degree'])){
            } else {
                $result['Op_Info_TechPro_School2_Degree']=NULL;
            }
        } else {
            $result['Op_Info_TechPro_School2_Degree_Awarded']='0';
            $result['Op_Info_TechPro_School2_Degree']=NULL;
        }

        if(isset($result['Op_Info_Active_Military']) && $result['Op_Info_Active_Military']=='1'){
            if(isset($result['SCRA_Prevents_Op']) && $result['SCRA_Prevents_Op']=='1'){
                if(isset($result['Op_Waive_SCRA_Rights']) && $result['Op_Waive_SCRA_Rights']=='1'){
                } else {
                    $result['Op_Waive_SCRA_Rights']='0';
                }
                $result['Op_Possible_SCRA_Issues']='1';
            } else {
                $result['Op_Possible_SCRA_Issues']='0';
                $result['SCRA_Prevents_Op']='0';
            }
        } else {
            $result['Op_Info_Active_Military']='0';
            $result['Op_Branch']=NULL;
            $result['SCRA_Prevents_Op']='0';
            $result['Op_Waive_SCRA_Rights']='0';
            $result['Op_Possible_SCRA_Issues']='0';
        }

        if(isset($result['Op_Divorced_Prior']) && $result['Op_Divorced_Prior']=='1'){
            if(isset($result['Op_Info_Prior_Divorce_Date1'])){
                $result['Op_Info_Prior_Divorce_Date1']=date("Y-m-d",strtotime($result['Op_Info_Prior_Divorce_Date1']));
            } else {
                $result['Op_Info_Prior_Divorce_Date1']=NULL;
            }
            if(isset($result['Op_Info_Prior_Divorce_Date2'])){
                $result['Op_Info_Prior_Divorce_Date2']=date("Y-m-d",strtotime($result['Op_Info_Prior_Divorce_Date2']));
            } else {
                $result['Op_Info_Prior_Divorce_Date2']=NULL;
            }

            // new calculations
            $result['Op_Total_Prior_Divorce_Support_PAID']=0.00;
            $result['Op_Total_Prior_Divorce_Support_RECEIVED']=0.00;
            if(isset($result['Op_Info_Prior_Divorce1_Support_PAID']) && $result['Op_Info_Prior_Divorce1_Support_PAID'] !=''){
                $result['Op_Total_Prior_Divorce_Support_PAID']=$result['Op_Total_Prior_Divorce_Support_PAID']+$result['Op_Info_Prior_Divorce1_Support_PAID'];
            }
            if(isset($result['Op_Info_Prior_Divorce2_Support_PAID']) && $result['Op_Info_Prior_Divorce2_Support_PAID'] !=''){
                $result['Op_Total_Prior_Divorce_Support_PAID']=$result['Op_Total_Prior_Divorce_Support_PAID']+$result['Op_Info_Prior_Divorce2_Support_PAID'];
            }

            if(isset($result['Op_Info_Prior_Divorce1_Support_RECEIVED']) && $result['Op_Info_Prior_Divorce1_Support_RECEIVED'] !=''){
                $result['Op_Total_Prior_Divorce_Support_RECEIVED']=$result['Op_Total_Prior_Divorce_Support_RECEIVED']+$result['Op_Info_Prior_Divorce1_Support_RECEIVED'];
            }
            if(isset($result['Op_Info_Prior_Divorce2_Support_RECEIVED']) && $result['Op_Info_Prior_Divorce2_Support_RECEIVED'] !=''){
                $result['Op_Total_Prior_Divorce_Support_RECEIVED']=$result['Op_Total_Prior_Divorce_Support_RECEIVED']+$result['Op_Info_Prior_Divorce2_Support_RECEIVED'];
            }
        } else {
            $result['Op_Divorced_Prior']='0';
            $result['Op_Info_Prior_Divorce_Date1']=NULL;
            $result['Op_Info_Prior_Divorce_Case_Num1']=NULL;
            $result['Op_Info_Prior_Divorce1_Support_PAID']=NULL;
            $result['Op_Info_Prior_Divorce1_Support_RECEIVED']=NULL;
            $result['Op_Info_Prior_Divorce_Place1']=NULL;
            $result['Op_Info_Prior_Divorce_Date2']=NULL;
            $result['Op_Info_Prior_Divorce_Case_Num2']=NULL;
            $result['Op_Info_Prior_Divorce2_Support_PAID']=NULL;
            $result['Op_Info_Prior_Divorce2_Support_RECEIVED']=NULL;
            $result['Op_Info_Prior_Divorce_Place2']=NULL;
            $result['Op_Total_Prior_Divorce_Support_PAID']=NULL;
            $result['Op_Total_Prior_Divorce_Support_RECEIVED']=NULL;
        }
        // echo "<pre>";print_r($result);die;
        $DrPersonalInfo=DrPersonalInfo::create($result);

        // update case overview info.
        if(isset($result['Client_Waive_SCRA_Rights']) && $result['Client_Waive_SCRA_Rights']=='1'){
        } else {
            $result['Client_Waive_SCRA_Rights']='0';
        }
        if(isset($result['Op_Waive_SCRA_Rights']) && $result['Op_Waive_SCRA_Rights']=='1'){
        } else {
            $result['Op_Waive_SCRA_Rights']='0';
        }
        $drcaseoverview=DrCaseOverview::where('case_id',$result['case_id'])->get()->first();
        if(isset($drcaseoverview)){
            $drcaseoverview->Client_Info_Active_Military=$result['Client_Info_Active_Military'];
            $drcaseoverview->Client_Branch=$result['Client_Branch'];
            $drcaseoverview->SCRA_Prevents_Client=$result['SCRA_Prevents_Client'];
            $drcaseoverview->Client_Waive_SCRA_Rights=$result['Client_Waive_SCRA_Rights'];
            $drcaseoverview->Client_Possible_SCRA_Issues=$result['Client_Possible_SCRA_Issues'];

            $drcaseoverview->Op_Info_Active_Military=$result['Op_Info_Active_Military'];
            $drcaseoverview->Op_Branch=$result['Op_Branch'];
            $drcaseoverview->SCRA_Prevents_Op=$result['SCRA_Prevents_Op'];
            $drcaseoverview->Op_Waive_SCRA_Rights=$result['Op_Waive_SCRA_Rights'];
            $drcaseoverview->Op_Possible_SCRA_Issues=$result['Op_Possible_SCRA_Issues'];
            $drcaseoverview->save();
        } else {
            return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('error', 'Complete Case Overview Info Section First.');
        }
        
        return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('success', 'Personal Information Submitted Successfully.');
        
    }

    public function show($case_id)
    {

    }

    public function edit($case_id)
    {
        $user_role=Auth::user()->roles->first()->name;
        if($user_role=='client'){
            $client_attorney = Caseuser::where([['case_id', $case_id],['user_id', Auth::user()->id]])->get()->pluck('attorney_id')->first();
            if($client_attorney){
                $case_info=Courtcase::where([['id', $case_id],['attorney_id', $client_attorney]])->first();
            } else {
                return redirect()->route('client.cases');
            }
        } else {
            $case_info=Courtcase::where([['id', $case_id],['attorney_id', Auth::user()->id]])->first();
        }
        
        $case_info->state_name= State::find($case_info->state_id)->state;
        $case_info->county_name= County::find($case_info->county_id)->county_name;

        $case_attorney=$case_info->attorney_id;
        if(isset($case_attorney)){
        } else {
            return redirect()->route('home');
        }
        $drpersonalinfo=DrPersonalInfo::where('case_id',$case_id)->get()->first();
        $drcaseoverview=DrCaseOverview::where('case_id',$case_id)->get()->first();
        if($drpersonalinfo){
            if(isset($drcaseoverview)){
                if(isset($drcaseoverview) && $drcaseoverview->Client_Info_Active_Military==$drpersonalinfo->Client_Info_Active_Military && $drcaseoverview->Client_Branch==$drpersonalinfo->Client_Branch && $drcaseoverview->SCRA_Prevents_Client==$drpersonalinfo->SCRA_Prevents_Client && $drcaseoverview->Client_Waive_SCRA_Rights==$drpersonalinfo->Client_Waive_SCRA_Rights && $drcaseoverview->Client_Possible_SCRA_Issues==$drpersonalinfo->Client_Possible_SCRA_Issues && $drcaseoverview->Op_Info_Active_Military==$drpersonalinfo->Op_Info_Active_Military && $drcaseoverview->Op_Branch==$drpersonalinfo->Op_Branch && $drcaseoverview->SCRA_Prevents_Op==$drpersonalinfo->SCRA_Prevents_Op && $drcaseoverview->Op_Waive_SCRA_Rights==$drpersonalinfo->Op_Waive_SCRA_Rights && $drcaseoverview->Op_Possible_SCRA_Issues==$drpersonalinfo->Op_Possible_SCRA_Issues)
                {
                } else {
                    $drpersonalinfo->Client_Info_Active_Military=$drcaseoverview->Client_Info_Active_Military;
                    $drpersonalinfo->Client_Branch=$drcaseoverview->Client_Branch;
                    $drpersonalinfo->SCRA_Prevents_Client=$drcaseoverview->SCRA_Prevents_Client;
                    $drpersonalinfo->Client_Waive_SCRA_Rights=$drcaseoverview->Client_Waive_SCRA_Rights;
                    $drpersonalinfo->Client_Possible_SCRA_Issues=$drcaseoverview->Client_Possible_SCRA_Issues;

                    $drpersonalinfo->Op_Info_Active_Military=$drcaseoverview->Op_Info_Active_Military;
                    $drpersonalinfo->Op_Branch=$drcaseoverview->Op_Branch;
                    $drpersonalinfo->SCRA_Prevents_Op=$drcaseoverview->SCRA_Prevents_Op;
                    $drpersonalinfo->Op_Waive_SCRA_Rights=$drcaseoverview->Op_Waive_SCRA_Rights;
                    $drpersonalinfo->Op_Possible_SCRA_Issues=$drcaseoverview->Op_Possible_SCRA_Issues;
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
            return view('dr_tables.dr_PersonalInfo.edit',['case_id'=> $case_id, 'drpersonalinfo' => $drpersonalinfo, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'case_info' =>$case_info]);
        } else {
            return redirect()->route('home');
        }

        
    }

    public function update(Request $request, $id)
    {
        $result = $request->except('submit','_method','_token');
        // parse string to date for client info section
        if(isset($result['Client_Info_Resident_of_Court_State_Since_Date'])){
            $result['Client_Info_Resident_of_Court_State_Since_Date']=date("Y-m-d",strtotime($result['Client_Info_Resident_of_Court_State_Since_Date']));
        } else {
            $result['Client_Info_Resident_of_Court_State_Since_Date']=NULL;
        }
        if(isset($result['Client_Info_Resident_of_Court_County_Since_Date'])){
            $result['Client_Info_Resident_of_Court_County_Since_Date']=date("Y-m-d",strtotime($result['Client_Info_Resident_of_Court_County_Since_Date']));
        } else {
            $result['Client_Info_Resident_of_Court_County_Since_Date']=NULL;
        }

        if(isset($result['Client_Info_Currently_Pregnant']) && $result['Client_Info_Currently_Pregnant']=='1'){
            if(isset($result['Client_Info_Due_Date'])){
                $result['Client_Info_Due_Date']=date("Y-m-d",strtotime($result['Client_Info_Due_Date']));
            } else {
                $result['Client_Info_Due_Date']=NULL;
            }
        } else {
            $result['Client_Info_Currently_Pregnant']='0';
            $result['Client_Info_Due_Date']=NULL;
        }

        if(isset($result['Client_Info_Restore_Former_Name']) && $result['Client_Info_Restore_Former_Name']=='1'){
            if(isset($result['Client_Info_Former_Name'])){
            } else {
                $result['Client_Info_Former_Name']=NULL;
            }
        } else {
            $result['Client_Info_Restore_Former_Name']='0';
            $result['Client_Info_Former_Name']=NULL;
        }

        if(isset($result['Client_Info_College1_Degree_Awarded']) && $result['Client_Info_College1_Degree_Awarded']=='1'){
            if(isset($result['Client_Info_College1_Degree'])){
            } else {
                $result['Client_Info_College1_Degree']=NULL;
            }
        } else {
            $result['Client_Info_College1_Degree_Awarded']='0';
            $result['Client_Info_College1_Degree']=NULL;
        }

        if(isset($result['Client_Info_College2_Degree_Awarded']) && $result['Client_Info_College2_Degree_Awarded']=='1'){
            if(isset($result['Client_Info_College2_Degree'])){
            } else {
                $result['Client_Info_College2_Degree']=NULL;
            }
        } else {
            $result['Client_Info_College2_Degree_Awarded']='0';
            $result['Client_Info_College2_Degree']=NULL;
        }

        if(isset($result['Client_Info_GradSchool1_Degree_Awarded']) && $result['Client_Info_GradSchool1_Degree_Awarded']=='1'){
            if(isset($result['Client_Info_Grad_School1_Degree'])){
            } else {
                $result['Client_Info_Grad_School1_Degree']=NULL;
            }
        } else {
            $result['Client_Info_GradSchool1_Degree_Awarded']='0';
            $result['Client_Info_Grad_School1_Degree']=NULL;
        }

        if(isset($result['Client_Info_GradSchool2_Degree_Awarded']) && $result['Client_Info_GradSchool2_Degree_Awarded']=='1'){
            if(isset($result['Client_Info_Grad_School2_Degree'])){
            } else {
                $result['Client_Info_Grad_School2_Degree']=NULL;
            }
        } else {
            $result['Client_Info_GradSchool2_Degree_Awarded']='0';
            $result['Client_Info_Grad_School2_Degree']=NULL;
        }

        if(isset($result['Client_Info_TechPro_School1_Degree_Awarded']) && $result['Client_Info_TechPro_School1_Degree_Awarded']=='1'){
            if(isset($result['Client_Info_TechPro_School1_Degree'])){
            } else {
                $result['Client_Info_TechPro_School1_Degree']=NULL;
            }
        } else {
            $result['Client_Info_TechPro_School1_Degree_Awarded']='0';
            $result['Client_Info_TechPro_School1_Degree']=NULL;
        }

        if(isset($result['Client_Info_TechPro_School2_Degree_Awarded']) && $result['Client_Info_TechPro_School2_Degree_Awarded']=='1'){
            if(isset($result['Client_Info_TechPro_School2_Degree'])){
            } else {
                $result['Client_Info_TechPro_School2_Degree']=NULL;
            }
        } else {
            $result['Client_Info_TechPro_School2_Degree_Awarded']='0';
            $result['Client_Info_TechPro_School2_Degree']=NULL;
        }

        if(isset($result['Client_Info_Active_Military']) && $result['Client_Info_Active_Military']=='1'){
            if(isset($result['SCRA_Prevents_Client']) && $result['SCRA_Prevents_Client']=='1'){
                if(isset($result['Client_Waive_SCRA_Rights']) && $result['Client_Waive_SCRA_Rights']=='1'){
                } else {
                    $result['Client_Waive_SCRA_Rights']='0';
                }
                $result['Client_Possible_SCRA_Issues']='1';
            } else {
                $result['Client_Possible_SCRA_Issues']='0';
                $result['SCRA_Prevents_Client']='0';
            }
        } else {
            $result['Client_Info_Active_Military']='0';
            $result['Client_Branch']=NULL;
            $result['SCRA_Prevents_Client']='0';
            $result['Client_Waive_SCRA_Rights']='0';
            $result['Client_Possible_SCRA_Issues']='0';
        }

        if(isset($result['Client_Divorced_Prior']) && $result['Client_Divorced_Prior']=='1'){
            if(isset($result['Client_Info_Prior_Divorce_Date1'])){
                $result['Client_Info_Prior_Divorce_Date1']=date("Y-m-d",strtotime($result['Client_Info_Prior_Divorce_Date1']));
            } else {
                $result['Client_Info_Prior_Divorce_Date1']=NULL;
            }
            if(isset($result['Client_Info_Prior_Divorce_Date2'])){
                $result['Client_Info_Prior_Divorce_Date2']=date("Y-m-d",strtotime($result['Client_Info_Prior_Divorce_Date2']));
            } else {
                $result['Client_Info_Prior_Divorce_Date2']=NULL;
            }

            // new calculations
            $result['Client_Total_Prior_Divorce_Support_PAID']=0.00;
            $result['Client_Total_Prior_Divorce_Support_RECEIVED']=0.00;
            if(isset($result['Client_Info_Prior_Divorce1_Support_PAID']) && $result['Client_Info_Prior_Divorce1_Support_PAID'] !=''){
                $result['Client_Total_Prior_Divorce_Support_PAID']=$result['Client_Total_Prior_Divorce_Support_PAID']+$result['Client_Info_Prior_Divorce1_Support_PAID'];
            }
            if(isset($result['Client_Info_Prior_Divorce2_Support_PAID']) && $result['Client_Info_Prior_Divorce2_Support_PAID'] !=''){
                $result['Client_Total_Prior_Divorce_Support_PAID']=$result['Client_Total_Prior_Divorce_Support_PAID']+$result['Client_Info_Prior_Divorce2_Support_PAID'];
            }

            if(isset($result['Client_Info_Prior_Divorce1_Support_RECEIVED']) && $result['Client_Info_Prior_Divorce1_Support_RECEIVED'] !=''){
                $result['Client_Total_Prior_Divorce_Support_RECEIVED']=$result['Client_Total_Prior_Divorce_Support_RECEIVED']+$result['Client_Info_Prior_Divorce1_Support_RECEIVED'];
            }
            if(isset($result['Client_Info_Prior_Divorce2_Support_RECEIVED']) && $result['Client_Info_Prior_Divorce2_Support_RECEIVED'] !=''){
                $result['Client_Total_Prior_Divorce_Support_RECEIVED']=$result['Client_Total_Prior_Divorce_Support_RECEIVED']+$result['Client_Info_Prior_Divorce2_Support_RECEIVED'];
            }
        } else {
            $result['Client_Divorced_Prior']='0';
            $result['Client_Info_Prior_Divorce_Date1']=NULL;
            $result['Client_Info_Prior_Divorce_Case_Num1']=NULL;
            $result['Client_Info_Prior_Divorce1_Support_PAID']=NULL;
            $result['Client_Info_Prior_Divorce1_Support_RECEIVED']=NULL;
            $result['Client_Info_Prior_Divorce_Place1']=NULL;
            $result['Client_Info_Prior_Divorce_Date2']=NULL;
            $result['Client_Info_Prior_Divorce_Case_Num2']=NULL;
            $result['Client_Info_Prior_Divorce2_Support_PAID']=NULL;
            $result['Client_Info_Prior_Divorce2_Support_RECEIVED']=NULL;
            $result['Client_Info_Prior_Divorce_Place2']=NULL;
            $result['Client_Total_Prior_Divorce_Support_PAID']=NULL;
            $result['Client_Total_Prior_Divorce_Support_RECEIVED']=NULL;
        }


        // parse string to date for opponent info section
        if(isset($result['Op_Info_Resident_of_Court_State_Since_Date'])){
            $result['Op_Info_Resident_of_Court_State_Since_Date']=date("Y-m-d",strtotime($result['Op_Info_Resident_of_Court_State_Since_Date']));
        } else {
            $result['Op_Info_Resident_of_Court_State_Since_Date']=NULL;
        }
        if(isset($result['Op_Info_Resident_of_Court_County_Since_Date'])){
            $result['Op_Info_Resident_of_Court_County_Since_Date']=date("Y-m-d",strtotime($result['Op_Info_Resident_of_Court_County_Since_Date']));
        } else {
            $result['Op_Info_Resident_of_Court_County_Since_Date']=NULL;
        }

        if(isset($result['Op_Info_Currently_Pregnant']) && $result['Op_Info_Currently_Pregnant']=='1'){
            if(isset($result['Op_Info_Due_Date'])){
                $result['Op_Info_Due_Date']=date("Y-m-d",strtotime($result['Op_Info_Due_Date']));
            } else {
                $result['Op_Info_Due_Date']=NULL;
            }
        } else {
            $result['Op_Info_Currently_Pregnant']='0';
            $result['Op_Info_Due_Date']=NULL;
        }

        if(isset($result['Op_Info_Restore_Former_Name']) && $result['Op_Info_Restore_Former_Name']=='1'){
            if(isset($result['Op_Info_Former_Name'])){
            } else {
                $result['Op_Info_Former_Name']=NULL;
            }
        } else {
            $result['Op_Info_Restore_Former_Name']='0';
            $result['Op_Info_Former_Name']=NULL;
        }

        if(isset($result['Op_Info_College1_Degree_Awarded']) && $result['Op_Info_College1_Degree_Awarded']=='1'){
            if(isset($result['Op_Info_College1_Degree'])){
            } else {
                $result['Op_Info_College1_Degree']=NULL;
            }
        } else {
            $result['Op_Info_College1_Degree_Awarded']='0';
            $result['Op_Info_College1_Degree']=NULL;
        }

        if(isset($result['Op_Info_College2_Degree_Awarded']) && $result['Op_Info_College2_Degree_Awarded']=='1'){
            if(isset($result['Op_Info_College2_Degree'])){
            } else {
                $result['Op_Info_College2_Degree']=NULL;
            }
        } else {
            $result['Op_Info_College2_Degree_Awarded']='0';
            $result['Op_Info_College2_Degree']=NULL;
        }

        if(isset($result['Op_Info_GradSchool1_Degree_Awarded']) && $result['Op_Info_GradSchool1_Degree_Awarded']=='1'){
            if(isset($result['Op_Info_Grad_School1_Degree'])){
            } else {
                $result['Op_Info_Grad_School1_Degree']=NULL;
            }
        } else {
            $result['Op_Info_GradSchool1_Degree_Awarded']='0';
            $result['Op_Info_Grad_School1_Degree']=NULL;
        }

        if(isset($result['Op_Info_GradSchool2_Degree_Awarded']) && $result['Op_Info_GradSchool2_Degree_Awarded']=='1'){
            if(isset($result['Op_Info_Grad_School2_Degree'])){
            } else {
                $result['Op_Info_Grad_School2_Degree']=NULL;
            }
        } else {
            $result['Op_Info_GradSchool2_Degree_Awarded']='0';
            $result['Op_Info_Grad_School2_Degree']=NULL;
        }

        if(isset($result['Op_Info_TechPro_School1_Degree_Awarded']) && $result['Op_Info_TechPro_School1_Degree_Awarded']=='1'){
            if(isset($result['Op_Info_TechPro_School1_Degree'])){
            } else {
                $result['Op_Info_TechPro_School1_Degree']=NULL;
            }
        } else {
            $result['Op_Info_TechPro_School1_Degree_Awarded']='0';
            $result['Op_Info_TechPro_School1_Degree']=NULL;
        }

        if(isset($result['Op_Info_TechPro_School2_Degree_Awarded']) && $result['Op_Info_TechPro_School2_Degree_Awarded']=='1'){
            if(isset($result['Op_Info_TechPro_School2_Degree'])){
            } else {
                $result['Op_Info_TechPro_School2_Degree']=NULL;
            }
        } else {
            $result['Op_Info_TechPro_School2_Degree_Awarded']='0';
            $result['Op_Info_TechPro_School2_Degree']=NULL;
        }

        if(isset($result['Op_Info_Active_Military']) && $result['Op_Info_Active_Military']=='1'){
            if(isset($result['SCRA_Prevents_Op']) && $result['SCRA_Prevents_Op']=='1'){
                if(isset($result['Op_Waive_SCRA_Rights']) && $result['Op_Waive_SCRA_Rights']=='1'){
                } else {
                    $result['Op_Waive_SCRA_Rights']='0';
                }
                $result['Op_Possible_SCRA_Issues']='1';
            } else {
                $result['Op_Possible_SCRA_Issues']='0';
                $result['SCRA_Prevents_Op']='0';
            }
        } else {
            $result['Op_Info_Active_Military']='0';
            $result['Op_Branch']=NULL;
            $result['SCRA_Prevents_Op']='0';
            $result['Op_Waive_SCRA_Rights']='0';
            $result['Op_Possible_SCRA_Issues']='0';
        }

        if(isset($result['Op_Divorced_Prior']) && $result['Op_Divorced_Prior']=='1'){
            if(isset($result['Op_Info_Prior_Divorce_Date1'])){
                $result['Op_Info_Prior_Divorce_Date1']=date("Y-m-d",strtotime($result['Op_Info_Prior_Divorce_Date1']));
            } else {
                $result['Op_Info_Prior_Divorce_Date1']=NULL;
            }
            if(isset($result['Op_Info_Prior_Divorce_Date2'])){
                $result['Op_Info_Prior_Divorce_Date2']=date("Y-m-d",strtotime($result['Op_Info_Prior_Divorce_Date2']));
            } else {
                $result['Op_Info_Prior_Divorce_Date2']=NULL;
            }

            // new calculations
            $result['Op_Total_Prior_Divorce_Support_PAID']=0.00;
            $result['Op_Total_Prior_Divorce_Support_RECEIVED']=0.00;
            if(isset($result['Op_Info_Prior_Divorce1_Support_PAID']) && $result['Op_Info_Prior_Divorce1_Support_PAID'] !=''){
                $result['Op_Total_Prior_Divorce_Support_PAID']=$result['Op_Total_Prior_Divorce_Support_PAID']+$result['Op_Info_Prior_Divorce1_Support_PAID'];
            }
            if(isset($result['Op_Info_Prior_Divorce2_Support_PAID']) && $result['Op_Info_Prior_Divorce2_Support_PAID'] !=''){
                $result['Op_Total_Prior_Divorce_Support_PAID']=$result['Op_Total_Prior_Divorce_Support_PAID']+$result['Op_Info_Prior_Divorce2_Support_PAID'];
            }

            if(isset($result['Op_Info_Prior_Divorce1_Support_RECEIVED']) && $result['Op_Info_Prior_Divorce1_Support_RECEIVED'] !=''){
                $result['Op_Total_Prior_Divorce_Support_RECEIVED']=$result['Op_Total_Prior_Divorce_Support_RECEIVED']+$result['Op_Info_Prior_Divorce1_Support_RECEIVED'];
            }
            if(isset($result['Op_Info_Prior_Divorce2_Support_RECEIVED']) && $result['Op_Info_Prior_Divorce2_Support_RECEIVED'] !=''){
                $result['Op_Total_Prior_Divorce_Support_RECEIVED']=$result['Op_Total_Prior_Divorce_Support_RECEIVED']+$result['Op_Info_Prior_Divorce2_Support_RECEIVED'];
            }
        } else {
            $result['Op_Divorced_Prior']='0';
            $result['Op_Info_Prior_Divorce_Date1']=NULL;
            $result['Op_Info_Prior_Divorce_Case_Num1']=NULL;
            $result['Op_Info_Prior_Divorce1_Support_PAID']=NULL;
            $result['Op_Info_Prior_Divorce1_Support_RECEIVED']=NULL;
            $result['Op_Info_Prior_Divorce_Place1']=NULL;
            $result['Op_Info_Prior_Divorce_Date2']=NULL;
            $result['Op_Info_Prior_Divorce_Case_Num2']=NULL;
            $result['Op_Info_Prior_Divorce2_Support_PAID']=NULL;
            $result['Op_Info_Prior_Divorce2_Support_RECEIVED']=NULL;
            $result['Op_Info_Prior_Divorce_Place2']=NULL;
            $result['Op_Total_Prior_Divorce_Support_PAID']=NULL;
            $result['Op_Total_Prior_Divorce_Support_RECEIVED']=NULL;
        }
        // echo "<pre>";print_r($result);die;

        $DrPersonalInfo  = DrPersonalInfo::findOrFail($id);
        if($DrPersonalInfo){
            $DrPersonalInfo->fill($result)->save();
            // update case overview info.
            $drcaseoverview=DrCaseOverview::where('case_id',$result['case_id'])->get()->first();
            if(isset($result['Client_Waive_SCRA_Rights']) && $result['Client_Waive_SCRA_Rights']=='1'){
            } else {
                $result['Client_Waive_SCRA_Rights']='0';
            }
            if(isset($result['Op_Waive_SCRA_Rights']) && $result['Op_Waive_SCRA_Rights']=='1'){
            } else {
                $result['Op_Waive_SCRA_Rights']='0';
            }
            if(isset($drcaseoverview)){
                $drcaseoverview->Client_Info_Active_Military=$result['Client_Info_Active_Military'];
                $drcaseoverview->Client_Branch=$result['Client_Branch'];
                $drcaseoverview->SCRA_Prevents_Client=$result['SCRA_Prevents_Client'];
                $drcaseoverview->Client_Waive_SCRA_Rights=$result['Client_Waive_SCRA_Rights'];
                $drcaseoverview->Client_Possible_SCRA_Issues=$result['Client_Possible_SCRA_Issues'];

                $drcaseoverview->Op_Info_Active_Military=$result['Op_Info_Active_Military'];
                $drcaseoverview->Op_Branch=$result['Op_Branch'];
                $drcaseoverview->SCRA_Prevents_Op=$result['SCRA_Prevents_Op'];
                $drcaseoverview->Op_Waive_SCRA_Rights=$result['Op_Waive_SCRA_Rights'];
                $drcaseoverview->Op_Possible_SCRA_Issues=$result['Op_Possible_SCRA_Issues'];
                $drcaseoverview->save();
            } else {
                return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('error', 'Complete Case Overview Info Section First.');
            }
            return redirect()->route('drpersonalinfo.edit',$result['case_id'])->with('success', 'Personal Information Updated Successfully.');
        } else {
            return redirect()->route('drpersonalinfo.edit',$result['case_id'])->with('error', 'Something went wrong. Please try Again.');
        }
    }
    
    public function destroy($case_id)
    {

    }

}
