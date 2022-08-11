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
use App\DrMonthlyHousingExpenses;


class DrMonthlyHousingExpensesController extends Controller
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
        $data=DrMonthlyHousingExpenses::orderBy('id','DESC')->get();
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
        $drmonthlyhousingexpenses=DrMonthlyHousingExpenses::where('case_id',$case_id)->get()->pluck('case_id');
        if(isset($drmonthlyhousingexpenses['0'])){
            return redirect()->route('home');
        }
        return view('dr_tables.dr_MonthlyHousingExpenses.create',['case_id'=> $case_id, 'client_name' => $client_name, 'opponent_name' => $opponent_name]);
    }

    public function store(Request $request)
    {
        $result = $request->except('submit');
        // parse string to date for client info section
        
        if(isset($result['Client_Rent_Own']) && $result['Client_Rent_Own']=='Owned'){
            $result['Client_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance']='0.00';
            $result['Client_Monthly_Homeowners_Insurance_IF_NOT_Included']='0.00';
            $result['Client_Monthly_Second_Mortgage_or_Equity_Loan_Payment']='0.00';
            $result['Client_Monthly_Renters_Insurance_IF_NOT_Included']='0.00';
        }

        // New Calculations
        $result['Client_Monthly_Gas_FuelOil_Propane']=0.00;
        $result['Client_Monthly_Housing_CleaningMaintenanceRepair']=0.00;
        $result['Client_Monthly_Lawn_Snow']=0.00;
        $result['Client_Total_Monthly_Housing_Other']=0.00;
        $result['Client_Total_Monthly_Housing_Expenses']=0.00;

        if(isset($result['Client_Monthly_Gas']) && $result['Client_Monthly_Gas']!=''){
            $result['Client_Monthly_Gas_FuelOil_Propane']=$result['Client_Monthly_Gas_FuelOil_Propane']+$result['Client_Monthly_Gas'];
        }
        if(isset($result['Client_Monthly_Fuel_Oil']) && $result['Client_Monthly_Fuel_Oil']!=''){
            $result['Client_Monthly_Gas_FuelOil_Propane']=$result['Client_Monthly_Gas_FuelOil_Propane']+$result['Client_Monthly_Fuel_Oil'];
        }
        if(isset($result['Client_Monthly_Propane']) && $result['Client_Monthly_Propane']!=''){
            $result['Client_Monthly_Gas_FuelOil_Propane']=$result['Client_Monthly_Gas_FuelOil_Propane']+$result['Client_Monthly_Propane'];
        }

        
        if(isset($result['Client_Monthly_House_Cleaning']) && $result['Client_Monthly_House_Cleaning']!=''){
            $result['Client_Monthly_Housing_CleaningMaintenanceRepair']=$result['Client_Monthly_Housing_CleaningMaintenanceRepair']+$result['Client_Monthly_House_Cleaning'];
        }
        if(isset($result['Client_Monthly_Housing_Maintenance']) && $result['Client_Monthly_Housing_Maintenance']!=''){
            $result['Client_Monthly_Housing_CleaningMaintenanceRepair']=$result['Client_Monthly_Housing_CleaningMaintenanceRepair']+$result['Client_Monthly_Housing_Maintenance'];
        }
        if(isset($result['Client_Monthly_Housing_Repair']) && $result['Client_Monthly_Housing_Repair']!=''){
            $result['Client_Monthly_Housing_CleaningMaintenanceRepair']=$result['Client_Monthly_Housing_CleaningMaintenanceRepair']+$result['Client_Monthly_Housing_Repair'];
        }


        if(isset($result['Client_Monthly_Lawn_Service']) && $result['Client_Monthly_Lawn_Service']!=''){
            $result['Client_Monthly_Lawn_Snow']=$result['Client_Monthly_Lawn_Snow']+$result['Client_Monthly_Lawn_Service'];
        }
        if(isset($result['Client_Monthly_Snow_Removal']) && $result['Client_Monthly_Snow_Removal']!=''){
            $result['Client_Monthly_Lawn_Snow']=$result['Client_Monthly_Lawn_Snow']+$result['Client_Monthly_Snow_Removal'];
        }


        if(isset($result['Client_Monthly_Housing_Other1_Amt']) && $result['Client_Monthly_Housing_Other1_Amt']!=''){
            $result['Client_Total_Monthly_Housing_Other']=$result['Client_Total_Monthly_Housing_Other']+$result['Client_Monthly_Housing_Other1_Amt'];
        }
        if(isset($result['Client_Monthly_Housing_Other2_Amt']) && $result['Client_Monthly_Housing_Other2_Amt']!=''){
            $result['Client_Total_Monthly_Housing_Other']=$result['Client_Total_Monthly_Housing_Other']+$result['Client_Monthly_Housing_Other2_Amt'];
        }
        if(isset($result['Client_Monthly_Housing_Other3_Amt']) && $result['Client_Monthly_Housing_Other3_Amt']!=''){
            $result['Client_Total_Monthly_Housing_Other']=$result['Client_Total_Monthly_Housing_Other']+$result['Client_Monthly_Housing_Other3_Amt'];
        }
        if(isset($result['Client_Monthly_Housing_Other4_Amt']) && $result['Client_Monthly_Housing_Other4_Amt']!=''){
            $result['Client_Total_Monthly_Housing_Other']=$result['Client_Total_Monthly_Housing_Other']+$result['Client_Monthly_Housing_Other4_Amt'];
        }


        if(isset($result['Client_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance']) && $result['Client_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance'];
        }
        if(isset($result['Client_Monthly_Homeowners_Insurance_IF_NOT_Included']) && $result['Client_Monthly_Homeowners_Insurance_IF_NOT_Included']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Homeowners_Insurance_IF_NOT_Included'];
        }
        if(isset($result['Client_Monthly_Second_Mortgage_or_Equity_Loan_Payment']) && $result['Client_Monthly_Second_Mortgage_or_Equity_Loan_Payment']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Second_Mortgage_or_Equity_Loan_Payment'];
        }
        if(isset($result['Client_Monthly_Renters_Insurance_IF_NOT_Included']) && $result['Client_Monthly_Renters_Insurance_IF_NOT_Included']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Renters_Insurance_IF_NOT_Included'];
        }
        if(isset($result['Client_Monthly_Gas_FuelOil_Propane']) && $result['Client_Monthly_Gas_FuelOil_Propane']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Gas_FuelOil_Propane'];
        }
        if(isset($result['Client_Monthly_Electric']) && $result['Client_Monthly_Electric']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Electric'];
        }
        if(isset($result['Client_Monthly_Water_and_Sewer']) && $result['Client_Monthly_Water_and_Sewer']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Water_and_Sewer'];
        }
        if(isset($result['Client_Monthly_Sewer_IF_NOT_Included']) && $result['Client_Monthly_Sewer_IF_NOT_Included']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Sewer_IF_NOT_Included'];
        }
        if(isset($result['Client_Monthly_Landline_Telephone']) && $result['Client_Monthly_Landline_Telephone']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Landline_Telephone'];
        }
        if(isset($result['Client_Monthly_Cell_Phone_IF_NOT_Included']) && $result['Client_Monthly_Cell_Phone_IF_NOT_Included']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Cell_Phone_IF_NOT_Included'];
        }
        if(isset($result['Client_Monthly_Trash']) && $result['Client_Monthly_Trash']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Trash'];
        }
        if(isset($result['Client_Monthly_Cable_Or_Satellite_TV']) && $result['Client_Monthly_Cable_Or_Satellite_TV']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Cable_Or_Satellite_TV'];
        }
        if(isset($result['Client_Monthly_Housing_CleaningMaintenanceRepair']) && $result['Client_Monthly_Housing_CleaningMaintenanceRepair']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Housing_CleaningMaintenanceRepair'];
        }
        if(isset($result['Client_Monthly_Lawn_Snow']) && $result['Client_Monthly_Lawn_Snow']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Lawn_Snow'];
        }
        if(isset($result['Client_Total_Monthly_Housing_Other']) && $result['Client_Total_Monthly_Housing_Other']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Total_Monthly_Housing_Other'];
        }


        if(isset($result['Op_Rent_Own']) && $result['Op_Rent_Own']=='Owned'){
            $result['Op_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance']='0.00';
            $result['Op_Monthly_Homeowners_Insurance_IF_NOT_Included']='0.00';
            $result['Op_Monthly_Second_Mortgage_or_Equity_Loan_Payment']='0.00';
            $result['Op_Monthly_Renters_Insurance_IF_NOT_Included']='0.00';
        }

        // New Calculations
        $result['Op_Monthly_Gas_FuelOil_Propane']=0.00;
        $result['Op_Monthly_Housing_CleaningMaintenanceRepair']=0.00;
        $result['Op_Monthly_Lawn_Snow']=0.00;
        $result['Op_Total_Monthly_Housing_Other']=0.00;
        $result['Op_Total_Monthly_Housing_Expenses']=0.00;

        if(isset($result['Op_Monthly_Gas']) && $result['Op_Monthly_Gas']!=''){
            $result['Op_Monthly_Gas_FuelOil_Propane']=$result['Op_Monthly_Gas_FuelOil_Propane']+$result['Op_Monthly_Gas'];
        }
        if(isset($result['Op_Monthly_Fuel_Oil']) && $result['Op_Monthly_Fuel_Oil']!=''){
            $result['Op_Monthly_Gas_FuelOil_Propane']=$result['Op_Monthly_Gas_FuelOil_Propane']+$result['Op_Monthly_Fuel_Oil'];
        }
        if(isset($result['Op_Monthly_Propane']) && $result['Op_Monthly_Propane']!=''){
            $result['Op_Monthly_Gas_FuelOil_Propane']=$result['Op_Monthly_Gas_FuelOil_Propane']+$result['Op_Monthly_Propane'];
        }

        
        if(isset($result['Op_Monthly_House_Cleaning']) && $result['Op_Monthly_House_Cleaning']!=''){
            $result['Op_Monthly_Housing_CleaningMaintenanceRepair']=$result['Op_Monthly_Housing_CleaningMaintenanceRepair']+$result['Op_Monthly_House_Cleaning'];
        }
        if(isset($result['Op_Monthly_Housing_Maintenance']) && $result['Op_Monthly_Housing_Maintenance']!=''){
            $result['Op_Monthly_Housing_CleaningMaintenanceRepair']=$result['Op_Monthly_Housing_CleaningMaintenanceRepair']+$result['Op_Monthly_Housing_Maintenance'];
        }
        if(isset($result['Op_Monthly_Housing_Repair']) && $result['Op_Monthly_Housing_Repair']!=''){
            $result['Op_Monthly_Housing_CleaningMaintenanceRepair']=$result['Op_Monthly_Housing_CleaningMaintenanceRepair']+$result['Op_Monthly_Housing_Repair'];
        }


        if(isset($result['Op_Monthly_Lawn_Service']) && $result['Op_Monthly_Lawn_Service']!=''){
            $result['Op_Monthly_Lawn_Snow']=$result['Op_Monthly_Lawn_Snow']+$result['Op_Monthly_Lawn_Service'];
        }
        if(isset($result['Op_Monthly_Snow_Removal']) && $result['Op_Monthly_Snow_Removal']!=''){
            $result['Op_Monthly_Lawn_Snow']=$result['Op_Monthly_Lawn_Snow']+$result['Op_Monthly_Snow_Removal'];
        }


        if(isset($result['Op_Monthly_Housing_Other1_Amt']) && $result['Op_Monthly_Housing_Other1_Amt']!=''){
            $result['Op_Total_Monthly_Housing_Other']=$result['Op_Total_Monthly_Housing_Other']+$result['Op_Monthly_Housing_Other1_Amt'];
        }
        if(isset($result['Op_Monthly_Housing_Other2_Amt']) && $result['Op_Monthly_Housing_Other2_Amt']!=''){
            $result['Op_Total_Monthly_Housing_Other']=$result['Op_Total_Monthly_Housing_Other']+$result['Op_Monthly_Housing_Other2_Amt'];
        }
        if(isset($result['Op_Monthly_Housing_Other3_Amt']) && $result['Op_Monthly_Housing_Other3_Amt']!=''){
            $result['Op_Total_Monthly_Housing_Other']=$result['Op_Total_Monthly_Housing_Other']+$result['Op_Monthly_Housing_Other3_Amt'];
        }
        if(isset($result['Op_Monthly_Housing_Other4_Amt']) && $result['Op_Monthly_Housing_Other4_Amt']!=''){
            $result['Op_Total_Monthly_Housing_Other']=$result['Op_Total_Monthly_Housing_Other']+$result['Op_Monthly_Housing_Other4_Amt'];
        }


        if(isset($result['Op_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance']) && $result['Op_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance'];
        }
        if(isset($result['Op_Monthly_Homeowners_Insurance_IF_NOT_Included']) && $result['Op_Monthly_Homeowners_Insurance_IF_NOT_Included']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Homeowners_Insurance_IF_NOT_Included'];
        }
        if(isset($result['Op_Monthly_Second_Mortgage_or_Equity_Loan_Payment']) && $result['Op_Monthly_Second_Mortgage_or_Equity_Loan_Payment']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Second_Mortgage_or_Equity_Loan_Payment'];
        }
        if(isset($result['Op_Monthly_Renters_Insurance_IF_NOT_Included']) && $result['Op_Monthly_Renters_Insurance_IF_NOT_Included']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Renters_Insurance_IF_NOT_Included'];
        }
        if(isset($result['Op_Monthly_Gas_FuelOil_Propane']) && $result['Op_Monthly_Gas_FuelOil_Propane']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Gas_FuelOil_Propane'];
        }
        if(isset($result['Op_Monthly_Electric']) && $result['Op_Monthly_Electric']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Electric'];
        }
        if(isset($result['Op_Monthly_Water_and_Sewer']) && $result['Op_Monthly_Water_and_Sewer']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Water_and_Sewer'];
        }
        if(isset($result['Op_Monthly_Sewer_IF_NOT_Included']) && $result['Op_Monthly_Sewer_IF_NOT_Included']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Sewer_IF_NOT_Included'];
        }
        if(isset($result['Op_Monthly_Landline_Telephone']) && $result['Op_Monthly_Landline_Telephone']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Landline_Telephone'];
        }
        if(isset($result['Op_Monthly_Cell_Phone_IF_NOT_Included']) && $result['Op_Monthly_Cell_Phone_IF_NOT_Included']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Cell_Phone_IF_NOT_Included'];
        }
        if(isset($result['Op_Monthly_Trash']) && $result['Op_Monthly_Trash']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Trash'];
        }
        if(isset($result['Op_Monthly_Cable_Or_Satellite_TV']) && $result['Op_Monthly_Cable_Or_Satellite_TV']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Cable_Or_Satellite_TV'];
        }
        if(isset($result['Op_Monthly_Housing_CleaningMaintenanceRepair']) && $result['Op_Monthly_Housing_CleaningMaintenanceRepair']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Housing_CleaningMaintenanceRepair'];
        }
        if(isset($result['Op_Monthly_Lawn_Snow']) && $result['Op_Monthly_Lawn_Snow']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Lawn_Snow'];
        }
        if(isset($result['Op_Total_Monthly_Housing_Other']) && $result['Op_Total_Monthly_Housing_Other']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Total_Monthly_Housing_Other'];
        }
        
        // echo "<pre>";print_r($result);die;
        $DrMonthlyHousingExpenses=DrMonthlyHousingExpenses::create($result);
        
        return redirect()->route('cases.family_law_interview_tabs',$result['case_id'])->with('success', 'Monthly Housing Expenses Information Submitted Successfully.');
        
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
        $drmonthlyhousingexpenses=DrMonthlyHousingExpenses::where('case_id',$case_id)->get()->first();
        // echo "<pre>";print_r($DrMonthlyHousingExpenses);//die;
        if($drmonthlyhousingexpenses){
            return view('dr_tables.dr_MonthlyHousingExpenses.edit',['case_id'=> $case_id, 'drmonthlyhousingexpenses' => $drmonthlyhousingexpenses, 'client_name' => $client_name, 'opponent_name' => $opponent_name]);
        } else {
            return redirect()->route('home');
        }
    }

    public function update(Request $request, $id)
    {
        $result = $request->except('submit','_method','_token');
        if(isset($result['Client_Rent_Own']) && $result['Client_Rent_Own']=='Owned'){
            $result['Client_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance']='0.00';
            $result['Client_Monthly_Homeowners_Insurance_IF_NOT_Included']='0.00';
            $result['Client_Monthly_Second_Mortgage_or_Equity_Loan_Payment']='0.00';
            $result['Client_Monthly_Renters_Insurance_IF_NOT_Included']='0.00';
        }

        // New Calculations
        $result['Client_Monthly_Gas_FuelOil_Propane']=0.00;
        $result['Client_Monthly_Housing_CleaningMaintenanceRepair']=0.00;
        $result['Client_Monthly_Lawn_Snow']=0.00;
        $result['Client_Total_Monthly_Housing_Other']=0.00;
        $result['Client_Total_Monthly_Housing_Expenses']=0.00;

        if(isset($result['Client_Monthly_Gas']) && $result['Client_Monthly_Gas']!=''){
            $result['Client_Monthly_Gas_FuelOil_Propane']=$result['Client_Monthly_Gas_FuelOil_Propane']+$result['Client_Monthly_Gas'];
        }
        if(isset($result['Client_Monthly_Fuel_Oil']) && $result['Client_Monthly_Fuel_Oil']!=''){
            $result['Client_Monthly_Gas_FuelOil_Propane']=$result['Client_Monthly_Gas_FuelOil_Propane']+$result['Client_Monthly_Fuel_Oil'];
        }
        if(isset($result['Client_Monthly_Propane']) && $result['Client_Monthly_Propane']!=''){
            $result['Client_Monthly_Gas_FuelOil_Propane']=$result['Client_Monthly_Gas_FuelOil_Propane']+$result['Client_Monthly_Propane'];
        }

        
        if(isset($result['Client_Monthly_House_Cleaning']) && $result['Client_Monthly_House_Cleaning']!=''){
            $result['Client_Monthly_Housing_CleaningMaintenanceRepair']=$result['Client_Monthly_Housing_CleaningMaintenanceRepair']+$result['Client_Monthly_House_Cleaning'];
        }
        if(isset($result['Client_Monthly_Housing_Maintenance']) && $result['Client_Monthly_Housing_Maintenance']!=''){
            $result['Client_Monthly_Housing_CleaningMaintenanceRepair']=$result['Client_Monthly_Housing_CleaningMaintenanceRepair']+$result['Client_Monthly_Housing_Maintenance'];
        }
        if(isset($result['Client_Monthly_Housing_Repair']) && $result['Client_Monthly_Housing_Repair']!=''){
            $result['Client_Monthly_Housing_CleaningMaintenanceRepair']=$result['Client_Monthly_Housing_CleaningMaintenanceRepair']+$result['Client_Monthly_Housing_Repair'];
        }


        if(isset($result['Client_Monthly_Lawn_Service']) && $result['Client_Monthly_Lawn_Service']!=''){
            $result['Client_Monthly_Lawn_Snow']=$result['Client_Monthly_Lawn_Snow']+$result['Client_Monthly_Lawn_Service'];
        }
        if(isset($result['Client_Monthly_Snow_Removal']) && $result['Client_Monthly_Snow_Removal']!=''){
            $result['Client_Monthly_Lawn_Snow']=$result['Client_Monthly_Lawn_Snow']+$result['Client_Monthly_Snow_Removal'];
        }


        if(isset($result['Client_Monthly_Housing_Other1_Amt']) && $result['Client_Monthly_Housing_Other1_Amt']!=''){
            $result['Client_Total_Monthly_Housing_Other']=$result['Client_Total_Monthly_Housing_Other']+$result['Client_Monthly_Housing_Other1_Amt'];
        }
        if(isset($result['Client_Monthly_Housing_Other2_Amt']) && $result['Client_Monthly_Housing_Other2_Amt']!=''){
            $result['Client_Total_Monthly_Housing_Other']=$result['Client_Total_Monthly_Housing_Other']+$result['Client_Monthly_Housing_Other2_Amt'];
        }
        if(isset($result['Client_Monthly_Housing_Other3_Amt']) && $result['Client_Monthly_Housing_Other3_Amt']!=''){
            $result['Client_Total_Monthly_Housing_Other']=$result['Client_Total_Monthly_Housing_Other']+$result['Client_Monthly_Housing_Other3_Amt'];
        }
        if(isset($result['Client_Monthly_Housing_Other4_Amt']) && $result['Client_Monthly_Housing_Other4_Amt']!=''){
            $result['Client_Total_Monthly_Housing_Other']=$result['Client_Total_Monthly_Housing_Other']+$result['Client_Monthly_Housing_Other4_Amt'];
        }


        if(isset($result['Client_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance']) && $result['Client_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance'];
        }
        if(isset($result['Client_Monthly_Homeowners_Insurance_IF_NOT_Included']) && $result['Client_Monthly_Homeowners_Insurance_IF_NOT_Included']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Homeowners_Insurance_IF_NOT_Included'];
        }
        if(isset($result['Client_Monthly_Second_Mortgage_or_Equity_Loan_Payment']) && $result['Client_Monthly_Second_Mortgage_or_Equity_Loan_Payment']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Second_Mortgage_or_Equity_Loan_Payment'];
        }
        if(isset($result['Client_Monthly_Renters_Insurance_IF_NOT_Included']) && $result['Client_Monthly_Renters_Insurance_IF_NOT_Included']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Renters_Insurance_IF_NOT_Included'];
        }
        if(isset($result['Client_Monthly_Gas_FuelOil_Propane']) && $result['Client_Monthly_Gas_FuelOil_Propane']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Gas_FuelOil_Propane'];
        }
        if(isset($result['Client_Monthly_Electric']) && $result['Client_Monthly_Electric']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Electric'];
        }
        if(isset($result['Client_Monthly_Water_and_Sewer']) && $result['Client_Monthly_Water_and_Sewer']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Water_and_Sewer'];
        }
        if(isset($result['Client_Monthly_Sewer_IF_NOT_Included']) && $result['Client_Monthly_Sewer_IF_NOT_Included']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Sewer_IF_NOT_Included'];
        }
        if(isset($result['Client_Monthly_Landline_Telephone']) && $result['Client_Monthly_Landline_Telephone']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Landline_Telephone'];
        }
        if(isset($result['Client_Monthly_Cell_Phone_IF_NOT_Included']) && $result['Client_Monthly_Cell_Phone_IF_NOT_Included']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Cell_Phone_IF_NOT_Included'];
        }
        if(isset($result['Client_Monthly_Trash']) && $result['Client_Monthly_Trash']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Trash'];
        }
        if(isset($result['Client_Monthly_Cable_Or_Satellite_TV']) && $result['Client_Monthly_Cable_Or_Satellite_TV']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Cable_Or_Satellite_TV'];
        }
        if(isset($result['Client_Monthly_Housing_CleaningMaintenanceRepair']) && $result['Client_Monthly_Housing_CleaningMaintenanceRepair']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Housing_CleaningMaintenanceRepair'];
        }
        if(isset($result['Client_Monthly_Lawn_Snow']) && $result['Client_Monthly_Lawn_Snow']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Monthly_Lawn_Snow'];
        }
        if(isset($result['Client_Total_Monthly_Housing_Other']) && $result['Client_Total_Monthly_Housing_Other']!=''){
            $result['Client_Total_Monthly_Housing_Expenses']=$result['Client_Total_Monthly_Housing_Expenses']+$result['Client_Total_Monthly_Housing_Other'];
        }


        if(isset($result['Op_Rent_Own']) && $result['Op_Rent_Own']=='Owned'){
            $result['Op_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance']='0.00';
            $result['Op_Monthly_Homeowners_Insurance_IF_NOT_Included']='0.00';
            $result['Op_Monthly_Second_Mortgage_or_Equity_Loan_Payment']='0.00';
            $result['Op_Monthly_Renters_Insurance_IF_NOT_Included']='0.00';
        }

        // New Calculations
        $result['Op_Monthly_Gas_FuelOil_Propane']=0.00;
        $result['Op_Monthly_Housing_CleaningMaintenanceRepair']=0.00;
        $result['Op_Monthly_Lawn_Snow']=0.00;
        $result['Op_Total_Monthly_Housing_Other']=0.00;
        $result['Op_Total_Monthly_Housing_Expenses']=0.00;

        if(isset($result['Op_Monthly_Gas']) && $result['Op_Monthly_Gas']!=''){
            $result['Op_Monthly_Gas_FuelOil_Propane']=$result['Op_Monthly_Gas_FuelOil_Propane']+$result['Op_Monthly_Gas'];
        }
        if(isset($result['Op_Monthly_Fuel_Oil']) && $result['Op_Monthly_Fuel_Oil']!=''){
            $result['Op_Monthly_Gas_FuelOil_Propane']=$result['Op_Monthly_Gas_FuelOil_Propane']+$result['Op_Monthly_Fuel_Oil'];
        }
        if(isset($result['Op_Monthly_Propane']) && $result['Op_Monthly_Propane']!=''){
            $result['Op_Monthly_Gas_FuelOil_Propane']=$result['Op_Monthly_Gas_FuelOil_Propane']+$result['Op_Monthly_Propane'];
        }

        
        if(isset($result['Op_Monthly_House_Cleaning']) && $result['Op_Monthly_House_Cleaning']!=''){
            $result['Op_Monthly_Housing_CleaningMaintenanceRepair']=$result['Op_Monthly_Housing_CleaningMaintenanceRepair']+$result['Op_Monthly_House_Cleaning'];
        }
        if(isset($result['Op_Monthly_Housing_Maintenance']) && $result['Op_Monthly_Housing_Maintenance']!=''){
            $result['Op_Monthly_Housing_CleaningMaintenanceRepair']=$result['Op_Monthly_Housing_CleaningMaintenanceRepair']+$result['Op_Monthly_Housing_Maintenance'];
        }
        if(isset($result['Op_Monthly_Housing_Repair']) && $result['Op_Monthly_Housing_Repair']!=''){
            $result['Op_Monthly_Housing_CleaningMaintenanceRepair']=$result['Op_Monthly_Housing_CleaningMaintenanceRepair']+$result['Op_Monthly_Housing_Repair'];
        }


        if(isset($result['Op_Monthly_Lawn_Service']) && $result['Op_Monthly_Lawn_Service']!=''){
            $result['Op_Monthly_Lawn_Snow']=$result['Op_Monthly_Lawn_Snow']+$result['Op_Monthly_Lawn_Service'];
        }
        if(isset($result['Op_Monthly_Snow_Removal']) && $result['Op_Monthly_Snow_Removal']!=''){
            $result['Op_Monthly_Lawn_Snow']=$result['Op_Monthly_Lawn_Snow']+$result['Op_Monthly_Snow_Removal'];
        }


        if(isset($result['Op_Monthly_Housing_Other1_Amt']) && $result['Op_Monthly_Housing_Other1_Amt']!=''){
            $result['Op_Total_Monthly_Housing_Other']=$result['Op_Total_Monthly_Housing_Other']+$result['Op_Monthly_Housing_Other1_Amt'];
        }
        if(isset($result['Op_Monthly_Housing_Other2_Amt']) && $result['Op_Monthly_Housing_Other2_Amt']!=''){
            $result['Op_Total_Monthly_Housing_Other']=$result['Op_Total_Monthly_Housing_Other']+$result['Op_Monthly_Housing_Other2_Amt'];
        }
        if(isset($result['Op_Monthly_Housing_Other3_Amt']) && $result['Op_Monthly_Housing_Other3_Amt']!=''){
            $result['Op_Total_Monthly_Housing_Other']=$result['Op_Total_Monthly_Housing_Other']+$result['Op_Monthly_Housing_Other3_Amt'];
        }
        if(isset($result['Op_Monthly_Housing_Other4_Amt']) && $result['Op_Monthly_Housing_Other4_Amt']!=''){
            $result['Op_Total_Monthly_Housing_Other']=$result['Op_Total_Monthly_Housing_Other']+$result['Op_Monthly_Housing_Other4_Amt'];
        }


        if(isset($result['Op_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance']) && $result['Op_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Rent_or_Mortgage_incTaxes_and_Insurance'];
        }
        if(isset($result['Op_Monthly_Homeowners_Insurance_IF_NOT_Included']) && $result['Op_Monthly_Homeowners_Insurance_IF_NOT_Included']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Homeowners_Insurance_IF_NOT_Included'];
        }
        if(isset($result['Op_Monthly_Second_Mortgage_or_Equity_Loan_Payment']) && $result['Op_Monthly_Second_Mortgage_or_Equity_Loan_Payment']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Second_Mortgage_or_Equity_Loan_Payment'];
        }
        if(isset($result['Op_Monthly_Renters_Insurance_IF_NOT_Included']) && $result['Op_Monthly_Renters_Insurance_IF_NOT_Included']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Renters_Insurance_IF_NOT_Included'];
        }
        if(isset($result['Op_Monthly_Gas_FuelOil_Propane']) && $result['Op_Monthly_Gas_FuelOil_Propane']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Gas_FuelOil_Propane'];
        }
        if(isset($result['Op_Monthly_Electric']) && $result['Op_Monthly_Electric']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Electric'];
        }
        if(isset($result['Op_Monthly_Water_and_Sewer']) && $result['Op_Monthly_Water_and_Sewer']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Water_and_Sewer'];
        }
        if(isset($result['Op_Monthly_Sewer_IF_NOT_Included']) && $result['Op_Monthly_Sewer_IF_NOT_Included']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Sewer_IF_NOT_Included'];
        }
        if(isset($result['Op_Monthly_Landline_Telephone']) && $result['Op_Monthly_Landline_Telephone']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Landline_Telephone'];
        }
        if(isset($result['Op_Monthly_Cell_Phone_IF_NOT_Included']) && $result['Op_Monthly_Cell_Phone_IF_NOT_Included']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Cell_Phone_IF_NOT_Included'];
        }
        if(isset($result['Op_Monthly_Trash']) && $result['Op_Monthly_Trash']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Trash'];
        }
        if(isset($result['Op_Monthly_Cable_Or_Satellite_TV']) && $result['Op_Monthly_Cable_Or_Satellite_TV']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Cable_Or_Satellite_TV'];
        }
        if(isset($result['Op_Monthly_Housing_CleaningMaintenanceRepair']) && $result['Op_Monthly_Housing_CleaningMaintenanceRepair']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Housing_CleaningMaintenanceRepair'];
        }
        if(isset($result['Op_Monthly_Lawn_Snow']) && $result['Op_Monthly_Lawn_Snow']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Monthly_Lawn_Snow'];
        }
        if(isset($result['Op_Total_Monthly_Housing_Other']) && $result['Op_Total_Monthly_Housing_Other']!=''){
            $result['Op_Total_Monthly_Housing_Expenses']=$result['Op_Total_Monthly_Housing_Expenses']+$result['Op_Total_Monthly_Housing_Other'];
        }
        
        $DrMonthlyHousingExpenses  = DrMonthlyHousingExpenses::findOrFail($id);
        if($DrMonthlyHousingExpenses){
            $DrMonthlyHousingExpenses->fill($result)->save();
            return redirect()->route('drmonthlyhousingexpenses.edit',$result['case_id'])->with('success', 'Monthly Housing Expenses Information Updated Successfully.');
        } else {
            return redirect()->route('drmonthlyhousingexpenses.edit',$result['case_id'])->with('error', 'Something went wrong. Please try Again.');
        }
    }
    
    public function destroy($id)
    {

    }

}
