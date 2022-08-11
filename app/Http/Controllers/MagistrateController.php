<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Magistrate;

use App\Court;

use App\Courtcase;

use DB;

use Session;

use Auth;

class MagistrateController extends Controller

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

        // $data = Magistrate::orderBy('id','DESC')->paginate(10);

        // return view('admin.magistrates.index',compact('data'))

        //     ->with('i', ($request->input('page', 1) - 1) * 5);

        $data = Magistrate::orderBy('id','DESC')->get();

        return view('admin.magistrates.index',compact('data'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {
        $courts = Court::pluck('name', 'id');
        return view('admin.magistrates.create', compact('courts'));

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

            'mag_name' => 'required',
            
            'mag_last_name' => 'required',
            
            'mag_title' => 'required',
            
        ]);

        $input = $request->all();
        $input['last_update']=date('Y-m-d');
        $input['last_updatevalue']=date('Y-m-d');

        $court = Court::find($request->court_id);
        $input['mag_court_name']=$court->name;
        
        $magistrate = Magistrate::create($input);


        return redirect()->route('magistrates.index')

                        ->with('success','Magistrate created successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $magistrate = Magistrate::find($id);
        if($magistrate){
        }else{
            return redirect()->route('magistrates.index')

                        ->with('error','Magistrate not found.');
        }

        return view('admin.magistrates.show',compact('magistrate'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $magistrate = Magistrate::find($id); 
        $courts = Court::pluck('name', 'id');   
        if($magistrate){
            return view('admin.magistrates.edit',compact('magistrate', 'courts'));
        } else {
            return redirect()->route('magistrates.index')

                        ->with('error','Magistrate not found');
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

            'mag_name' => 'required',
            
            'mag_last_name' => 'required',
            
            'mag_title' => 'required',
            
        ]);


        $input = $request->all();
        $input['last_update']=date('Y-m-d');
        $input['last_updatevalue']=date('Y-m-d');

        $court = Court::find($request->court_id);
        $input['mag_court_name']=$court->name;

        $magistrate = Magistrate::find($id);

        $magistrate->update($input);

        // to update magistrate info in courtcases table
        $update_courtcase_magistrate=Courtcase::where('magistrate_id', $id) ->update(array('magistrate_name' => $magistrate->mag_name));
        $update_courtcase_original_magistrate=Courtcase::where('original_magistrate_id', $id) ->update(array('original_magistrate_name' => $magistrate->mag_name));

        return redirect()->route('magistrates.index')

                        ->with('success','Magistrate updated successfully');

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
        Magistrate::find($id)->delete();

        return redirect()->route('magistrates.index')

                        ->with('success','Magistrate deleted successfully');

    }

}