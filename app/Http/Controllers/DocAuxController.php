<?php
namespace App\Http\Controllers;


use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\AuxTable;

class DocAuxController extends Controller

{
    function __construct()

    {

         $this->middleware('role:attorney');

    }

    public function getPopupDynamicForm()
    {
        
        return view('doc_aux.popup_dynamic_form');
    }

    public function getPopupDynamicFormFields(Request $request){
        $document_id=$request->document_id;
        $get_fields = DB::table('test_doc_table')
                        ->where('id', $document_id)
                        ->first();
        if($get_fields)
        {
            echo json_encode($get_fields);
        } else {
            echo "null";
        }
    }
    
    public function storeDynamicPopupFormData(Request $request){
        $form_data= $request->except('submit', '_token');
        foreach($form_data as $key=>$value)
        {
            if(isset($form_data[$key]) && stristr($key,'date')!==FALSE){
                $time_input = strtotime($form_data[$key]);
                $date_input = date('Y-m-d', $time_input);
                $form_data[$key]=$date_input;
            }
        }
        
        // dd($form_data);

        $aux_table_data=AuxTable::create($form_data);

        return redirect()->route('get_popup_form')->with('success','Data Submitted Successfully.');

    }

}