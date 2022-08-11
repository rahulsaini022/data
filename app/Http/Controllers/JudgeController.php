<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Judge;

use App\Courtcase;

use DB;

use Session;

use Auth;

class JudgeController extends Controller

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

        // $data = Judge::orderBy('id','DESC')->paginate(10);

        // return view('admin.judges.index',compact('data'))

        //     ->with('i', ($request->input('page', 1) - 1) * 5);

        $data = Judge::orderBy('id','DESC')->get();

        return view('admin.judges.index',compact('data'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('admin.judges.create');

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

            'adjudicator' => 'required',
            
            'adjudicator_lname' => 'required',

            'adj_title' => 'required',

        ]);

        $input = $request->all();
        $input['last_update']=date('Y-m-d');
        $input['last_updatevalue']=date('Y-m-d');
        $judge = Judge::create($input);


        return redirect()->route('judges.index')

                        ->with('success','Judge created successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $judge = Judge::find($id);
        if($judge){
        }else{
            return redirect()->route('judges.index')

                        ->with('error','Judge not found.');
        }

        return view('admin.judges.show',compact('judge'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $judge = Judge::find($id);



        return view('admin.judges.edit',compact('judge'));

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

            'adjudicator' => 'required',
            
            'adjudicator_lname' => 'required',
            
            'adj_title' => 'required',

        ]);


        $input = $request->all();
        $input['last_update']=date('Y-m-d');
        $input['last_updatevalue']=date('Y-m-d');

        $judge = Judge::find($id);

        $judge->update($input);

        // to update judge info in courtcases table
        $update_courtcase_judge=Courtcase::where('judge_id', $id) ->update(array('judge_name' => $judge->adjudicator));
        $update_courtcase_original_judge=Courtcase::where('original_judge_id', $id) ->update(array('original_judge_name' => $judge->adjudicator));


        return redirect()->route('judges.index')

                        ->with('success','Judge updated successfully');

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
        Judge::find($id)->delete();

        return redirect()->route('judges.index')

                        ->with('success','Judge deleted successfully');

    }

}