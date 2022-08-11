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
use App\DrSpousalSupportThisMarriage;


class DrSpousalSupportThisMarriageController extends Controller
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
        $data=DrSpousalSupportThisMarriage::orderBy('id','DESC')->get();
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

        $drspousalsupportthismarriage=DrSpousalSupportThisMarriage::where('case_id',$case_id)->get()->pluck('case_id');
        if(isset($drspousalsupportthismarriage['0'])){
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
        return view('dr_tables.dr_SpousalSupportThisMarriage.create',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name]);
    }

    public function store(Request $request)
    {
        $result = $request->except('submit');
        // parse string to date for client info section
        if(isset($result['Start_Date_Spousal_Support'])){
            $result['Start_Date_Spousal_Support']=date("Y-m-d",strtotime($result['Start_Date_Spousal_Support']));
        } else {
            $result['Start_Date_Spousal_Support']=NULL;
        }
        
        if(isset($result['Duration_Spousal_Support_LIFETIME']) && $result['Duration_Spousal_Support_LIFETIME']=='Yes'){
            $result['Duration_Spousal_Support_MONTHS']=NULL;
            $result['Final_Spousal_Support_Payment_Date']=NULL;
            $result['Final_Spousal_Support_Payment_Amount']=0.00;
        }
        if(isset($result['Spousal_Support_This_Marriage']) && $result['Spousal_Support_This_Marriage']=='No'){
            $result['Spousal_Support_Obligor']=NULL;
            $result['Monthly_Spousal_Support_Amount']=NULL;
            $result['Start_Date_Spousal_Support']=NULL;
            $result['Duration_Spousal_Support_LIFETIME']=NULL;
            $result['Duration_Spousal_Support_MONTHS']=NULL;
            $result['Final_Spousal_Support_Payment_Date']=NULL;
            $result['Final_Spousal_Support_Payment_Amount']=NULL;
            $result['Court_Retains_Jurisdiction_Amount']=NULL;
            $result['Court_Retains_Jurisdiction_Duration']=NULL;
            $result['Terminates_On_Death_Either']=NULL;
            $result['Terminates_On_Remarriage_Obligee']=NULL;
            $result['Terminates_On_Cohabitation_Obligee']=NULL;
            $result['Terminates_On_Disability_Leading_Application_Medicaid']=NULL;
            $result['Method_Of_Payment']=NULL;
            $result['Special_Provisions']=NULL;
        }
        // echo "<pre>";print_r($result);die;
        $DrSpousalSupportThisMarriage=DrSpousalSupportThisMarriage::create($result);
        
        return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('success', 'Spousal Support This Marriage Information Submitted Successfully.');
        
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
        $drspousalsupportthismarriage=DrSpousalSupportThisMarriage::where('case_id',$case_id)->get()->first();
        if($drspousalsupportthismarriage){
            return view('dr_tables.dr_SpousalSupportThisMarriage.edit',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'drspousalsupportthismarriage' => $drspousalsupportthismarriage]);
        } else {
            return redirect()->route('home');
        }
         // echo "<pre>";print_r($drspousalsupportthismarriage);//die;
        
    }

    public function update(Request $request, $id)
    {
        $result = $request->except('submit','_method','_token');

        if(isset($result['Start_Date_Spousal_Support'])){
            $result['Start_Date_Spousal_Support']=date("Y-m-d",strtotime($result['Start_Date_Spousal_Support']));
        } else {
            $result['Start_Date_Spousal_Support']=NULL;
        }
        
        if(isset($result['Duration_Spousal_Support_LIFETIME']) && $result['Duration_Spousal_Support_LIFETIME']=='Yes'){
            $result['Duration_Spousal_Support_MONTHS']=NULL;
            $result['Final_Spousal_Support_Payment_Date']=NULL;
            $result['Final_Spousal_Support_Payment_Amount']=0.00;
        }
        if(isset($result['Spousal_Support_This_Marriage']) && $result['Spousal_Support_This_Marriage']=='No'){
            $result['Spousal_Support_Obligor']=NULL;
            $result['Monthly_Spousal_Support_Amount']=NULL;
            $result['Start_Date_Spousal_Support']=NULL;
            $result['Duration_Spousal_Support_LIFETIME']=NULL;
            $result['Duration_Spousal_Support_MONTHS']=NULL;
            $result['Final_Spousal_Support_Payment_Date']=NULL;
            $result['Final_Spousal_Support_Payment_Amount']=NULL;
            $result['Court_Retains_Jurisdiction_Amount']=NULL;
            $result['Court_Retains_Jurisdiction_Duration']=NULL;
            $result['Terminates_On_Death_Either']=NULL;
            $result['Terminates_On_Remarriage_Obligee']=NULL;
            $result['Terminates_On_Cohabitation_Obligee']=NULL;
            $result['Terminates_On_Disability_Leading_Application_Medicaid']=NULL;
            $result['Method_Of_Payment']=NULL;
            $result['Special_Provisions']=NULL;
        }
        
        $DrSpousalSupportThisMarriage  = DrSpousalSupportThisMarriage::findOrFail($id);
        if($DrSpousalSupportThisMarriage){
            $DrSpousalSupportThisMarriage->fill($result)->save();
            return redirect()->route('drspousalsupportthismarriage.edit',$result['case_id'])->with('success', 'Spousal Support This Marriage Information Updated Successfully.');
        } else {
            return redirect()->route('drspousalsupportthismarriage.edit',$result['case_id'])->with('error', 'Something went wrong. Please try Again.');
        }
    }
    
    public function destroy($id)
    {

    }

}
