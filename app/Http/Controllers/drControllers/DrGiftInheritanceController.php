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
use App\DrGiftInheritance;


class DrGiftInheritanceController extends Controller
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
        $data=DrGiftInheritance::orderBy('id','DESC')->get();
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


        $drgiftinheritance=DrGiftInheritance::where('case_id',$case_id)->get()->pluck('case_id');
        if(isset($drgiftinheritance['0'])){
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

        return view('dr_tables.dr_GiftInheritance.create',['case_id'=> $case_id, 'client_name' => $client_name, 'opponent_name' => $opponent_name]);
    }

    public function store(Request $request)
    {
        $result = $request->except('submit');
        // parse string to date for client info section
        $result['Client_Total_Exp_Gift_Inheritance_Amt']=0.00;
        $result['Op_Total_Exp_Gift_Inheritance_Amt']=0.00;

        for ($i=1; $i <= 6; $i++) {
            if(isset($result['Client_Exp_Gift_Inheritance_Source_Amt'.$i.'']) && $result['Client_Exp_Gift_Inheritance_Source_Amt'.$i.''] !=''){
                $result['Client_Total_Exp_Gift_Inheritance_Amt']=$result['Client_Total_Exp_Gift_Inheritance_Amt']+$result['Client_Exp_Gift_Inheritance_Source_Amt'.$i.''];
            }
            if(isset($result['Op_Exp_Gift_Inheritance_Source_Amt'.$i.'']) && $result['Op_Exp_Gift_Inheritance_Source_Amt'.$i.''] !=''){
                $result['Op_Total_Exp_Gift_Inheritance_Amt']=$result['Op_Total_Exp_Gift_Inheritance_Amt']+$result['Op_Exp_Gift_Inheritance_Source_Amt'.$i.''];
            }
        }


        // echo "<pre>";print_r($result);die;
        $DrGiftInheritance=DrGiftInheritance::create($result);

        return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('success', 'Gift Inheritance Information Submitted Successfully.');

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

        $drgiftinheritance=DrGiftInheritance::where('case_id',$case_id)->get()->first();
        if($drgiftinheritance){
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
            return view('dr_tables.dr_GiftInheritance.edit',['case_id'=> $case_id, 'drgiftinheritance' => $drgiftinheritance, 'client_name' => $client_name, 'opponent_name' => $opponent_name]);
        } else {
            return redirect()->route('home');
        }
        // echo "<pre>";print_r($DrGiftInheritance);//die;

    }

    public function update(Request $request, $id)
    {
        $result = $request->except('submit','_method','_token');

        $result['Client_Total_Exp_Gift_Inheritance_Amt']=0.00;
        $result['Op_Total_Exp_Gift_Inheritance_Amt']=0.00;

        for ($i=1; $i <= 6; $i++) {
            if(isset($result['Client_Exp_Gift_Inheritance_Source_Amt'.$i.'']) && $result['Client_Exp_Gift_Inheritance_Source_Amt'.$i.''] !=''){
                $result['Client_Total_Exp_Gift_Inheritance_Amt']=$result['Client_Total_Exp_Gift_Inheritance_Amt']+$result['Client_Exp_Gift_Inheritance_Source_Amt'.$i.''];
            }
            if(isset($result['Op_Exp_Gift_Inheritance_Source_Amt'.$i.'']) && $result['Op_Exp_Gift_Inheritance_Source_Amt'.$i.''] !=''){
                $result['Op_Total_Exp_Gift_Inheritance_Amt']=$result['Op_Total_Exp_Gift_Inheritance_Amt']+$result['Op_Exp_Gift_Inheritance_Source_Amt'.$i.''];
            }
        }

        $DrGiftInheritance  = DrGiftInheritance::findOrFail($id);
        if($DrGiftInheritance){
            $DrGiftInheritance->fill($result)->save();
            return redirect()->route('drgiftinheritance.edit',$result['case_id'])->with('success', 'Gift Inheritance Information Updated Successfully.');
        } else {
            return redirect()->route('drgiftinheritance.edit',$result['case_id'])->with('error', 'Something went wrong. Please try Again.');
        }
    }

    public function destroy($id)
    {

    }

}
