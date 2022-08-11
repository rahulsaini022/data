<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\State;

use DB;

use Session;

use Auth;

class StateController extends Controller

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

        // $data = State::orderBy('id','DESC')->paginate(10);

        // return view('admin.states.index',compact('data'))

        //     ->with('i', ($request->input('page', 1) - 1) * 5);

        $data = State::orderBy('id','DESC')->get();

        return view('admin.states.index',compact('data'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('admin.states.create');

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

            'state' => 'required',
            
            'state_abbreviation' => 'required',
            
            'active' => 'required',

        ]);

        $input = $request->all();
        
        $state = State::create($input);


        return redirect()->route('states.index')

                        ->with('success','State created successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $state = State::find($id);
        if($state){
        }else{
            return redirect()->route('states.index')

                        ->with('error','State not found.');
        }

        return view('admin.states.show',compact('state'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $state = State::find($id);



        return view('admin.states.edit',compact('state'));

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

            'state' => 'required',
            
            'state_abbreviation' => 'required',

        ]);


        $input = $request->all();

        $state = State::find($id);
        $state->update($input);

        return redirect()->route('states.index')

                        ->with('success','State updated successfully');

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
        State::find($id)->delete();

        return redirect()->route('states.index')

                        ->with('success','State deleted successfully');

    }

    public function deactivate($id){
        $state=State::find($id);
        $state->active='0';
        $state->save();

        return redirect()->route('states.index')

                        ->with('success','State deactivated successfully');
    }

    public function activate($id){
        $state=State::find($id);
        $state->active='1';
        $state->save();

        return redirect()->route('states.index')

                        ->with('success','State activated successfully');
    }

}
