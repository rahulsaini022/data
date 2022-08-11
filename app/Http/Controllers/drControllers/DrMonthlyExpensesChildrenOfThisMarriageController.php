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
use App\DrMarriageInfo;
use App\DrMonthlyExpensesChildrenOfThisMarriage;


class DrMonthlyExpensesChildrenOfThisMarriageController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
        
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    // to fetch all records
    public function index($case_id)
    {
        $Num_MinorDependant_Children_of_this_Marriage=DrMarriageInfo::where('case_id',$case_id)->get()->pluck('Num_MinorDependant_Children_of_this_Marriage')->first();
        if(isset($Num_MinorDependant_Children_of_this_Marriage) && $Num_MinorDependant_Children_of_this_Marriage > 0){
            
        } else {
            return redirect()->route('home');
        }
        $data=DrMonthlyExpensesChildrenOfThisMarriage::orderBy('id','DESC')->get();
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

        $Num_MinorDependant_Children_of_this_Marriage=DrMarriageInfo::where('case_id',$case_id)->get()->pluck('Num_MinorDependant_Children_of_this_Marriage')->first();
        if(isset($Num_MinorDependant_Children_of_this_Marriage) && $Num_MinorDependant_Children_of_this_Marriage > 0){
            
        } else {
            return redirect()->route('home');
        }

        $drmonthlyexpenseschildrenofthismarriage=DrMonthlyExpensesChildrenOfThisMarriage::where('case_id',$case_id)->get()->pluck('case_id');
        if(isset($drmonthlyexpenseschildrenofthismarriage['0'])){
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
        
        return view('dr_tables.dr_MonthlyExpensesChildrenOfThisMarriage.create',['case_id'=> $case_id, 'client_name' => $client_name, 'opponent_name' => $opponent_name]);
    }

    public function store(Request $request)
    {
        $result = $request->except('submit');
        
        // echo "<pre>";print_r($result);die;
        $DrMonthlyExpensesChildrenOfThisMarriage=DrMonthlyExpensesChildrenOfThisMarriage::create($result);
        
        return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('success', 'Monthly Expenses Children Of This Marriage Information Submitted Successfully.');
        
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
        
        $Num_MinorDependant_Children_of_this_Marriage=DrMarriageInfo::where('case_id',$case_id)->get()->pluck('Num_MinorDependant_Children_of_this_Marriage')->first();
        if(isset($Num_MinorDependant_Children_of_this_Marriage) && $Num_MinorDependant_Children_of_this_Marriage > 0){
            
        } else {
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

        $drmonthlyexpenseschildrenofthismarriage=DrMonthlyExpensesChildrenOfThisMarriage::where('case_id',$case_id)->get()->first();
         // echo "<pre>";print_r($drmonthlyexpenseschildrenofthismarriage);//die;
        if($drmonthlyexpenseschildrenofthismarriage){
            return view('dr_tables.dr_MonthlyExpensesChildrenOfThisMarriage.edit',['case_id'=> $case_id, 'drmonthlyexpenseschildrenofthismarriage' => $drmonthlyexpenseschildrenofthismarriage, 'client_name' => $client_name, 'opponent_name' => $opponent_name]);
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request, $id)
    {
        $result = $request->except('submit','_method','_token');

        $DrMonthlyExpensesChildrenOfThisMarriage  = DrMonthlyExpensesChildrenOfThisMarriage::findOrFail($id);
        if($DrMonthlyExpensesChildrenOfThisMarriage){
            $DrMonthlyExpensesChildrenOfThisMarriage->fill($result)->save();
            return redirect()->route('drmonthlyexpenseschildrenofthismarriage.edit',$result['case_id'])->with('success', 'Monthly Expenses Children Of This Marriage Information Updated Successfully.');
        } else {
            return redirect()->route('drmonthlyexpenseschildrenofthismarriage.edit',$result['case_id'])->with('error', 'Something went wrong. Please try Again.');
        }
    }
    
    public function destroy($id)
    {

    }

}
