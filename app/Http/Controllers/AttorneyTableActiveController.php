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

class AttorneyTableActiveController extends Controller

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
      
        if ($request->ajax()) {
            // DB::statement(DB::raw('set @rownum=0'));
            // $data = AttorneyTableActive::get([
            //     'attorney_table_active.*',
            //     DB::raw('@rownum  := @rownum  + 1 AS rownum')
            // ]);
            // return DataTables::of($data)
            //     ->addIndexColumn()

            //     ->make(true);
            $draw = $request->get('draw');
            $start = $request->get("start");

            $rowperpage = $request->get("length"); // Rows display per page

            $columnIndex_arr = $request->get('order');
            $columnName_arr = $request->get('columns');
            $order_arr = $request->get('order');
            $search_arr = $request->get('search');
            // print_r($request->all());
            // exit;
            $columnIndex = $columnIndex_arr[0]['column']; // Column index
            $columnName = $columnName_arr[$columnIndex]['data']; // Column name
            $columnSortOrder = $order_arr[0]['dir']; // asc or desc
            $searchValue = $search_arr['value']; // Search value
            // $columnIndex = ''; // Column index
            // $columnName = 'id'; // Column name
            // $columnSortOrder = 'asc'; // asc or desc
            // $searchValue =''; // Search value

            // Total records
            $totalRecords = AttorneyTableActive::select('count(*) as allcount')->count();
            $totalRecordswithFilter = AttorneyTableActive::select('count(*) as allcount')->where('registrationnumber', 'like', '%' . $searchValue . '%')->count();
            DB::statement(DB::raw('set @rownum=0'));
            // Fetch records
            $records = AttorneyTableActive::orderBy($columnName, $columnSortOrder)
                ->where('attorney_table_active.registrationnumber', 'like', '%' . $searchValue . '%')
                ->orWhere('attorney_table_active.registration_state', 'like', '%' . $searchValue . '%')
                ->orWhere('attorney_table_active.document_sign_name', 'like', '%' . $searchValue . '%')
                // ->orWhere('attorney_table_active.registrationnumber', 'like', '%' . $searchValue . '%')
               
                ->skip($start)
                ->take($rowperpage)
                ->get([
                'attorney_table_active.*',
                DB::raw('@rownum  := @rownum  + 1 AS rownum')
                ]);
          
            //  dd($records);
            $data_arr = array();
            $sno = $start + 1;
            foreach ($records as $record) {
                $sno = $sno;
                $id = $record->id;
                $ttno=$record->rownum;
                $registrationnumber = $record->registrationnumber;
                $registration_state = $record->registration_state;
                $document_sign_name = $record->document_sign_name;


                $data_arr[] = array(

                    'no' => $sno,
                    "registrationnumber" => $registrationnumber,
                    "ttno"=>$ttno,
                    "registration_state" => $registration_state,
                    "document_sign_name" => $document_sign_name,
                    "id" => $id,

                );
                $sno++;
            }

            $response = array(
                "draw" => intval($draw),
                "iTotalRecords" => $totalRecords,
                "iTotalDisplayRecords" => $totalRecordswithFilter,
                "aaData" => $data_arr
            );

            return json_encode($response);
        

        }
      
        $data = AttorneyTableActive::orderBy('id','DESC')->paginate(50);


        return view('admin.attorney_table_active.index',compact('data'));

    }
    


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {
        return view('admin.attorney_table_active.create');

    }


    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

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
        $attorneytableactive = AttorneyTableActive::create($input);


        return redirect()->route('attorneytableactive.index')

                        ->with('success','New attorney table active record created successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $attorneytableactive = AttorneyTableActive::find($id);
        if($attorneytableactive){
        }else{
            return redirect()->route('attorneytableactive.index')

                        ->with('error','Attorney table active record not found.');
        }

        return view('admin.attorney_table_active.show',compact('attorneytableactive'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $attorneytableactive = AttorneyTableActive::find($id); 
        if($attorneytableactive){
            return view('admin.attorney_table_active.edit',compact('attorneytableactive'));
        } else {
            return redirect()->route('attorneytableactive.index')

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
        // die('Not Valid');
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

        $attorney_active_data_old=DB::table('attorney_table_active')
                            ->where([['registrationnumber', $request->registrationnumber],['registration_state_id', $request->registration_state_id]])
                            // ->orWhere('registrationnumber_state1', $request->attorney_reg_1_num)
                            ->get()->first();
        if($attorney_active_data_old){
            unset($attorney_active_data_old->id);
            $attorney_active_data_old = (array) $attorney_active_data_old;
            AttorneyTableActiveBeforeEdit::create($attorney_active_data_old);
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

        $attorneytableactive = AttorneyTableActive::find($id);

        $attorneytableactive->update($input);

        return redirect()->route('attorneytableactive.index')

                        ->with('success','Attorney table active record updated successfully');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {
        die('Not Valid');
        AttorneyTableActive::find($id)->delete();

        return redirect()->route('attorneytableactive.index')

                        ->with('success','Attorney table active record deleted successfully.');

    }


    /* Get value from datatable */


     public function server_processing(Request $request)
    {
        $search = $request->query('search', array('value' => '', 'regex' => false));
        $draw = $request->query('draw', 0);
        $start = $request->query('start', 0);
        $length = $request->query('length', 50);
        $order = $request->query('order', array(1, 'asc'));        

        $filter = $search['value'];

        $sortColumns = array(
            0 => 'registrationnumber',
            1 => 'registration_state',
            2 => 'document_sign_name',
            
        );

        $query = AttorneyTableActive::select('id','registrationnumber','registration_state','document_sign_name');

        if (!empty($filter)) {
            $query->where('registrationnumber', 'like', '%'.$filter.'%');
        }

        $recordsTotal = $query->count();

        $sortColumnName = $sortColumns[$order[0]['column']];

        $query->orderBy($sortColumnName, $order[0]['dir'])
                ->take($length)
                ->skip($start);

        $json = array(
            'draw' => $draw,
            'recordsTotal' => $recordsTotal,
            'recordsFiltered' => $recordsTotal,
            'data' => [],
        );

        $products = $query->all();

        

        foreach ($products as $product) {

            $json['data'][] = [
                $product->registrationnumber,
                $product->registration_state,
                $product->document_sign_name,
                $product->id,
                view('admin.attorney_table_active.index', ['data' => $product])->render(),
            ];
        }

        return $json;
        
    }


    public function Filtering(Request $request)
    {
    
   
        
      $filter=($request->has('filter')? $request->filter : Session::get('filter') );
     if (!empty($filter)) {
        $data = AttorneyTableActive::where('registrationnumber','like', '%'.$filter.'%')->orWhere('registration_state','like','%'.$filter.'%')->orWhere('document_sign_name','like','%'.$filter.'%')
            ->orderBy('id','DESC')->paginate(50);
    } else {
        $data = AttorneyTableActive::orderBy('id','DESC')->paginate(50);
    }
        Session::put('filter', $filter);
    return view('admin.attorney_table_active.index',compact('data','filter'));
}

}