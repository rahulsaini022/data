<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\Document;

class DocumentTableController extends Controller

{
    function __construct()

    {

         $this->middleware('role:super admin');

    }

    public function index(Request $request)

    {

        die;
        $data = Document::orderBy('id','ASC')->get();

        return view('admin.documenttable.index',compact('data'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('admin.documenttable.create');

    }


    /**

     * Store a newly created resource in storage.

     *

     * @param  \Illuminate\Http\Request  $request

     * @return \Illuminate\Http\Response

     */

    public function store(Request $request)

    {

        // $this->validate($request, [

        //     'number_of_credits' => 'required',

        //     'purchase_price' => 'required'

        // ]);


        $input = $request->all();

        if(isset($input['textinputdate1'])){
            $input['textinputdate1']=date("Y-m-d",strtotime($input['textinputdate1']));
        } else {
            $input['textinputdate1']=NULL;
        }

        if(isset($input['textinputdate2'])){
            $input['textinputdate2']=date("Y-m-d",strtotime($input['textinputdate2']));
        } else {
            $input['textinputdate2']=NULL;
        }

        if(isset($input['textinputdate3'])){
            $input['textinputdate3']=date("Y-m-d",strtotime($input['textinputdate3']));
        } else {
            $input['textinputdate3']=NULL;
        }

        if(isset($input['textinputdate4'])){
            $input['textinputdate4']=date("Y-m-d",strtotime($input['textinputdate4']));
        } else {
            $input['textinputdate4']=NULL;
        }

        if(isset($input['textinputdate5'])){
            $input['textinputdate5']=date("Y-m-d",strtotime($input['textinputdate5']));
        } else {
            $input['textinputdate5']=NULL;
        }
        
        $document = Document::create($input);

        return redirect()->route('documenttable.index')

                        ->with('success','New Document Table Record created successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $document = Document::find($id);

        return view('admin.documenttable.show',compact('document'));
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $document = Document::find($id);

        return view('admin.documenttable.edit',compact('document'));

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

        // $this->validate($request, [

        //     'number_of_credits' => 'required',

        //     'purchase_price' => 'required'

        // ]);


        $input = $request->all();
        if(isset($input['textinputdate1'])){
            $input['textinputdate1']=date("Y-m-d",strtotime($input['textinputdate1']));
        } else {
            $input['textinputdate1']=NULL;
        }

        if(isset($input['textinputdate2'])){
            $input['textinputdate2']=date("Y-m-d",strtotime($input['textinputdate2']));
        } else {
            $input['textinputdate2']=NULL;
        }

        if(isset($input['textinputdate3'])){
            $input['textinputdate3']=date("Y-m-d",strtotime($input['textinputdate3']));
        } else {
            $input['textinputdate3']=NULL;
        }

        if(isset($input['textinputdate4'])){
            $input['textinputdate4']=date("Y-m-d",strtotime($input['textinputdate4']));
        } else {
            $input['textinputdate4']=NULL;
        }

        if(isset($input['textinputdate5'])){
            $input['textinputdate5']=date("Y-m-d",strtotime($input['textinputdate5']));
        } else {
            $input['textinputdate5']=NULL;
        }

        $document = Document::find($id);

        $document->update($input);

        return redirect()->route('documenttable.index')

                        ->with('success','Document Table Record updated successfully');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {

        Document::find($id)->delete();

        return redirect()->route('documenttable.index')

                        ->with('success','Document Table Record deleted successfully');

    }

}