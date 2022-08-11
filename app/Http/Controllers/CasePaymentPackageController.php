<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\CasePaymentPackage;
use Illuminate\Support\Facades\DB;


class CasePaymentPackageController extends Controller

{
    function __construct()

    {

         $this->middleware('role:super admin');

    }

    public function index(Request $request)

    {


        $data = CasePaymentPackage::orderBy('id','DESC')->get();

        return view('admin.case-packages.index',compact('data'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {
        $case_types=DB::table('case_types')->get()->all();
        return view('admin.case-packages.create', compact('case_types'));

    }


    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        $messages = [
            'case_type_ids.required' => 'Case Types field is required.',
        ];
        $this->validate($request, [

            'package_title' => 'required',
            
            'package_description' => 'required',

            'package_price' => 'required',
            
            'active' => 'required',
            
            'case_type_ids' => 'required',

        ], $messages);


        $input = $request->all();
        if(isset($input['case_type_ids']) && is_array($input['case_type_ids'])){
            $input['case_type_ids'] = implode(",",$input['case_type_ids']);
        } else {
            $input['case_type_ids'] = NULL;
        }

        $package = CasePaymentPackage::create($input);

        return redirect()->route('casepaymentpackages.index')

                        ->with('success','New package created successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $package = CasePaymentPackage::find($id);
        $case_type_ids = explode(",",$package->case_type_ids);
        $case_types=DB::table('case_types')->whereIn('id', $case_type_ids)->get()->all();
        return view('admin.case-packages.show',compact('package', 'case_types'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $package = CasePaymentPackage::find($id);
        $case_types=DB::table('case_types')->get()->all();

        return view('admin.case-packages.edit',compact('package', 'case_types'));

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
        $messages = [
            'case_type_ids.required' => 'Case Types field is required.',
        ];
        $this->validate($request, [

            'package_title' => 'required',
            
            'package_description' => 'required',

            'package_price' => 'required',
            
            'active' => 'required',
            
            'case_type_ids' => 'required',

        ], $messages);


        $input = $request->all();
        if(isset($input['case_type_ids']) && is_array($input['case_type_ids'])){
            $input['case_type_ids'] = implode(",",$input['case_type_ids']);
        } else {
            $input['case_type_ids'] = NULL;
        }

        $package = CasePaymentPackage::find($id);

        $package->update($input);

        return redirect()->route('casepaymentpackages.index')

                        ->with('success','Package updated successfully');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        CasePaymentPackage::find($id)->delete();

        return redirect()->route('casepaymentpackages.index')

                        ->with('success','Package deleted successfully');

    }

    public function deactivate($id){
        $package=CasePaymentPackage::find($id);
        $package->active='0';
        $package->save();

        return redirect()->route('casepaymentpackages.index')

                        ->with('success','Package deactivated successfully');
    }

    public function activate($id){
        $package=CasePaymentPackage::find($id);
        $package->active='1';
        $package->save();

        return redirect()->route('casepaymentpackages.index')

                        ->with('success','Package activated successfully');
    }

}