<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Price;

class PriceController extends Controller

{
    function __construct()

    {

         $this->middleware('role:super admin');

    }

    public function index(Request $request)

    {


        $data = Price::orderBy('id','DESC')->get();

        return view('admin.prices.index',compact('data'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('admin.prices.create');

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

            'title' => 'required',

            'full_price' => 'required'

        ]);


        $input = $request->all();
        
        $price = Price::create($input);

        return redirect()->route('prices.index')

                        ->with('success','New Pricing created successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $price = Price::find($id);

        return view('admin.prices.show',compact('price'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $price = Price::find($id);

        return view('admin.prices.edit',compact('price'));

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

            'title' => 'required',

            'full_price' => 'required'

        ]);


        $input = $request->all();

        $price = Price::find($id);

        $price->update($input);

        return redirect()->route('prices.index')

                        ->with('success','Pricing updated successfully');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        Price::find($id)->delete();

        return redirect()->route('prices.index')

                        ->with('success','Pricing deleted successfully');

    }

}