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
use App\DrRetirementAccts;
use App\DrCaseOverview;


class DrRetirementAcctsController extends Controller
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
        $data=DrRetirementAccts::orderBy('id','DESC')->get();
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

        $drretirementaccts=DrRetirementAccts::where('case_id',$case_id)->get()->pluck('case_id');
        if(isset($drretirementaccts['0'])){
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
        return view('dr_tables.dr_RetirementAccts.create',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'drcaseoverview'=>$drcaseoverview]);
    }

    // save tab info in database table.
    public function store(Request $request)
    {
        $result = $request->except('submit');
        $result['RetAccts_Total_Marital_Equity']=0.00;
        $result['RetAccts_Total_Client_PropertyValue_Equity']=0.00;
        $result['RetAccts_Total_Op_PropertyValue_Equity']=0.00;
        $result['RetAccts_Total_Client_Yearly_Income']=0.00;
        $result['RetAccts_Total_Op_Yearly_Income']=0.00;
        for ($i=1; $i <= 4; $i++) {
            unset($result[''.$i.'_Client_RetAcct_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Op_RetAcct_Estimated_Value_Select_Reset']);
            
            if(isset($result['Client_RetAcct'.$i.'_Disposition_Type_QDRO']) && $result['Client_RetAcct'.$i.'_Disposition_Type_QDRO'] !=''){
                if($result['Client_RetAcct'.$i.'_Disposition_Type_QDRO']=='QDRO_Fixed'){
                    $result['Client_RetAcct'.$i.'_Disposition_Type']='QDRO';
                    $result['Client_RetAcct'.$i.'_Disposition_Method']='Fixed';
                }
                if($result['Client_RetAcct'.$i.'_Disposition_Type_QDRO']=='QDRO_Percentage'){
                    $result['Client_RetAcct'.$i.'_Disposition_Type']='QDRO';
                    $result['Client_RetAcct'.$i.'_Disposition_Method']='Percentage';
                }
                if($result['Client_RetAcct'.$i.'_Disposition_Type_QDRO']=='Fixed_Buyout'){
                    $result['Client_RetAcct'.$i.'_Disposition_Type']='Buyout';
                    $result['Client_RetAcct'.$i.'_Disposition_Method']='Fixed';
                }
            } else {
                $result['Client_RetAcct'.$i.'_Disposition_Type']=NULL;
                $result['Client_RetAcct'.$i.'_Disposition_Method']=NULL;
            }
            unset($result['Client_RetAcct'.$i.'_Disposition_Type_QDRO']);
            unset($result['Client_RetAcct'.$i.'_Disposition_Type_QDRO_Amount']);
            unset($result['Client_RetAcct'.$i.'_Disposition_Type_QDRO_Percentage_Amount']);

            $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client']=0.00;
            $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Op']=0.00;
            if(isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income']) && !isset($result['Client_RetAcct'.$i.'_Percent_Marital_Equity_to_Client'])){
                $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client']=$result['Client_RetAcct'.$i.'_Current_Yearly_Income'];
            }
            if(!isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income']) && isset($result['Client_RetAcct'.$i.'_Percent_Marital_Equity_to_Client'])){
                $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client']=$result['Client_RetAcct'.$i.'_Percent_Marital_Equity_to_Client']/100;
            }
            if(isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income']) && isset($result['Client_RetAcct'.$i.'_Percent_Marital_Equity_to_Client'])){
                $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client']=$result['Client_RetAcct'.$i.'_Current_Yearly_Income']*($result['Client_RetAcct'.$i.'_Percent_Marital_Equity_to_Client']/100);
            }

            if(isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income']) && !isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client'])){
                $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Op']=$result['Client_RetAcct'.$i.'_Current_Yearly_Income'];
            }
            if(!isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income']) && isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client'])){
                $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Op']=$result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client'];
            }
            if(isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income']) && isset($result['Client_RetAcct'.$i.'_Percent_Marital_Equity_to_Client'])){
                $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Op']=$result['Client_RetAcct'.$i.'_Current_Yearly_Income']-$result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client'];
            }

            // for opponent

            $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client']=0.00;
            $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Op']=0.00;
            if(isset($result['Op_RetAcct'.$i.'_Disposition_Type_QDRO']) && $result['Op_RetAcct'.$i.'_Disposition_Type_QDRO'] !=''){
                if($result['Op_RetAcct'.$i.'_Disposition_Type_QDRO']=='QDRO_Fixed'){
                    $result['Op_RetAcct'.$i.'_Disposition_Type']='QDRO';
                    $result['Op_RetAcct'.$i.'_Disposition_Method']='Fixed';
                }
                if($result['Op_RetAcct'.$i.'_Disposition_Type_QDRO']=='QDRO_Percentage'){
                    $result['Op_RetAcct'.$i.'_Disposition_Type']='QDRO';
                    $result['Op_RetAcct'.$i.'_Disposition_Method']='Percentage';
                }
                if($result['Op_RetAcct'.$i.'_Disposition_Type_QDRO']=='Fixed_Buyout'){
                    $result['Op_RetAcct'.$i.'_Disposition_Type']='Buyout';
                    $result['Op_RetAcct'.$i.'_Disposition_Method']='Fixed';
                }
            } else {
                $result['Op_RetAcct'.$i.'_Disposition_Type']=NULL;
                $result['Op_RetAcct'.$i.'_Disposition_Method']=NULL;
            }
            unset($result['Op_RetAcct'.$i.'_Disposition_Type_QDRO']);
            unset($result['Op_RetAcct'.$i.'_Disposition_Type_QDRO_Amount']);
            unset($result['Op_RetAcct'.$i.'_Disposition_Type_QDRO_Percentage_Amount']);

            if(isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income']) && !isset($result['Op_RetAcct'.$i.'_Percent_Marital_Equity_to_Client'])){
                $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client']=$result['Op_RetAcct'.$i.'_Current_Yearly_Income'];
            }
            if(!isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income']) && isset($result['Op_RetAcct'.$i.'_Percent_Marital_Equity_to_Client'])){
                $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client']=$result['Op_RetAcct'.$i.'_Percent_Marital_Equity_to_Client']/100;
            }
            if(isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income']) && isset($result['Op_RetAcct'.$i.'_Percent_Marital_Equity_to_Client'])){
                $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client']=$result['Op_RetAcct'.$i.'_Current_Yearly_Income']*($result['Op_RetAcct'.$i.'_Percent_Marital_Equity_to_Client']/100);
            }

            if(isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income']) && !isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client'])){
                $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Op']=$result['Op_RetAcct'.$i.'_Current_Yearly_Income'];
            }
            if(!isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income']) && isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client'])){
                $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Op']=$result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client'];
            }
            if(isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income']) && isset($result['Op_RetAcct'.$i.'_Percent_Marital_Equity_to_Client'])){
                $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Op']=$result['Op_RetAcct'.$i.'_Current_Yearly_Income']-$result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client'];
            }

            // for other calculations
            if(isset($result['Client_RetAcct'.$i.'_Estimated_MaritalEquity1']) && $result['Client_RetAcct'.$i.'_Estimated_MaritalEquity1'] !=''){
                $result['RetAccts_Total_Marital_Equity']=$result['RetAccts_Total_Marital_Equity']+$result['Client_RetAcct'.$i.'_Estimated_MaritalEquity1'];
            }
            if(isset($result['Op_RetAcct'.$i.'_Estimated_MaritalEquity1']) && $result['Op_RetAcct'.$i.'_Estimated_MaritalEquity1'] !=''){
                $result['RetAccts_Total_Marital_Equity']=$result['RetAccts_Total_Marital_Equity']+$result['Op_RetAcct'.$i.'_Estimated_MaritalEquity1'];
            }
            
            if(isset($result['Client_RetAcct'.$i.'_Estimated_Value_to_Client']) && $result['Client_RetAcct'.$i.'_Estimated_Value_to_Client'] !=''){
                $result['RetAccts_Total_Client_PropertyValue_Equity']=$result['RetAccts_Total_Client_PropertyValue_Equity']+$result['Client_RetAcct'.$i.'_Estimated_Value_to_Client'];
            }
            if(isset($result['Op_RetAcct'.$i.'_Estimated_Value_to_Client']) && $result['Op_RetAcct'.$i.'_Estimated_Value_to_Client'] !=''){
                $result['RetAccts_Total_Client_PropertyValue_Equity']=$result['RetAccts_Total_Client_PropertyValue_Equity']+$result['Op_RetAcct'.$i.'_Estimated_Value_to_Client'];
            }
            
            if(isset($result['Client_RetAcct'.$i.'_Estimated_Value_to_Op']) && $result['Client_RetAcct'.$i.'_Estimated_Value_to_Op'] !=''){
                $result['RetAccts_Total_Op_PropertyValue_Equity']=$result['RetAccts_Total_Op_PropertyValue_Equity']+$result['Client_RetAcct'.$i.'_Estimated_Value_to_Op'];
            }
            if(isset($result['Op_RetAcct'.$i.'_Estimated_Value_to_Op']) && $result['Op_RetAcct'.$i.'_Estimated_Value_to_Op'] !=''){
                $result['RetAccts_Total_Op_PropertyValue_Equity']=$result['RetAccts_Total_Op_PropertyValue_Equity']+$result['Op_RetAcct'.$i.'_Estimated_Value_to_Op'];
            }
            
            if(isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client']) && $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client'] !=''){
                $result['RetAccts_Total_Client_Yearly_Income']=$result['RetAccts_Total_Client_Yearly_Income']+$result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client'];
            }
            if(isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client']) && $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client'] !=''){
                $result['RetAccts_Total_Client_Yearly_Income']=$result['RetAccts_Total_Client_Yearly_Income']+$result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client'];
            }
            
            if(isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income_Op']) && $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Op'] !=''){
                $result['RetAccts_Total_Op_Yearly_Income']=$result['RetAccts_Total_Op_Yearly_Income']+$result['Client_RetAcct'.$i.'_Current_Yearly_Income_Op'];
            }
            if(isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income_Op']) && $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Op'] !=''){
                $result['RetAccts_Total_Op_Yearly_Income']=$result['RetAccts_Total_Op_Yearly_Income']+$result['Op_RetAcct'.$i.'_Current_Yearly_Income_Op'];
            }

        }

        if(isset($result['Any_Retirement_Accts']) && $result['Any_Retirement_Accts']=='1'){
        } else {
            $result['Any_Retirement_Accts']='0';
            $result['Num_Client_Retirement_Accts']=0;
            $result['Num_Op_Retirement_Accts']=0;
        }

        if(isset($result['Num_Client_Retirement_Accts'])){
        } else {
            $result['Num_Client_Retirement_Accts']='0';
        }
        $Num_Client_Retirement_Accts=$result['Num_Client_Retirement_Accts'];
        $Num_Client_Retirement_Accts=$Num_Client_Retirement_Accts+1;
        for ($i=$Num_Client_Retirement_Accts; $i <= 4; $i++) { 
            $result['Client_RetAcct'.$i.'_Institution_ZIP']=NULL;            
            $result['Client_RetAcct'.$i.'_Institution_Name']=NULL;            
            $result['Client_RetAcct'.$i.'_Institution_Street_Address']=NULL;            
            $result['Client_RetAcct'.$i.'_Institution_City']=NULL;            
            $result['Client_RetAcct'.$i.'_Institution_State']=NULL;            
            $result['Client_RetAcct'.$i.'_Institution_Acct_Num']=NULL;            
            $result['Client_RetAcct'.$i.'_Date_of_Marriage_Balance']=NULL;            
            $result['Client_RetAcct'.$i.'_Current_Balance']=NULL;            
            $result['Client_RetAcct'.$i.'_Estimated_MaritalEquity1']=NULL;            
            $result['Client_RetAcct'.$i.'_Current_Yearly_Income']=NULL;            
            $result['Client_RetAcct'.$i.'_SoleSeparate_Claim']=NULL;            
            $result['Client_RetAcct'.$i.'_SoleSeparate_Party']=NULL;            
            $result['Client_RetAcct'.$i.'_SoleSeparate_Grounds']=NULL;            
            $result['Client_RetAcct'.$i.'_Disposition_Type']=NULL;            
            $result['Client_RetAcct'.$i.'_Disposition_Method']=NULL;            
            $result['Client_RetAcct'.$i.'_Percent_Marital_Equity_to_Client']=NULL;            
            $result['Client_RetAcct'.$i.'_Percent_Marital_Equity_to_Op']=NULL;            
            $result['Client_RetAcct'.$i.'_Estimated_Value_to_Client']=NULL;            
            $result['Client_RetAcct'.$i.'_Estimated_Value_to_Op']=NULL;            
        }

        if(isset($result['Num_Op_Retirement_Accts'])){
        } else {
            $result['Num_Op_Retirement_Accts']='0';
        }
        $Num_Op_Retirement_Accts=$result['Num_Op_Retirement_Accts'];
        $Num_Op_Retirement_Accts=$Num_Op_Retirement_Accts+1;
        for ($i=$Num_Op_Retirement_Accts; $i <= 4; $i++) { 
            $result['Op_RetAcct'.$i.'_Institution_ZIP']=NULL;            
            $result['Op_RetAcct'.$i.'_Institution_Name']=NULL;            
            $result['Op_RetAcct'.$i.'_Institution_Street_Address']=NULL;            
            $result['Op_RetAcct'.$i.'_Institution_City']=NULL;            
            $result['Op_RetAcct'.$i.'_Institution_State']=NULL;            
            $result['Op_RetAcct'.$i.'_Institution_Acct_Num']=NULL;            
            $result['Op_RetAcct'.$i.'_Date_of_Marriage_Balance']=NULL;            
            $result['Op_RetAcct'.$i.'_Current_Balance']=NULL;            
            $result['Op_RetAcct'.$i.'_Estimated_MaritalEquity1']=NULL;            
            $result['Op_RetAcct'.$i.'_Current_Yearly_Income']=NULL;            
            $result['Op_RetAcct'.$i.'_SoleSeparate_Claim']=NULL;            
            $result['Op_RetAcct'.$i.'_SoleSeparate_Party']=NULL;            
            $result['Op_RetAcct'.$i.'_SoleSeparate_Grounds']=NULL;            
            $result['Op_RetAcct'.$i.'_Disposition_Type']=NULL;            
            $result['Op_RetAcct'.$i.'_Disposition_Method']=NULL;            
            $result['Op_RetAcct'.$i.'_Percent_Marital_Equity_to_Client']=NULL;            
            $result['Op_RetAcct'.$i.'_Percent_Marital_Equity_to_Op']=NULL;            
            $result['Op_RetAcct'.$i.'_Estimated_Value_to_Client']=NULL;            
            $result['Op_RetAcct'.$i.'_Estimated_Value_to_Op']=NULL;            
        }

        
        // echo "<pre>";print_r($result);die;
        $drretirementaccts=DrRetirementAccts::create($result);
        // update case overview info.
        $drcaseoverview=DrCaseOverview::where('case_id',$result['case_id'])->get()->first();
        if(isset($drcaseoverview)){
            $drcaseoverview->Any_Retirement_Accts=$result['Any_Retirement_Accts'];
            $drcaseoverview->Num_Client_Retirement_Accts=$result['Num_Client_Retirement_Accts'];
            $drcaseoverview->Num_Op_Retirement_Accts=$result['Num_Op_Retirement_Accts'];
            $drcaseoverview->save();
        } else {
            return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('error', 'Complete Case Overview Info Section First.');
        }
        
        return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('success', 'Retirement Accts Information Submitted Successfully.');
        
    }

    public function show($id)
    {

    }

    public function edit($case_id)
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
        
        $drretirementaccts=DrRetirementAccts::where('case_id',$case_id)->get()->first();
         // echo "<pre>";print_r($drretirementaccts);//die;
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
         // echo "<pre>";print_r($drretirementaccts);die;
        $drcaseoverview=DrCaseOverview::where('case_id',$case_id)->get()->first();
        if($drretirementaccts){
            if(isset($drcaseoverview)){
                if(isset($drcaseoverview) && $drcaseoverview->Any_Retirement_Accts==$drretirementaccts->Any_Retirement_Accts && $drcaseoverview->Num_Client_Retirement_Accts==$drretirementaccts->Num_Client_Retirement_Accts && $drcaseoverview->Num_Op_Retirement_Accts==$drretirementaccts->Num_Op_Retirement_Accts)
                {

                } else {
                    $drretirementaccts->Any_Retirement_Accts=$drcaseoverview->Any_Retirement_Accts;
                    $drretirementaccts->Num_Client_Retirement_Accts=$drcaseoverview->Num_Client_Retirement_Accts;
                    $drretirementaccts->Num_Op_Retirement_Accts=$drcaseoverview->Num_Op_Retirement_Accts;
                }
            }
            return view('dr_tables.dr_RetirementAccts.edit',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'drretirementaccts' => $drretirementaccts]);
        } else {
            return redirect()->route('home');
        }
        
    }

    public function update(Request $request, $id)
    {
        $result = $request->except('submit','_method','_token');

        $result['RetAccts_Total_Marital_Equity']=0.00;
        $result['RetAccts_Total_Client_PropertyValue_Equity']=0.00;
        $result['RetAccts_Total_Op_PropertyValue_Equity']=0.00;
        $result['RetAccts_Total_Client_Yearly_Income']=0.00;
        $result['RetAccts_Total_Op_Yearly_Income']=0.00;
        for ($i=1; $i <= 4; $i++) {
            unset($result[''.$i.'_Client_RetAcct_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Op_RetAcct_Estimated_Value_Select_Reset']);
            
            if(isset($result['Client_RetAcct'.$i.'_Disposition_Type_QDRO']) && $result['Client_RetAcct'.$i.'_Disposition_Type_QDRO'] !=''){
                if($result['Client_RetAcct'.$i.'_Disposition_Type_QDRO']=='QDRO_Fixed'){
                    $result['Client_RetAcct'.$i.'_Disposition_Type']='QDRO';
                    $result['Client_RetAcct'.$i.'_Disposition_Method']='Fixed';
                }
                if($result['Client_RetAcct'.$i.'_Disposition_Type_QDRO']=='QDRO_Percentage'){
                    $result['Client_RetAcct'.$i.'_Disposition_Type']='QDRO';
                    $result['Client_RetAcct'.$i.'_Disposition_Method']='Percentage';
                }
                if($result['Client_RetAcct'.$i.'_Disposition_Type_QDRO']=='Fixed_Buyout'){
                    $result['Client_RetAcct'.$i.'_Disposition_Type']='Buyout';
                    $result['Client_RetAcct'.$i.'_Disposition_Method']='Fixed';
                }
            } else {
                $result['Client_RetAcct'.$i.'_Disposition_Type']=NULL;
                $result['Client_RetAcct'.$i.'_Disposition_Method']=NULL;
            }
            unset($result['Client_RetAcct'.$i.'_Disposition_Type_QDRO']);
            unset($result['Client_RetAcct'.$i.'_Disposition_Type_QDRO_Amount']);
            unset($result['Client_RetAcct'.$i.'_Disposition_Type_QDRO_Percentage_Amount']);

            $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client']=0.00;
            $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Op']=0.00;
            if(isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income']) && !isset($result['Client_RetAcct'.$i.'_Percent_Marital_Equity_to_Client'])){
                $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client']=$result['Client_RetAcct'.$i.'_Current_Yearly_Income'];
            }
            if(!isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income']) && isset($result['Client_RetAcct'.$i.'_Percent_Marital_Equity_to_Client'])){
                $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client']=$result['Client_RetAcct'.$i.'_Percent_Marital_Equity_to_Client']/100;
            }
            if(isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income']) && isset($result['Client_RetAcct'.$i.'_Percent_Marital_Equity_to_Client'])){
                $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client']=$result['Client_RetAcct'.$i.'_Current_Yearly_Income']*($result['Client_RetAcct'.$i.'_Percent_Marital_Equity_to_Client']/100);
            }

            if(isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income']) && !isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client'])){
                $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Op']=$result['Client_RetAcct'.$i.'_Current_Yearly_Income'];
            }
            if(!isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income']) && isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client'])){
                $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Op']=$result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client'];
            }
            if(isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income']) && isset($result['Client_RetAcct'.$i.'_Percent_Marital_Equity_to_Client'])){
                $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Op']=$result['Client_RetAcct'.$i.'_Current_Yearly_Income']-$result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client'];
            }

            // for opponent

            $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client']=0.00;
            $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Op']=0.00;
            if(isset($result['Op_RetAcct'.$i.'_Disposition_Type_QDRO']) && $result['Op_RetAcct'.$i.'_Disposition_Type_QDRO'] !=''){
                if($result['Op_RetAcct'.$i.'_Disposition_Type_QDRO']=='QDRO_Fixed'){
                    $result['Op_RetAcct'.$i.'_Disposition_Type']='QDRO';
                    $result['Op_RetAcct'.$i.'_Disposition_Method']='Fixed';
                }
                if($result['Op_RetAcct'.$i.'_Disposition_Type_QDRO']=='QDRO_Percentage'){
                    $result['Op_RetAcct'.$i.'_Disposition_Type']='QDRO';
                    $result['Op_RetAcct'.$i.'_Disposition_Method']='Percentage';
                }
                if($result['Op_RetAcct'.$i.'_Disposition_Type_QDRO']=='Fixed_Buyout'){
                    $result['Op_RetAcct'.$i.'_Disposition_Type']='Buyout';
                    $result['Op_RetAcct'.$i.'_Disposition_Method']='Fixed';
                }
            } else {
                $result['Op_RetAcct'.$i.'_Disposition_Type']=NULL;
                $result['Op_RetAcct'.$i.'_Disposition_Method']=NULL;
            }
            unset($result['Op_RetAcct'.$i.'_Disposition_Type_QDRO']);
            unset($result['Op_RetAcct'.$i.'_Disposition_Type_QDRO_Amount']);
            unset($result['Op_RetAcct'.$i.'_Disposition_Type_QDRO_Percentage_Amount']);

            if(isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income']) && !isset($result['Op_RetAcct'.$i.'_Percent_Marital_Equity_to_Client'])){
                $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client']=$result['Op_RetAcct'.$i.'_Current_Yearly_Income'];
            }
            if(!isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income']) && isset($result['Op_RetAcct'.$i.'_Percent_Marital_Equity_to_Client'])){
                $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client']=$result['Op_RetAcct'.$i.'_Percent_Marital_Equity_to_Client']/100;
            }
            if(isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income']) && isset($result['Op_RetAcct'.$i.'_Percent_Marital_Equity_to_Client'])){
                $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client']=$result['Op_RetAcct'.$i.'_Current_Yearly_Income']*($result['Op_RetAcct'.$i.'_Percent_Marital_Equity_to_Client']/100);
            }

            if(isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income']) && !isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client'])){
                $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Op']=$result['Op_RetAcct'.$i.'_Current_Yearly_Income'];
            }
            if(!isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income']) && isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client'])){
                $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Op']=$result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client'];
            }
            if(isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income']) && isset($result['Op_RetAcct'.$i.'_Percent_Marital_Equity_to_Client'])){
                $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Op']=$result['Op_RetAcct'.$i.'_Current_Yearly_Income']-$result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client'];
            }

            // for other calculations
            if(isset($result['Client_RetAcct'.$i.'_Estimated_MaritalEquity1']) && $result['Client_RetAcct'.$i.'_Estimated_MaritalEquity1'] !=''){
                $result['RetAccts_Total_Marital_Equity']=$result['RetAccts_Total_Marital_Equity']+$result['Client_RetAcct'.$i.'_Estimated_MaritalEquity1'];
            }
            if(isset($result['Op_RetAcct'.$i.'_Estimated_MaritalEquity1']) && $result['Op_RetAcct'.$i.'_Estimated_MaritalEquity1'] !=''){
                $result['RetAccts_Total_Marital_Equity']=$result['RetAccts_Total_Marital_Equity']+$result['Op_RetAcct'.$i.'_Estimated_MaritalEquity1'];
            }
            
            if(isset($result['Client_RetAcct'.$i.'_Estimated_Value_to_Client']) && $result['Client_RetAcct'.$i.'_Estimated_Value_to_Client'] !=''){
                $result['RetAccts_Total_Client_PropertyValue_Equity']=$result['RetAccts_Total_Client_PropertyValue_Equity']+$result['Client_RetAcct'.$i.'_Estimated_Value_to_Client'];
            }
            if(isset($result['Op_RetAcct'.$i.'_Estimated_Value_to_Client']) && $result['Op_RetAcct'.$i.'_Estimated_Value_to_Client'] !=''){
                $result['RetAccts_Total_Client_PropertyValue_Equity']=$result['RetAccts_Total_Client_PropertyValue_Equity']+$result['Op_RetAcct'.$i.'_Estimated_Value_to_Client'];
            }
            
            if(isset($result['Client_RetAcct'.$i.'_Estimated_Value_to_Op']) && $result['Client_RetAcct'.$i.'_Estimated_Value_to_Op'] !=''){
                $result['RetAccts_Total_Op_PropertyValue_Equity']=$result['RetAccts_Total_Op_PropertyValue_Equity']+$result['Client_RetAcct'.$i.'_Estimated_Value_to_Op'];
            }
            if(isset($result['Op_RetAcct'.$i.'_Estimated_Value_to_Op']) && $result['Op_RetAcct'.$i.'_Estimated_Value_to_Op'] !=''){
                $result['RetAccts_Total_Op_PropertyValue_Equity']=$result['RetAccts_Total_Op_PropertyValue_Equity']+$result['Op_RetAcct'.$i.'_Estimated_Value_to_Op'];
            }
            
            if(isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client']) && $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client'] !=''){
                $result['RetAccts_Total_Client_Yearly_Income']=$result['RetAccts_Total_Client_Yearly_Income']+$result['Client_RetAcct'.$i.'_Current_Yearly_Income_Client'];
            }
            if(isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client']) && $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client'] !=''){
                $result['RetAccts_Total_Client_Yearly_Income']=$result['RetAccts_Total_Client_Yearly_Income']+$result['Op_RetAcct'.$i.'_Current_Yearly_Income_Client'];
            }
            
            if(isset($result['Client_RetAcct'.$i.'_Current_Yearly_Income_Op']) && $result['Client_RetAcct'.$i.'_Current_Yearly_Income_Op'] !=''){
                $result['RetAccts_Total_Op_Yearly_Income']=$result['RetAccts_Total_Op_Yearly_Income']+$result['Client_RetAcct'.$i.'_Current_Yearly_Income_Op'];
            }
            if(isset($result['Op_RetAcct'.$i.'_Current_Yearly_Income_Op']) && $result['Op_RetAcct'.$i.'_Current_Yearly_Income_Op'] !=''){
                $result['RetAccts_Total_Op_Yearly_Income']=$result['RetAccts_Total_Op_Yearly_Income']+$result['Op_RetAcct'.$i.'_Current_Yearly_Income_Op'];
            }

        }
        
        if(isset($result['Any_Retirement_Accts']) && $result['Any_Retirement_Accts']=='1'){
        } else {
            $result['Any_Retirement_Accts']='0';
            $result['Num_Client_Retirement_Accts']=0;
            $result['Num_Op_Retirement_Accts']=0;
        }

        if(isset($result['Num_Client_Retirement_Accts'])){
        } else {
            $result['Num_Client_Retirement_Accts']='0';
        }
        $Num_Client_Retirement_Accts=$result['Num_Client_Retirement_Accts'];
        $Num_Client_Retirement_Accts=$Num_Client_Retirement_Accts+1;
        for ($i=$Num_Client_Retirement_Accts; $i <= 4; $i++) { 
            $result['Client_RetAcct'.$i.'_Institution_ZIP']=NULL;            
            $result['Client_RetAcct'.$i.'_Institution_Name']=NULL;            
            $result['Client_RetAcct'.$i.'_Institution_Street_Address']=NULL;            
            $result['Client_RetAcct'.$i.'_Institution_City']=NULL;            
            $result['Client_RetAcct'.$i.'_Institution_State']=NULL;            
            $result['Client_RetAcct'.$i.'_Institution_Acct_Num']=NULL;            
            $result['Client_RetAcct'.$i.'_Date_of_Marriage_Balance']=NULL;            
            $result['Client_RetAcct'.$i.'_Current_Balance']=NULL;            
            $result['Client_RetAcct'.$i.'_Estimated_MaritalEquity1']=NULL;            
            $result['Client_RetAcct'.$i.'_Current_Yearly_Income']=NULL;            
            $result['Client_RetAcct'.$i.'_SoleSeparate_Claim']=NULL;            
            $result['Client_RetAcct'.$i.'_SoleSeparate_Party']=NULL;            
            $result['Client_RetAcct'.$i.'_SoleSeparate_Grounds']=NULL;            
            $result['Client_RetAcct'.$i.'_Disposition_Type']=NULL;            
            $result['Client_RetAcct'.$i.'_Disposition_Method']=NULL;            
            $result['Client_RetAcct'.$i.'_Percent_Marital_Equity_to_Client']=NULL;            
            $result['Client_RetAcct'.$i.'_Percent_Marital_Equity_to_Op']=NULL;            
            $result['Client_RetAcct'.$i.'_Estimated_Value_to_Client']=NULL;            
            $result['Client_RetAcct'.$i.'_Estimated_Value_to_Op']=NULL;            
        }

        if(isset($result['Num_Op_Retirement_Accts'])){
        } else {
            $result['Num_Op_Retirement_Accts']='0';
        }
        $Num_Op_Retirement_Accts=$result['Num_Op_Retirement_Accts'];
        $Num_Op_Retirement_Accts=$Num_Op_Retirement_Accts+1;
        for ($i=$Num_Op_Retirement_Accts; $i <= 4; $i++) { 
            $result['Op_RetAcct'.$i.'_Institution_ZIP']=NULL;            
            $result['Op_RetAcct'.$i.'_Institution_Name']=NULL;            
            $result['Op_RetAcct'.$i.'_Institution_Street_Address']=NULL;            
            $result['Op_RetAcct'.$i.'_Institution_City']=NULL;            
            $result['Op_RetAcct'.$i.'_Institution_State']=NULL;            
            $result['Op_RetAcct'.$i.'_Institution_Acct_Num']=NULL;            
            $result['Op_RetAcct'.$i.'_Date_of_Marriage_Balance']=NULL;            
            $result['Op_RetAcct'.$i.'_Current_Balance']=NULL;            
            $result['Op_RetAcct'.$i.'_Estimated_MaritalEquity1']=NULL;            
            $result['Op_RetAcct'.$i.'_Current_Yearly_Income']=NULL;            
            $result['Op_RetAcct'.$i.'_SoleSeparate_Claim']=NULL;            
            $result['Op_RetAcct'.$i.'_SoleSeparate_Party']=NULL;            
            $result['Op_RetAcct'.$i.'_SoleSeparate_Grounds']=NULL;            
            $result['Op_RetAcct'.$i.'_Disposition_Type']=NULL;            
            $result['Op_RetAcct'.$i.'_Disposition_Method']=NULL;            
            $result['Op_RetAcct'.$i.'_Percent_Marital_Equity_to_Client']=NULL;            
            $result['Op_RetAcct'.$i.'_Percent_Marital_Equity_to_Op']=NULL;            
            $result['Op_RetAcct'.$i.'_Estimated_Value_to_Client']=NULL;            
            $result['Op_RetAcct'.$i.'_Estimated_Value_to_Op']=NULL;            
        }

        
        // echo "<pre>";print_r($result);die;
        $drretirementaccts  = DrRetirementAccts::findOrFail($id);
        if($drretirementaccts){
            $drretirementaccts->fill($result)->save();
            // update case overview info.
            $drcaseoverview=DrCaseOverview::where('case_id',$result['case_id'])->get()->first();
            if(isset($drcaseoverview)){
                $drcaseoverview->Any_Retirement_Accts=$result['Any_Retirement_Accts'];
                $drcaseoverview->Num_Client_Retirement_Accts=$result['Num_Client_Retirement_Accts'];
                $drcaseoverview->Num_Op_Retirement_Accts=$result['Num_Op_Retirement_Accts'];
                $drcaseoverview->save();
            } else {
                return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('error', 'Complete Case Overview Info Section First.');
            }
            return redirect()->route('drretirementaccts.edit',$result['case_id'])->with('success', 'Retirement Accts Information Updated Successfully.');
        } else {
            return redirect()->route('drretirementaccts.edit',$result['case_id'])->with('error', 'Something went wrong. Please try Again.');
        }
    }
    
    public function destroy($id)
    {

    }

}
