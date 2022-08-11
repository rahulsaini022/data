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
use App\DrMonthlyEducationExpenses;


class DrMonthlyEducationExpensesController extends Controller
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
        $data=DrMonthlyEducationExpenses::orderBy('id','DESC')->get();
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
        $drmonthlyeducationexpenses=DrMonthlyEducationExpenses::where('case_id',$case_id)->get()->pluck('case_id');
        if(isset($drmonthlyeducationexpenses['0'])){
            return redirect()->route('home');
        }
        return view('dr_tables.dr_MonthlyEducationExpenses.create',['case_id'=> $case_id, 'client_name' => $client_name, 'opponent_name' => $opponent_name]);
    }

    public function store(Request $request)
    {
        $result = $request->except('submit');
        // parse string to date for client info section
        $result['Client_Total_Monthly_Education_Expenses']=0.00;
        $result['Op_Total_Monthly_Education_Expenses']=0.00;

        if(isset($result['Client_Monthly_School_Tuition_For_Client']) && $result['Client_Monthly_School_Tuition_For_Client'] !=''){
            $result['Client_Total_Monthly_Education_Expenses']=$result['Client_Total_Monthly_Education_Expenses']+$result['Client_Monthly_School_Tuition_For_Client'];
        }
        if(isset($result['Client_Monthly_School_Tuition_For_Children']) && $result['Client_Monthly_School_Tuition_For_Children'] !=''){
            $result['Client_Total_Monthly_Education_Expenses']=$result['Client_Total_Monthly_Education_Expenses']+$result['Client_Monthly_School_Tuition_For_Children'];
        }
        if(isset($result['Client_Monthly_School_Books_Fees_Etc']) && $result['Client_Monthly_School_Books_Fees_Etc'] !=''){
            $result['Client_Total_Monthly_Education_Expenses']=$result['Client_Total_Monthly_Education_Expenses']+$result['Client_Monthly_School_Books_Fees_Etc'];
        }
        if(isset($result['Client_Monthly_College_Loan_Repayment1']) && $result['Client_Monthly_College_Loan_Repayment1'] !=''){
            $result['Client_Total_Monthly_Education_Expenses']=$result['Client_Total_Monthly_Education_Expenses']+$result['Client_Monthly_College_Loan_Repayment1'];
        }
        if(isset($result['Client_Monthly_College_Loan_Repayment2']) && $result['Client_Monthly_College_Loan_Repayment2'] !=''){
            $result['Client_Total_Monthly_Education_Expenses']=$result['Client_Total_Monthly_Education_Expenses']+$result['Client_Monthly_College_Loan_Repayment2'];
        }
        if(isset($result['Client_Monthly_College_Loan_Repayment3']) && $result['Client_Monthly_College_Loan_Repayment3'] !=''){
            $result['Client_Total_Monthly_Education_Expenses']=$result['Client_Total_Monthly_Education_Expenses']+$result['Client_Monthly_College_Loan_Repayment3'];
        }
        if(isset($result['Client_Monthly_Education_Other_Amount1']) && $result['Client_Monthly_Education_Other_Amount1'] !=''){
            $result['Client_Total_Monthly_Education_Expenses']=$result['Client_Total_Monthly_Education_Expenses']+$result['Client_Monthly_Education_Other_Amount1'];
        }
        if(isset($result['Client_Monthly_Education_Other_Amount2']) && $result['Client_Monthly_Education_Other_Amount2'] !=''){
            $result['Client_Total_Monthly_Education_Expenses']=$result['Client_Total_Monthly_Education_Expenses']+$result['Client_Monthly_Education_Other_Amount2'];
        }

        
        if(isset($result['Op_Monthly_School_Tuition_For_Op']) && $result['Op_Monthly_School_Tuition_For_Op'] !=''){
            $result['Op_Total_Monthly_Education_Expenses']=$result['Op_Total_Monthly_Education_Expenses']+$result['Op_Monthly_School_Tuition_For_Op'];
        }
        if(isset($result['Op_Monthly_School_Tuition_For_Children']) && $result['Op_Monthly_School_Tuition_For_Children'] !=''){
            $result['Op_Total_Monthly_Education_Expenses']=$result['Op_Total_Monthly_Education_Expenses']+$result['Op_Monthly_School_Tuition_For_Children'];
        }
        if(isset($result['Op_Monthly_School_Books_Fees_Etc']) && $result['Op_Monthly_School_Books_Fees_Etc'] !=''){
            $result['Op_Total_Monthly_Education_Expenses']=$result['Op_Total_Monthly_Education_Expenses']+$result['Op_Monthly_School_Books_Fees_Etc'];
        }
        if(isset($result['Op_Monthly_College_Loan_Repayment1']) && $result['Op_Monthly_College_Loan_Repayment1'] !=''){
            $result['Op_Total_Monthly_Education_Expenses']=$result['Op_Total_Monthly_Education_Expenses']+$result['Op_Monthly_College_Loan_Repayment1'];
        }
        if(isset($result['Op_Monthly_College_Loan_Repayment2']) && $result['Op_Monthly_College_Loan_Repayment2'] !=''){
            $result['Op_Total_Monthly_Education_Expenses']=$result['Op_Total_Monthly_Education_Expenses']+$result['Op_Monthly_College_Loan_Repayment2'];
        }
        if(isset($result['Op_Monthly_College_Loan_Repayment3']) && $result['Op_Monthly_College_Loan_Repayment3'] !=''){
            $result['Op_Total_Monthly_Education_Expenses']=$result['Op_Total_Monthly_Education_Expenses']+$result['Op_Monthly_College_Loan_Repayment3'];
        }
        if(isset($result['Op_Monthly_Education_Other_Amount1']) && $result['Op_Monthly_Education_Other_Amount1'] !=''){
            $result['Op_Total_Monthly_Education_Expenses']=$result['Op_Total_Monthly_Education_Expenses']+$result['Op_Monthly_Education_Other_Amount1'];
        }
        if(isset($result['Op_Monthly_Education_Other_Amount2']) && $result['Op_Monthly_Education_Other_Amount2'] !=''){
            $result['Op_Total_Monthly_Education_Expenses']=$result['Op_Total_Monthly_Education_Expenses']+$result['Op_Monthly_Education_Other_Amount2'];
        }
        
        // echo "<pre>";print_r($result);die;
        $DrMonthlyEducationExpenses=DrMonthlyEducationExpenses::create($result);
        
        return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('success', 'Monthly Education Expenses Information Submitted Successfully.');
        
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
        $drmonthlyeducationexpenses=DrMonthlyEducationExpenses::where('case_id',$case_id)->get()->first();
        if($drmonthlyeducationexpenses){
            return view('dr_tables.dr_MonthlyEducationExpenses.edit',['case_id'=> $case_id, 'drmonthlyeducationexpenses' => $drmonthlyeducationexpenses, 'client_name' => $client_name, 'opponent_name' => $opponent_name]);
        } else {
            return redirect()->route('home');
        }
        // echo "<pre>";print_r($DrMonthlyEducationExpenses);//die;
        
    }

    public function update(Request $request, $id)
    {
        $result = $request->except('submit','_method','_token');
        $result['Client_Total_Monthly_Education_Expenses']=0.00;
        $result['Op_Total_Monthly_Education_Expenses']=0.00;

        if(isset($result['Client_Monthly_School_Tuition_For_Client']) && $result['Client_Monthly_School_Tuition_For_Client'] !=''){
            $result['Client_Total_Monthly_Education_Expenses']=$result['Client_Total_Monthly_Education_Expenses']+$result['Client_Monthly_School_Tuition_For_Client'];
        }
        if(isset($result['Client_Monthly_School_Tuition_For_Children']) && $result['Client_Monthly_School_Tuition_For_Children'] !=''){
            $result['Client_Total_Monthly_Education_Expenses']=$result['Client_Total_Monthly_Education_Expenses']+$result['Client_Monthly_School_Tuition_For_Children'];
        }
        if(isset($result['Client_Monthly_School_Books_Fees_Etc']) && $result['Client_Monthly_School_Books_Fees_Etc'] !=''){
            $result['Client_Total_Monthly_Education_Expenses']=$result['Client_Total_Monthly_Education_Expenses']+$result['Client_Monthly_School_Books_Fees_Etc'];
        }
        if(isset($result['Client_Monthly_College_Loan_Repayment1']) && $result['Client_Monthly_College_Loan_Repayment1'] !=''){
            $result['Client_Total_Monthly_Education_Expenses']=$result['Client_Total_Monthly_Education_Expenses']+$result['Client_Monthly_College_Loan_Repayment1'];
        }
        if(isset($result['Client_Monthly_College_Loan_Repayment2']) && $result['Client_Monthly_College_Loan_Repayment2'] !=''){
            $result['Client_Total_Monthly_Education_Expenses']=$result['Client_Total_Monthly_Education_Expenses']+$result['Client_Monthly_College_Loan_Repayment2'];
        }
        if(isset($result['Client_Monthly_College_Loan_Repayment3']) && $result['Client_Monthly_College_Loan_Repayment3'] !=''){
            $result['Client_Total_Monthly_Education_Expenses']=$result['Client_Total_Monthly_Education_Expenses']+$result['Client_Monthly_College_Loan_Repayment3'];
        }
        if(isset($result['Client_Monthly_Education_Other_Amount1']) && $result['Client_Monthly_Education_Other_Amount1'] !=''){
            $result['Client_Total_Monthly_Education_Expenses']=$result['Client_Total_Monthly_Education_Expenses']+$result['Client_Monthly_Education_Other_Amount1'];
        }
        if(isset($result['Client_Monthly_Education_Other_Amount2']) && $result['Client_Monthly_Education_Other_Amount2'] !=''){
            $result['Client_Total_Monthly_Education_Expenses']=$result['Client_Total_Monthly_Education_Expenses']+$result['Client_Monthly_Education_Other_Amount2'];
        }

        
        if(isset($result['Op_Monthly_School_Tuition_For_Op']) && $result['Op_Monthly_School_Tuition_For_Op'] !=''){
            $result['Op_Total_Monthly_Education_Expenses']=$result['Op_Total_Monthly_Education_Expenses']+$result['Op_Monthly_School_Tuition_For_Op'];
        }
        if(isset($result['Op_Monthly_School_Tuition_For_Children']) && $result['Op_Monthly_School_Tuition_For_Children'] !=''){
            $result['Op_Total_Monthly_Education_Expenses']=$result['Op_Total_Monthly_Education_Expenses']+$result['Op_Monthly_School_Tuition_For_Children'];
        }
        if(isset($result['Op_Monthly_School_Books_Fees_Etc']) && $result['Op_Monthly_School_Books_Fees_Etc'] !=''){
            $result['Op_Total_Monthly_Education_Expenses']=$result['Op_Total_Monthly_Education_Expenses']+$result['Op_Monthly_School_Books_Fees_Etc'];
        }
        if(isset($result['Op_Monthly_College_Loan_Repayment1']) && $result['Op_Monthly_College_Loan_Repayment1'] !=''){
            $result['Op_Total_Monthly_Education_Expenses']=$result['Op_Total_Monthly_Education_Expenses']+$result['Op_Monthly_College_Loan_Repayment1'];
        }
        if(isset($result['Op_Monthly_College_Loan_Repayment2']) && $result['Op_Monthly_College_Loan_Repayment2'] !=''){
            $result['Op_Total_Monthly_Education_Expenses']=$result['Op_Total_Monthly_Education_Expenses']+$result['Op_Monthly_College_Loan_Repayment2'];
        }
        if(isset($result['Op_Monthly_College_Loan_Repayment3']) && $result['Op_Monthly_College_Loan_Repayment3'] !=''){
            $result['Op_Total_Monthly_Education_Expenses']=$result['Op_Total_Monthly_Education_Expenses']+$result['Op_Monthly_College_Loan_Repayment3'];
        }
        if(isset($result['Op_Monthly_Education_Other_Amount1']) && $result['Op_Monthly_Education_Other_Amount1'] !=''){
            $result['Op_Total_Monthly_Education_Expenses']=$result['Op_Total_Monthly_Education_Expenses']+$result['Op_Monthly_Education_Other_Amount1'];
        }
        if(isset($result['Op_Monthly_Education_Other_Amount2']) && $result['Op_Monthly_Education_Other_Amount2'] !=''){
            $result['Op_Total_Monthly_Education_Expenses']=$result['Op_Total_Monthly_Education_Expenses']+$result['Op_Monthly_Education_Other_Amount2'];
        }
        
        
        $DrMonthlyEducationExpenses  = DrMonthlyEducationExpenses::findOrFail($id);
        if($DrMonthlyEducationExpenses){
            $DrMonthlyEducationExpenses->fill($result)->save();
            return redirect()->route('drmonthlyeducationexpenses.edit',$result['case_id'])->with('success', 'Monthly Education Expenses Information Updated Successfully.');
        } else {
            return redirect()->route('drmonthlyeducationexpenses.edit',$result['case_id'])->with('error', 'Something went wrong. Please try Again.');
        }
    }
    
    public function destroy($id)
    {

    }

}
