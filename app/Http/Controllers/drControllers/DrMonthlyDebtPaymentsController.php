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
use App\DrMonthlyDebtPayments;


class DrMonthlyDebtPaymentsController extends Controller
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
        $data=DrMonthlyDebtPayments::orderBy('id','DESC')->get();
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

        $drmonthlydebtpayments=DrMonthlyDebtPayments::where('case_id',$case_id)->get()->pluck('case_id');
        if(isset($drmonthlydebtpayments['0'])){
            return redirect()->route('home');
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
        return view('dr_tables.dr_MonthlyDebtPayments.create',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name]);
    }

    public function store(Request $request)
    {
        $result = $request->except('submit', 'client_name', 'opponent_name');
        
        if(isset($result['Num_Joint_Monthly_Debts_Creditors'])){
        } else {
            $result['Num_Joint_Monthly_Debts_Creditors']='0';
        }

        $Num_Joint_Monthly_Debts_Creditors=$result['Num_Joint_Monthly_Debts_Creditors'];
        
        $result['Total_Debts']=0.00;
        $result['Total_Debt_Payments']=0.00;
        $result['Total_Joint_Debts']=0.00;
        $result['Total_Debts_to_Client']=0.00;
        $result['Total_Debt_Payments_to_Client']=0.00;
        $result['Total_Debts_to_Op']=0.00;
        $result['Total_Debt_Payments_to_Op']=0.00;

        for ($i=1; $i <= $Num_Joint_Monthly_Debts_Creditors; $i++) { 
            if(isset($result['Joint_Debt_Balance'.$i.'']) && $result['Joint_Debt_Balance'.$i.''] !=''){
                $result['Total_Joint_Debts']=$result['Total_Joint_Debts']+$result['Joint_Debt_Balance'.$i.''];
            }
            if(isset($result['Joint_Monthly_Debt_Payment'.$i.'']) && $result['Joint_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments']=$result['Total_Debt_Payments']+$result['Joint_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($request->client_name) && isset($result['Post_Decree_Responsible_Party_Joint_Debt'.$i.'']) && $request->client_name == $result['Post_Decree_Responsible_Party_Joint_Debt'.$i.''] && isset($result['Joint_Debt_Balance'.$i.'']) && $result['Joint_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Client']=$result['Total_Debts_to_Client']+$result['Joint_Debt_Balance'.$i.''];
            }
            if(isset($request->client_name) && isset($result['Post_Decree_Responsible_Party_Joint_Debt'.$i.'']) && $request->client_name == $result['Post_Decree_Responsible_Party_Joint_Debt'.$i.''] && isset($result['Joint_Monthly_Debt_Payment'.$i.'']) && $result['Joint_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Client']=$result['Total_Debt_Payments_to_Client']+$result['Joint_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($request->opponent_name) && isset($result['Post_Decree_Responsible_Party_Joint_Debt'.$i.'']) && $request->opponent_name == $result['Post_Decree_Responsible_Party_Joint_Debt'.$i.''] && isset($result['Joint_Debt_Balance'.$i.'']) && $result['Joint_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Op']=$result['Total_Debts_to_Op']+$result['Joint_Debt_Balance'.$i.''];
            }
            if(isset($request->opponent_name) && isset($result['Post_Decree_Responsible_Party_Joint_Debt'.$i.'']) && $request->opponent_name == $result['Post_Decree_Responsible_Party_Joint_Debt'.$i.''] && isset($result['Joint_Monthly_Debt_Payment'.$i.'']) && $result['Joint_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Op']=$result['Total_Debt_Payments_to_Op']+$result['Joint_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($result['Post_Decree_Responsible_Party_Joint_Debt'.$i.'']) && 'Both' == $result['Post_Decree_Responsible_Party_Joint_Debt'.$i.''] && isset($result['Joint_Debt_Balance'.$i.'']) && $result['Joint_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Client']=$result['Total_Debts_to_Client']+($result['Joint_Debt_Balance'.$i.'']/2);
                $result['Total_Debts_to_Op']=$result['Total_Debts_to_Op']+($result['Joint_Debt_Balance'.$i.'']/2);
            }
            if(isset($result['Post_Decree_Responsible_Party_Joint_Debt'.$i.'']) && 'Both' == $result['Post_Decree_Responsible_Party_Joint_Debt'.$i.''] && isset($result['Joint_Monthly_Debt_Payment'.$i.'']) && $result['Joint_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Client']=$result['Total_Debt_Payments_to_Client']+($result['Joint_Monthly_Debt_Payment'.$i.'']/2);
                $result['Total_Debt_Payments_to_Op']=$result['Total_Debt_Payments_to_Op']+($result['Joint_Monthly_Debt_Payment'.$i.'']/2);
            }
        }

        $Num_Joint_Monthly_Debts_Creditors=$Num_Joint_Monthly_Debts_Creditors+1;
        for ($i=$Num_Joint_Monthly_Debts_Creditors; $i <= 15; $i++) { 
            $result['Joint_Monthly_Debt_Creditor_Name'.$i.'']=NULL;
            $result['Joint_Monthly_Debt_Purpose_Security'.$i.'']=NULL;
            $result['Joint_Monthly_Debt_Other_Type'.$i.'']=NULL;
            $result['Joint_Monthly_Debt_Primary_Beneficiary'.$i.'']=NULL;
            $result['Joint_Monthly_Debt_Payment'.$i.'']=NULL;
            $result['Joint_Debt_Balance'.$i.'']=NULL;
            $result['Post_Decree_Responsible_Party_Joint_Debt'.$i.'']=NULL;
        }

        if(isset($result['Num_Client_Monthly_Debts_Creditors'])){
        } else {
            $result['Num_Client_Monthly_Debts_Creditors']='0';
        }

        $Num_Client_Monthly_Debts_Creditors=$result['Num_Client_Monthly_Debts_Creditors'];

        $result['Total_Client_Debts']=0.00;
        for ($i=1; $i <= $Num_Client_Monthly_Debts_Creditors; $i++) { 
            if(isset($result['Client_Debt_Balance'.$i.'']) && $result['Client_Debt_Balance'.$i.''] !=''){
                $result['Total_Client_Debts']=$result['Total_Client_Debts']+$result['Client_Debt_Balance'.$i.''];
            }
            if(isset($result['Client_Monthly_Debt_Payment'.$i.'']) && $result['Client_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments']=$result['Total_Debt_Payments']+$result['Client_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($request->client_name) && isset($result['Post_Decree_Responsible_Party_Client_Debt'.$i.'']) && $request->client_name == $result['Post_Decree_Responsible_Party_Client_Debt'.$i.''] && isset($result['Client_Debt_Balance'.$i.'']) && $result['Client_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Client']=$result['Total_Debts_to_Client']+$result['Client_Debt_Balance'.$i.''];
            }
            if(isset($request->client_name) && isset($result['Post_Decree_Responsible_Party_Client_Debt'.$i.'']) && $request->client_name == $result['Post_Decree_Responsible_Party_Client_Debt'.$i.''] && isset($result['Client_Monthly_Debt_Payment'.$i.'']) && $result['Client_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Client']=$result['Total_Debt_Payments_to_Client']+$result['Client_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($request->opponent_name) && isset($result['Post_Decree_Responsible_Party_Client_Debt'.$i.'']) && $request->opponent_name == $result['Post_Decree_Responsible_Party_Client_Debt'.$i.''] && isset($result['Client_Debt_Balance'.$i.'']) && $result['Client_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Op']=$result['Total_Debts_to_Op']+$result['Client_Debt_Balance'.$i.''];
            }
            if(isset($request->opponent_name) && isset($result['Post_Decree_Responsible_Party_Client_Debt'.$i.'']) && $request->opponent_name == $result['Post_Decree_Responsible_Party_Client_Debt'.$i.''] && isset($result['Client_Monthly_Debt_Payment'.$i.'']) && $result['Client_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Op']=$result['Total_Debt_Payments_to_Op']+$result['Client_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($result['Post_Decree_Responsible_Party_Client_Debt'.$i.'']) && 'Both' == $result['Post_Decree_Responsible_Party_Client_Debt'.$i.''] && isset($result['Client_Debt_Balance'.$i.'']) && $result['Client_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Client']=$result['Total_Debts_to_Client']+($result['Client_Debt_Balance'.$i.'']/2);
                $result['Total_Debts_to_Op']=$result['Total_Debts_to_Op']+($result['Client_Debt_Balance'.$i.'']/2);
            }
            if(isset($result['Post_Decree_Responsible_Party_Client_Debt'.$i.'']) && 'Both' == $result['Post_Decree_Responsible_Party_Client_Debt'.$i.''] && isset($result['Client_Monthly_Debt_Payment'.$i.'']) && $result['Client_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Client']=$result['Total_Debt_Payments_to_Client']+($result['Client_Monthly_Debt_Payment'.$i.'']/2);
                $result['Total_Debt_Payments_to_Op']=$result['Total_Debt_Payments_to_Op']+($result['Client_Monthly_Debt_Payment'.$i.'']/2);
            }
        }

        $Num_Client_Monthly_Debts_Creditors=$Num_Client_Monthly_Debts_Creditors+1;
        for ($i=$Num_Client_Monthly_Debts_Creditors; $i <= 15; $i++) { 
            $result['Client_Monthly_Debt_Creditor_Name'.$i.'']=NULL;
            $result['Client_Monthly_Debt_Purpose_Security'.$i.'']=NULL;
            $result['Client_Monthly_Debt_Other_Type'.$i.'']=NULL;
            $result['Client_Monthly_Debt_Primary_Beneficiary'.$i.'']=NULL;
            $result['Client_Monthly_Debt_Payment'.$i.'']=NULL;
            $result['Client_Debt_Balance'.$i.'']=NULL;
            $result['Post_Decree_Responsible_Party_Client_Debt'.$i.'']=NULL;
        }

        if(isset($result['Num_Op_Monthly_Debts_Creditors'])){
        } else {
            $result['Num_Op_Monthly_Debts_Creditors']='0';
        }
        $Num_Op_Monthly_Debts_Creditors=$result['Num_Op_Monthly_Debts_Creditors'];

        $result['Total_Op_Debts']=0.00;
        for ($i=1; $i <= $Num_Op_Monthly_Debts_Creditors; $i++) { 
            if(isset($result['Op_Debt_Balance'.$i.'']) && $result['Op_Debt_Balance'.$i.''] !=''){
                $result['Total_Op_Debts']=$result['Total_Op_Debts']+$result['Op_Debt_Balance'.$i.''];
            }
            if(isset($result['Op_Monthly_Debt_Payment'.$i.'']) && $result['Op_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments']=$result['Total_Debt_Payments']+$result['Op_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($request->client_name) && isset($result['Post_Decree_Responsible_Party_Op_Debt'.$i.'']) && $request->client_name == $result['Post_Decree_Responsible_Party_Op_Debt'.$i.''] && isset($result['Op_Debt_Balance'.$i.'']) && $result['Op_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Client']=$result['Total_Debts_to_Client']+$result['Op_Debt_Balance'.$i.''];
            }
            if(isset($request->client_name) && isset($result['Post_Decree_Responsible_Party_Op_Debt'.$i.'']) && $request->client_name == $result['Post_Decree_Responsible_Party_Op_Debt'.$i.''] && isset($result['Op_Monthly_Debt_Payment'.$i.'']) && $result['Op_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Client']=$result['Total_Debt_Payments_to_Client']+$result['Op_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($request->opponent_name) && isset($result['Post_Decree_Responsible_Party_Op_Debt'.$i.'']) && $request->opponent_name == $result['Post_Decree_Responsible_Party_Op_Debt'.$i.''] && isset($result['Op_Debt_Balance'.$i.'']) && $result['Op_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Op']=$result['Total_Debts_to_Op']+$result['Op_Debt_Balance'.$i.''];
            }
            if(isset($request->opponent_name) && isset($result['Post_Decree_Responsible_Party_Op_Debt'.$i.'']) && $request->opponent_name == $result['Post_Decree_Responsible_Party_Op_Debt'.$i.''] && isset($result['Op_Monthly_Debt_Payment'.$i.'']) && $result['Op_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Op']=$result['Total_Debt_Payments_to_Op']+$result['Op_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($result['Post_Decree_Responsible_Party_Op_Debt'.$i.'']) && 'Both' == $result['Post_Decree_Responsible_Party_Op_Debt'.$i.''] && isset($result['Op_Debt_Balance'.$i.'']) && $result['Op_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Client']=$result['Total_Debts_to_Client']+($result['Op_Debt_Balance'.$i.'']/2);
                $result['Total_Debts_to_Op']=$result['Total_Debts_to_Op']+($result['Op_Debt_Balance'.$i.'']/2);
            }
            if(isset($result['Post_Decree_Responsible_Party_Op_Debt'.$i.'']) && 'Both' == $result['Post_Decree_Responsible_Party_Op_Debt'.$i.''] && isset($result['Op_Monthly_Debt_Payment'.$i.'']) && $result['Op_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Client']=$result['Total_Debt_Payments_to_Client']+($result['Op_Monthly_Debt_Payment'.$i.'']/2);
                $result['Total_Debt_Payments_to_Op']=$result['Total_Debt_Payments_to_Op']+($result['Op_Monthly_Debt_Payment'.$i.'']/2);
            }
        }

        $result['Total_Debts']=$result['Total_Joint_Debts']+$result['Total_Client_Debts']+$result['Total_Op_Debts'];

        $Num_Op_Monthly_Debts_Creditors=$Num_Op_Monthly_Debts_Creditors+1;
        for ($i=$Num_Op_Monthly_Debts_Creditors; $i <= 15; $i++) { 
            $result['Op_Monthly_Debt_Creditor_Name'.$i.'']=NULL;
            $result['Op_Monthly_Debt_Purpose_Security'.$i.'']=NULL;
            $result['Op_Monthly_Debt_Other_Type'.$i.'']=NULL;
            $result['Op_Monthly_Debt_Primary_Beneficiary'.$i.'']=NULL;
            $result['Op_Monthly_Debt_Payment'.$i.'']=NULL;
            $result['Op_Debt_Balance'.$i.'']=NULL;
            $result['Post_Decree_Responsible_Party_Op_Debt'.$i.'']=NULL;
        }
        
        // echo "<pre>";print_r($result);die;
        $DrMonthlyDebtPayments=DrMonthlyDebtPayments::create($result);
        
        return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('success', 'Monthly Debt Payments Information Submitted Successfully.');
        
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
        $drmonthlydebtpayments=DrMonthlyDebtPayments::where('case_id',$case_id)->get()->first();
        if($drmonthlydebtpayments){
            return view('dr_tables.dr_MonthlyDebtPayments.edit',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'drmonthlydebtpayments' => $drmonthlydebtpayments]);
        } else {
            return redirect()->route('home');
        }
        // echo "<pre>";print_r($DrMonthlyDebtPayments);//die;
        
    }

    public function update(Request $request, $id)
    {
        $result = $request->except('submit','_method','_token','client_name','opponent_name');
        
        if(isset($result['Num_Joint_Monthly_Debts_Creditors'])){
        } else {
            $result['Num_Joint_Monthly_Debts_Creditors']='0';
        }

        $Num_Joint_Monthly_Debts_Creditors=$result['Num_Joint_Monthly_Debts_Creditors'];
        
        $result['Total_Debts']=0.00;
        $result['Total_Debt_Payments']=0.00;
        $result['Total_Joint_Debts']=0.00;
        $result['Total_Debts_to_Client']=0.00;
        $result['Total_Debt_Payments_to_Client']=0.00;
        $result['Total_Debts_to_Op']=0.00;
        $result['Total_Debt_Payments_to_Op']=0.00;

        for ($i=1; $i <= $Num_Joint_Monthly_Debts_Creditors; $i++) { 
            if(isset($result['Joint_Debt_Balance'.$i.'']) && $result['Joint_Debt_Balance'.$i.''] !=''){
                $result['Total_Joint_Debts']=$result['Total_Joint_Debts']+$result['Joint_Debt_Balance'.$i.''];
            }
            if(isset($result['Joint_Monthly_Debt_Payment'.$i.'']) && $result['Joint_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments']=$result['Total_Debt_Payments']+$result['Joint_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($request->client_name) && isset($result['Post_Decree_Responsible_Party_Joint_Debt'.$i.'']) && $request->client_name == $result['Post_Decree_Responsible_Party_Joint_Debt'.$i.''] && isset($result['Joint_Debt_Balance'.$i.'']) && $result['Joint_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Client']=$result['Total_Debts_to_Client']+$result['Joint_Debt_Balance'.$i.''];
            }
            if(isset($request->client_name) && isset($result['Post_Decree_Responsible_Party_Joint_Debt'.$i.'']) && $request->client_name == $result['Post_Decree_Responsible_Party_Joint_Debt'.$i.''] && isset($result['Joint_Monthly_Debt_Payment'.$i.'']) && $result['Joint_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Client']=$result['Total_Debt_Payments_to_Client']+$result['Joint_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($request->opponent_name) && isset($result['Post_Decree_Responsible_Party_Joint_Debt'.$i.'']) && $request->opponent_name == $result['Post_Decree_Responsible_Party_Joint_Debt'.$i.''] && isset($result['Joint_Debt_Balance'.$i.'']) && $result['Joint_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Op']=$result['Total_Debts_to_Op']+$result['Joint_Debt_Balance'.$i.''];
            }
            if(isset($request->opponent_name) && isset($result['Post_Decree_Responsible_Party_Joint_Debt'.$i.'']) && $request->opponent_name == $result['Post_Decree_Responsible_Party_Joint_Debt'.$i.''] && isset($result['Joint_Monthly_Debt_Payment'.$i.'']) && $result['Joint_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Op']=$result['Total_Debt_Payments_to_Op']+$result['Joint_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($result['Post_Decree_Responsible_Party_Joint_Debt'.$i.'']) && 'Both' == $result['Post_Decree_Responsible_Party_Joint_Debt'.$i.''] && isset($result['Joint_Debt_Balance'.$i.'']) && $result['Joint_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Client']=$result['Total_Debts_to_Client']+($result['Joint_Debt_Balance'.$i.'']/2);
                $result['Total_Debts_to_Op']=$result['Total_Debts_to_Op']+($result['Joint_Debt_Balance'.$i.'']/2);
            }
            if(isset($result['Post_Decree_Responsible_Party_Joint_Debt'.$i.'']) && 'Both' == $result['Post_Decree_Responsible_Party_Joint_Debt'.$i.''] && isset($result['Joint_Monthly_Debt_Payment'.$i.'']) && $result['Joint_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Client']=$result['Total_Debt_Payments_to_Client']+($result['Joint_Monthly_Debt_Payment'.$i.'']/2);
                $result['Total_Debt_Payments_to_Op']=$result['Total_Debt_Payments_to_Op']+($result['Joint_Monthly_Debt_Payment'.$i.'']/2);
            }
        }

        $Num_Joint_Monthly_Debts_Creditors=$Num_Joint_Monthly_Debts_Creditors+1;
        for ($i=$Num_Joint_Monthly_Debts_Creditors; $i <= 15; $i++) { 
            $result['Joint_Monthly_Debt_Creditor_Name'.$i.'']=NULL;
            $result['Joint_Monthly_Debt_Purpose_Security'.$i.'']=NULL;
            $result['Joint_Monthly_Debt_Other_Type'.$i.'']=NULL;
            $result['Joint_Monthly_Debt_Primary_Beneficiary'.$i.'']=NULL;
            $result['Joint_Monthly_Debt_Payment'.$i.'']=NULL;
            $result['Joint_Debt_Balance'.$i.'']=NULL;
            $result['Post_Decree_Responsible_Party_Joint_Debt'.$i.'']=NULL;
        }

        if(isset($result['Num_Client_Monthly_Debts_Creditors'])){
        } else {
            $result['Num_Client_Monthly_Debts_Creditors']='0';
        }

        $Num_Client_Monthly_Debts_Creditors=$result['Num_Client_Monthly_Debts_Creditors'];

        $result['Total_Client_Debts']=0.00;
        for ($i=1; $i <= $Num_Client_Monthly_Debts_Creditors; $i++) { 
            if(isset($result['Client_Debt_Balance'.$i.'']) && $result['Client_Debt_Balance'.$i.''] !=''){
                $result['Total_Client_Debts']=$result['Total_Client_Debts']+$result['Client_Debt_Balance'.$i.''];
            }
            if(isset($result['Client_Monthly_Debt_Payment'.$i.'']) && $result['Client_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments']=$result['Total_Debt_Payments']+$result['Client_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($request->client_name) && isset($result['Post_Decree_Responsible_Party_Client_Debt'.$i.'']) && $request->client_name == $result['Post_Decree_Responsible_Party_Client_Debt'.$i.''] && isset($result['Client_Debt_Balance'.$i.'']) && $result['Client_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Client']=$result['Total_Debts_to_Client']+$result['Client_Debt_Balance'.$i.''];
            }
            if(isset($request->client_name) && isset($result['Post_Decree_Responsible_Party_Client_Debt'.$i.'']) && $request->client_name == $result['Post_Decree_Responsible_Party_Client_Debt'.$i.''] && isset($result['Client_Monthly_Debt_Payment'.$i.'']) && $result['Client_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Client']=$result['Total_Debt_Payments_to_Client']+$result['Client_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($request->opponent_name) && isset($result['Post_Decree_Responsible_Party_Client_Debt'.$i.'']) && $request->opponent_name == $result['Post_Decree_Responsible_Party_Client_Debt'.$i.''] && isset($result['Client_Debt_Balance'.$i.'']) && $result['Client_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Op']=$result['Total_Debts_to_Op']+$result['Client_Debt_Balance'.$i.''];
            }
            if(isset($request->opponent_name) && isset($result['Post_Decree_Responsible_Party_Client_Debt'.$i.'']) && $request->opponent_name == $result['Post_Decree_Responsible_Party_Client_Debt'.$i.''] && isset($result['Client_Monthly_Debt_Payment'.$i.'']) && $result['Client_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Op']=$result['Total_Debt_Payments_to_Op']+$result['Client_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($result['Post_Decree_Responsible_Party_Client_Debt'.$i.'']) && 'Both' == $result['Post_Decree_Responsible_Party_Client_Debt'.$i.''] && isset($result['Client_Debt_Balance'.$i.'']) && $result['Client_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Client']=$result['Total_Debts_to_Client']+($result['Client_Debt_Balance'.$i.'']/2);
                $result['Total_Debts_to_Op']=$result['Total_Debts_to_Op']+($result['Client_Debt_Balance'.$i.'']/2);
            }
            if(isset($result['Post_Decree_Responsible_Party_Client_Debt'.$i.'']) && 'Both' == $result['Post_Decree_Responsible_Party_Client_Debt'.$i.''] && isset($result['Client_Monthly_Debt_Payment'.$i.'']) && $result['Client_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Client']=$result['Total_Debt_Payments_to_Client']+($result['Client_Monthly_Debt_Payment'.$i.'']/2);
                $result['Total_Debt_Payments_to_Op']=$result['Total_Debt_Payments_to_Op']+($result['Client_Monthly_Debt_Payment'.$i.'']/2);
            }
        }

        $Num_Client_Monthly_Debts_Creditors=$Num_Client_Monthly_Debts_Creditors+1;
        for ($i=$Num_Client_Monthly_Debts_Creditors; $i <= 15; $i++) { 
            $result['Client_Monthly_Debt_Creditor_Name'.$i.'']=NULL;
            $result['Client_Monthly_Debt_Purpose_Security'.$i.'']=NULL;
            $result['Client_Monthly_Debt_Other_Type'.$i.'']=NULL;
            $result['Client_Monthly_Debt_Primary_Beneficiary'.$i.'']=NULL;
            $result['Client_Monthly_Debt_Payment'.$i.'']=NULL;
            $result['Client_Debt_Balance'.$i.'']=NULL;
            $result['Post_Decree_Responsible_Party_Client_Debt'.$i.'']=NULL;
        }

        if(isset($result['Num_Op_Monthly_Debts_Creditors'])){
        } else {
            $result['Num_Op_Monthly_Debts_Creditors']='0';
        }
        $Num_Op_Monthly_Debts_Creditors=$result['Num_Op_Monthly_Debts_Creditors'];

        $result['Total_Op_Debts']=0.00;
        for ($i=1; $i <= $Num_Op_Monthly_Debts_Creditors; $i++) { 
            if(isset($result['Op_Debt_Balance'.$i.'']) && $result['Op_Debt_Balance'.$i.''] !=''){
                $result['Total_Op_Debts']=$result['Total_Op_Debts']+$result['Op_Debt_Balance'.$i.''];
            }
            if(isset($result['Op_Monthly_Debt_Payment'.$i.'']) && $result['Op_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments']=$result['Total_Debt_Payments']+$result['Op_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($request->client_name) && isset($result['Post_Decree_Responsible_Party_Op_Debt'.$i.'']) && $request->client_name == $result['Post_Decree_Responsible_Party_Op_Debt'.$i.''] && isset($result['Op_Debt_Balance'.$i.'']) && $result['Op_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Client']=$result['Total_Debts_to_Client']+$result['Op_Debt_Balance'.$i.''];
            }
            if(isset($request->client_name) && isset($result['Post_Decree_Responsible_Party_Op_Debt'.$i.'']) && $request->client_name == $result['Post_Decree_Responsible_Party_Op_Debt'.$i.''] && isset($result['Op_Monthly_Debt_Payment'.$i.'']) && $result['Op_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Client']=$result['Total_Debt_Payments_to_Client']+$result['Op_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($request->opponent_name) && isset($result['Post_Decree_Responsible_Party_Op_Debt'.$i.'']) && $request->opponent_name == $result['Post_Decree_Responsible_Party_Op_Debt'.$i.''] && isset($result['Op_Debt_Balance'.$i.'']) && $result['Op_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Op']=$result['Total_Debts_to_Op']+$result['Op_Debt_Balance'.$i.''];
            }
            if(isset($request->opponent_name) && isset($result['Post_Decree_Responsible_Party_Op_Debt'.$i.'']) && $request->opponent_name == $result['Post_Decree_Responsible_Party_Op_Debt'.$i.''] && isset($result['Op_Monthly_Debt_Payment'.$i.'']) && $result['Op_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Op']=$result['Total_Debt_Payments_to_Op']+$result['Op_Monthly_Debt_Payment'.$i.''];
            }

            if(isset($result['Post_Decree_Responsible_Party_Op_Debt'.$i.'']) && 'Both' == $result['Post_Decree_Responsible_Party_Op_Debt'.$i.''] && isset($result['Op_Debt_Balance'.$i.'']) && $result['Op_Debt_Balance'.$i.''] !=''){
                $result['Total_Debts_to_Client']=$result['Total_Debts_to_Client']+($result['Op_Debt_Balance'.$i.'']/2);
                $result['Total_Debts_to_Op']=$result['Total_Debts_to_Op']+($result['Op_Debt_Balance'.$i.'']/2);
            }
            if(isset($result['Post_Decree_Responsible_Party_Op_Debt'.$i.'']) && 'Both' == $result['Post_Decree_Responsible_Party_Op_Debt'.$i.''] && isset($result['Op_Monthly_Debt_Payment'.$i.'']) && $result['Op_Monthly_Debt_Payment'.$i.''] !=''){
                $result['Total_Debt_Payments_to_Client']=$result['Total_Debt_Payments_to_Client']+($result['Op_Monthly_Debt_Payment'.$i.'']/2);
                $result['Total_Debt_Payments_to_Op']=$result['Total_Debt_Payments_to_Op']+($result['Op_Monthly_Debt_Payment'.$i.'']/2);
            }
        }

        $result['Total_Debts']=$result['Total_Joint_Debts']+$result['Total_Client_Debts']+$result['Total_Op_Debts'];

        $Num_Op_Monthly_Debts_Creditors=$Num_Op_Monthly_Debts_Creditors+1;
        for ($i=$Num_Op_Monthly_Debts_Creditors; $i <= 15; $i++) { 
            $result['Op_Monthly_Debt_Creditor_Name'.$i.'']=NULL;
            $result['Op_Monthly_Debt_Purpose_Security'.$i.'']=NULL;
            $result['Op_Monthly_Debt_Other_Type'.$i.'']=NULL;
            $result['Op_Monthly_Debt_Primary_Beneficiary'.$i.'']=NULL;
            $result['Op_Monthly_Debt_Payment'.$i.'']=NULL;
            $result['Op_Debt_Balance'.$i.'']=NULL;
            $result['Post_Decree_Responsible_Party_Op_Debt'.$i.'']=NULL;
        }
        
        $DrMonthlyDebtPayments  = DrMonthlyDebtPayments::findOrFail($id);
        if($DrMonthlyDebtPayments){
            $DrMonthlyDebtPayments->fill($result)->save();
            return redirect()->route('drmonthlydebtpayments.edit',$result['case_id'])->with('success', 'Monthly Debt Payments Information Updated Successfully.');
        } else {
            return redirect()->route('drmonthlydebtpayments.edit',$result['case_id'])->with('error', 'Something went wrong. Please try Again.');
        }
    }
    
    public function destroy($id)
    {

    }

}
