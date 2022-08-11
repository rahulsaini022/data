<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Division;

use DB;

use Session;

use Auth;

class DivisionController extends Controller

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

        // $data = Division::orderBy('id','DESC')->paginate(10);

        // return view('admin.divisions.index',compact('data'))

        //     ->with('i', ($request->input('page', 1) - 1) * 5);

        $data = Division::orderBy('id','DESC')->get();

        return view('admin.divisions.index',compact('data'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('admin.divisions.create');

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

            'name' => 'required',
        ]);

        $input = $request->all();
        
        $division = Division::create($input);


        return redirect()->route('divisions.index')

                        ->with('success','Division created successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $division = Division::find($id);
        if($division){
        }else{
            return redirect()->route('divisions.index')

                        ->with('error','Division not found.');
        }

        return view('admin.divisions.show',compact('division'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $division = Division::find($id);



        return view('admin.divisions.edit',compact('division'));

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

            'name' => 'required',
            
        ]);


        $input = $request->all();

        $division = Division::find($id);
        $division->update($input);

        return redirect()->route('divisions.index')

                        ->with('success','Division updated successfully');

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
        Division::find($id)->delete();

        return redirect()->route('divisions.index')

                        ->with('success','Division deleted successfully');

    }

}
