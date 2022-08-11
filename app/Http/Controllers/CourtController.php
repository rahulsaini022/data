<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Court;

use DB;

use Session;

use Auth;

class CourtController extends Controller

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

        // $data = Court::orderBy('id','DESC')->paginate(10);

        // return view('admin.courts.index',compact('data'))

        //     ->with('i', ($request->input('page', 1) - 1) * 5);

        $data = Court::orderBy('id','DESC')->get();

        return view('admin.courts.index',compact('data'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('admin.courts.create');

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
        
        $court = Court::create($input);


        return redirect()->route('courts.index')

                        ->with('success','Court created successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $court = Court::find($id);
        if($court){
        }else{
            return redirect()->route('courts.index')

                        ->with('error','Court not found.');
        }

        return view('admin.courts.show',compact('court'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $court = Court::find($id);



        return view('admin.courts.edit',compact('court'));

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

        $court = Court::find($id);
        $court->update($input);

        return redirect()->route('courts.index')

                        ->with('success','Court updated successfully');

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
        Court::find($id)->delete();

        return redirect()->route('courts.index')

                        ->with('success','Court deleted successfully');

    }

}
