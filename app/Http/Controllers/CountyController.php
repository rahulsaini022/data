<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\County;
use App\State;

use Illuminate\Support\Facades\DB;

use Session;

use Auth;

class CountyController extends Controller

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

            $draw = $request->get('draw');
            $start = $request->get("start");

            $rowperpage = $request->get("length"); // Rows display per page

            $columnIndex_arr = $request->get('order');
            $columnName_arr = $request->get('columns');
            $order_arr = $request->get('order');
            $search_arr = $request->get('search');
         
            $columnIndex = $columnIndex_arr[0]['column']; // Column index
            $columnName = $columnName_arr[$columnIndex]['data']; // Column name
            $columnSortOrder = $order_arr[0]['dir']; // asc or desc
            $searchValue = $search_arr['value']; // Search value
          
   
            $totalRecords = County::select('count(*) as allcount')->count();
            $totalRecordswithFilter = County::select('count(*) as allcount')->where('id', 'like', '%' . $searchValue . '%')->count();
            DB::statement(DB::raw('set @rownum=0'));
            // Fetch records
            $records = County::orderBy($columnName, $columnSortOrder)
                ->where('counties.state_abbreviation', 'like', '%' . $searchValue . '%')
                ->orWhere('counties.county_name', 'like', '%' . $searchValue . '%')
                ->orWhere('counties.county_designation', 'like', '%' . $searchValue . '%')

                ->skip($start)
                ->take($rowperpage)
                ->get([
                'counties.*',
                DB::raw('@rownum  := @rownum  + 1 AS rownum')
                ]);
            //  dd($records);
            $requ= $request->all();
            $data_arr = array();
            $sno = $start + 1;
            foreach ($records as $record) {
                $sno = $sno;
                $re=$record;
                $req= $requ;
                $id = $record->id;
                $county_name = $record->county_name;
                $state_abbreviation = $record->state_abbreviation;
                $county_designation = $record->county_designation;


                $data_arr[] = array(

                    'no' => $sno,
                    're'=> $re,
                    'request' => $req,
                    "county_name" => $county_name,
                    "state_abbreviation" => $state_abbreviation,
                    "county_designation" => $county_designation,
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
      ;
        $data = County::orderBy('id','DESC')->get();

        // return view('admin.counties.index',compact('data'))

        //     ->with('i', ($request->input('page', 1) - 1) * 5);

        // $data = County::orderBy('id','DESC')->get();

        return view('admin.counties.index',compact('data'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('admin.counties.create');

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

            'state_id' => 'required',
            
            'county_name' => 'required',
            
            'county_designation' => 'required',
            
            'county_active' => 'required',

        ]);

        $input = $request->all();
        $state=State::find($request->state_id);
        $input['state_abbreviation']=$state->state_abbreviation;
        $county = County::create($input);


        return redirect()->route('counties.index')

                        ->with('success','County created successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $county = County::find($id);
        if($county){
        }else{
            return redirect()->route('counties.index')

                        ->with('error','County not found.');
        }

        return view('admin.counties.show',compact('county'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $county = County::find($id);



        return view('admin.counties.edit',compact('county'));

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
        
        $this->validate($request, [

            'state_id' => 'required',
            
            'county_name' => 'required',
            
            'county_designation' => 'required',
            
            'county_active' => 'required',

        ]);


        $input = $request->all();
        $state=State::find($request->state_id);
        $input['state_abbreviation']=$state->state_abbreviation;
        $county = County::find($id);
        $county->update($input);

        return redirect()->route('counties.index')

                        ->with('success','County updated successfully');

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
        County::find($id)->delete();

        return redirect()->route('counties.index')

                        ->with('success','County deleted successfully');

    }

}
