<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Minwagetable;

class MinWagetableController extends Controller

{
    function __construct()

    {

         $this->middleware('role:super admin');

    }

    public function index(Request $request)

    {


        $minwage = Minwagetable::orderBy('id','ASC')->first();

        return view('admin.minimumwage.index',compact('minwage'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('admin.pdfcredits.create');

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

            'effective_date' => 'required',

            'hourly_minimum_wage' => 'required'

        ]);


       $update = Minwagetable::where('id',1)->update(['effective_date'=>$request->effective_date,'hourly_minimum_wage'=>$request->hourly_minimum_wage]);

        return redirect()->route('minmumwage.index')

                        ->with('success','Minimum wage updated successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $pdfcredit = Pdfcredit::find($id);

        return view('admin.pdfcredits.show',compact('pdfcredit'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $pdfcredit = Pdfcredit::find($id);

        return view('admin.pdfcredits.edit',compact('pdfcredit'));

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

            'number_of_credits' => 'required',

            'purchase_price' => 'required'

        ]);


        $input = $request->all();

        $pdfcredit = Pdfcredit::find($id);

        $pdfcredit->update($input);

        return redirect()->route('pdfcredits.index')

                        ->with('success','PDF Credit updated successfully');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        Pdfcredit::find($id)->delete();

        return redirect()->route('pdfcredits.index')

                        ->with('success','PDF Credit deleted successfully');

    }

}