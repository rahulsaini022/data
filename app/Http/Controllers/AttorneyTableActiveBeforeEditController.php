<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\AttorneyTableActive;

use App\AttorneyTableActiveBeforeEdit;

use App\State;

use App\County;

use Illuminate\Support\Facades\DB;

use Session;

use Auth;

class AttorneyTableActiveBeforeEditController extends Controller

{

    function __construct()

    {

         $this->middleware('role:super admin');

    }

    /**

     * Display a listing of the resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function index(Request $request)

    {

        $data=AttorneyTableActiveBeforeEdit::orderBy('id','DESC')->paginate(50);

        // return view('admin.attorney_table_active_before_edit.index',compact('data'))

        //     ->with('i', ($request->input('page', 1) - 1) * 5);

        // $data = AttorneyTableActiveBeforeEdit::orderBy('id','DESC')->get();

        return view('admin.attorney_table_active_before_edit.index',compact('data'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {
        die('Not Valid');
        return view('admin.attorney_table_active_before_edit.create');

    }


    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {
        die('Not Valid');
        $this->validate($request, [

            'registration_state_id' => 'required',
            
            'registrationnumber' => 'required',
            
            'registrationnumber_state1' => 'required',

            'fname' => 'required',

            'currentstatus' => 'required',

            'document_sign_name' => 'required',

            'gender' => 'required',

            'admissiondate' => 'required',

            'howadmitted' => 'required',

            // 'county_id' => 'required',
            
        ]);

        $input = $request->all();

        $state = State::find($request->registration_state_id);
        $input['registration_state']=$state->state;

        $firm_state = State::find($request->firm_state);
        $input['firm_state']=$firm_state->state;
        $input['firm_state_abr']=$firm_state->state_abbreviation;

        $time_input = strtotime( $request->admissiondate);
        $input['admissiondate'] = date('Y-m-d', $time_input);
        $input['admissiondatevalue'] = date('Ymd', $time_input);

        $time_input = strtotime( $request->birthdate);
        $input['birthdate'] = date('Y-m-d', $time_input);
        $input['birthdatevalue'] = date('Ymd', $time_input);

        $county = County::find($request->firm_county);
        $input['county_id']=$request->firm_county;
        $input['firm_county']=$county->county_name;

        $input['last_update']=date('Y-m-d');
        $input['last_updatevalue']=date('Ymd');

        $input['last_edited_by']=Auth::user()->name;
        $attorneytableactivebeforeedit = AttorneyTableActiveBeforeEdit::create($input);


        return redirect()->route('attorneytableactivebeforeedit.index')

                        ->with('success','Record created successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $attorneytableactivebeforeedit = AttorneyTableActiveBeforeEdit::find($id);
        if($attorneytableactivebeforeedit){
        }else{
            return redirect()->route('attorneytableactivebeforeedit.index')

                        ->with('error','Record not found.');
        }

        return view('admin.attorney_table_active_before_edit.show',compact('attorneytableactivebeforeedit'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {
        die('Not Valid');
        $attorneytableactivebeforeedit = AttorneyTableActiveBeforeEdit::find($id); 
        if($attorneytableactivebeforeedit){
            return view('admin.attorney_table_active_before_edit.edit',compact('attorneytableactivebeforeedit'));
        } else {
            return redirect()->route('attorneytableactivebeforeedit.index')

                        ->with('error','Record not found');
        }

    }


    /**

     * Update the specified resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function update(Request $request, $id)

    {
        die('Not Valid');
        $this->validate($request, [

            'registration_state_id' => 'required',
            
            'registrationnumber' => 'required',
            
            'registrationnumber_state1' => 'required',

            'fname' => 'required',

            'currentstatus' => 'required',

            'document_sign_name' => 'required',

            'gender' => 'required',

            'admissiondate' => 'required',

            'howadmitted' => 'required',

            // 'county_id' => 'required',
            
        ]);

        $attorney_table_active_before_edit=DB::table('attorney_table_active_before_edit')
                            ->where([['registrationnumber', $request->registrationnumber],['registration_state_id', $request->registration_state_id]])
                            // ->orWhere('registrationnumber_state1', $request->attorney_reg_1_num)
                            ->get()->first();
        if($attorney_table_active_before_edit){
            unset($attorney_table_active_before_edit->id);
            $attorney_table_active_before_edit = (array) $attorney_table_active_before_edit;
            AttorneyTableActiveBeforeEdit::create($attorney_table_active_before_edit);
        }

        $input = $request->all();

        $state = State::find($request->registration_state_id);
        $input['registration_state']=$state->state;

        $firm_state = State::find($request->firm_state);
        $input['firm_state']=$firm_state->state;
        $input['firm_state_abr']=$firm_state->state_abbreviation;

        $time_input = strtotime( $request->admissiondate);
        $input['admissiondate'] = date('Y-m-d', $time_input);
        $input['admissiondatevalue'] = date('Ymd', $time_input);

        $time_input = strtotime( $request->birthdate);
        $input['birthdate'] = date('Y-m-d', $time_input);
        $input['birthdatevalue'] = date('Ymd', $time_input);

        $county = County::find($request->firm_county);
        $input['county_id']=$request->firm_county;
        $input['firm_county']=$county->county_name;

        $input['last_update']=date('Y-m-d');
        $input['last_updatevalue']=date('Ymd');

        $input['last_edited_by']=Auth::user()->name;

        $attorneytableactivebeforeedit = AttorneyTableActiveBeforeEdit::find($id);

        $attorneytableactivebeforeedit->update($input);

        return redirect()->route('attorneytableactivebeforeedit.index')

                        ->with('success','Record updated successfully');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {
        // die('Not Valid');
        AttorneyTableActiveBeforeEdit::find($id)->delete();

        return redirect()->route('attorneytableactivebeforeedit.index')

                        ->with('success','Record deleted successfully.');

    }

    public function restoreRecord(Request $request)
    {
        $id=$request->id;

        // to backup old attorney data before updating in attorney table active
        $attorney_table_active_before_edit=AttorneyTableActiveBeforeEdit::find($id);
        if($attorney_table_active_before_edit){

            $data['registrationnumber_state1']=$attorney_table_active_before_edit->registrationnumber_state1;
            $data['fname']=$attorney_table_active_before_edit->fname;
            $data['mname']=$attorney_table_active_before_edit->mname;
            $data['lname']=$attorney_table_active_before_edit->lname;
            $data['sufname']=$attorney_table_active_before_edit->sufname;
            $data['currentstatus']=$attorney_table_active_before_edit->currentstatus;
            $data['document_sign_name']=$attorney_table_active_before_edit->document_sign_name;
            $data['gender']=$attorney_table_active_before_edit->gender;
            $data['attorneytitle']=$attorney_table_active_before_edit->attorneytitle;
            $data['insured']=$attorney_table_active_before_edit->insured;
            $data['admissiondate']=$attorney_table_active_before_edit->admissiondate;
            $data['admissiondatevalue']=$attorney_table_active_before_edit->admissiondatevalue;
            $data['howadmitted']=$attorney_table_active_before_edit->howadmitted;
            $data['birthdate']=$attorney_table_active_before_edit->birthdate;
            $data['birthdatevalue']=$attorney_table_active_before_edit->birthdatevalue;
            $data['firm_name']=$attorney_table_active_before_edit->firm_name;
            $data['firm_tagline']=$attorney_table_active_before_edit->firm_tagline;
            $data['firm_street_address']=$attorney_table_active_before_edit->firm_street_address;
            $data['firm_suite_unit_mailcode']=$attorney_table_active_before_edit->firm_suite_unit_mailcode;
            $data['po_box']=$attorney_table_active_before_edit->po_box;
            $data['firm_city']=$attorney_table_active_before_edit->firm_city;
            $data['firm_state']=$attorney_table_active_before_edit->firm_state;
            $data['firm_state_abr']=$attorney_table_active_before_edit->firm_state_abr;
            $data['firm_zip']=$attorney_table_active_before_edit->firm_zip;
            $data['firm_telephone']=$attorney_table_active_before_edit->firm_telephone;
            $data['firm_fax']=$attorney_table_active_before_edit->firm_fax;
            // $data['email']=$attorney_table_active_before_edit->email;
            $data['lawschool']=$attorney_table_active_before_edit->lawschool;
            $data['county_id']=$attorney_table_active_before_edit->county_id;
            $data['firm_county']=$attorney_table_active_before_edit->firm_county;
            $data['last_update']=$attorney_table_active_before_edit->last_update;
            $data['last_updatevalue']=$attorney_table_active_before_edit->last_updatevalue;
            $data['last_edited_by']=$attorney_table_active_before_edit->last_edited_by;

            // dd($data);
            $attorney_active_data=AttorneyTableActive::where([['registrationnumber', $attorney_table_active_before_edit->registrationnumber],['registration_state_id', $attorney_table_active_before_edit->registration_state_id]])->update($data);
            if($attorney_active_data){
                return redirect()->route('attorneytableactivebeforeedit.index')
                            ->with('success','Record restored successfully.');
            } else {
                return redirect()->route('attorneytableactivebeforeedit.index')
                            ->with('error','Nothing to update.');
            }
        
        }

    }

    public function getRecordsByRegNum(Request $request)
    {
        $reg_num=$request->reg_num;
        $data=AttorneyTableActiveBeforeEdit::where('registrationnumber', $reg_num)->orderBy('id','DESC')->paginate(50);
        if($data->items()){
            return view('admin.attorney_table_active_before_edit.index',compact('data'));
        } else {
            return redirect()->route('attorneytableactivebeforeedit.index')
                        ->with('error','Record not found.');
        }

        
    }

}