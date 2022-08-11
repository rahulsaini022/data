<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

use App\Clerk;

use DB;

use Session;

use Auth;

class ClerkController extends Controller

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

        // $data = Clerk::orderBy('id','DESC')->paginate(10);

        // return view('admin.clerks.index',compact('data'))

        //     ->with('i', ($request->input('page', 1) - 1) * 5);

        $data = Clerk::orderBy('id','DESC')->get();

        return view('admin.clerks.index',compact('data'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('admin.clerks.create');

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

            'clerkname' => 'required',
            
            'clerktitle' => 'required',

        ]);

        $input = $request->all();
        $input['last_update']=date('Y-m-d');
        $input['last_updatevalue']=date('Y-m-d');
        
        $clerk = Clerk::create($input);


        return redirect()->route('clerks.index')

                        ->with('success','Clerk created successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $clerk = Clerk::find($id);
        if($clerk){
        }else{
            return redirect()->route('clerks.index')

                        ->with('error','Clerk not found.');
        }

        return view('admin.clerks.show',compact('clerk'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $clerk = Clerk::find($id);



        return view('admin.clerks.edit',compact('clerk'));

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

            'clerkname' => 'required',
            
            'clerktitle' => 'required',

        ]);


        $input = $request->all();
        $input['last_update']=date('Y-m-d');
        $input['last_updatevalue']=date('Y-m-d');

        $clerk = Clerk::find($id);
        $clerk->update($input);

        return redirect()->route('clerks.index')

                        ->with('success','Clerk updated successfully');

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
        Clerk::find($id)->delete();

        return redirect()->route('clerks.index')

                        ->with('success','Clerk deleted successfully');

    }

}
