<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\CustomerUploads;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB ;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class CustomerUploadsController extends Controller
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
    public function index()
    {
        $data = CustomerUploads::orderBy('id','DESC')->get();
        foreach($data as $key=>$val){

            $userdata = DB::table('users')->where('id',$val->user_id)->first();
            $val->username = $userdata->name;
            $val->create_date = date('d/m/Y',strtotime($val->created_at));
        }

        return view('admin.customeruploads.index',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $getdata = CustomerUploads::where('id',$id)->first();
        if(CustomerUploads::where('id',$id)->update(['status'=>1])){
           $file_name = $getdata->upload_document;
        File::move(public_path('uiodirs/OrchardSubmissions/'.$file_name), public_path('uiodirs/Orchard/'.$file_name));
        }

   return redirect()->route('customeruploads.index')->with('success', 'File approved successfully.');


    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = CustomerUploads::find($id);
        $file_name = $data->upload_document;
        if($data->status == 0){
            if($data->delete()){
            $path=( public_path() . '/uiodirs/OrchardSubmissions/'.$file_name);
           
            if(File::exists($path))
            {
                    unlink($path);
            }
           
             return redirect()->route('customeruploads.index')->with('success', 'File deleted successfully.');
            }
        }else{
            if($data->delete()){
            $path=public_path('uiodirs/Orchard/'.$file_name);
                if (File::exists($path)) {
                    unlink($path);
                }
            return redirect()->route('customeruploads.index')->with('success', 'File deleted successfully.');
            }
        }


    }

    /**
     * Update file status
     * @param $id
     * @return \Illuminate\Http\Response
     */

      public function updatefilestatus(Request $request)
     {


     }

     /* Download and delete file */
    public function download(Request $request){
      $file_name=$request->file_name;
      $data = CustomerUploads::where('upload_document',$file_name)->first();
      if($data->status == 0){
        $path=( public_path() . '/uiodirs/OrchardSubmissions/'.$file_name.'');
      }else{
        $path=( public_path() . '/uiodirs/Orchard/'.$file_name.'');
      }

      $headers = array(
            'Content-Type'=> 'application/pdf'
          );
        if(file_exists($path)){
            // $response=response()->download($path, $file_name, $headers);
            $response=response()->download($path, $file_name, $headers);


            return $response;
        } else {
         return redirect()->back()->with('error', 'File Does not Exist');   
        }
    }
}
