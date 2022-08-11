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
use App\DrRealEstate;
use App\DrCaseOverview;


class DrRealEstateController extends Controller
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
        $data=DrRealEstate::orderBy('id','DESC')->get();
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

        $drrealestate=DrRealEstate::where('case_id',$case_id)->get()->pluck('case_id');
        if(isset($drrealestate['0'])){
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
        return view('dr_tables.dr_RealEstate.create',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'drcaseoverview'=>$drcaseoverview]);
    }

    // save tab info in database table.
    public function store(Request $request)
    {
        $result = $request->except('submit');

        $result['Real_Estate_Total_Marital_Equity']=0.00;
        $result['Real_Estate_Total_RentalIncome']=0.00;
        $result['Real_Estate_Total_DefaultMaritalEquity_to_Client']=0.00;
        $result['Real_Estate_Total_DefaultMaritalEquity_to_Op']=0.00;
        $result['Real_Estate_Total_MaritalEquity_to_Client']=0.00;
        $result['Real_Estate_Total_MaritalEquity_to_Op']=0.00;
        $result['Real_Estate_Total_RentalIncome_to_Client']=0.00;
        $result['Real_Estate_Total_RentalIncome_to_Op']=0.00;

        for ($i=1; $i <= 5; $i++) {
            unset($result[''.$i.'_Joint_Real_Estate_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Client_Real_Estate_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Op_Real_Estate_Estimated_Value_Select_Reset']);

            if(isset($result['Joint_Real_Estate_Disposition_Method'.$i.'']) && $result['Joint_Real_Estate_Disposition_Method'.$i.''] !='Fixed Buyout/Refinance'){
                $result['Joint_Real_Estate_Paying_Party'.$i.'']=NULL;
            }

            if(isset($result['Client_Real_Estate_Disposition_Method'.$i.'']) && $result['Client_Real_Estate_Disposition_Method'.$i.''] !='Fixed Buyout/Refinance'){
                $result['Client_Real_Estate_Paying_Party'.$i.'']=NULL;
            }

            if(isset($result['Op_Real_Estate_Disposition_Method'.$i.'']) && $result['Op_Real_Estate_Disposition_Method'.$i.''] !='Fixed Buyout/Refinance'){
                $result['Op_Real_Estate_Paying_Party'.$i.'']=NULL;
            }

            if(isset($result['Joint_Real_Estate_Rental'.$i.'']) && $result['Joint_Real_Estate_Rental'.$i.''] =='No'){
                $result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.'']=0;
                $result['Joint_Real_Estate_Client_Share_Rental'.$i.'']=0;
                $result['Joint_Real_Estate_Op_Share_Rental'.$i.'']=0;
            }

            if(isset($result['Client_Real_Estate_Rental'.$i.'']) && $result['Client_Real_Estate_Rental'.$i.''] =='No'){
                $result['Client_Real_Estate_Yearly_Net_Rental_Income'.$i.'']=0;
                $result['Client_Real_Estate_Client_Share_Rental'.$i.'']=0;
                $result['Client_Real_Estate_Op_Share_Rental'.$i.'']=0;
            }

            if(isset($result['Op_Real_Estate_Rental'.$i.'']) && $result['Op_Real_Estate_Rental'.$i.''] =='No'){
                $result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.'']=0;
                $result['Op_Real_Estate_Client_Share_Rental'.$i.'']=0;
                $result['Op_Real_Estate_Op_Share_Rental'.$i.'']=0;
            }

            // for client
            $result['Client_Real_Estate_Client_Share_Rental'.$i.'']=0.00;
            if(isset($result['Client_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Client_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''] !='' && !isset($result['Client_Real_Estate_Yearly_Net_Rental_Income'.$i.''])){
                $result['Client_Real_Estate_Client_Share_Rental'.$i.'']=$result['Client_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']/100;
            }
            if(isset($result['Client_Real_Estate_Yearly_Net_Rental_Income'.$i.'']) && $result['Client_Real_Estate_Yearly_Net_Rental_Income'.$i.''] !='' && !isset($result['Client_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''])){
                $result['Client_Real_Estate_Client_Share_Rental'.$i.'']=$result['Client_Real_Estate_Yearly_Net_Rental_Income'.$i.''];
            }
            if(isset($result['Client_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Client_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''] !='' && isset($result['Client_Real_Estate_Yearly_Net_Rental_Income'.$i.'']) && $result['Client_Real_Estate_Yearly_Net_Rental_Income'.$i.''] !=''){
                $result['Client_Real_Estate_Client_Share_Rental'.$i.'']=($result['Client_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']*$result['Client_Real_Estate_Yearly_Net_Rental_Income'.$i.''])/100;
            }

            // new calculations
            // for joint
            $result['Joint_Real_Estate_Client_Share_Rental'.$i.'']=0.00;
            if(isset($result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''] !='' && !isset($result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.''])){
                $result['Joint_Real_Estate_Client_Share_Rental'.$i.'']=$result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']/100;
            }
            if(isset($result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.'']) && $result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.''] !='' && !isset($result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''])){
                $result['Joint_Real_Estate_Client_Share_Rental'.$i.'']=$result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.''];
            }
            if(isset($result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''] !='' && isset($result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.'']) && $result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.''] !=''){
                $result['Joint_Real_Estate_Client_Share_Rental'.$i.'']=($result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']*$result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.''])/100;
            }

            // for opponent
            $result['Op_Real_Estate_Client_Share_Rental'.$i.'']=0.00;
            if(isset($result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''] !='' && !isset($result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.''])){
                $result['Op_Real_Estate_Client_Share_Rental'.$i.'']=$result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']/100;
            }
            if(isset($result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.'']) && $result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.''] !='' && !isset($result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''])){
                $result['Op_Real_Estate_Client_Share_Rental'.$i.'']=$result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.''];
            }
            if(isset($result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''] !='' && isset($result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.'']) && $result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.''] !=''){
                $result['Op_Real_Estate_Client_Share_Rental'.$i.'']=($result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']*$result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.''])/100;
            }

            // for all real estates
            if(isset($result['Joint_Real_Estate_MaritalEquity'.$i.'']) && $result['Joint_Real_Estate_MaritalEquity'.$i.''] !=''){
                $result['Real_Estate_Total_Marital_Equity']=$result['Real_Estate_Total_Marital_Equity']+$result['Joint_Real_Estate_MaritalEquity'.$i.''];
            }
            if(isset($result['Client_Real_Estate_MaritalEquity'.$i.'']) && $result['Client_Real_Estate_MaritalEquity'.$i.''] !=''){
                $result['Real_Estate_Total_Marital_Equity']=$result['Real_Estate_Total_Marital_Equity']+$result['Client_Real_Estate_MaritalEquity'.$i.''];
            }
            if(isset($result['Op_Real_Estate_MaritalEquity'.$i.'']) && $result['Op_Real_Estate_MaritalEquity'.$i.''] !=''){
                $result['Real_Estate_Total_Marital_Equity']=$result['Real_Estate_Total_Marital_Equity']+$result['Op_Real_Estate_MaritalEquity'.$i.''];
            }

            if(isset($result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.'']) && $result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome']=$result['Real_Estate_Total_RentalIncome']+$result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.''];
            }
            if(isset($result['Client_Real_Estate_Yearly_Net_Rental_Income'.$i.'']) && $result['Client_Real_Estate_Yearly_Net_Rental_Income'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome']=$result['Real_Estate_Total_RentalIncome']+$result['Client_Real_Estate_Yearly_Net_Rental_Income'.$i.''];
            }
            if(isset($result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.'']) && $result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome']=$result['Real_Estate_Total_RentalIncome']+$result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.''];
            }

            if(isset($result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''] !=''){
                $result['Real_Estate_Total_DefaultMaritalEquity_to_Client']=$result['Real_Estate_Total_DefaultMaritalEquity_to_Client']+$result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''];
            }
            if(isset($result['Client_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Client_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''] !=''){
                $result['Real_Estate_Total_DefaultMaritalEquity_to_Client']=$result['Real_Estate_Total_DefaultMaritalEquity_to_Client']+$result['Client_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''];
            }
            if(isset($result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''] !=''){
                $result['Real_Estate_Total_DefaultMaritalEquity_to_Client']=$result['Real_Estate_Total_DefaultMaritalEquity_to_Client']+$result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''];
            }

            if(isset($result['Joint_Real_Estate_Percent_Marital_Equity_to_Op'.$i.'']) && $result['Joint_Real_Estate_Percent_Marital_Equity_to_Op'.$i.''] !=''){
                $result['Real_Estate_Total_DefaultMaritalEquity_to_Op']=$result['Real_Estate_Total_DefaultMaritalEquity_to_Op']+$result['Joint_Real_Estate_Percent_Marital_Equity_to_Op'.$i.''];
            }
            if(isset($result['Client_Real_Estate_Percent_Marital_Equity_to_Op'.$i.'']) && $result['Client_Real_Estate_Percent_Marital_Equity_to_Op'.$i.''] !=''){
                $result['Real_Estate_Total_DefaultMaritalEquity_to_Op']=$result['Real_Estate_Total_DefaultMaritalEquity_to_Op']+$result['Client_Real_Estate_Percent_Marital_Equity_to_Op'.$i.''];
            }
            if(isset($result['Op_Real_Estate_Percent_Marital_Equity_to_Op'.$i.'']) && $result['Op_Real_Estate_Percent_Marital_Equity_to_Op'.$i.''] !=''){
                $result['Real_Estate_Total_DefaultMaritalEquity_to_Op']=$result['Real_Estate_Total_DefaultMaritalEquity_to_Op']+$result['Op_Real_Estate_Percent_Marital_Equity_to_Op'.$i.''];
            }

            if(isset($result['Joint_Real_Estate_Estimated_Value_to_Client'.$i.'']) && $result['Joint_Real_Estate_Estimated_Value_to_Client'.$i.''] !=''){
                $result['Real_Estate_Total_MaritalEquity_to_Client']=$result['Real_Estate_Total_MaritalEquity_to_Client']+$result['Joint_Real_Estate_Estimated_Value_to_Client'.$i.''];
            }
            if(isset($result['Client_Real_Estate_Estimated_Value_to_Client'.$i.'']) && $result['Client_Real_Estate_Estimated_Value_to_Client'.$i.''] !=''){
                $result['Real_Estate_Total_MaritalEquity_to_Client']=$result['Real_Estate_Total_MaritalEquity_to_Client']+$result['Client_Real_Estate_Estimated_Value_to_Client'.$i.''];
            }
            if(isset($result['Op_Real_Estate_Estimated_Value_to_Client'.$i.'']) && $result['Op_Real_Estate_Estimated_Value_to_Client'.$i.''] !=''){
                $result['Real_Estate_Total_MaritalEquity_to_Client']=$result['Real_Estate_Total_MaritalEquity_to_Client']+$result['Op_Real_Estate_Estimated_Value_to_Client'.$i.''];
            }

            if(isset($result['Joint_Real_Estate_Estimated_Value_to_Op'.$i.'']) && $result['Joint_Real_Estate_Estimated_Value_to_Op'.$i.''] !=''){
                $result['Real_Estate_Total_MaritalEquity_to_Op']=$result['Real_Estate_Total_MaritalEquity_to_Op']+$result['Joint_Real_Estate_Estimated_Value_to_Op'.$i.''];
            }
            if(isset($result['Client_Real_Estate_Estimated_Value_to_Op'.$i.'']) && $result['Client_Real_Estate_Estimated_Value_to_Op'.$i.''] !=''){
                $result['Real_Estate_Total_MaritalEquity_to_Op']=$result['Real_Estate_Total_MaritalEquity_to_Op']+$result['Client_Real_Estate_Estimated_Value_to_Op'.$i.''];
            }
            if(isset($result['Op_Real_Estate_Estimated_Value_to_Op'.$i.'']) && $result['Op_Real_Estate_Estimated_Value_to_Op'.$i.''] !=''){
                $result['Real_Estate_Total_MaritalEquity_to_Op']=$result['Real_Estate_Total_MaritalEquity_to_Op']+$result['Op_Real_Estate_Estimated_Value_to_Op'.$i.''];
            }

            if(isset($result['Joint_Real_Estate_Client_Share_Rental'.$i.'']) && $result['Joint_Real_Estate_Client_Share_Rental'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome_to_Client']=$result['Real_Estate_Total_RentalIncome_to_Client']+$result['Joint_Real_Estate_Client_Share_Rental'.$i.''];
            }
            if(isset($result['Client_Real_Estate_Client_Share_Rental'.$i.'']) && $result['Client_Real_Estate_Client_Share_Rental'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome_to_Client']=$result['Real_Estate_Total_RentalIncome_to_Client']+$result['Client_Real_Estate_Client_Share_Rental'.$i.''];
            }
            if(isset($result['Op_Real_Estate_Client_Share_Rental'.$i.'']) && $result['Op_Real_Estate_Client_Share_Rental'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome_to_Client']=$result['Real_Estate_Total_RentalIncome_to_Client']+$result['Op_Real_Estate_Client_Share_Rental'.$i.''];
            }

            if(isset($result['Joint_Real_Estate_Op_Share_Rental'.$i.'']) && $result['Joint_Real_Estate_Op_Share_Rental'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome_to_Op']=$result['Real_Estate_Total_RentalIncome_to_Op']+$result['Joint_Real_Estate_Op_Share_Rental'.$i.''];
            }
            if(isset($result['Client_Real_Estate_Op_Share_Rental'.$i.'']) && $result['Client_Real_Estate_Op_Share_Rental'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome_to_Op']=$result['Real_Estate_Total_RentalIncome_to_Op']+$result['Client_Real_Estate_Op_Share_Rental'.$i.''];
            }
            if(isset($result['Op_Real_Estate_Op_Share_Rental'.$i.'']) && $result['Op_Real_Estate_Op_Share_Rental'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome_to_Op']=$result['Real_Estate_Total_RentalIncome_to_Op']+$result['Op_Real_Estate_Op_Share_Rental'.$i.''];
            }


        }

        if(isset($result['Any_Real_Estate']) && $result['Any_Real_Estate']=='1'){
        } else {
            $result['Any_Real_Estate']='0';
            $result['Num_Joint_Real_Estate_Properties']=0;
            $result['Num_Client_Real_Estate_Properties']=0;
            $result['Num_Op_Real_Estate_Properties']=0;
        }

        if(isset($result['Num_Joint_Real_Estate_Properties'])){
        } else {
            $result['Num_Joint_Real_Estate_Properties']='0';
        }
        $Num_Joint_Real_Estate_Properties=$result['Num_Joint_Real_Estate_Properties'];
        $Num_Joint_Real_Estate_Properties=$Num_Joint_Real_Estate_Properties+1;
        for ($i=$Num_Joint_Real_Estate_Properties; $i <= 5; $i++) { 
            $result['Joint_Real_Estate_ZIP'.$i.'']=NULL;
            $result['Joint_Real_Estate_Street_Address'.$i.'']=NULL;            
            $result['Joint_Real_Estate_City'.$i.'']=NULL;            
            $result['Joint_Real_Estate_State'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Current_Value'.$i.'']=NULL;            
            $result['Joint_Real_Estate_First_Mortgage_Company_Name'.$i.'']=NULL;            
            $result['Joint_Real_Estate_First_Mortgage_Balance'.$i.'']=NULL;            
            $result['Joint_Real_Estate_First_Mortgage_Monthly_Payment'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Second_Mortgage_LOC_Company_Name'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Second_Mortgage_LOC_Balance'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment'.$i.'']=NULL;            
            $result['Joint_Real_Estate_MaritalEquity'.$i.'']=NULL;
            $result['Joint_Real_Estate_Rental'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.'']=NULL;
            $result['Joint_Real_Estate_Client_Share_Rental'.$i.'']=NULL;
            $result['Joint_Real_Estate_Op_Share_Rental'.$i.'']=NULL;
            $result['Joint_Real_Estate_SoleSeparate_Claim'.$i.'']=NULL;            
            $result['Joint_Real_Estate_SoleSeparate_Party'.$i.'']=NULL;            
            $result['Joint_Real_Estate_SoleSeparate_Grounds'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Disposition_Method'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Estimated_Value_to_Client'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Estimated_Value_to_Op'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Paying_Party'.$i.'']=NULL;            
        }

        if(isset($result['Num_Client_Real_Estate_Properties'])){
        } else {
            $result['Num_Client_Real_Estate_Properties']='0';
        }
        $Num_Client_Real_Estate_Properties=$result['Num_Client_Real_Estate_Properties'];
        $Num_Client_Real_Estate_Properties=$Num_Client_Real_Estate_Properties+1;
        for ($i=$Num_Client_Real_Estate_Properties; $i <= 5; $i++) { 
            $result['Client_Real_Estate_ZIP'.$i.'']=NULL;
            $result['Client_Real_Estate_Street_Address'.$i.'']=NULL;            
            $result['Client_Real_Estate_City'.$i.'']=NULL;            
            $result['Client_Real_Estate_State'.$i.'']=NULL;            
            $result['Client_Real_Estate_Current_Value'.$i.'']=NULL;            
            $result['Client_Real_Estate_First_Mortgage_Company_Name'.$i.'']=NULL;            
            $result['Client_Real_Estate_First_Mortgage_Balance'.$i.'']=NULL;            
            $result['Client_Real_Estate_First_Mortgage_Monthly_Payment'.$i.'']=NULL;            
            $result['Client_Real_Estate_Second_Mortgage_LOC_Company_Name'.$i.'']=NULL;            
            $result['Client_Real_Estate_Second_Mortgage_LOC_Balance'.$i.'']=NULL;            
            $result['Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment'.$i.'']=NULL;            
            $result['Client_Real_Estate_MaritalEquity'.$i.'']=NULL;
            $result['Client_Real_Estate_Rental'.$i.'']=NULL;            
            $result['Client_Real_Estate_Yearly_Net_Rental_Income'.$i.'']=NULL;            
            $result['Client_Real_Estate_Client_Share_Rental'.$i.'']=NULL;
            $result['Client_Real_Estate_Op_Share_Rental'.$i.'']=NULL;
            $result['Client_Real_Estate_SoleSeparate_Claim'.$i.'']=NULL;            
            $result['Client_Real_Estate_SoleSeparate_Party'.$i.'']=NULL;            
            $result['Client_Real_Estate_SoleSeparate_Grounds'.$i.'']=NULL;            
            $result['Client_Real_Estate_Disposition_Method'.$i.'']=NULL;            
            $result['Client_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
            $result['Client_Real_Estate_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
            $result['Client_Real_Estate_Estimated_Value_to_Client'.$i.'']=NULL;            
            $result['Client_Real_Estate_Estimated_Value_to_Op'.$i.'']=NULL;            
            $result['Client_Real_Estate_Paying_Party'.$i.'']=NULL;            
        }

        if(isset($result['Num_Op_Real_Estate_Properties'])){
        } else {
            $result['Num_Op_Real_Estate_Properties']='0';
        }
        $Num_Op_Real_Estate_Properties=$result['Num_Op_Real_Estate_Properties'];
        $Num_Op_Real_Estate_Properties=$Num_Op_Real_Estate_Properties+1;
        for ($i=$Num_Op_Real_Estate_Properties; $i <= 5; $i++) { 
            $result['Op_Real_Estate_ZIP'.$i.'']=NULL;
            $result['Op_Real_Estate_Street_Address'.$i.'']=NULL;            
            $result['Op_Real_Estate_City'.$i.'']=NULL;            
            $result['Op_Real_Estate_State'.$i.'']=NULL;            
            $result['Op_Real_Estate_Current_Value'.$i.'']=NULL;            
            $result['Op_Real_Estate_First_Mortgage_Company_Name'.$i.'']=NULL;            
            $result['Op_Real_Estate_First_Mortgage_Balance'.$i.'']=NULL;            
            $result['Op_Real_Estate_First_Mortgage_Monthly_Payment'.$i.'']=NULL;            
            $result['Op_Real_Estate_Second_Mortgage_LOC_Company_Name'.$i.'']=NULL;            
            $result['Op_Real_Estate_Second_Mortgage_LOC_Balance'.$i.'']=NULL;            
            $result['Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment'.$i.'']=NULL;
            $result['Op_Real_Estate_MaritalEquity'.$i.'']=NULL;
            $result['Op_Real_Estate_Rental'.$i.'']=NULL;            
            $result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.'']=NULL;
            $result['Op_Real_Estate_Client_Share_Rental'.$i.'']=NULL;
            $result['Op_Real_Estate_Op_Share_Rental'.$i.'']=NULL;
            $result['Op_Real_Estate_SoleSeparate_Claim'.$i.'']=NULL;            
            $result['Op_Real_Estate_SoleSeparate_Party'.$i.'']=NULL;            
            $result['Op_Real_Estate_SoleSeparate_Grounds'.$i.'']=NULL;            
            $result['Op_Real_Estate_Disposition_Method'.$i.'']=NULL;            
            $result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
            $result['Op_Real_Estate_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
            $result['Op_Real_Estate_Estimated_Value_to_Client'.$i.'']=NULL;            
            $result['Op_Real_Estate_Estimated_Value_to_Op'.$i.'']=NULL;            
            $result['Op_Real_Estate_Paying_Party'.$i.'']=NULL;            
        }
        
        // echo "<pre>";print_r($result);die;
        $drrealestate=DrRealEstate::create($result);
        // update case overview info.
        $drcaseoverview=DrCaseOverview::where('case_id',$result['case_id'])->get()->first();
        if(isset($drcaseoverview)){
            $drcaseoverview->Any_Real_Estate=$result['Any_Real_Estate'];
            $drcaseoverview->Num_Joint_Real_Estate_Properties=$result['Num_Joint_Real_Estate_Properties'];
            $drcaseoverview->Num_Client_Real_Estate_Properties=$result['Num_Client_Real_Estate_Properties'];
            $drcaseoverview->Num_Op_Real_Estate_Properties=$result['Num_Op_Real_Estate_Properties'];
            $drcaseoverview->save();
        } else {
            return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('error', 'Complete Case Overview Info Section First.');
        }

        return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('success', 'Real Estate Information Submitted Successfully.');
        
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
        
        $drrealestate=DrRealEstate::where('case_id',$case_id)->get()->first();
         // echo "<pre>";print_r($drrealestate);//die;
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
         // echo "<pre>";print_r($drrealestate);die;
        $drcaseoverview=DrCaseOverview::where('case_id',$case_id)->get()->first();
        if($drrealestate){
            if(isset($drcaseoverview)){
                if(isset($drcaseoverview) && $drcaseoverview->Any_Real_Estate==$drrealestate->Any_Real_Estate && $drcaseoverview->Num_Joint_Real_Estate_Properties==$drrealestate->Num_Joint_Real_Estate_Properties && $drcaseoverview->Num_Client_Real_Estate_Properties==$drrealestate->Num_Client_Real_Estate_Properties && $drcaseoverview->Num_Op_Real_Estate_Properties==$drrealestate->Num_Op_Real_Estate_Properties)
                {

                } else {
                    $drrealestate->Any_Real_Estate=$drcaseoverview->Any_Real_Estate;
                    $drrealestate->Num_Joint_Real_Estate_Properties=$drcaseoverview->Num_Joint_Real_Estate_Properties;
                    $drrealestate->Num_Client_Real_Estate_Properties=$drcaseoverview->Num_Client_Real_Estate_Properties;
                    $drrealestate->Num_Op_Real_Estate_Properties=$drcaseoverview->Num_Op_Real_Estate_Properties;
                }

            }
            return view('dr_tables.dr_RealEstate.edit',['case_id'=> $case_id, 'client_name'=>$client_name, 'opponent_name'=>$opponent_name, 'drrealestate' => $drrealestate]);
        } else {
            return redirect()->route('home');
        }
        
    }

    public function update(Request $request, $id)
    {
        $result = $request->except('submit','_method','_token');

        $result['Real_Estate_Total_Marital_Equity']=0.00;
        $result['Real_Estate_Total_RentalIncome']=0.00;
        $result['Real_Estate_Total_DefaultMaritalEquity_to_Client']=0.00;
        $result['Real_Estate_Total_DefaultMaritalEquity_to_Op']=0.00;
        $result['Real_Estate_Total_MaritalEquity_to_Client']=0.00;
        $result['Real_Estate_Total_MaritalEquity_to_Op']=0.00;
        $result['Real_Estate_Total_RentalIncome_to_Client']=0.00;
        $result['Real_Estate_Total_RentalIncome_to_Op']=0.00;

        for ($i=1; $i <= 5; $i++) {
            unset($result[''.$i.'_Joint_Real_Estate_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Client_Real_Estate_Estimated_Value_Select_Reset']);
            unset($result[''.$i.'_Op_Real_Estate_Estimated_Value_Select_Reset']);

            if(isset($result['Joint_Real_Estate_Disposition_Method'.$i.'']) && $result['Joint_Real_Estate_Disposition_Method'.$i.''] !='Fixed Buyout/Refinance'){
                $result['Joint_Real_Estate_Paying_Party'.$i.'']=NULL;
            }

            if(isset($result['Client_Real_Estate_Disposition_Method'.$i.'']) && $result['Client_Real_Estate_Disposition_Method'.$i.''] !='Fixed Buyout/Refinance'){
                $result['Client_Real_Estate_Paying_Party'.$i.'']=NULL;
            }

            if(isset($result['Op_Real_Estate_Disposition_Method'.$i.'']) && $result['Op_Real_Estate_Disposition_Method'.$i.''] !='Fixed Buyout/Refinance'){
                $result['Op_Real_Estate_Paying_Party'.$i.'']=NULL;
            }

            if(isset($result['Joint_Real_Estate_Rental'.$i.'']) && $result['Joint_Real_Estate_Rental'.$i.''] =='No'){
                $result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.'']=0;
                $result['Joint_Real_Estate_Client_Share_Rental'.$i.'']=0;
                $result['Joint_Real_Estate_Op_Share_Rental'.$i.'']=0;
            }

            if(isset($result['Client_Real_Estate_Rental'.$i.'']) && $result['Client_Real_Estate_Rental'.$i.''] =='No'){
                $result['Client_Real_Estate_Yearly_Net_Rental_Income'.$i.'']=0;
                $result['Client_Real_Estate_Client_Share_Rental'.$i.'']=0;
                $result['Client_Real_Estate_Op_Share_Rental'.$i.'']=0;
            }

            if(isset($result['Op_Real_Estate_Rental'.$i.'']) && $result['Op_Real_Estate_Rental'.$i.''] =='No'){
                $result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.'']=0;
                $result['Op_Real_Estate_Client_Share_Rental'.$i.'']=0;
                $result['Op_Real_Estate_Op_Share_Rental'.$i.'']=0;
            }

            // new calculations
            // for joint
            $result['Joint_Real_Estate_Client_Share_Rental'.$i.'']=0.00;
            if(isset($result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''] !='' && !isset($result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.''])){
                $result['Joint_Real_Estate_Client_Share_Rental'.$i.'']=$result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']/100;
            }
            if(isset($result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.'']) && $result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.''] !='' && !isset($result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''])){
                $result['Joint_Real_Estate_Client_Share_Rental'.$i.'']=$result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.''];
            }
            if(isset($result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''] !='' && isset($result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.'']) && $result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.''] !=''){
                $result['Joint_Real_Estate_Client_Share_Rental'.$i.'']=($result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']*$result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.''])/100;
            }
            
            // for opponent
            $result['Op_Real_Estate_Client_Share_Rental'.$i.'']=0.00;
            if(isset($result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''] !='' && !isset($result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.''])){
                $result['Op_Real_Estate_Client_Share_Rental'.$i.'']=$result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']/100;
            }
            if(isset($result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.'']) && $result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.''] !='' && !isset($result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''])){
                $result['Op_Real_Estate_Client_Share_Rental'.$i.'']=$result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.''];
            }
            if(isset($result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''] !='' && isset($result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.'']) && $result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.''] !=''){
                $result['Op_Real_Estate_Client_Share_Rental'.$i.'']=($result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']*$result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.''])/100;
            }

            // for all real estates
            if(isset($result['Joint_Real_Estate_MaritalEquity'.$i.'']) && $result['Joint_Real_Estate_MaritalEquity'.$i.''] !=''){
                $result['Real_Estate_Total_Marital_Equity']=$result['Real_Estate_Total_Marital_Equity']+$result['Joint_Real_Estate_MaritalEquity'.$i.''];
            }
            if(isset($result['Client_Real_Estate_MaritalEquity'.$i.'']) && $result['Client_Real_Estate_MaritalEquity'.$i.''] !=''){
                $result['Real_Estate_Total_Marital_Equity']=$result['Real_Estate_Total_Marital_Equity']+$result['Client_Real_Estate_MaritalEquity'.$i.''];
            }
            if(isset($result['Op_Real_Estate_MaritalEquity'.$i.'']) && $result['Op_Real_Estate_MaritalEquity'.$i.''] !=''){
                $result['Real_Estate_Total_Marital_Equity']=$result['Real_Estate_Total_Marital_Equity']+$result['Op_Real_Estate_MaritalEquity'.$i.''];
            }

            if(isset($result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.'']) && $result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome']=$result['Real_Estate_Total_RentalIncome']+$result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.''];
            }
            if(isset($result['Client_Real_Estate_Yearly_Net_Rental_Income'.$i.'']) && $result['Client_Real_Estate_Yearly_Net_Rental_Income'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome']=$result['Real_Estate_Total_RentalIncome']+$result['Client_Real_Estate_Yearly_Net_Rental_Income'.$i.''];
            }
            if(isset($result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.'']) && $result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome']=$result['Real_Estate_Total_RentalIncome']+$result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.''];
            }

            if(isset($result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''] !=''){
                $result['Real_Estate_Total_DefaultMaritalEquity_to_Client']=$result['Real_Estate_Total_DefaultMaritalEquity_to_Client']+$result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''];
            }
            if(isset($result['Client_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Client_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''] !=''){
                $result['Real_Estate_Total_DefaultMaritalEquity_to_Client']=$result['Real_Estate_Total_DefaultMaritalEquity_to_Client']+$result['Client_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''];
            }
            if(isset($result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']) && $result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''] !=''){
                $result['Real_Estate_Total_DefaultMaritalEquity_to_Client']=$result['Real_Estate_Total_DefaultMaritalEquity_to_Client']+$result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.''];
            }

            if(isset($result['Joint_Real_Estate_Percent_Marital_Equity_to_Op'.$i.'']) && $result['Joint_Real_Estate_Percent_Marital_Equity_to_Op'.$i.''] !=''){
                $result['Real_Estate_Total_DefaultMaritalEquity_to_Op']=$result['Real_Estate_Total_DefaultMaritalEquity_to_Op']+$result['Joint_Real_Estate_Percent_Marital_Equity_to_Op'.$i.''];
            }
            if(isset($result['Client_Real_Estate_Percent_Marital_Equity_to_Op'.$i.'']) && $result['Client_Real_Estate_Percent_Marital_Equity_to_Op'.$i.''] !=''){
                $result['Real_Estate_Total_DefaultMaritalEquity_to_Op']=$result['Real_Estate_Total_DefaultMaritalEquity_to_Op']+$result['Client_Real_Estate_Percent_Marital_Equity_to_Op'.$i.''];
            }
            if(isset($result['Op_Real_Estate_Percent_Marital_Equity_to_Op'.$i.'']) && $result['Op_Real_Estate_Percent_Marital_Equity_to_Op'.$i.''] !=''){
                $result['Real_Estate_Total_DefaultMaritalEquity_to_Op']=$result['Real_Estate_Total_DefaultMaritalEquity_to_Op']+$result['Op_Real_Estate_Percent_Marital_Equity_to_Op'.$i.''];
            }

            if(isset($result['Joint_Real_Estate_Estimated_Value_to_Client'.$i.'']) && $result['Joint_Real_Estate_Estimated_Value_to_Client'.$i.''] !=''){
                $result['Real_Estate_Total_MaritalEquity_to_Client']=$result['Real_Estate_Total_MaritalEquity_to_Client']+$result['Joint_Real_Estate_Estimated_Value_to_Client'.$i.''];
            }
            if(isset($result['Client_Real_Estate_Estimated_Value_to_Client'.$i.'']) && $result['Client_Real_Estate_Estimated_Value_to_Client'.$i.''] !=''){
                $result['Real_Estate_Total_MaritalEquity_to_Client']=$result['Real_Estate_Total_MaritalEquity_to_Client']+$result['Client_Real_Estate_Estimated_Value_to_Client'.$i.''];
            }
            if(isset($result['Op_Real_Estate_Estimated_Value_to_Client'.$i.'']) && $result['Op_Real_Estate_Estimated_Value_to_Client'.$i.''] !=''){
                $result['Real_Estate_Total_MaritalEquity_to_Client']=$result['Real_Estate_Total_MaritalEquity_to_Client']+$result['Op_Real_Estate_Estimated_Value_to_Client'.$i.''];
            }

            if(isset($result['Joint_Real_Estate_Estimated_Value_to_Op'.$i.'']) && $result['Joint_Real_Estate_Estimated_Value_to_Op'.$i.''] !=''){
                $result['Real_Estate_Total_MaritalEquity_to_Op']=$result['Real_Estate_Total_MaritalEquity_to_Op']+$result['Joint_Real_Estate_Estimated_Value_to_Op'.$i.''];
            }
            if(isset($result['Client_Real_Estate_Estimated_Value_to_Op'.$i.'']) && $result['Client_Real_Estate_Estimated_Value_to_Op'.$i.''] !=''){
                $result['Real_Estate_Total_MaritalEquity_to_Op']=$result['Real_Estate_Total_MaritalEquity_to_Op']+$result['Client_Real_Estate_Estimated_Value_to_Op'.$i.''];
            }
            if(isset($result['Op_Real_Estate_Estimated_Value_to_Op'.$i.'']) && $result['Op_Real_Estate_Estimated_Value_to_Op'.$i.''] !=''){
                $result['Real_Estate_Total_MaritalEquity_to_Op']=$result['Real_Estate_Total_MaritalEquity_to_Op']+$result['Op_Real_Estate_Estimated_Value_to_Op'.$i.''];
            }

            if(isset($result['Joint_Real_Estate_Client_Share_Rental'.$i.'']) && $result['Joint_Real_Estate_Client_Share_Rental'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome_to_Client']=$result['Real_Estate_Total_RentalIncome_to_Client']+$result['Joint_Real_Estate_Client_Share_Rental'.$i.''];
            }
            if(isset($result['Client_Real_Estate_Client_Share_Rental'.$i.'']) && $result['Client_Real_Estate_Client_Share_Rental'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome_to_Client']=$result['Real_Estate_Total_RentalIncome_to_Client']+$result['Client_Real_Estate_Client_Share_Rental'.$i.''];
            }
            if(isset($result['Op_Real_Estate_Client_Share_Rental'.$i.'']) && $result['Op_Real_Estate_Client_Share_Rental'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome_to_Client']=$result['Real_Estate_Total_RentalIncome_to_Client']+$result['Op_Real_Estate_Client_Share_Rental'.$i.''];
            }

            if(isset($result['Joint_Real_Estate_Op_Share_Rental'.$i.'']) && $result['Joint_Real_Estate_Op_Share_Rental'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome_to_Op']=$result['Real_Estate_Total_RentalIncome_to_Op']+$result['Joint_Real_Estate_Op_Share_Rental'.$i.''];
            }
            if(isset($result['Client_Real_Estate_Op_Share_Rental'.$i.'']) && $result['Client_Real_Estate_Op_Share_Rental'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome_to_Op']=$result['Real_Estate_Total_RentalIncome_to_Op']+$result['Client_Real_Estate_Op_Share_Rental'.$i.''];
            }
            if(isset($result['Op_Real_Estate_Op_Share_Rental'.$i.'']) && $result['Op_Real_Estate_Op_Share_Rental'.$i.''] !=''){
                $result['Real_Estate_Total_RentalIncome_to_Op']=$result['Real_Estate_Total_RentalIncome_to_Op']+$result['Op_Real_Estate_Op_Share_Rental'.$i.''];
            }

        }

        if(isset($result['Any_Real_Estate']) && $result['Any_Real_Estate']=='1'){
        } else {
            $result['Any_Real_Estate']='0';
            $result['Num_Joint_Real_Estate_Properties']=0;
            $result['Num_Client_Real_Estate_Properties']=0;
            $result['Num_Op_Real_Estate_Properties']=0;
        }

        if(isset($result['Num_Joint_Real_Estate_Properties'])){
        } else {
            $result['Num_Joint_Real_Estate_Properties']='0';
        }
        $Num_Joint_Real_Estate_Properties=$result['Num_Joint_Real_Estate_Properties'];
        $Num_Joint_Real_Estate_Properties=$Num_Joint_Real_Estate_Properties+1;
        for ($i=$Num_Joint_Real_Estate_Properties; $i <= 5; $i++) { 
            $result['Joint_Real_Estate_ZIP'.$i.'']=NULL;
            $result['Joint_Real_Estate_Street_Address'.$i.'']=NULL;            
            $result['Joint_Real_Estate_City'.$i.'']=NULL;            
            $result['Joint_Real_Estate_State'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Current_Value'.$i.'']=NULL;            
            $result['Joint_Real_Estate_First_Mortgage_Company_Name'.$i.'']=NULL;            
            $result['Joint_Real_Estate_First_Mortgage_Balance'.$i.'']=NULL;            
            $result['Joint_Real_Estate_First_Mortgage_Monthly_Payment'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Second_Mortgage_LOC_Company_Name'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Second_Mortgage_LOC_Balance'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Second_Mortgage_LOC_Monthly_Payment'.$i.'']=NULL;
            $result['Joint_Real_Estate_MaritalEquity'.$i.'']=NULL;          
            $result['Joint_Real_Estate_Rental'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Yearly_Net_Rental_Income'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Client_Share_Rental'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Op_Share_Rental'.$i.'']=NULL;            
            $result['Joint_Real_Estate_SoleSeparate_Claim'.$i.'']=NULL;            
            $result['Joint_Real_Estate_SoleSeparate_Party'.$i.'']=NULL;
            $result['Joint_Real_Estate_SoleSeparate_Grounds'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Disposition_Method'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Estimated_Value_to_Client'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Estimated_Value_to_Op'.$i.'']=NULL;            
            $result['Joint_Real_Estate_Paying_Party'.$i.'']=NULL;            
        }

        if(isset($result['Num_Client_Real_Estate_Properties'])){
        } else {
            $result['Num_Client_Real_Estate_Properties']='0';
        }
        $Num_Client_Real_Estate_Properties=$result['Num_Client_Real_Estate_Properties'];
        $Num_Client_Real_Estate_Properties=$Num_Client_Real_Estate_Properties+1;
        for ($i=$Num_Client_Real_Estate_Properties; $i <= 5; $i++) { 
            $result['Client_Real_Estate_ZIP'.$i.'']=NULL;
            $result['Client_Real_Estate_Street_Address'.$i.'']=NULL;            
            $result['Client_Real_Estate_City'.$i.'']=NULL;            
            $result['Client_Real_Estate_State'.$i.'']=NULL;            
            $result['Client_Real_Estate_Current_Value'.$i.'']=NULL;            
            $result['Client_Real_Estate_First_Mortgage_Company_Name'.$i.'']=NULL;            
            $result['Client_Real_Estate_First_Mortgage_Balance'.$i.'']=NULL;            
            $result['Client_Real_Estate_First_Mortgage_Monthly_Payment'.$i.'']=NULL;            
            $result['Client_Real_Estate_Second_Mortgage_LOC_Company_Name'.$i.'']=NULL;            
            $result['Client_Real_Estate_Second_Mortgage_LOC_Balance'.$i.'']=NULL;            
            $result['Client_Real_Estate_Second_Mortgage_LOC_Monthly_Payment'.$i.'']=NULL;            
            $result['Client_Real_Estate_MaritalEquity'.$i.'']=NULL;
            $result['Client_Real_Estate_Rental'.$i.'']=NULL;            
            $result['Client_Real_Estate_Yearly_Net_Rental_Income'.$i.'']=NULL;            
            $result['Client_Real_Estate_Client_Share_Rental'.$i.'']=NULL;            
            $result['Client_Real_Estate_Op_Share_Rental'.$i.'']=NULL;
            $result['Client_Real_Estate_SoleSeparate_Claim'.$i.'']=NULL;            
            $result['Client_Real_Estate_SoleSeparate_Party'.$i.'']=NULL;            
            $result['Client_Real_Estate_SoleSeparate_Grounds'.$i.'']=NULL;            
            $result['Client_Real_Estate_Disposition_Method'.$i.'']=NULL;            
            $result['Client_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
            $result['Client_Real_Estate_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
            $result['Client_Real_Estate_Estimated_Value_to_Client'.$i.'']=NULL;            
            $result['Client_Real_Estate_Estimated_Value_to_Op'.$i.'']=NULL;            
            $result['Client_Real_Estate_Paying_Party'.$i.'']=NULL;            
        }

        if(isset($result['Num_Op_Real_Estate_Properties'])){
        } else {
            $result['Num_Op_Real_Estate_Properties']='0';
        }
        $Num_Op_Real_Estate_Properties=$result['Num_Op_Real_Estate_Properties'];
        $Num_Op_Real_Estate_Properties=$Num_Op_Real_Estate_Properties+1;
        for ($i=$Num_Op_Real_Estate_Properties; $i <= 5; $i++) { 
            $result['Op_Real_Estate_ZIP'.$i.'']=NULL;
            $result['Op_Real_Estate_Street_Address'.$i.'']=NULL;            
            $result['Op_Real_Estate_City'.$i.'']=NULL;            
            $result['Op_Real_Estate_State'.$i.'']=NULL;            
            $result['Op_Real_Estate_Current_Value'.$i.'']=NULL;            
            $result['Op_Real_Estate_First_Mortgage_Company_Name'.$i.'']=NULL;            
            $result['Op_Real_Estate_First_Mortgage_Balance'.$i.'']=NULL;            
            $result['Op_Real_Estate_First_Mortgage_Monthly_Payment'.$i.'']=NULL;            
            $result['Op_Real_Estate_Second_Mortgage_LOC_Company_Name'.$i.'']=NULL;            
            $result['Op_Real_Estate_Second_Mortgage_LOC_Balance'.$i.'']=NULL;            
            $result['Op_Real_Estate_Second_Mortgage_LOC_Monthly_Payment'.$i.'']=NULL;            
            $result['Op_Real_Estate_MaritalEquity'.$i.'']=NULL;
            $result['Op_Real_Estate_Rental'.$i.'']=NULL;            
            $result['Op_Real_Estate_Yearly_Net_Rental_Income'.$i.'']=NULL;
            $result['Op_Real_Estate_Client_Share_Rental'.$i.'']=NULL;
            $result['Op_Real_Estate_Op_Share_Rental'.$i.'']=NULL;            
            $result['Op_Real_Estate_SoleSeparate_Claim'.$i.'']=NULL;            
            $result['Op_Real_Estate_SoleSeparate_Party'.$i.'']=NULL;            
            $result['Op_Real_Estate_SoleSeparate_Grounds'.$i.'']=NULL;            
            $result['Op_Real_Estate_Disposition_Method'.$i.'']=NULL;            
            $result['Op_Real_Estate_Percent_Marital_Equity_to_Client'.$i.'']=NULL;            
            $result['Op_Real_Estate_Percent_Marital_Equity_to_Op'.$i.'']=NULL;            
            $result['Op_Real_Estate_Estimated_Value_to_Client'.$i.'']=NULL;            
            $result['Op_Real_Estate_Estimated_Value_to_Op'.$i.'']=NULL;            
            $result['Op_Real_Estate_Paying_Party'.$i.'']=NULL;            
        }
        
        // echo "<pre>";print_r($result);die;
        $drrealestate  = DrRealEstate::findOrFail($id);
        if($drrealestate){
            $drrealestate->fill($result)->save();
            // update case overview info.
            $drcaseoverview=DrCaseOverview::where('case_id',$result['case_id'])->get()->first();
            if(isset($drcaseoverview)){
                $drcaseoverview->Any_Real_Estate=$result['Any_Real_Estate'];
                $drcaseoverview->Num_Joint_Real_Estate_Properties=$result['Num_Joint_Real_Estate_Properties'];
                $drcaseoverview->Num_Client_Real_Estate_Properties=$result['Num_Client_Real_Estate_Properties'];
                $drcaseoverview->Num_Op_Real_Estate_Properties=$result['Num_Op_Real_Estate_Properties'];
                $drcaseoverview->save();
            } else {
                return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('error', 'Complete Case Overview Info Section First.');
            }
            
            return redirect()->route('drrealestate.edit',$result['case_id'])->with('success', 'Real Estate Information Updated Successfully.');
        } else {
            return redirect()->route('drrealestate.edit',$result['case_id'])->with('error', 'Something went wrong. Please try Again.');
        }
    }
    
    public function destroy($id)
    {

    }

}
