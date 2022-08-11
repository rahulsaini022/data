<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Motion;
use App\Motionparty;
use App\Courtcase;
use App\Caseuser;
use App\User;
use Auth;

class MotionController extends Controller

{
    // to show motions options for each case
    public function getCaseMotions($case_id)
    {
        $case_data=Courtcase::find($case_id);
        if(isset($case_data) && $case_data->attorney_id==Auth::user()->id && $case_data->payment_status=='1'){
            $motions = Motion::where([['case_id', $case_id],['parent_motion_id', '0']])->get();
            if(isset($motions)){
                foreach($motions as $motion){
                    $k=0;        
                    foreach($motion->motionparties as $motionparty){
                        $name=User::where('id', $motionparty['party_id'])->get()->pluck('name')->first();
                        $caseuser=Caseuser::where([
                                        ['case_id', $case_id],
                                        ['attorney_id', Auth::user()->id],
                                        ['user_id', $motionparty['party_id']]
                                    ])->get()
                                    ->first();
                        if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                            $motion->motionparties[$k]['name']=$caseuser->org_comp_name;
                        } else {
                            $mname=$caseuser->mname;
                            if(isset($mname) && $mname !='') {
                                $namearray = explode(' ', $name, 2);
                                if(count($namearray) > 1) {
                                    $fullname=$namearray[0].' '.$mname.' '.$namearray[1];
                                } else {
                                    $fullname=$name.' '.$mname;
                                }
                            } else {
                                $fullname=$name;
                            }
                            $motion->motionparties[$k]['name']=$fullname;
                        }
                        // $motion->motionparties[$k]['name']=$name;
                        $motion->motionparties[$k]['type']=$caseuser->type;
                        $party_group=$caseuser->party_group;
                        if(isset($case_data->top_party_type) && $case_data->top_party_type !=''){
                            if($party_group=='top' || $party_group=='bottom'){
                                $motion->motionparties[$k]['party_group']=$case_data[''.$party_group.'_party_type'];
                            }
                            if($party_group=='top_third'){
                                $party_group='top';
                                $motion->motionparties[$k]['party_group']='Third-Party '.$case_data[''.$party_group.'_party_type'];
                            } else if($party_group=='bottom_third'){
                                $party_group='bottom';
                                $motion->motionparties[$k]['party_group']='Third-Party '.$case_data[''.$party_group.'_party_type'];
                            }
                        } else {
                            if($party_group=='top' || $party_group=='bottom'){
                                $motion->motionparties[$k]['party_group']=$case_data['original_'.$party_group.'_party_type'];
                            }
                            if($party_group=='top_third'){
                                $party_group='top';
                                $motion->motionparties[$k]['party_group']='Third-Party '.$case_data['original_'.$party_group.'_party_type'];
                            } else if($party_group=='bottom_third'){
                                $party_group='bottom';
                                $motion->motionparties[$k]['party_group']='Third-Party '.$case_data['original_'.$party_group.'_party_type'];
                            }
                        }

                        //$motion->motionparties[$k]['party_group']=$case_data[''.$party_group.'_party_type'];
                        ++$k;
                    }
                }
            } else {
                $motion=NULL;
            }
            // dd($subordinatemotions);
            return view('motions.index',['case_data' => $case_data, 'motions' => $motions]);
        } else {
            // return view('motions.index',['case_id' => $case_id]);
            return redirect()->route('cases.index');

        }

    }

    /* Show Create Case Motion Info Form */
    public function createCaseMotions($case_id)
    {
        $case_data=Courtcase::find($case_id);
        if(isset($case_data) && $case_data->attorney_id==Auth::user()->id && $case_data->payment_status=='1'){
            $user_ids_top=Caseuser::where([['case_id', $case_id],['party_group', 'top']])->get()->pluck('user_id')->all();
            $user_ids_bottom=Caseuser::where([['case_id', $case_id],['party_group', 'bottom']])->get()->pluck('user_id')->all();
            $top_party_data=array();
            $i=0;
            if($user_ids_top){
                $case_data['total_top_parties']=count($user_ids_top);
                foreach($user_ids_top as $user_id){
                    $top_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $top_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        $mname=$caseuser->mname;
                        if(isset($mname) && $mname !='') {
                            $namearray = explode(' ', $top_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $top_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $top_party_data[$i]['name']=$top_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }
                    
                    $top_party_data[$i]['designation1']=$caseuser->designation1;
                    $top_party_data[$i]['designation2']=$caseuser->designation2;
                    $top_party_data[$i]['designation3']=$caseuser->designation3;
                    $top_party_data[$i]['designation4']=$caseuser->designation4;
                    $top_party_data[$i]['designation5']=$caseuser->designation5;

                    ++$i;
                }
            }
            $bottom_party_data=array();
            $i=0;
            if($user_ids_bottom){
                $case_data['total_bottom_parties']=count($user_ids_bottom);
                foreach($user_ids_bottom as $user_id){
                    $bottom_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $bottom_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        $mname=$caseuser->mname;
                        if(isset($mname) && $mname !='') {
                            $namearray = explode(' ', $bottom_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $bottom_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $bottom_party_data[$i]['name']=$bottom_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    $bottom_party_data[$i]['designation1']=$caseuser->designation1;
                    $bottom_party_data[$i]['designation2']=$caseuser->designation2;
                    $bottom_party_data[$i]['designation3']=$caseuser->designation3;
                    $bottom_party_data[$i]['designation4']=$caseuser->designation4;
                    $bottom_party_data[$i]['designation5']=$caseuser->designation5;

                    ++$i;
                }
            }

            // for third parties
            $user_ids_top_third=Caseuser::where([['case_id', $case_id],['party_group', 'top_third']])->get()->pluck('user_id')->all();
            $user_ids_bottom_third=Caseuser::where([['case_id', $case_id],['party_group', 'bottom_third']])->get()->pluck('user_id')->all();
            $top_third_party_data=array();
            $i=0;
            if($user_ids_top_third){
                $case_data['total_top_third_parties']=count($user_ids_top_third);
                foreach($user_ids_top_third as $user_id){
                    $top_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $top_third_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        $mname=$caseuser->mname;
                        if(isset($mname) && $mname !='') {
                            $namearray = explode(' ', $top_third_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $top_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $top_third_party_data[$i]['name']=$top_third_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    $top_third_party_data[$i]['designation1']=$caseuser->designation1;
                    $top_third_party_data[$i]['designation2']=$caseuser->designation2;
                    $top_third_party_data[$i]['designation3']=$caseuser->designation3;
                    $top_third_party_data[$i]['designation4']=$caseuser->designation4;
                    $top_third_party_data[$i]['designation5']=$caseuser->designation5;

                    ++$i;
                }
            }
            $bottom_third_party_data=array();
            $i=0;
            if($user_ids_bottom_third){
                $case_data['total_bottom_third_parties']=count($user_ids_bottom_third);
                foreach($user_ids_bottom_third as $user_id){
                    $bottom_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $bottom_third_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        $mname=$caseuser->mname;
                        if(isset($mname) && $mname !='') {
                            $namearray = explode(' ', $bottom_third_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $bottom_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $bottom_third_party_data[$i]['name']=$bottom_third_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    $bottom_third_party_data[$i]['designation1']=$caseuser->designation1;
                    $bottom_third_party_data[$i]['designation2']=$caseuser->designation2;
                    $bottom_third_party_data[$i]['designation3']=$caseuser->designation3;
                    $bottom_third_party_data[$i]['designation4']=$caseuser->designation4;
                    $bottom_third_party_data[$i]['designation5']=$caseuser->designation5;

                    ++$i;
                }
            }

            $motion_types=DB::table('motion_types')->get()->all();
            $motions = Motion::where([['case_id', $case_id],['parent_motion_id', '0']])->get();
            $motion_level=count($motions)+1;
            return view('motions.create',['case_id' => $case_id, 'top_party_data' => $top_party_data, 'bottom_party_data' => $bottom_party_data, 'top_third_party_data' => $top_third_party_data, 'bottom_third_party_data' => $bottom_third_party_data, 'case_data' => $case_data, 'motion_types' => $motion_types, 'motion_level' => $motion_level]);    
        } else {
            // return view('motions.index',['case_id' => $case_id]);
            return redirect()->route('cases.index');

        }

    }

    /* Store Case Motion Info */
    public function storeCaseMotions(Request $request)
    {
        $result = $request->except('submit');
        $case_id=$request->case_id;
        $movants=$request->movants;
        $respondents=$request->respondents;

        if($request->response_deadline){
            $response_deadline=date("Y-m-d",strtotime($request->response_deadline));
        } else {
            $response_deadline=NULL;
        }
        if($request->file_date){
            $file_date=date("Y-m-d",strtotime($request->file_date));
        } else {
            $file_date=NULL;
        }
        $data=array(
            'case_id'=>$request->case_id,
            'motion_name'=>$request->motion_name,
            'motion_category'=>$request->motion_category,
            'motion_type_id'=>$request->motion_type_id,
            'motion_status'=>$request->motion_status,
            'motion_level'=>$request->motion_level,
            'response_deadline'=>$response_deadline,
            'file_date'=>$file_date,
            'created_at'=>now(),
            'updated_at'=>now(),
        );
        $motion = Motion::create($data);
        $totalsenders=$totalreceivers=$totalobservers=0;
        $data2=array();
        if($movants){
            $num=1;
            foreach ($movants as $movant) {
                $designation1=$designation2=$designation3=$designation4=$designation5=NULL;
                for ($i=1; $i <= 5; $i++) { 
                    if(isset($result['movant_'.$movant.'_designation'.$i.'']) && $result['movant_'.$movant.'_designation'.$i.''] !='') 
                    {
                        ${"designation" . $i}=$result['movant_'.$movant.'_designation'.$i.''];
                    }
                }
                $party_type="movant";
                $party_class="S".$num++;
                $data2[] = array(
                    'motion_id' => $motion->id,
                    'party_id' => $movant,
                    'party_type' => $party_type,
                    'party_class' => $party_class,
                    'response_deadline' => $response_deadline,
                    'designation1' => $designation1,
                    'designation2' => $designation2,
                    'designation3' => $designation3,
                    'designation4' => $designation4,
                    'designation5' => $designation5,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                );
                ++$totalsenders;
            }
        }
        if($respondents){
            $num=1;
            foreach ($respondents as $respondent) {
                $designation1=$designation2=$designation3=$designation4=$designation5=NULL;
                for ($i=1; $i <= 5; $i++) { 
                    if(isset($result['respondent_'.$respondent.'_designation'.$i.'']) && $result['respondent_'.$respondent.'_designation'.$i.''] !='') 
                    {
                        ${"designation" . $i}=$result['respondent_'.$respondent.'_designation'.$i.''];
                    }
                }
                $party_type="respondent";
                $party_class="R".$num++;
                $data2[] = array(
                    'motion_id' => $motion->id,
                    'party_id' => $respondent,
                    'party_type' => $party_type,
                    'party_class' => $party_class,
                    'response_deadline' => $response_deadline,
                    'designation1' => $designation1,
                    'designation2' => $designation2,
                    'designation3' => $designation3,
                    'designation4' => $designation4,
                    'designation5' => $designation5,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                );
                ++$totalreceivers;
            }
        }
        // for observers
        $motion_checked_parties=array_unique(array_merge($movants,$respondents));
        $motion_all_parties=Caseuser::where([['case_id', $case_id],['attorney_id', Auth::user()->id]])->get()->pluck('user_id')->all();
        $observers=array_diff($motion_all_parties,$motion_checked_parties);

        $num=1;
        foreach ($observers as $observer) {            
            $party_type="NA";
            $party_class="O".$num++;
            $data2[] = array(
                'motion_id' => $motion->id,
                'party_id' => $observer,
                'party_type' => $party_type,
                'party_class' => $party_class,
                'response_deadline' => NULL,
                'designation1' => NULL,
                'designation2' => NULL,
                'designation3' => NULL,
                'designation4' => NULL,
                'designation5' => NULL,
                'created_at'=>now(),
                'updated_at'=>now(),
            );
            ++$totalobservers;
        }
        $motionparty = Motionparty::insert($data2);
        // update motion table
        $motiontoupdate = Motion::find($motion->id);

        $motiontoupdate->num_s = $totalsenders;
        $motiontoupdate->num_r = $totalreceivers;
        $motiontoupdate->num_o = $totalobservers;

        $motiontoupdate->save();
        // dd($data2);
        return redirect()->route('cases.motions',['case_id' => $request->case_id])->with('success', 'Motion Created Successfully!');

    }

    /* Show Edit Case Motion Info Form */
    public function editCaseMotions($case_id, $motion_id)
    {
        $case_data=Courtcase::find($case_id);
        if(isset($case_data) && $case_data->attorney_id==Auth::user()->id && $case_data->payment_status=='1'){
            $user_ids_top=Caseuser::where([['case_id', $case_id],['party_group', 'top']])->get()->pluck('user_id')->all();
            $user_ids_bottom=Caseuser::where([['case_id', $case_id],['party_group', 'bottom']])->get()->pluck('user_id')->all();
            $top_party_data=array();
            $i=0;
            if($user_ids_top){
                $case_data['total_top_parties']=count($user_ids_top);
                foreach($user_ids_top as $user_id){
                    $top_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $top_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        $mname=$caseuser->mname;
                        if(isset($mname) && $mname !='') {
                            $namearray = explode(' ', $top_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $top_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $top_party_data[$i]['name']=$top_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    $top_party_data[$i]['designation1']=$caseuser->designation1;
                    $top_party_data[$i]['designation2']=$caseuser->designation2;
                    $top_party_data[$i]['designation3']=$caseuser->designation3;
                    $top_party_data[$i]['designation4']=$caseuser->designation4;
                    $top_party_data[$i]['designation5']=$caseuser->designation5;

                    ++$i;
                }
            }
            $bottom_party_data=array();
            $i=0;
            if($user_ids_bottom){
                $case_data['total_bottom_parties']=count($user_ids_bottom);
                foreach($user_ids_bottom as $user_id){
                    $bottom_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $bottom_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        $mname=$caseuser->mname;
                        if(isset($mname) && $mname !='') {
                            $namearray = explode(' ', $bottom_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $bottom_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $bottom_party_data[$i]['name']=$bottom_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    $bottom_party_data[$i]['designation1']=$caseuser->designation1;
                    $bottom_party_data[$i]['designation2']=$caseuser->designation2;
                    $bottom_party_data[$i]['designation3']=$caseuser->designation3;
                    $bottom_party_data[$i]['designation4']=$caseuser->designation4;
                    $bottom_party_data[$i]['designation5']=$caseuser->designation5;

                    ++$i;
                }
            }

            // for third parties
            $user_ids_top_third=Caseuser::where([['case_id', $case_id],['party_group', 'top_third']])->get()->pluck('user_id')->all();
            $user_ids_bottom_third=Caseuser::where([['case_id', $case_id],['party_group', 'bottom_third']])->get()->pluck('user_id')->all();
            $top_third_party_data=array();
            $i=0;
            if($user_ids_top_third){
                $case_data['total_top_third_parties']=count($user_ids_top_third);
                foreach($user_ids_top_third as $user_id){
                    $top_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $top_third_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        $mname=$caseuser->mname;
                        if(isset($mname) && $mname !='') {
                            $namearray = explode(' ', $top_third_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $top_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $top_third_party_data[$i]['name']=$top_third_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    $top_third_party_data[$i]['designation1']=$caseuser->designation1;
                    $top_third_party_data[$i]['designation2']=$caseuser->designation2;
                    $top_third_party_data[$i]['designation3']=$caseuser->designation3;
                    $top_third_party_data[$i]['designation4']=$caseuser->designation4;
                    $top_third_party_data[$i]['designation5']=$caseuser->designation5;

                    ++$i;
                }
            }
            $bottom_third_party_data=array();
            $i=0;
            if($user_ids_bottom_third){
                $case_data['total_bottom_third_parties']=count($user_ids_bottom_third);
                foreach($user_ids_bottom_third as $user_id){
                    $bottom_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $bottom_third_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        $mname=$caseuser->mname;
                        if(isset($mname) && $mname !='') {
                            $namearray = explode(' ', $bottom_third_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $bottom_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $bottom_third_party_data[$i]['name']=$bottom_third_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    $bottom_third_party_data[$i]['designation1']=$caseuser->designation1;
                    $bottom_third_party_data[$i]['designation2']=$caseuser->designation2;
                    $bottom_third_party_data[$i]['designation3']=$caseuser->designation3;
                    $bottom_third_party_data[$i]['designation4']=$caseuser->designation4;
                    $bottom_third_party_data[$i]['designation5']=$caseuser->designation5;

                    ++$i;
                }
            }

            $motion_types=DB::table('motion_types')->get()->all();
            $motion = Motion::find($motion_id);
            if($motion){
                $motionparties=$motion->motionparties;
                $movantparties=array();
                $respondentparties=array();
                $movantpartiesdesignations=array();
                $respondentpartiesdesignations=array();
                foreach ($motionparties as $motionparty) {
                    if($motionparty && $motionparty->party_type=='movant'){
                        $movantparties[]=$motionparty->party_id;

                        $movantpartiesdesignations[$motionparty->party_id]['designation1']=$motionparty->designation1;
                        $movantpartiesdesignations[$motionparty->party_id]['designation2']=$motionparty->designation2;
                        $movantpartiesdesignations[$motionparty->party_id]['designation3']=$motionparty->designation3;
                        $movantpartiesdesignations[$motionparty->party_id]['designation4']=$motionparty->designation4;
                        $movantpartiesdesignations[$motionparty->party_id]['designation5']=$motionparty->designation5;

                    } elseif ($motionparty && $motionparty->party_type=='respondent') {
                        $respondentparties[]=$motionparty->party_id;

                        $respondentpartiesdesignations[$motionparty->party_id]['designation1']=$motionparty->designation1;
                        $respondentpartiesdesignations[$motionparty->party_id]['designation2']=$motionparty->designation2;
                        $respondentpartiesdesignations[$motionparty->party_id]['designation3']=$motionparty->designation3;
                        $respondentpartiesdesignations[$motionparty->party_id]['designation4']=$motionparty->designation4;
                        $respondentpartiesdesignations[$motionparty->party_id]['designation5']=$motionparty->designation5;

                    }
                }
                return view('motions.edit',['case_id' => $case_id, 'top_party_data' => $top_party_data, 'bottom_party_data' => $bottom_party_data, 'top_third_party_data' => $top_third_party_data, 'bottom_third_party_data' => $bottom_third_party_data, 'case_data' => $case_data, 'motion_types' => $motion_types, 'motion' => $motion, 'movantparties' => $movantparties, 'respondentparties' => $respondentparties, 'movantpartiesdesignations' => $movantpartiesdesignations, 'respondentpartiesdesignations' => $respondentpartiesdesignations]); 
            } else{
                return redirect()->route('cases.index');
            } 
        } else {
            // return view('motions.index',['case_id' => $case_id]);
            return redirect()->route('cases.index');

        }

    }

    /* Update Case Motion Info */
    public function updateCaseMotions(Request $request)
    {
        $result = $request->except('submit');
        $case_id=$request->case_id;
        $movants=$request->movants;
        $respondents=$request->respondents;
        if($request->response_deadline){
            $response_deadline=date("Y-m-d",strtotime($request->response_deadline));
        } else {
            $response_deadline=NULL;
        }
        if($request->file_date){
            $file_date=date("Y-m-d",strtotime($request->file_date));
        } else {
            $file_date=NULL;
        }
        $data=array(
            'case_id'=>$request->case_id,
            'motion_name'=>$request->motion_name,
            'motion_category'=>$request->motion_category,
            'motion_type_id'=>$request->motion_type_id,
            'motion_status'=>$request->motion_status,
            'response_deadline'=>$response_deadline,
            'file_date'=>$file_date,
            'updated_at'=>now(),
        );
        $motion = Motion::find($request->motion_id);
        $motionparties=$motion->motionparties;
        $motiondata=$motion->update($data);
        $totalsenders=$totalreceivers=$totalobservers=0;
        $data2=array();
        if($movants){
            $num=1;
            foreach ($movants as $movant) {
                $designation1=$designation2=$designation3=$designation4=$designation5=NULL;
                for ($i=1; $i <= 5; $i++) { 
                    if(isset($result['movant_'.$movant.'_designation'.$i.'']) && $result['movant_'.$movant.'_designation'.$i.''] !='') 
                    {
                        ${"designation" . $i}=$result['movant_'.$movant.'_designation'.$i.''];
                    }
                }
                $party_type="movant";
                $party_class="S".$num++;
                $data2[] = array(
                    'motion_id' => $request->motion_id,
                    'party_id' => $movant,
                    'party_type' => $party_type,
                    'party_class' => $party_class,
                    'response_deadline'=>$response_deadline,
                    'designation1' => $designation1,
                    'designation2' => $designation2,
                    'designation3' => $designation3,
                    'designation4' => $designation4,
                    'designation5' => $designation5,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                );
                ++$totalsenders;
            }
        }
        if($respondents){
            $num=1;
            foreach ($respondents as $respondent) {
                $designation1=$designation2=$designation3=$designation4=$designation5=NULL;
                for ($i=1; $i <= 5; $i++) { 
                    if(isset($result['respondent_'.$respondent.'_designation'.$i.'']) && $result['respondent_'.$respondent.'_designation'.$i.''] !='') 
                    {
                        ${"designation" . $i}=$result['respondent_'.$respondent.'_designation'.$i.''];
                    }
                }
                $party_type="respondent";
                $party_class="R".$num++;
                $data2[] = array(
                    'motion_id' => $request->motion_id,
                    'party_id' => $respondent,
                    'party_type' => $party_type,
                    'party_class' => $party_class,
                    'response_deadline'=>$response_deadline,
                    'designation1' => $designation1,
                    'designation2' => $designation2,
                    'designation3' => $designation3,
                    'designation4' => $designation4,
                    'designation5' => $designation5,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                );
                ++$totalreceivers;
            }
        }

        // for observers
        $motion_checked_parties=array_unique(array_merge($movants,$respondents));
        $motion_all_parties=Caseuser::where([['case_id', $case_id],['attorney_id', Auth::user()->id]])->get()->pluck('user_id')->all();
        $observers=array_diff($motion_all_parties,$motion_checked_parties);
        
        $num=1;
        foreach ($observers as $observer) {            
            $party_type="NA";
            $party_class="O".$num++;
            $data2[] = array(
                'motion_id' => $request->motion_id,
                'party_id' => $observer,
                'party_type' => $party_type,
                'party_class' => $party_class,
                'response_deadline' => NULL,
                'designation1' => NULL,
                'designation2' => NULL,
                'designation3' => NULL,
                'designation4' => NULL,
                'designation5' => NULL,
                'created_at'=>now(),
                'updated_at'=>now(),
            );
            ++$totalobservers;
        }

        if(isset($motionparties) && $motionparties->count() >0){
            Motionparty::where('motion_id',$request->motion_id)->delete();
            $motionparty = Motionparty::insert($data2);
        } else{
            $motionparty = Motionparty::insert($data2);
        }
        // update motion table
        $motiontoupdate = Motion::find($motion->id);

        $motiontoupdate->num_s = $totalsenders;
        $motiontoupdate->num_r = $totalreceivers;
        $motiontoupdate->num_o = $totalobservers;

        $motiontoupdate->save();
        // dd($data2);
        return redirect()->route('cases.motions',['case_id' => $request->case_id])->with('success', 'Motion Updated Successfully!');

    }

    /* Show Create Case Subordinate Motion Info Form */
    public function createSubordinateCaseMotions(Request $request)
    {
        $case_id=$request->case_id;
        $motion_id=$request->motion_id;
        $select_party_id=$request->select_party_id;
        if(isset($request->motion_action_type) && ($request->motion_action_type=='Agreed Entry' || $request->motion_action_type=='OTHER')){
            //die('Agreed Entry OR OTHER');
        }
        $case_data=Courtcase::find($case_id);
        if(isset($case_data) && $case_data->attorney_id==Auth::user()->id && $case_data->payment_status=='1'){
            $user_ids_top=Caseuser::where([['case_id', $case_id],['party_group', 'top']])->get()->pluck('user_id')->all();
            $user_ids_bottom=Caseuser::where([['case_id', $case_id],['party_group', 'bottom']])->get()->pluck('user_id')->all();
            $top_party_data=array();
            $i=0;
            if($user_ids_top){
                $case_data['total_top_parties']=count($user_ids_top);
                foreach($user_ids_top as $user_id){
                    $top_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $top_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        $mname=$caseuser->mname;
                        if(isset($mname) && $mname !='') {
                            $namearray = explode(' ', $top_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $top_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $top_party_data[$i]['name']=$top_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    $top_party_data[$i]['designation1']=$caseuser->designation1;
                    $top_party_data[$i]['designation2']=$caseuser->designation2;
                    $top_party_data[$i]['designation3']=$caseuser->designation3;
                    $top_party_data[$i]['designation4']=$caseuser->designation4;
                    $top_party_data[$i]['designation5']=$caseuser->designation5;

                    ++$i;
                }
            }
            $bottom_party_data=array();
            $i=0;
            if($user_ids_bottom){
                $case_data['total_bottom_parties']=count($user_ids_bottom);
                foreach($user_ids_bottom as $user_id){
                    $bottom_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $bottom_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        $mname=$caseuser->mname;
                        if(isset($mname) && $mname !='') {
                            $namearray = explode(' ', $bottom_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $bottom_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $bottom_party_data[$i]['name']=$bottom_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    $bottom_party_data[$i]['designation1']=$caseuser->designation1;
                    $bottom_party_data[$i]['designation2']=$caseuser->designation2;
                    $bottom_party_data[$i]['designation3']=$caseuser->designation3;
                    $bottom_party_data[$i]['designation4']=$caseuser->designation4;
                    $bottom_party_data[$i]['designation5']=$caseuser->designation5;

                    ++$i;
                }
            }

            // for third parties
            $user_ids_top_third=Caseuser::where([['case_id', $case_id],['party_group', 'top_third']])->get()->pluck('user_id')->all();
            $user_ids_bottom_third=Caseuser::where([['case_id', $case_id],['party_group', 'bottom_third']])->get()->pluck('user_id')->all();
            $top_third_party_data=array();
            $i=0;
            if($user_ids_top_third){
                $case_data['total_top_third_parties']=count($user_ids_top_third);
                foreach($user_ids_top_third as $user_id){
                    $top_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $top_third_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        $mname=$caseuser->mname;
                        if(isset($mname) && $mname !='') {
                            $namearray = explode(' ', $top_third_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $top_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $top_third_party_data[$i]['name']=$top_third_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    $top_third_party_data[$i]['designation1']=$caseuser->designation1;
                    $top_third_party_data[$i]['designation2']=$caseuser->designation2;
                    $top_third_party_data[$i]['designation3']=$caseuser->designation3;
                    $top_third_party_data[$i]['designation4']=$caseuser->designation4;
                    $top_third_party_data[$i]['designation5']=$caseuser->designation5;

                    ++$i;
                }
            }
            $bottom_third_party_data=array();
            $i=0;
            if($user_ids_bottom_third){
                $case_data['total_bottom_third_parties']=count($user_ids_bottom_third);
                foreach($user_ids_bottom_third as $user_id){
                    $bottom_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $bottom_third_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        $mname=$caseuser->mname;
                        if(isset($mname) && $mname !='') {
                            $namearray = explode(' ', $bottom_third_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $bottom_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $bottom_third_party_data[$i]['name']=$bottom_third_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    $bottom_third_party_data[$i]['designation1']=$caseuser->designation1;
                    $bottom_third_party_data[$i]['designation2']=$caseuser->designation2;
                    $bottom_third_party_data[$i]['designation3']=$caseuser->designation3;
                    $bottom_third_party_data[$i]['designation4']=$caseuser->designation4;
                    $bottom_third_party_data[$i]['designation5']=$caseuser->designation5;

                    ++$i;
                }
            }

            $motion_types=DB::table('motion_types')->get()->all();
            $motion = Motion::find($motion_id);
            if($motion){

                // for level
                $motion_level=$motion->motion_level;
                $last_sub_motions = Motion::where([['case_id', $case_id],['parent_motion_id', $motion_id]])->latest('id')->first();
                if($last_sub_motions){
                    $motion_level_last=$last_sub_motions->motion_level;
                    $has_child=true;
                } else {
                    $motion_level_last=$motion_level;
                    $has_child=false;
                }
                if($has_child){
                    $last_num = substr($motion_level_last, -1);
                    $motion_level_last=substr($motion_level_last, 0, -1);
                    $last_num++;
                    $new_motion_level = $motion_level_last."".$last_num;
                } else {
                    $new_motion_level=$motion_level_last.'.1';
                }                
                // end for level

                $motionparties=$motion->motionparties;
                $movantparties=array();
                $respondentparties=array();
                foreach ($motionparties as $motionparty) {
                    if($motionparty && $motionparty->party_type=='movant'){
                        $movantparties[]=$motionparty->party_id;
                    } elseif ($motionparty && $motionparty->party_type=='respondent') {
                       $respondentparties[]=$motionparty->party_id;                        
                    }
                }
                return view('motions.subordinate_create',['case_id' => $case_id, 'top_party_data' => $top_party_data, 'bottom_party_data' => $bottom_party_data, 'top_third_party_data' => $top_third_party_data, 'bottom_third_party_data' => $bottom_third_party_data, 'case_data' => $case_data, 'motion_types' => $motion_types, 'motion' => $motion, 'movantparties' => $movantparties, 'respondentparties' => $respondentparties, 'motion_action_type' => $request->motion_action_type, 'select_party_id' => $select_party_id, 'motion_level'=> $new_motion_level]); 
            } else{
                return redirect()->route('cases.index');
            } 
        } else {
            // return view('motions.index',['case_id' => $case_id]);
            return redirect()->route('cases.index');

        }

    }

    /* Store Case Subordinate Motion Info */
    public function storeSubordinateCaseMotions(Request $request)
    {
        $result = $request->except('submit');
        $case_id=$request->case_id;
        $movants=$request->movants;
        $respondents=$request->respondents;
        if($request->response_deadline){
            $response_deadline=date("Y-m-d",strtotime($request->response_deadline));
        } else {
            $response_deadline=NULL;
        }
        if($request->file_date){
            $file_date=date("Y-m-d",strtotime($request->file_date));
        } else {
            $file_date=NULL;
        }
        $data=array(
            'case_id'=>$request->case_id,
            'motion_name'=>$request->motion_name,
            'motion_category'=>$request->motion_category,
            'motion_action_type'=>$request->motion_action_type,
            'parent_motion_id'=>$request->parent_motion_id,
            'motion_type_id'=>$request->motion_type_id,
            'motion_status'=>$request->motion_status,
            'motion_level'=>$request->motion_level,
            'response_deadline'=>$response_deadline,
            'file_date'=>$file_date,
            'created_at'=>now(),
            'updated_at'=>now(),
        );
        $motion = Motion::create($data);
        $totalsenders=$totalreceivers=$totalobservers=0;
        $data2=array();
        if($movants){
            $num=1;
            foreach ($movants as $movant) {
                $designation1=$designation2=$designation3=$designation4=$designation5=NULL;
                for ($i=1; $i <= 5; $i++) { 
                    if(isset($result['movant_'.$movant.'_designation'.$i.'']) && $result['movant_'.$movant.'_designation'.$i.''] !='') 
                    {
                        ${"designation" . $i}=$result['movant_'.$movant.'_designation'.$i.''];
                    }
                }
                $party_type="movant";
                $party_class="S".$num++;
                $data2[] = array(
                    'motion_id' => $motion->id,
                    'party_id' => $movant,
                    'party_type' => $party_type,
                    'party_class' => $party_class,
                    'response_deadline' => $response_deadline,
                    'designation1' => $designation1,
                    'designation2' => $designation2,
                    'designation3' => $designation3,
                    'designation4' => $designation4,
                    'designation5' => $designation5,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                );
                ++$totalsenders;
            }
        }
        if($respondents){
            $num=1;
            foreach ($respondents as $respondent) {
                $designation1=$designation2=$designation3=$designation4=$designation5=NULL;
                for ($i=1; $i <= 5; $i++) { 
                    if(isset($result['respondent_'.$respondent.'_designation'.$i.'']) && $result['respondent_'.$respondent.'_designation'.$i.''] !='') 
                    {
                        ${"designation" . $i}=$result['respondent_'.$respondent.'_designation'.$i.''];
                    }
                }
                $party_type="respondent";
                $party_class="R".$num++;
                $data2[] = array(
                    'motion_id' => $motion->id,
                    'party_id' => $respondent,
                    'party_type' => $party_type,
                    'party_class' => $party_class,
                    'response_deadline' => $response_deadline,
                    'designation1' => $designation1,
                    'designation2' => $designation2,
                    'designation3' => $designation3,
                    'designation4' => $designation4,
                    'designation5' => $designation5,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                );
                ++$totalreceivers;
            }
        }

        // for observers
        // $motion_checked_parties=array_unique(array_merge($movants,$respondents));
        // $motion_all_parties=Caseuser::where([['case_id', $case_id],['attorney_id', Auth::user()->id]])->get()->pluck('user_id')->all();
        // $observers=array_diff($motion_all_parties,$motion_checked_parties);
        $already_observers=Motionparty::where([['motion_id', $request->parent_motion_id],['party_class', 'like', 'O%']])->orderBy('party_class')->get()->pluck('party_id')->all();
        $sub_motion_ids=Motion::where('parent_motion_id', $request->parent_motion_id)->get()->pluck('id')->all();
        $already_observers1=Motionparty::whereIn('motion_id', $sub_motion_ids)->where('party_class', 'like', 'O%')->orderBy('party_class')->get()->pluck('party_id')->all();
        $all_already_observers=array_unique(array_merge($already_observers,$already_observers1));

        $motion_checked_parties=array_unique(array_merge($movants,$respondents));
        $motion_all_parties=Caseuser::where([['case_id', $case_id],['attorney_id', Auth::user()->id]])->get()->pluck('user_id')->all();
        $observers=array_diff($motion_all_parties,$motion_checked_parties);
        $observers=array_unique(array_merge($all_already_observers,$observers));
        $observers=array_diff($observers,$motion_checked_parties);

        $num=1;
        foreach ($observers as $observer) {            
            $party_type="NA";
            $party_class="O".$num++;
            $data2[] = array(
                'motion_id' => $motion->id,
                'party_id' => $observer,
                'party_type' => $party_type,
                'party_class' => $party_class,
                'response_deadline' => NULL,
                'designation1' => NULL,
                'designation2' => NULL,
                'designation3' => NULL,
                'designation4' => NULL,
                'designation5' => NULL,
                'created_at'=>now(),
                'updated_at'=>now(),
            );
            ++$totalobservers;
        }

        $motionparty = Motionparty::insert($data2);
        // update motion table
        $motiontoupdate = Motion::find($motion->id);

        $motiontoupdate->num_s = $totalsenders;
        $motiontoupdate->num_r = $totalreceivers;
        $motiontoupdate->num_o = $totalobservers;

        $motiontoupdate->save();
        // dd($data2);
        return redirect()->route('cases.motions',['case_id' => $request->case_id])->with('success', 'Subordinate Motion Created Successfully!');

    }

    /* Show Edit Case Subordinate Motion Info Form */
    public function editSubordinateCaseMotions($case_id, $motion_id)
    {
        $case_data=Courtcase::find($case_id);
        if(isset($case_data) && $case_data->attorney_id==Auth::user()->id && $case_data->payment_status=='1'){
            $user_ids_top=Caseuser::where([['case_id', $case_id],['party_group', 'top']])->get()->pluck('user_id')->all();
            $user_ids_bottom=Caseuser::where([['case_id', $case_id],['party_group', 'bottom']])->get()->pluck('user_id')->all();
            $top_party_data=array();
            $i=0;
            if($user_ids_top){
                $case_data['total_top_parties']=count($user_ids_top);
                foreach($user_ids_top as $user_id){
                    $top_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $top_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        $mname=$caseuser->mname;
                        if(isset($mname) && $mname !='') {
                            $namearray = explode(' ', $top_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $top_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $top_party_data[$i]['name']=$top_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    $top_party_data[$i]['designation1']=$caseuser->designation1;
                    $top_party_data[$i]['designation2']=$caseuser->designation2;
                    $top_party_data[$i]['designation3']=$caseuser->designation3;
                    $top_party_data[$i]['designation4']=$caseuser->designation4;
                    $top_party_data[$i]['designation5']=$caseuser->designation5;

                    ++$i;
                }
            }
            $bottom_party_data=array();
            $i=0;
            if($user_ids_bottom){
                $case_data['total_bottom_parties']=count($user_ids_bottom);
                foreach($user_ids_bottom as $user_id){
                    $bottom_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $bottom_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        $mname=$caseuser->mname;
                        if(isset($mname) && $mname !='') {
                            $namearray = explode(' ', $bottom_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $bottom_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $bottom_party_data[$i]['name']=$bottom_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    $bottom_party_data[$i]['designation1']=$caseuser->designation1;
                    $bottom_party_data[$i]['designation2']=$caseuser->designation2;
                    $bottom_party_data[$i]['designation3']=$caseuser->designation3;
                    $bottom_party_data[$i]['designation4']=$caseuser->designation4;
                    $bottom_party_data[$i]['designation5']=$caseuser->designation5;

                    ++$i;
                }
            }

            // for third parties
            $user_ids_top_third=Caseuser::where([['case_id', $case_id],['party_group', 'top_third']])->get()->pluck('user_id')->all();
            $user_ids_bottom_third=Caseuser::where([['case_id', $case_id],['party_group', 'bottom_third']])->get()->pluck('user_id')->all();
            $top_third_party_data=array();
            $i=0;
            if($user_ids_top_third){
                $case_data['total_top_third_parties']=count($user_ids_top_third);
                foreach($user_ids_top_third as $user_id){
                    $top_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $top_third_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        $mname=$caseuser->mname;
                        if(isset($mname) && $mname !='') {
                            $namearray = explode(' ', $top_third_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $top_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $top_third_party_data[$i]['name']=$top_third_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    $top_third_party_data[$i]['designation1']=$caseuser->designation1;
                    $top_third_party_data[$i]['designation2']=$caseuser->designation2;
                    $top_third_party_data[$i]['designation3']=$caseuser->designation3;
                    $top_third_party_data[$i]['designation4']=$caseuser->designation4;
                    $top_third_party_data[$i]['designation5']=$caseuser->designation5;

                    ++$i;
                }
            }
            $bottom_third_party_data=array();
            $i=0;
            if($user_ids_bottom_third){
                $case_data['total_bottom_third_parties']=count($user_ids_bottom_third);
                foreach($user_ids_bottom_third as $user_id){
                    $bottom_third_party_data[$i]=User::where('id', $user_id)->get()->first();
                    $caseuser=Caseuser::where([
                        ['case_id', $case_id],
                        ['attorney_id', Auth::user()->id],
                        ['user_id', $user_id]
                    ])->get()
                    ->first();
                    if(isset($caseuser->party_entity) && $caseuser->party_entity=='organization_company') {
                        $bottom_third_party_data[$i]['name']=$caseuser->org_comp_name;
                    } else {
                        $mname=$caseuser->mname;
                        if(isset($mname) && $mname !='') {
                            $namearray = explode(' ', $bottom_third_party_data[$i]['name'], 2);
                            if(count($namearray) > 1) {
                                $bottom_third_party_data[$i]['name']=$namearray[0].' '.$mname.' '.$namearray[1];
                            } else {
                                $bottom_third_party_data[$i]['name']=$bottom_third_party_data[$i]['name'].' '.$mname;
                            }
                        }
                    }

                    $bottom_third_party_data[$i]['designation1']=$caseuser->designation1;
                    $bottom_third_party_data[$i]['designation2']=$caseuser->designation2;
                    $bottom_third_party_data[$i]['designation3']=$caseuser->designation3;
                    $bottom_third_party_data[$i]['designation4']=$caseuser->designation4;
                    $bottom_third_party_data[$i]['designation5']=$caseuser->designation5;

                    ++$i;
                }
            }

            $motion_types=DB::table('motion_types')->get()->all();
            $motion = Motion::find($motion_id);
            if($motion){
                $parentmotion = Motion::find($motion->parent_motion_id)->first();
                $motion['parent_motion_name']=$parentmotion->motion_name;
                $motionparties=$motion->motionparties;
                $movantparties=array();
                $respondentparties=array();
                $movantpartiesdesignations=array();
                $respondentpartiesdesignations=array();
                foreach ($motionparties as $motionparty) {
                    if($motionparty && $motionparty->party_type=='movant'){
                        $movantparties[]=$motionparty->party_id;

                        $movantpartiesdesignations[$motionparty->party_id]['designation1']=$motionparty->designation1;
                        $movantpartiesdesignations[$motionparty->party_id]['designation2']=$motionparty->designation2;
                        $movantpartiesdesignations[$motionparty->party_id]['designation3']=$motionparty->designation3;
                        $movantpartiesdesignations[$motionparty->party_id]['designation4']=$motionparty->designation4;
                        $movantpartiesdesignations[$motionparty->party_id]['designation5']=$motionparty->designation5;

                    } elseif ($motionparty && $motionparty->party_type=='respondent') {
                       $respondentparties[]=$motionparty->party_id;

                       $respondentpartiesdesignations[$motionparty->party_id]['designation1']=$motionparty->designation1;
                        $respondentpartiesdesignations[$motionparty->party_id]['designation2']=$motionparty->designation2;
                        $respondentpartiesdesignations[$motionparty->party_id]['designation3']=$motionparty->designation3;
                        $respondentpartiesdesignations[$motionparty->party_id]['designation4']=$motionparty->designation4;
                        $respondentpartiesdesignations[$motionparty->party_id]['designation5']=$motionparty->designation5;

                    }
                }
                return view('motions.subordinate_edit',['case_id' => $case_id, 'top_party_data' => $top_party_data, 'bottom_party_data' => $bottom_party_data, 'top_third_party_data' => $top_third_party_data, 'bottom_third_party_data' => $bottom_third_party_data, 'case_data' => $case_data, 'motion_types' => $motion_types, 'motion' => $motion, 'movantparties' => $movantparties, 'respondentparties' => $respondentparties, 'movantpartiesdesignations' => $movantpartiesdesignations, 'respondentpartiesdesignations' => $respondentpartiesdesignations]); 
            } else{
                return redirect()->route('cases.index');
            } 
        } else {
            // return view('motions.index',['case_id' => $case_id]);
            return redirect()->route('cases.index');

        }

    }

    /* Update Case Subordinate Motion Info */
    public function updateSubordinateCaseMotions(Request $request)
    {
        $result = $request->except('submit');
        $case_id=$request->case_id;
        $movants=$request->movants;
        $respondents=$request->respondents;
        if($request->response_deadline){
            $response_deadline=date("Y-m-d",strtotime($request->response_deadline));
        } else {
            $response_deadline=NULL;
        }
        if($request->file_date){
            $file_date=date("Y-m-d",strtotime($request->file_date));
        } else {
            $file_date=NULL;
        }
        $data=array(
            'case_id'=>$request->case_id,
            'motion_name'=>$request->motion_name,
            'motion_category'=>$request->motion_category,
            'motion_action_type'=>$request->motion_action_type,
            'parent_motion_id'=>$request->parent_motion_id,
            'motion_type_id'=>$request->motion_type_id,
            'motion_status'=>$request->motion_status,
            'response_deadline'=>$response_deadline,
            'file_date'=>$file_date,
            'client_role'=>$request->client_role,
            'updated_at'=>now(),
        );
        $motion = Motion::find($request->motion_id);
        $motionparties=$motion->motionparties;
        $motiondata=$motion->update($data);
        $totalsenders=$totalreceivers=$totalobservers=0;
        $data2=array();
        if($movants){
            $num=1;
            foreach ($movants as $movant) {
                $designation1=$designation2=$designation3=$designation4=$designation5=NULL;
                for ($i=1; $i <= 5; $i++) { 
                    if(isset($result['movant_'.$movant.'_designation'.$i.'']) && $result['movant_'.$movant.'_designation'.$i.''] !='') 
                    {
                        ${"designation" . $i}=$result['movant_'.$movant.'_designation'.$i.''];
                    }
                }
                $party_type="movant";
                $party_class="S".$num++;
                $data2[] = array(
                    'motion_id' => $request->motion_id,
                    'party_id' => $movant,
                    'party_type' => $party_type,
                    'party_class' => $party_class,
                    'response_deadline'=>$response_deadline,
                    'designation1' => $designation1,
                    'designation2' => $designation2,
                    'designation3' => $designation3,
                    'designation4' => $designation4,
                    'designation5' => $designation5,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                );
                ++$totalsenders;
            }
        }
        if($respondents){
            $num=1;
            foreach ($respondents as $respondent) {
                $designation1=$designation2=$designation3=$designation4=$designation5=NULL;
                for ($i=1; $i <= 5; $i++) { 
                    if(isset($result['respondent_'.$respondent.'_designation'.$i.'']) && $result['respondent_'.$respondent.'_designation'.$i.''] !='') 
                    {
                        ${"designation" . $i}=$result['respondent_'.$respondent.'_designation'.$i.''];
                    }
                }
                
                $party_type="respondent";
                $party_class="R".$num++;
                $data2[] = array(
                    'motion_id' => $request->motion_id,
                    'party_id' => $respondent,
                    'party_type' => $party_type,
                    'party_class' => $party_class,
                    'response_deadline'=>$response_deadline,
                    'designation1' => $designation1,
                    'designation2' => $designation2,
                    'designation3' => $designation3,
                    'designation4' => $designation4,
                    'designation5' => $designation5,
                    'created_at'=>now(),
                    'updated_at'=>now(),
                );
                ++$totalreceivers;
            }
        }

        // for observers
        $already_observers=Motionparty::where([['motion_id', $request->parent_motion_id],['party_class', 'like', 'O%']])->orderBy('party_class')->get()->pluck('party_id')->all();
        $sub_motion_ids=Motion::where('parent_motion_id', $request->parent_motion_id)->get()->pluck('id')->all();
        $already_observers1=Motionparty::whereIn('motion_id', $sub_motion_ids)->where('party_class', 'like', 'O%')->orderBy('party_class')->get()->pluck('party_id')->all();
        $all_already_observers=array_unique(array_merge($already_observers,$already_observers1));

        $motion_checked_parties=array_unique(array_merge($movants,$respondents));
        $motion_all_parties=Caseuser::where([['case_id', $case_id],['attorney_id', Auth::user()->id]])->get()->pluck('user_id')->all();
        $observers=array_diff($motion_all_parties,$motion_checked_parties);
        $observers=array_unique(array_merge($all_already_observers,$observers));
        $observers=array_diff($observers,$motion_checked_parties);

        $num=1;
        foreach ($observers as $observer) {            
            $party_type="NA";
            $party_class="O".$num++;
            $data2[] = array(
                'motion_id' => $request->motion_id,
                'party_id' => $observer,
                'party_type' => $party_type,
                'party_class' => $party_class,
                'response_deadline' => NULL,
                'designation1' => NULL,
                'designation2' => NULL,
                'designation3' => NULL,
                'designation4' => NULL,
                'designation5' => NULL,
                'created_at'=>now(),
                'updated_at'=>now(),
            );
            ++$totalobservers;
        }
        if(isset($motionparties) && $motionparties->count() >0){
            Motionparty::where('motion_id',$request->motion_id)->delete();
            $motionparty = Motionparty::insert($data2);
        } else{
            $motionparty = Motionparty::insert($data2);
        }
        // update motion table
        $motiontoupdate = Motion::find($motion->id);

        $motiontoupdate->num_s = $totalsenders;
        $motiontoupdate->num_r = $totalreceivers;
        $motiontoupdate->num_o = $totalobservers;

        $motiontoupdate->save();
        // dd($data2);
        return redirect()->route('cases.motions',['case_id' => $request->case_id])->with('success', 'Subordinate Motion Updated Successfully!');

    }

    /* TO change Motion status */
    public function changeMotionStatus(Request $request)
    {
        $motion_id=$request->motion_id;
        if(isset($motion_id) && isset($request->case_id)){
            $motion = Motion::findOrFail($motion_id);
            if($motion){
                $motion->motion_status = $request->motion_status;
                $motion->save();
            }
            return redirect()->route('cases.motions',['case_id' => $request->case_id])->with('success', 'Motion Status Changed Successfully!');
        } else {
            return redirect()->route('cases.motions',['case_id' => $request->case_id])->with('error', 'Something went wrong please try again.');
        }
    }

    /* To extend deadline */
    public function extendDeadline(Request $request)
    {
        $motion_id=$request->motion_id;
        if(isset($motion_id) && isset($request->case_id) && isset($request->motionparty_id) && isset($request->response_deadline)){
            $motion = Motion::findOrFail($motion_id);
            $response_deadline=date("Y-m-d",strtotime($request->response_deadline));
            if($motion){
                if($request->motionparty_id=='all'){
                    $motion->response_deadline = $response_deadline;
                    $motion->save();

                    $motionparty=Motionparty::where('motion_id', $motion_id)->update(['response_deadline' => $response_deadline]);

                } else {
                        //$motionparty=Motionparty::where([['motion_id', $motion_id],['motionparty_id', $request->motionparty_id]])->update(['response_deadline' => $response_deadline]);
                        $motionparty=Motionparty::findOrFail($request->motionparty_id);
                        if($motionparty){
                            $motionparty->response_deadline = $response_deadline;
                            $motionparty->save();
                        }
                }
                
            }
            return redirect()->route('cases.motions',['case_id' => $request->case_id])->with('success', 'Response Deadline Extended Successfully!');
        } else {
            return redirect()->route('cases.motions',['case_id' => $request->case_id])->with('error', 'Something went wrong please try again.');
        }
    }

    /* To add Agreed entry to motion */
    public function agreedEntry(Request $request)
    {
        $motion_id=$request->motion_id;
        if(isset($motion_id) && isset($request->case_id)){
            $motion = Motion::findOrFail($motion_id);
            if($motion){
                $motion->agreed_entry = $request->agreed_entry;
                $motion->save();
            }
            return redirect()->route('cases.motions',['case_id' => $request->case_id])->with('success', 'Agreed Entry Added Successfully!');
        } else {
            return redirect()->route('cases.motions',['case_id' => $request->case_id])->with('error', 'Something went wrong please try again.');
        }
    }

    /* To stay the motion */
    public function stayMotion(Request $request)
    {
        $motion_id=$request->motion_id;
        if(isset($motion_id) && isset($request->case_id)){
            $motion = Motion::findOrFail($motion_id);
            if($motion){
                $motion->stay_motion = $request->stay_motion;
                $motion->save();
            }
            return redirect()->route('cases.motions',['case_id' => $request->case_id])->with('success', 'Motion Stayed Successfully!');
        } else {
            return redirect()->route('cases.motions',['case_id' => $request->case_id])->with('error', 'Something went wrong please try again.');
        }
    }

}