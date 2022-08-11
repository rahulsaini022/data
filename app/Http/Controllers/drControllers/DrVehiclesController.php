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
use App\DrVehicles;
use App\DrCaseOverview;


class DrVehiclesController extends Controller
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
        $data=DrVehicles::orderBy('id','DESC')->get();
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

        $drvehicles=DrVehicles::where('case_id',$case_id)->get()->pluck('case_id');
        if(isset($drvehicles['0'])){
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
        return view('dr_tables.dr_Vehicles.create',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'drcaseoverview'=>$drcaseoverview]);
    }

    // save tab info in database table.
    public function store(Request $request)
    {
        $result = $request->except('submit', 'client_name', 'opponent_name');
        
        $result['Vehicle_Client_Total_Monthly_Lease_Amount']=0.00;
        $result['Vehicle_Op_Total_Monthly_Lease_Amount']=0.00;

        for ($i=1; $i <= 6; $i++) {
            unset($result[''.$i.'_Joint_Vehicle_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Client_Vehicle_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Op_Vehicle_Estimated_Value_Select_Reset']);
            if(isset($result['Joint_Vehicle_Disposition_Method'.$i.'']) && $result['Joint_Vehicle_Disposition_Method'.$i.''] !='Fixed Buyout'){
                $result['Joint_Vehicle_Paying_Party'.$i.'']=NULL;
            }
            if(isset($result['Client_Vehicle_Disposition_Method'.$i.'']) && $result['Client_Vehicle_Disposition_Method'.$i.''] !='Fixed Buyout'){
                $result['Client_Vehicle_Paying_Party'.$i.'']=NULL;
            }
            if(isset($result['Op_Vehicle_Disposition_Method'.$i.'']) && $result['Op_Vehicle_Disposition_Method'.$i.''] !='Fixed Buyout'){
                $result['Op_Vehicle_Paying_Party'.$i.'']=NULL;
            }

            if(isset($result['Joint_Vehicle_Owned_Leased'.$i.'']) && $result['Joint_Vehicle_Owned_Leased'.$i.''] !='Owned')
            {
                $result['Joint_Vehicle_VIN'.$i.'']=NULL;            
                $result['Joint_Vehicle_Current_Value'.$i.'']=NULL;            
                $result['Joint_Vehicle_Loan_Company_Name'.$i.'']=NULL;            
                $result['Joint_Vehicle_Loan_Balance'.$i.'']=NULL;            
                $result['Joint_Vehicle_Loan_Monthly_Payment'.$i.'']=NULL;            
                $result['Joint_Vehicle_Loan_Second_Company_Name'.$i.'']=NULL;            
                $result['Joint_Vehicle_Loan_Second_Company_Balance'.$i.'']=NULL;            
                $result['Joint_Vehicle_Loan_Second_Company_Monthly_Payment'.$i.'']=NULL;            
                $result['Joint_Vehicle_Marital_Equity'.$i.'']=NULL;            
                $result['Joint_Vehicle_SoleSeparate_Claim'.$i.'']=NULL;            
                $result['Joint_Vehicle_SoleSeparate_Party'.$i.'']=NULL;            
                $result['Joint_Vehicle_SoleSeparate_Grounds'.$i.'']=NULL;            
                $result['Joint_Vehicle_Disposition_Method'.$i.'']=NULL;            
                $result['Joint_Vehicle_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
                $result['Joint_Vehicle_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
                $result['Joint_Vehicle_Estimated_Value_to_Client'.$i.'']=NULL;            
                $result['Joint_Vehicle_Estimated_Value_to_Op'.$i.'']=NULL;            
                $result['Joint_Vehicle_Paying_Party'.$i.'']=NULL;
            } else {
                $result['Joint_Vehicle_Lease_Company'.$i.'']=NULL;            
                $result['Joint_Vehicle_Monthly_Lease_Amount'.$i.'']=NULL;            
                $result['Joint_Vehicle_Lease_Disposition_Method'.$i.'']=NULL;
            }



            if(isset($result['Client_Vehicle_Owned_Leased'.$i.'']) && $result['Client_Vehicle_Owned_Leased'.$i.''] !='Owned')
            {
                $result['Client_Vehicle_VIN'.$i.'']=NULL;            
                $result['Client_Vehicle_Current_Value'.$i.'']=NULL;            
                $result['Client_Vehicle_Loan_Company_Name'.$i.'']=NULL;            
                $result['Client_Vehicle_Loan_Balance'.$i.'']=NULL;            
                $result['Client_Vehicle_Loan_Monthly_Payment'.$i.'']=NULL;            
                $result['Client_Vehicle_Loan_Second_Company_Name'.$i.'']=NULL;            
                $result['Client_Vehicle_Loan_Second_Company_Balance'.$i.'']=NULL;            
                $result['Client_Vehicle_Loan_Second_Company_Monthly_Payment'.$i.'']=NULL;            
                $result['Client_Vehicle_Marital_Equity'.$i.'']=NULL;            
                $result['Client_Vehicle_SoleSeparate_Claim'.$i.'']=NULL;            
                $result['Client_Vehicle_SoleSeparate_Party'.$i.'']=NULL;            
                $result['Client_Vehicle_SoleSeparate_Grounds'.$i.'']=NULL;            
                $result['Client_Vehicle_Disposition_Method'.$i.'']=NULL;            
                $result['Client_Vehicle_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
                $result['Client_Vehicle_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
                $result['Client_Vehicle_Estimated_Value_to_Client'.$i.'']=NULL;            
                $result['Client_Vehicle_Estimated_Value_to_Op'.$i.'']=NULL;            
                $result['Client_Vehicle_Paying_Party'.$i.'']=NULL;
            } else {
                $result['Client_Vehicle_Lease_Company'.$i.'']=NULL;            
                $result['Client_Vehicle_Monthly_Lease_Amount'.$i.'']=NULL;            
                $result['Client_Vehicle_Lease_Disposition_Method'.$i.'']=NULL;
            }



            if(isset($result['Op_Vehicle_Owned_Leased'.$i.'']) && $result['Op_Vehicle_Owned_Leased'.$i.''] !='Owned')
            {
                $result['Op_Vehicle_VIN'.$i.'']=NULL;            
                $result['Op_Vehicle_Current_Value'.$i.'']=NULL;            
                $result['Op_Vehicle_Loan_Company_Name'.$i.'']=NULL;            
                $result['Op_Vehicle_Loan_Balance'.$i.'']=NULL;            
                $result['Op_Vehicle_Loan_Monthly_Payment'.$i.'']=NULL;            
                $result['Op_Vehicle_Loan_Second_Company_Name'.$i.'']=NULL;            
                $result['Op_Vehicle_Loan_Second_Company_Balance'.$i.'']=NULL;            
                $result['Op_Vehicle_Loan_Second_Company_Monthly_Payment'.$i.'']=NULL;            
                $result['Op_Vehicle_Marital_Equity'.$i.'']=NULL;            
                $result['Op_Vehicle_SoleSeparate_Claim'.$i.'']=NULL;            
                $result['Op_Vehicle_SoleSeparate_Party'.$i.'']=NULL;            
                $result['Op_Vehicle_SoleSeparate_Grounds'.$i.'']=NULL;            
                $result['Op_Vehicle_Disposition_Method'.$i.'']=NULL;            
                $result['Op_Vehicle_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
                $result['Op_Vehicle_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
                $result['Op_Vehicle_Estimated_Value_to_Client'.$i.'']=NULL;            
                $result['Op_Vehicle_Estimated_Value_to_Op'.$i.'']=NULL;            
                $result['Op_Vehicle_Paying_Party'.$i.'']=NULL;
            } else {
                $result['Op_Vehicle_Lease_Company'.$i.'']=NULL;            
                $result['Op_Vehicle_Monthly_Lease_Amount'.$i.'']=NULL;            
                $result['Op_Vehicle_Lease_Disposition_Method'.$i.'']=NULL;
            }

            // new calculations 
            // for joint
            if(isset($result['Joint_Vehicle_Lease_Disposition_Method'.$i.'']) && $result['Joint_Vehicle_Lease_Disposition_Method'.$i.'']=='Transfer Lease Responsibility to '.$request->client_name.''){
                if(isset($result['Joint_Vehicle_Monthly_Lease_Amount'.$i.'']) && $result['Joint_Vehicle_Monthly_Lease_Amount'.$i.'']!=''){
                    $result['Joint_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=$result['Joint_Vehicle_Monthly_Lease_Amount'.$i.''];
                } else {
                    $result['Joint_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=0.00;
                }
            } else {
                $result['Joint_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=0.00;
            }

            if(isset($result['Joint_Vehicle_Lease_Disposition_Method'.$i.'']) && $result['Joint_Vehicle_Lease_Disposition_Method'.$i.'']=='Transfer Lease Responsibility to '.$request->opponent_name.''){
                if(isset($result['Joint_Vehicle_Monthly_Lease_Amount'.$i.'']) && $result['Joint_Vehicle_Monthly_Lease_Amount'.$i.'']!=''){
                    $result['Joint_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=$result['Joint_Vehicle_Monthly_Lease_Amount'.$i.''];
                } else {
                    $result['Joint_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=0.00;
                }
            } else {
                $result['Joint_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=0.00;
            }

            // for client
            if(isset($result['Client_Vehicle_Lease_Disposition_Method'.$i.'']) && $result['Client_Vehicle_Lease_Disposition_Method'.$i.'']=='Transfer Lease Responsibility to '.$request->client_name.''){
                if(isset($result['Client_Vehicle_Monthly_Lease_Amount'.$i.'']) && $result['Client_Vehicle_Monthly_Lease_Amount'.$i.'']!=''){
                    $result['Client_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=$result['Client_Vehicle_Monthly_Lease_Amount'.$i.''];
                } else {
                    $result['Client_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=0.00;
                }
            } else {
                $result['Client_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=0.00;
            }

            if(isset($result['Client_Vehicle_Lease_Disposition_Method'.$i.'']) && $result['Client_Vehicle_Lease_Disposition_Method'.$i.'']=='Transfer Lease Responsibility to '.$request->opponent_name.''){
                if(isset($result['Client_Vehicle_Monthly_Lease_Amount'.$i.'']) && $result['Client_Vehicle_Monthly_Lease_Amount'.$i.'']!=''){
                    $result['Client_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=$result['Client_Vehicle_Monthly_Lease_Amount'.$i.''];
                } else {
                    $result['Client_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=0.00;
                }
            } else {
                $result['Client_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=0.00;
            }

            // for opponent
            if(isset($result['Op_Vehicle_Lease_Disposition_Method'.$i.'']) && $result['Op_Vehicle_Lease_Disposition_Method'.$i.'']=='Transfer Lease Responsibility to '.$request->client_name.''){
                if(isset($result['Op_Vehicle_Monthly_Lease_Amount'.$i.'']) && $result['Op_Vehicle_Monthly_Lease_Amount'.$i.'']!=''){
                    $result['Op_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=$result['Op_Vehicle_Monthly_Lease_Amount'.$i.''];
                } else {
                    $result['Op_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=0.00;
                }
            } else {
                $result['Op_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=0.00;
            }

            if(isset($result['Op_Vehicle_Lease_Disposition_Method'.$i.'']) && $result['Op_Vehicle_Lease_Disposition_Method'.$i.'']=='Transfer Lease Responsibility to '.$request->opponent_name.''){
                if(isset($result['Op_Vehicle_Monthly_Lease_Amount'.$i.'']) && $result['Op_Vehicle_Monthly_Lease_Amount'.$i.'']!=''){
                    $result['Op_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=$result['Op_Vehicle_Monthly_Lease_Amount'.$i.''];
                } else {
                    $result['Op_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=0.00;
                }
            } else {
                $result['Op_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=0.00;
            }

            // for all vehicles for client
            if(isset($result['Joint_Vehicle_Client_Monthly_Lease_Amount'.$i.'']) && $result['Joint_Vehicle_Client_Monthly_Lease_Amount'.$i.'']!=''){
                $result['Vehicle_Client_Total_Monthly_Lease_Amount']=$result['Vehicle_Client_Total_Monthly_Lease_Amount']+$result['Joint_Vehicle_Client_Monthly_Lease_Amount'.$i.''];
            }
            if(isset($result['Client_Vehicle_Client_Monthly_Lease_Amount'.$i.'']) && $result['Client_Vehicle_Client_Monthly_Lease_Amount'.$i.'']!=''){
                $result['Vehicle_Client_Total_Monthly_Lease_Amount']=$result['Vehicle_Client_Total_Monthly_Lease_Amount']+$result['Client_Vehicle_Client_Monthly_Lease_Amount'.$i.''];
            }
            if(isset($result['Op_Vehicle_Client_Monthly_Lease_Amount'.$i.'']) && $result['Op_Vehicle_Client_Monthly_Lease_Amount'.$i.'']!=''){
                $result['Vehicle_Client_Total_Monthly_Lease_Amount']=$result['Vehicle_Client_Total_Monthly_Lease_Amount']+$result['Op_Vehicle_Client_Monthly_Lease_Amount'.$i.''];
            }

            // for all vehicles for client
            if(isset($result['Joint_Vehicle_Op_Monthly_Lease_Amount'.$i.'']) && $result['Joint_Vehicle_Op_Monthly_Lease_Amount'.$i.'']!=''){
                $result['Vehicle_Op_Total_Monthly_Lease_Amount']=$result['Vehicle_Op_Total_Monthly_Lease_Amount']+$result['Joint_Vehicle_Op_Monthly_Lease_Amount'.$i.''];
            }
            if(isset($result['Client_Vehicle_Op_Monthly_Lease_Amount'.$i.'']) && $result['Client_Vehicle_Op_Monthly_Lease_Amount'.$i.'']!=''){
                $result['Vehicle_Op_Total_Monthly_Lease_Amount']=$result['Vehicle_Op_Total_Monthly_Lease_Amount']+$result['Client_Vehicle_Op_Monthly_Lease_Amount'.$i.''];
            }
            if(isset($result['Op_Vehicle_Op_Monthly_Lease_Amount'.$i.'']) && $result['Op_Vehicle_Op_Monthly_Lease_Amount'.$i.'']!=''){
                $result['Vehicle_Op_Total_Monthly_Lease_Amount']=$result['Vehicle_Op_Total_Monthly_Lease_Amount']+$result['Op_Vehicle_Op_Monthly_Lease_Amount'.$i.''];
            }

        }

        if(isset($result['Any_Vehicles']) && $result['Any_Vehicles']=='1'){
        } else {
            $result['Any_Vehicles']='0';
            $result['Num_Joint_Vehicles']=0;
            $result['Num_Client_Vehicles']=0;
            $result['Num_Op_Vehicles']=0;
        }

        if(isset($result['Num_Joint_Vehicles'])){
        } else {
            $result['Num_Joint_Vehicles']='0';
        }
        $Num_Joint_Vehicles=$result['Num_Joint_Vehicles'];
        $Num_Joint_Vehicles=$Num_Joint_Vehicles+1;
        for ($i=$Num_Joint_Vehicles; $i <= 6; $i++) { 
            $result['Joint_Vehicle_Year'.$i.'']=NULL;            
            $result['Joint_Vehicle_Make_Model'.$i.'']=NULL;            
            $result['Joint_Vehicle_Owned_Leased'.$i.'']=NULL;            
            $result['Joint_Vehicle_VIN'.$i.'']=NULL;            
            $result['Joint_Vehicle_Current_Value'.$i.'']=NULL;            
            $result['Joint_Vehicle_Loan_Company_Name'.$i.'']=NULL;            
            $result['Joint_Vehicle_Loan_Balance'.$i.'']=NULL;            
            $result['Joint_Vehicle_Loan_Monthly_Payment'.$i.'']=NULL;            
            $result['Joint_Vehicle_Loan_Second_Company_Name'.$i.'']=NULL;            
            $result['Joint_Vehicle_Loan_Second_Company_Balance'.$i.'']=NULL;            
            $result['Joint_Vehicle_Loan_Second_Company_Monthly_Payment'.$i.'']=NULL;            
            $result['Joint_Vehicle_Marital_Equity'.$i.'']=NULL;            
            $result['Joint_Vehicle_SoleSeparate_Claim'.$i.'']=NULL;            
            $result['Joint_Vehicle_SoleSeparate_Party'.$i.'']=NULL;            
            $result['Joint_Vehicle_SoleSeparate_Grounds'.$i.'']=NULL;            
            $result['Joint_Vehicle_Disposition_Method'.$i.'']=NULL;            
            $result['Joint_Vehicle_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
            $result['Joint_Vehicle_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
            $result['Joint_Vehicle_Estimated_Value_to_Client'.$i.'']=NULL;            
            $result['Joint_Vehicle_Estimated_Value_to_Op'.$i.'']=NULL;            
            $result['Joint_Vehicle_Paying_Party'.$i.'']=NULL;            
            $result['Joint_Vehicle_Lease_Company'.$i.'']=NULL;            
            $result['Joint_Vehicle_Monthly_Lease_Amount'.$i.'']=NULL;            
            $result['Joint_Vehicle_Lease_Disposition_Method'.$i.'']=NULL;            
        }

        if(isset($result['Num_Client_Vehicles'])){
        } else {
            $result['Num_Client_Vehicles']='0';
        }
        $Num_Client_Vehicles=$result['Num_Client_Vehicles'];
        $Num_Client_Vehicles=$Num_Client_Vehicles+1;
        for ($i=$Num_Client_Vehicles; $i <= 6; $i++) { 
            $result['Client_Vehicle_Year'.$i.'']=NULL;            
            $result['Client_Vehicle_Make_Model'.$i.'']=NULL;            
            $result['Client_Vehicle_Owned_Leased'.$i.'']=NULL;            
            $result['Client_Vehicle_VIN'.$i.'']=NULL;            
            $result['Client_Vehicle_Current_Value'.$i.'']=NULL;            
            $result['Client_Vehicle_Loan_Company_Name'.$i.'']=NULL;            
            $result['Client_Vehicle_Loan_Balance'.$i.'']=NULL;            
            $result['Client_Vehicle_Loan_Monthly_Payment'.$i.'']=NULL;            
            $result['Client_Vehicle_Loan_Second_Company_Name'.$i.'']=NULL;            
            $result['Client_Vehicle_Loan_Second_Company_Balance'.$i.'']=NULL;            
            $result['Client_Vehicle_Loan_Second_Company_Monthly_Payment'.$i.'']=NULL;            
            $result['Client_Vehicle_Marital_Equity'.$i.'']=NULL;            
            $result['Client_Vehicle_SoleSeparate_Claim'.$i.'']=NULL;            
            $result['Client_Vehicle_SoleSeparate_Party'.$i.'']=NULL;            
            $result['Client_Vehicle_SoleSeparate_Grounds'.$i.'']=NULL;            
            $result['Client_Vehicle_Disposition_Method'.$i.'']=NULL;            
            $result['Client_Vehicle_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
            $result['Client_Vehicle_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
            $result['Client_Vehicle_Estimated_Value_to_Client'.$i.'']=NULL;            
            $result['Client_Vehicle_Estimated_Value_to_Op'.$i.'']=NULL;            
            $result['Client_Vehicle_Paying_Party'.$i.'']=NULL;            
            $result['Client_Vehicle_Lease_Company'.$i.'']=NULL;            
            $result['Client_Vehicle_Monthly_Lease_Amount'.$i.'']=NULL;            
            $result['Client_Vehicle_Lease_Disposition_Method'.$i.'']=NULL;            
        }

        if(isset($result['Num_Op_Vehicles'])){
        } else {
            $result['Num_Op_Vehicles']='0';
        }
        $Num_Op_Vehicles=$result['Num_Op_Vehicles'];
        $Num_Op_Vehicles=$Num_Op_Vehicles+1;
        for ($i=$Num_Op_Vehicles; $i <= 6; $i++) { 
            $result['Op_Vehicle_Year'.$i.'']=NULL;            
            $result['Op_Vehicle_Make_Model'.$i.'']=NULL;            
            $result['Op_Vehicle_Owned_Leased'.$i.'']=NULL;            
            $result['Op_Vehicle_VIN'.$i.'']=NULL;            
            $result['Op_Vehicle_Current_Value'.$i.'']=NULL;            
            $result['Op_Vehicle_Loan_Company_Name'.$i.'']=NULL;            
            $result['Op_Vehicle_Loan_Balance'.$i.'']=NULL;            
            $result['Op_Vehicle_Loan_Monthly_Payment'.$i.'']=NULL;            
            $result['Op_Vehicle_Loan_Second_Company_Name'.$i.'']=NULL;            
            $result['Op_Vehicle_Loan_Second_Company_Balance'.$i.'']=NULL;            
            $result['Op_Vehicle_Loan_Second_Company_Monthly_Payment'.$i.'']=NULL;            
            $result['Op_Vehicle_Marital_Equity'.$i.'']=NULL;            
            $result['Op_Vehicle_SoleSeparate_Claim'.$i.'']=NULL;            
            $result['Op_Vehicle_SoleSeparate_Party'.$i.'']=NULL;            
            $result['Op_Vehicle_SoleSeparate_Grounds'.$i.'']=NULL;            
            $result['Op_Vehicle_Disposition_Method'.$i.'']=NULL;            
            $result['Op_Vehicle_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
            $result['Op_Vehicle_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
            $result['Op_Vehicle_Estimated_Value_to_Client'.$i.'']=NULL;            
            $result['Op_Vehicle_Estimated_Value_to_Op'.$i.'']=NULL;            
            $result['Op_Vehicle_Paying_Party'.$i.'']=NULL;            
            $result['Op_Vehicle_Lease_Company'.$i.'']=NULL;            
            $result['Op_Vehicle_Monthly_Lease_Amount'.$i.'']=NULL;            
            $result['Op_Vehicle_Lease_Disposition_Method'.$i.'']=NULL;            
        }

        
        // echo "<pre>";print_r($result);die;
        $drvehicles=DrVehicles::create($result);
        // update case overview info.
        $drcaseoverview=DrCaseOverview::where('case_id',$result['case_id'])->get()->first();
        if(isset($drcaseoverview)){
            $drcaseoverview->Any_Vehicles=$result['Any_Vehicles'];
            $drcaseoverview->Num_Joint_Vehicles=$result['Num_Joint_Vehicles'];
            $drcaseoverview->Num_Client_Vehicles=$result['Num_Client_Vehicles'];
            $drcaseoverview->Num_Op_Vehicles=$result['Num_Op_Vehicles'];
            $drcaseoverview->save();
        } else {
            return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('error', 'Complete Case Overview Info Section First.');
        }
        return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('success', 'Vehicles Information Submitted Successfully.');
        
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
        
        $drvehicles=DrVehicles::where('case_id',$case_id)->get()->first();
         // echo "<pre>";print_r($drvehicles);//die;
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
         // echo "<pre>";print_r($drvehicles);die;
        $drcaseoverview=DrCaseOverview::where('case_id',$case_id)->get()->first();
        if($drvehicles){
            if(isset($drcaseoverview)){
                if(isset($drcaseoverview) && $drcaseoverview->Any_Vehicles==$drvehicles->Any_Vehicles && $drcaseoverview->Num_Joint_Vehicles==$drvehicles->Num_Joint_Vehicles && $drcaseoverview->Num_Client_Vehicles==$drvehicles->Num_Client_Vehicles && $drcaseoverview->Num_Op_Vehicles==$drvehicles->Num_Op_Vehicles)
                {

                } else {
                    $drvehicles->Any_Vehicles=$drcaseoverview->Any_Vehicles;
                    $drvehicles->Num_Joint_Vehicles=$drcaseoverview->Num_Joint_Vehicles;
                    $drvehicles->Num_Client_Vehicles=$drcaseoverview->Num_Client_Vehicles;
                    $drvehicles->Num_Op_Vehicles=$drcaseoverview->Num_Op_Vehicles;
                }

            }
            return view('dr_tables.dr_Vehicles.edit',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'drvehicles' => $drvehicles]);
        } else {
            return redirect()->route('home');
        }
        
    }

    public function update(Request $request, $id)
    {
        $result = $request->except('submit','_method','_token', 'client_name', 'opponent_name');

        $result['Vehicle_Client_Total_Monthly_Lease_Amount']=0.00;
        $result['Vehicle_Op_Total_Monthly_Lease_Amount']=0.00;

        for ($i=1; $i <= 6; $i++) {
            unset($result[''.$i.'_Joint_Vehicle_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Client_Vehicle_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Op_Vehicle_Estimated_Value_Select_Reset']);
            if(isset($result['Joint_Vehicle_Disposition_Method'.$i.'']) && $result['Joint_Vehicle_Disposition_Method'.$i.''] !='Fixed Buyout'){
                $result['Joint_Vehicle_Paying_Party'.$i.'']=NULL;
            }
            if(isset($result['Client_Vehicle_Disposition_Method'.$i.'']) && $result['Client_Vehicle_Disposition_Method'.$i.''] !='Fixed Buyout'){
                $result['Client_Vehicle_Paying_Party'.$i.'']=NULL;
            }
            if(isset($result['Op_Vehicle_Disposition_Method'.$i.'']) && $result['Op_Vehicle_Disposition_Method'.$i.''] !='Fixed Buyout'){
                $result['Op_Vehicle_Paying_Party'.$i.'']=NULL;
            }

            if(isset($result['Joint_Vehicle_Owned_Leased'.$i.'']) && $result['Joint_Vehicle_Owned_Leased'.$i.''] !='Owned')
            {
                $result['Joint_Vehicle_VIN'.$i.'']=NULL;            
                $result['Joint_Vehicle_Current_Value'.$i.'']=NULL;            
                $result['Joint_Vehicle_Loan_Company_Name'.$i.'']=NULL;            
                $result['Joint_Vehicle_Loan_Balance'.$i.'']=NULL;            
                $result['Joint_Vehicle_Loan_Monthly_Payment'.$i.'']=NULL;            
                $result['Joint_Vehicle_Loan_Second_Company_Name'.$i.'']=NULL;            
                $result['Joint_Vehicle_Loan_Second_Company_Balance'.$i.'']=NULL;            
                $result['Joint_Vehicle_Loan_Second_Company_Monthly_Payment'.$i.'']=NULL;            
                $result['Joint_Vehicle_Marital_Equity'.$i.'']=NULL;            
                $result['Joint_Vehicle_SoleSeparate_Claim'.$i.'']=NULL;            
                $result['Joint_Vehicle_SoleSeparate_Party'.$i.'']=NULL;            
                $result['Joint_Vehicle_SoleSeparate_Grounds'.$i.'']=NULL;            
                $result['Joint_Vehicle_Disposition_Method'.$i.'']=NULL;            
                $result['Joint_Vehicle_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
                $result['Joint_Vehicle_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
                $result['Joint_Vehicle_Estimated_Value_to_Client'.$i.'']=NULL;            
                $result['Joint_Vehicle_Estimated_Value_to_Op'.$i.'']=NULL;            
                $result['Joint_Vehicle_Paying_Party'.$i.'']=NULL;
            } else {
                $result['Joint_Vehicle_Lease_Company'.$i.'']=NULL;            
                $result['Joint_Vehicle_Monthly_Lease_Amount'.$i.'']=NULL;            
                $result['Joint_Vehicle_Lease_Disposition_Method'.$i.'']=NULL;
            }



            if(isset($result['Client_Vehicle_Owned_Leased'.$i.'']) && $result['Client_Vehicle_Owned_Leased'.$i.''] !='Owned')
            {
                $result['Client_Vehicle_VIN'.$i.'']=NULL;            
                $result['Client_Vehicle_Current_Value'.$i.'']=NULL;            
                $result['Client_Vehicle_Loan_Company_Name'.$i.'']=NULL;            
                $result['Client_Vehicle_Loan_Balance'.$i.'']=NULL;            
                $result['Client_Vehicle_Loan_Monthly_Payment'.$i.'']=NULL;            
                $result['Client_Vehicle_Loan_Second_Company_Name'.$i.'']=NULL;            
                $result['Client_Vehicle_Loan_Second_Company_Balance'.$i.'']=NULL;            
                $result['Client_Vehicle_Loan_Second_Company_Monthly_Payment'.$i.'']=NULL;            
                $result['Client_Vehicle_Marital_Equity'.$i.'']=NULL;            
                $result['Client_Vehicle_SoleSeparate_Claim'.$i.'']=NULL;            
                $result['Client_Vehicle_SoleSeparate_Party'.$i.'']=NULL;            
                $result['Client_Vehicle_SoleSeparate_Grounds'.$i.'']=NULL;            
                $result['Client_Vehicle_Disposition_Method'.$i.'']=NULL;            
                $result['Client_Vehicle_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
                $result['Client_Vehicle_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
                $result['Client_Vehicle_Estimated_Value_to_Client'.$i.'']=NULL;            
                $result['Client_Vehicle_Estimated_Value_to_Op'.$i.'']=NULL;            
                $result['Client_Vehicle_Paying_Party'.$i.'']=NULL;
            } else {
                $result['Client_Vehicle_Lease_Company'.$i.'']=NULL;            
                $result['Client_Vehicle_Monthly_Lease_Amount'.$i.'']=NULL;            
                $result['Client_Vehicle_Lease_Disposition_Method'.$i.'']=NULL;
            }



            if(isset($result['Op_Vehicle_Owned_Leased'.$i.'']) && $result['Op_Vehicle_Owned_Leased'.$i.''] !='Owned')
            {
                $result['Op_Vehicle_VIN'.$i.'']=NULL;            
                $result['Op_Vehicle_Current_Value'.$i.'']=NULL;            
                $result['Op_Vehicle_Loan_Company_Name'.$i.'']=NULL;            
                $result['Op_Vehicle_Loan_Balance'.$i.'']=NULL;            
                $result['Op_Vehicle_Loan_Monthly_Payment'.$i.'']=NULL;            
                $result['Op_Vehicle_Loan_Second_Company_Name'.$i.'']=NULL;            
                $result['Op_Vehicle_Loan_Second_Company_Balance'.$i.'']=NULL;            
                $result['Op_Vehicle_Loan_Second_Company_Monthly_Payment'.$i.'']=NULL;            
                $result['Op_Vehicle_Marital_Equity'.$i.'']=NULL;            
                $result['Op_Vehicle_SoleSeparate_Claim'.$i.'']=NULL;            
                $result['Op_Vehicle_SoleSeparate_Party'.$i.'']=NULL;            
                $result['Op_Vehicle_SoleSeparate_Grounds'.$i.'']=NULL;            
                $result['Op_Vehicle_Disposition_Method'.$i.'']=NULL;            
                $result['Op_Vehicle_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
                $result['Op_Vehicle_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
                $result['Op_Vehicle_Estimated_Value_to_Client'.$i.'']=NULL;            
                $result['Op_Vehicle_Estimated_Value_to_Op'.$i.'']=NULL;            
                $result['Op_Vehicle_Paying_Party'.$i.'']=NULL;
            } else {
                $result['Op_Vehicle_Lease_Company'.$i.'']=NULL;            
                $result['Op_Vehicle_Monthly_Lease_Amount'.$i.'']=NULL;            
                $result['Op_Vehicle_Lease_Disposition_Method'.$i.'']=NULL;
            }

            // new calculations 
            // for joint
            if(isset($result['Joint_Vehicle_Lease_Disposition_Method'.$i.'']) && $result['Joint_Vehicle_Lease_Disposition_Method'.$i.'']=='Transfer Lease Responsibility to '.$request->client_name.''){
                if(isset($result['Joint_Vehicle_Monthly_Lease_Amount'.$i.'']) && $result['Joint_Vehicle_Monthly_Lease_Amount'.$i.'']!=''){
                    $result['Joint_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=$result['Joint_Vehicle_Monthly_Lease_Amount'.$i.''];
                } else {
                    $result['Joint_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=0.00;
                }
            } else {
                $result['Joint_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=0.00;
            }

            if(isset($result['Joint_Vehicle_Lease_Disposition_Method'.$i.'']) && $result['Joint_Vehicle_Lease_Disposition_Method'.$i.'']=='Transfer Lease Responsibility to '.$request->opponent_name.''){
                if(isset($result['Joint_Vehicle_Monthly_Lease_Amount'.$i.'']) && $result['Joint_Vehicle_Monthly_Lease_Amount'.$i.'']!=''){
                    $result['Joint_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=$result['Joint_Vehicle_Monthly_Lease_Amount'.$i.''];
                } else {
                    $result['Joint_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=0.00;
                }
            } else {
                $result['Joint_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=0.00;
            }

            // for client
            if(isset($result['Client_Vehicle_Lease_Disposition_Method'.$i.'']) && $result['Client_Vehicle_Lease_Disposition_Method'.$i.'']=='Transfer Lease Responsibility to '.$request->client_name.''){
                if(isset($result['Client_Vehicle_Monthly_Lease_Amount'.$i.'']) && $result['Client_Vehicle_Monthly_Lease_Amount'.$i.'']!=''){
                    $result['Client_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=$result['Client_Vehicle_Monthly_Lease_Amount'.$i.''];
                } else {
                    $result['Client_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=0.00;
                }
            } else {
                $result['Client_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=0.00;
            }

            if(isset($result['Client_Vehicle_Lease_Disposition_Method'.$i.'']) && $result['Client_Vehicle_Lease_Disposition_Method'.$i.'']=='Transfer Lease Responsibility to '.$request->opponent_name.''){
                if(isset($result['Client_Vehicle_Monthly_Lease_Amount'.$i.'']) && $result['Client_Vehicle_Monthly_Lease_Amount'.$i.'']!=''){
                    $result['Client_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=$result['Client_Vehicle_Monthly_Lease_Amount'.$i.''];
                } else {
                    $result['Client_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=0.00;
                }
            } else {
                $result['Client_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=0.00;
            }

            // for opponent
            if(isset($result['Op_Vehicle_Lease_Disposition_Method'.$i.'']) && $result['Op_Vehicle_Lease_Disposition_Method'.$i.'']=='Transfer Lease Responsibility to '.$request->client_name.''){
                if(isset($result['Op_Vehicle_Monthly_Lease_Amount'.$i.'']) && $result['Op_Vehicle_Monthly_Lease_Amount'.$i.'']!=''){
                    $result['Op_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=$result['Op_Vehicle_Monthly_Lease_Amount'.$i.''];
                } else {
                    $result['Op_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=0.00;
                }
            } else {
                $result['Op_Vehicle_Client_Monthly_Lease_Amount'.$i.'']=0.00;
            }

            if(isset($result['Op_Vehicle_Lease_Disposition_Method'.$i.'']) && $result['Op_Vehicle_Lease_Disposition_Method'.$i.'']=='Transfer Lease Responsibility to '.$request->opponent_name.''){
                if(isset($result['Op_Vehicle_Monthly_Lease_Amount'.$i.'']) && $result['Op_Vehicle_Monthly_Lease_Amount'.$i.'']!=''){
                    $result['Op_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=$result['Op_Vehicle_Monthly_Lease_Amount'.$i.''];
                } else {
                    $result['Op_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=0.00;
                }
            } else {
                $result['Op_Vehicle_Op_Monthly_Lease_Amount'.$i.'']=0.00;
            }

            // for all vehicles for client
            if(isset($result['Joint_Vehicle_Client_Monthly_Lease_Amount'.$i.'']) && $result['Joint_Vehicle_Client_Monthly_Lease_Amount'.$i.'']!=''){
                $result['Vehicle_Client_Total_Monthly_Lease_Amount']=$result['Vehicle_Client_Total_Monthly_Lease_Amount']+$result['Joint_Vehicle_Client_Monthly_Lease_Amount'.$i.''];
            }
            if(isset($result['Client_Vehicle_Client_Monthly_Lease_Amount'.$i.'']) && $result['Client_Vehicle_Client_Monthly_Lease_Amount'.$i.'']!=''){
                $result['Vehicle_Client_Total_Monthly_Lease_Amount']=$result['Vehicle_Client_Total_Monthly_Lease_Amount']+$result['Client_Vehicle_Client_Monthly_Lease_Amount'.$i.''];
            }
            if(isset($result['Op_Vehicle_Client_Monthly_Lease_Amount'.$i.'']) && $result['Op_Vehicle_Client_Monthly_Lease_Amount'.$i.'']!=''){
                $result['Vehicle_Client_Total_Monthly_Lease_Amount']=$result['Vehicle_Client_Total_Monthly_Lease_Amount']+$result['Op_Vehicle_Client_Monthly_Lease_Amount'.$i.''];
            }

            // for all vehicles for client
            if(isset($result['Joint_Vehicle_Op_Monthly_Lease_Amount'.$i.'']) && $result['Joint_Vehicle_Op_Monthly_Lease_Amount'.$i.'']!=''){
                $result['Vehicle_Op_Total_Monthly_Lease_Amount']=$result['Vehicle_Op_Total_Monthly_Lease_Amount']+$result['Joint_Vehicle_Op_Monthly_Lease_Amount'.$i.''];
            }
            if(isset($result['Client_Vehicle_Op_Monthly_Lease_Amount'.$i.'']) && $result['Client_Vehicle_Op_Monthly_Lease_Amount'.$i.'']!=''){
                $result['Vehicle_Op_Total_Monthly_Lease_Amount']=$result['Vehicle_Op_Total_Monthly_Lease_Amount']+$result['Client_Vehicle_Op_Monthly_Lease_Amount'.$i.''];
            }
            if(isset($result['Op_Vehicle_Op_Monthly_Lease_Amount'.$i.'']) && $result['Op_Vehicle_Op_Monthly_Lease_Amount'.$i.'']!=''){
                $result['Vehicle_Op_Total_Monthly_Lease_Amount']=$result['Vehicle_Op_Total_Monthly_Lease_Amount']+$result['Op_Vehicle_Op_Monthly_Lease_Amount'.$i.''];
            }
        }

        if(isset($result['Any_Vehicles']) && $result['Any_Vehicles']=='1'){
        } else {
            $result['Any_Vehicles']='0';
            $result['Num_Joint_Vehicles']=0;
            $result['Num_Client_Vehicles']=0;
            $result['Num_Op_Vehicles']=0;
        }

        if(isset($result['Num_Joint_Vehicles'])){
        } else {
            $result['Num_Joint_Vehicles']='0';
        }
        $Num_Joint_Vehicles=$result['Num_Joint_Vehicles'];
        $Num_Joint_Vehicles=$Num_Joint_Vehicles+1;
        for ($i=$Num_Joint_Vehicles; $i <= 6; $i++) { 
            $result['Joint_Vehicle_Year'.$i.'']=NULL;            
            $result['Joint_Vehicle_Make_Model'.$i.'']=NULL;            
            $result['Joint_Vehicle_Owned_Leased'.$i.'']=NULL;            
            $result['Joint_Vehicle_VIN'.$i.'']=NULL;            
            $result['Joint_Vehicle_Current_Value'.$i.'']=NULL;            
            $result['Joint_Vehicle_Loan_Company_Name'.$i.'']=NULL;            
            $result['Joint_Vehicle_Loan_Balance'.$i.'']=NULL;            
            $result['Joint_Vehicle_Loan_Monthly_Payment'.$i.'']=NULL;            
            $result['Joint_Vehicle_Loan_Second_Company_Name'.$i.'']=NULL;            
            $result['Joint_Vehicle_Loan_Second_Company_Balance'.$i.'']=NULL;            
            $result['Joint_Vehicle_Loan_Second_Company_Monthly_Payment'.$i.'']=NULL;            
            $result['Joint_Vehicle_Marital_Equity'.$i.'']=NULL;            
            $result['Joint_Vehicle_SoleSeparate_Claim'.$i.'']=NULL;            
            $result['Joint_Vehicle_SoleSeparate_Party'.$i.'']=NULL;            
            $result['Joint_Vehicle_SoleSeparate_Grounds'.$i.'']=NULL;            
            $result['Joint_Vehicle_Disposition_Method'.$i.'']=NULL;            
            $result['Joint_Vehicle_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
            $result['Joint_Vehicle_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
            $result['Joint_Vehicle_Estimated_Value_to_Client'.$i.'']=NULL;            
            $result['Joint_Vehicle_Estimated_Value_to_Op'.$i.'']=NULL;            
            $result['Joint_Vehicle_Paying_Party'.$i.'']=NULL;            
            $result['Joint_Vehicle_Lease_Company'.$i.'']=NULL;            
            $result['Joint_Vehicle_Monthly_Lease_Amount'.$i.'']=NULL;            
            $result['Joint_Vehicle_Lease_Disposition_Method'.$i.'']=NULL;            
        }

        if(isset($result['Num_Client_Vehicles'])){
        } else {
            $result['Num_Client_Vehicles']='0';
        }
        $Num_Client_Vehicles=$result['Num_Client_Vehicles'];
        $Num_Client_Vehicles=$Num_Client_Vehicles+1;
        for ($i=$Num_Client_Vehicles; $i <= 6; $i++) { 
            $result['Client_Vehicle_Year'.$i.'']=NULL;            
            $result['Client_Vehicle_Make_Model'.$i.'']=NULL;            
            $result['Client_Vehicle_Owned_Leased'.$i.'']=NULL;            
            $result['Client_Vehicle_VIN'.$i.'']=NULL;            
            $result['Client_Vehicle_Current_Value'.$i.'']=NULL;            
            $result['Client_Vehicle_Loan_Company_Name'.$i.'']=NULL;            
            $result['Client_Vehicle_Loan_Balance'.$i.'']=NULL;            
            $result['Client_Vehicle_Loan_Monthly_Payment'.$i.'']=NULL;            
            $result['Client_Vehicle_Loan_Second_Company_Name'.$i.'']=NULL;            
            $result['Client_Vehicle_Loan_Second_Company_Balance'.$i.'']=NULL;            
            $result['Client_Vehicle_Loan_Second_Company_Monthly_Payment'.$i.'']=NULL;            
            $result['Client_Vehicle_Marital_Equity'.$i.'']=NULL;            
            $result['Client_Vehicle_SoleSeparate_Claim'.$i.'']=NULL;            
            $result['Client_Vehicle_SoleSeparate_Party'.$i.'']=NULL;            
            $result['Client_Vehicle_SoleSeparate_Grounds'.$i.'']=NULL;            
            $result['Client_Vehicle_Disposition_Method'.$i.'']=NULL;            
            $result['Client_Vehicle_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
            $result['Client_Vehicle_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
            $result['Client_Vehicle_Estimated_Value_to_Client'.$i.'']=NULL;            
            $result['Client_Vehicle_Estimated_Value_to_Op'.$i.'']=NULL;            
            $result['Client_Vehicle_Paying_Party'.$i.'']=NULL;            
            $result['Client_Vehicle_Lease_Company'.$i.'']=NULL;            
            $result['Client_Vehicle_Monthly_Lease_Amount'.$i.'']=NULL;            
            $result['Client_Vehicle_Lease_Disposition_Method'.$i.'']=NULL;            
        }

        if(isset($result['Num_Op_Vehicles'])){
        } else {
            $result['Num_Op_Vehicles']='0';
        }
        $Num_Op_Vehicles=$result['Num_Op_Vehicles'];
        $Num_Op_Vehicles=$Num_Op_Vehicles+1;
        for ($i=$Num_Op_Vehicles; $i <= 6; $i++) { 
            $result['Op_Vehicle_Year'.$i.'']=NULL;            
            $result['Op_Vehicle_Make_Model'.$i.'']=NULL;            
            $result['Op_Vehicle_Owned_Leased'.$i.'']=NULL;            
            $result['Op_Vehicle_VIN'.$i.'']=NULL;            
            $result['Op_Vehicle_Current_Value'.$i.'']=NULL;            
            $result['Op_Vehicle_Loan_Company_Name'.$i.'']=NULL;            
            $result['Op_Vehicle_Loan_Balance'.$i.'']=NULL;            
            $result['Op_Vehicle_Loan_Monthly_Payment'.$i.'']=NULL;            
            $result['Op_Vehicle_Loan_Second_Company_Name'.$i.'']=NULL;            
            $result['Op_Vehicle_Loan_Second_Company_Balance'.$i.'']=NULL;            
            $result['Op_Vehicle_Loan_Second_Company_Monthly_Payment'.$i.'']=NULL;            
            $result['Op_Vehicle_Marital_Equity'.$i.'']=NULL;            
            $result['Op_Vehicle_SoleSeparate_Claim'.$i.'']=NULL;            
            $result['Op_Vehicle_SoleSeparate_Party'.$i.'']=NULL;            
            $result['Op_Vehicle_SoleSeparate_Grounds'.$i.'']=NULL;            
            $result['Op_Vehicle_Disposition_Method'.$i.'']=NULL;            
            $result['Op_Vehicle_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
            $result['Op_Vehicle_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
            $result['Op_Vehicle_Estimated_Value_to_Client'.$i.'']=NULL;            
            $result['Op_Vehicle_Estimated_Value_to_Op'.$i.'']=NULL;            
            $result['Op_Vehicle_Paying_Party'.$i.'']=NULL;            
            $result['Op_Vehicle_Lease_Company'.$i.'']=NULL;            
            $result['Op_Vehicle_Monthly_Lease_Amount'.$i.'']=NULL;            
            $result['Op_Vehicle_Lease_Disposition_Method'.$i.'']=NULL;            
        }

        
        // echo "<pre>";print_r($result);die;
        $drvehicles  = DrVehicles::findOrFail($id);
        if($drvehicles){
            $drvehicles->fill($result)->save();
            // update case overview info.
            $drcaseoverview=DrCaseOverview::where('case_id',$result['case_id'])->get()->first();
            if(isset($drcaseoverview)){
                $drcaseoverview->Any_Vehicles=$result['Any_Vehicles'];
                $drcaseoverview->Num_Joint_Vehicles=$result['Num_Joint_Vehicles'];
                $drcaseoverview->Num_Client_Vehicles=$result['Num_Client_Vehicles'];
                $drcaseoverview->Num_Op_Vehicles=$result['Num_Op_Vehicles'];
                $drcaseoverview->save();
            } else {
                return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('error', 'Complete Case Overview Info Section First.');
            }
            return redirect()->route('drvehicles.edit',$result['case_id'])->with('success', 'Vehicles Information Updated Successfully.');
        } else {
            return redirect()->route('drvehicles.edit',$result['case_id'])->with('error', 'Something went wrong. Please try Again.');
        }
    }
    
    public function destroy($id)
    {

    }

}
