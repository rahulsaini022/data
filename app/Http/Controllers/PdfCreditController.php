<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Pdfcredit;

class PdfCreditController extends Controller

{
    function __construct()

    {

         $this->middleware('role:super admin');

    }

    public function index(Request $request)

    {


        $data = Pdfcredit::orderBy('id','ASC')->get();

        return view('admin.pdfcredits.index',compact('data'));

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

            'number_of_credits' => 'required',

            'purchase_price' => 'required'

        ]);


        $input = $request->all();
        
        $pdfcredit = Pdfcredit::create($input);

        return redirect()->route('pdfcredits.index')

                        ->with('success','New PDF credit created successfully');

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

                        ->with('success','PDF credit updated successfully');

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

                        ->with('success','PDF credit deleted successfully');

    }

}