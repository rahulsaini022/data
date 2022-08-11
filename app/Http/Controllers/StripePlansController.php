<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\StripePlan;

class StripePlansController extends Controller

{
    function __construct()

    {

         $this->middleware('role:super admin');

    }

    public function index(Request $request)

    {


        $data = StripePlan::orderBy('id','DESC')->get();

        return view('admin.stripe_plans.index',compact('data'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('admin.stripe_plans.create');

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

            'plan_id' => 'required',

            'plan_name' => 'required'

        ]);


        $input = $request->all();
        
        $stripeplans = StripePlan::create($input);

        return redirect()->route('stripeplans.index')

                        ->with('success','New stripe plan created successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $stripeplans = StripePlan::find($id);

        return view('admin.stripe_plans.show',compact('stripeplans'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $stripeplans = StripePlan::find($id);

        return view('admin.stripe_plans.edit',compact('stripeplans'));

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

            'plan_id' => 'required',

            'plan_name' => 'required'

        ]);


        $input = $request->all();

        $stripeplans = StripePlan::find($id);

        $stripeplans->update($input);

        return redirect()->route('stripeplans.index')

                        ->with('success','Stripe plan updated successfully');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {
        die('not valid');
        StripePlan::find($id)->delete();

        return redirect()->route('stripeplans.index')

                        ->with('success','Stripe plan deleted successfully');

    }

}