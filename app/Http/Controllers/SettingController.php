<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Setting;

class SettingController extends Controller

{
    function __construct()

    {

         $this->middleware('role:super admin');

    }

    public function index(Request $request)

    {


        $data = Setting::orderBy('id','DESC')->get();

        return view('admin.settings.index',compact('data'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('admin.settings.create');

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

            'setting_label' => 'required',

            'setting_key' => 'required',
            
            'setting_value' => 'required'

        ]);


        $input = $request->all();
        
        $setting = Setting::create($input);

        return redirect()->route('settings.index')

                        ->with('success','New Setting created successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $setting = Setting::find($id);

        return view('admin.settings.show',compact('setting'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $setting = Setting::find($id);

        return view('admin.settings.edit',compact('setting'));

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

            'setting_label' => 'required',

            'setting_key' => 'required',
            
            'setting_value' => 'required'

        ]);


        $input = $request->all();

        $setting = Setting::find($id);

        $setting->update($input);

        return redirect()->route('settings.index')

                        ->with('success','Setting updated successfully');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        Setting::find($id)->delete();

        return redirect()->route('settings.index')

                        ->with('success','Setting deleted successfully');

    }

}