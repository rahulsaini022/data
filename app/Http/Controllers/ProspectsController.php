<?php
namespace App\Http\Controllers;


use Illuminate\Http\Request;
use App\ProspectiveClientTable;
use App\TriggerAttorneyself;
use App\Setting;
use Auth;
use Illuminate\Support\Facades\DB;
use App\DocumentTable;

class ProspectsController extends Controller

{
    function __construct()

    {


    }

    public function index()

    {

        $data = ProspectiveClientTable::where('attorney_id', Auth::user()->id)->orderBy('id','DESC')->get();

        return view('prospects.index',compact('data'));

    }


    /**

     * Show the form for creating a new resource.

     *

     * @return \Illuminate\Http\Response

     */

    public function create()

    {

        return view('prospects.create');

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

            'prosp_fname' => 'required',
            
            'prosp_lname' => 'required',

            // 'prosp_email' => 'required'

        ]);


        $input = $request->all();
        
        $input['attorney_id']=Auth::user()->id;

        $prospects = ProspectiveClientTable::create($input);

        return redirect()->route('prospects.index')

                        ->with('success','New prospect created successfully');

    }
    /**

     * Display the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function show($id)

    {
        $prospects = ProspectiveClientTable::find($id);
        if($prospects->attorney_id == Auth::user()->id){
            return view('prospects.show',compact('prospects'));
        } else {
            return redirect()->route('prospects.index')

                        ->with('error','Prospect not found.');
        }
    }

    /**

     * Show the form for editing the specified resource.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function edit($id)

    {

        $prospects = ProspectiveClientTable::find($id);

        if($prospects->attorney_id == Auth::user()->id){
            return view('prospects.edit',compact('prospects'));
        } else {
            return redirect()->route('prospects.index')

                        ->with('error','Prospect not found.');
        }

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

            'prosp_fname' => 'required',
            
            'prosp_lname' => 'required',

            // 'prosp_email' => 'required'

        ]);


        $input = $request->all();

        $prospects = ProspectiveClientTable::find($id);

        $prospects->update($input);

        return redirect()->route('prospects.index')

                        ->with('success','Prospect updated successfully');

    }

    /**

     * Remove the specified resource from storage.

     *

     * @param  int  $id

     * @return \Illuminate\Http\Response

     */

    public function destroy($id)

    {
        $prospects = ProspectiveClientTable::find($id);
        if($prospects->attorney_id == Auth::user()->id){
            $prospects->delete();
            return redirect()->route('prospects.index')

                        ->with('success','Prospect deleted successfully');
        } else {
            return redirect()->route('prospects.index')

                        ->with('error','Prospect not found.');
        }

    }

    public function draftProspect(Request $request)
    {
        // $prospect_id=$request->prospect_id;
        // $letter_intake_dropdown=$request->letter_intake_dropdown;
        // $data['attorney_id']=Auth::user()->id;
        // $data['doc_number']=$letter_intake_dropdown;
        // $data['prospect_id']=$prospect_id;
        // TriggerAttorneyself::create($data);

        $doc_number=$request->letter_intake_dropdown;
        $prospect_id=$request->prospect_id;
        $type = $request->doctype;
        $admin_email=Setting::where('setting_key', 'admin_email')->pluck('setting_value')->first();
        if(!$admin_email){
          $admin_email=env('APP_EMAIL');
        }

        // $triggers_attorneyself=DB::table('triggers_attorneyself')->insert(
        //     ['attorney_self_id' => Auth::user()->id, 'trigattorneyself' => $doc_number]
        // );
        // die('in process');

        /*if($doc_number == "BigProspTest Package"){
*/
            /* Fetch all the documents that need to be generated against the selected package. 
            /*$package_data = DB::table('document_package_table')->join('document_table', 'document_table.doc_number', '=', 'document_package_table.doc_id')->where('document_package_table.package_name',$doc_number) ->select('document_package_table.*', 'document_table.*')->get();*/


             /* Initiating the package record to start the document generation */
            $triggers_all_packages = DB::table('triggers_all_packages')->insertGetId(
                 ['attorney_self_id' => Auth::user()->id, 'trig_package' => $doc_number,'package_select'=> 1,'prospect_id'=>$prospect_id]
          );
             
         // foreach($package_data as $key=>$val){
             /*$triggers_attorneyself=DB::table('triggers_all_documents')->insert(
                ['attorney_self_id' => Auth::user()->id, 'doc_disp_name' => $val->doc_disp_name,'queryview'=>$val->queryview,'doc_number'=>$val->doc_number,'vote_dir'=>$val->vote_dir,'trig_package'=>$doc_number,'trig'=>1,'prospect_id'=>$prospect_id,'p_id'=>$triggers_all_packages]
            );*/
        // }
            $user_id = Auth::user()->id;
            /* call the procedure to update the package_select 0 */ 
            DB::select("CALL packages2docs(?,?)",[$user_id,0]);
           

            $votes=DB::table('FDD_triggers_all_documents_Votes')->get();
            $success_macros=0;
            $failed_macros=0;
            foreach($votes as $vote){
                exec('touch '.$vote->vote_dir.'', $output, $return);
                //sleep(1);
                // Return will return non-zero upon an error
                if (!$return)
                {
                  ++$success_macros;
                      // sleep(3);
                      
                      // return redirect()->route('get_practice_aids_downloads');                  

                } else {
                      // $response= "PDF not created";
                      ++$failed_macros;
                }
             }

        
        /*/*}else
        {

            /* Fetch all the documents that need to be generated against the selected package. 
           /* $package_data = DB::table('document_package_table')->join('document_table', 'document_table.doc_number', '=', 'document_package_table.doc_id')->where('document_package_table.package_name',$doc_number) ->select('document_package_table.*', 'document_table.*')->first();*/
            
            /* Initiating the package record to start the document generation 
            /*$triggers_all_packages = DB::table('triggers_all_packages')->insertGetId(
                 ['attorney_self_id' => Auth::user()->id, 'trig_package' => $doc_number,'package_select'=> 1,'prospect_id'=>$prospect_id]
          );*/
          
             /*$triggers_attorneyself=DB::table('triggers_all_documents')->insert(
                ['attorney_self_id' => Auth::user()->id, 'doc_disp_name' => $package_data->doc_disp_name,'queryview'=>$package_data->queryview,'doc_number'=>$package_data->doc_number,'vote_dir'=>$package_data->vote_dir,'trig_package'=>$doc_number,'trig'=>1,'prospect_id'=>$prospect_id,'p_id'=>$triggers_all_packages]
            );
       
    }*/
        
        
        return redirect()->route('attorney.downloads')->with('success', 'Your drafts will be available in your download directory soon. If you do not see your file here after a few seconds then please try again or email us.');
        // $document_out_format=DocumentTable::where('doc_number', $doc_number)->pluck('document_out_format')->first();
        // if($triggers_attorneyself && isset($document_out_format) && strtolower($document_out_format)=='doc'){
        //     //sleep(2);

        //     exec('touch /var/www/html/public/LatchProcessing/LatchVotes/FDD_View_Prospect_DOC/junk.txt', $output, $return);
        //                 // Return will return non-zero upon an error
        //     if (!$return)
        //     {
        //           // sleep(3);
        //           return redirect()->route('attorney.downloads')->with('success', 'Your drafts will be available in your download directory soon. If you do not see your file here after a few seconds then please try again or Email Us.');
        //           // return redirect()->route('get_practice_aids_downloads');                  

        //     } else {
        //           // $response= "PDF not created";
        //           echo $errmsg="Sorry, File that you are trying to download is not available yet. Please <a href='mailto:".$admin_email."'>check</a> with admin for more details"; die;
        //     }

        // } else if($triggers_attorneyself && isset($document_out_format) && strtolower($document_out_format)=='pdf'){
        //     sleep(2);
        //     exec('touch /var/www/html/public/LatchProcessing/LatchVotes/FDD_View_Prospect_PDF/junk.txt', $output, $return);
        //                 // Return will return non-zero upon an error
        //     if (!$return)
        //     {
        //           // sleep(3);
        //           return redirect()->route('attorney.downloads')->with('success', 'Your drafts will be available in your download directory soon. If you do not see your file here after a few seconds then please try again or Email Us.');
        //           // return redirect()->route('get_practice_aids_downloads');                  

        //     } else {
        //           // $response= "PDF not created";
        //           echo $errmsg="Sorry, File that you are trying to download is not available yet. Please <a href='mailto:".$admin_email."'>check</a> with admin for more details"; die;
        //     }

        // } else {
        //     return redirect()->back()->with('error', 'File does not exist.');
        // }

        //return redirect()->route('prospects.index')

                       // ->with('success','Prospect drafted successfully');
    }

    public function create_case($prospect_id)
    {
        // return view('case.create');
        return view('case.create_case',['prospect_id' => $prospect_id]);
    }

}