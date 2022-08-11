<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\User;
use App\Attorney;
use App\Download;
use App\Setting;
use App\State;
use App\Pdfcredit;
use App\Usercredithistory;
use  Illuminate\Support\Facades\Redirect;
use  Illuminate\Support\Facades\Auth;
use  Illuminate\Support\Facades\File;
use Carbon\Carbon;

class FddToolsController extends Controller

{
    /* Show FDD Tools List */
    public function index()
    {
        $id=Auth::user()->id;
    	$attorney=User::find($id);
    	if(Auth::user()->id == $attorney->id && Auth::user()->hasRole('attorney'))
		{
            //$ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
            //$OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
            //$other_data=array('OH_Minimum_Wage' => $OH_Minimum_Wage);
		    //return view('fdd_tools.index',['attorney'=>$attorney, 'attorney_data' =>$attorney_data, 'other_data' => $other_data]);
            // $path=( public_path() . '/uiodirs/'.Auth::user()->id.'/download/');
            // $files = File::allfiles($path);
            // $files_data=Download::where('attorney_id', Auth::user()->id)->orderBy('created_at', 'DESC')->get()->all();
            // $settings=Setting::get()->all();

            // return view('fdd_tools.index',['attorney'=>$attorney, 'attorney_data' =>$attorney_data, 'files_data'=>$files]);
            return view('fdd_tools.index');
		} else {
            return redirect()->route('home');
        }
    }

    // to compress pdf file
    public function squeezPdf(Request $request){
        // old code
        // $file=$request->file('file_to_compress');
        // $compress_level=$request->compress_level;
        // if($compress_level==''){
        //     $compress_level='recommended';
        // }
        // $now = Carbon::now();
        // // $current_timestamp=Carbon::createFromFormat('m/d/Y', Carbon::now());
        // $current_timestamp =$now->format('mdYHis');
        // $original_name = $file->getClientOriginalName();
        // $base_filename = preg_replace("/\.[^.]+$/", "", $original_name);

        // $file->move(public_path() . '/uiodirs/pdftocompress/', Auth::user()->id.'_'.$current_timestamp.'_'.$file->getClientOriginalName());
        // // dd($request->file('file_to_compress'));
        // $public_project_key = env("ILOVEPDF_PROJECT_PUBLIC_KEY");
        // $secret_project_key = env("ILOVEPDF_PROJECT_SECRET_KEY");
        // include(base_path() . '/vendor/ilovepdf/ilovepdf_php/init.php');
        // $ilovepdf = new \Ilovepdf\Ilovepdf($public_project_key, $secret_project_key);
        // $filepath=( public_path() . '/uiodirs/pdftocompress/'.Auth::user()->id.'_'.$current_timestamp.'_'.$file->getClientOriginalName());
        // // $base_filename = Auth::user()->id.'_'.$current_timestamp.'_'.$file->getClientOriginalName();
        // // $base_filename = pathinfo($file, PATHINFO_FILENAME);
        // $downloadpath=( public_path() . '/uiodirs/'.Auth::user()->id.'/download/');
        // $ilovepdf->verifySsl(false);
        // $ilovepdf->timeoutLarge = 606060;
        // $myTask = $ilovepdf->newTask('compress');
        // $myTask->setCompressionLevel($compress_level);//low, recommended, extreme;
        // $myTask->addFile($filepath);
        // $output_file_name=$base_filename.'_compressed_'.$current_timestamp.'.pdf';
        // // $output_file_name=Auth::user()->id.'_'.$filename;
        // $myTask->setOutputFilename($output_file_name);
        // $myTask->execute();
        // $myTask->download($downloadpath);
        // if(file_exists($filepath)){
        //     File::delete($filepath);
        // } else {
        //   // die('File Does not Exist');
        // }
        // sleep(3);
        // return redirect()->route('fdd_tools.pdf_tools_downloads');


        // // var_dump($myTask); die('here');
        // // download file at user browser
        // // $download_output_file_name=$base_filename.'_'.Auth::user()->id.'.pdf';
        // // $download_output_file_name='Compressed_'.Auth::user()->id.'_file.pdf';

        // // following code is for downloading the compressed file for user
        // // $path=( public_path() . '/uiodirs/fordistribution/'.$output_file_name.'');
        // // $headers = array(
        // //     'Content-Type'=> 'application/pdf'
        // //   );
        // // if(file_exists($path)){
        // //     $response=response()->download($path, $output_file_name, $headers);
        // //     // $response=response()->download($path, $output_file_name, $headers)->deleteFileAfterSend();
        // //     ob_end_clean();
        // //     return $response;
        // // } else {
        // //   die('File Does not Exist');
        // // }

        // // var_dump($ilovepdf);
        // // die('here');
        // // return redirect()->route('fdd_tools')->with('success', 'PDF Squeezed Successfully!');
        // // end of old code
        // /var/www/html/public/FDD_PDF_Tools/FDD_PDF_Squeezer/InputPDF_Documents
        $user=User::find(Auth::user()->id);
        $old_credits=$user->credits;
        if($old_credits < 2 ){
            return redirect()->route('fdd_tools.pdf_tools')->with('error', 'Your Credit Balanace is not sufficient for this service. Please buy PDF Credits to use this service.');
        }
        $file=$request->file('file_to_compress');
        $file->move(public_path() . '/FDD_PDF_Tools/FDD_PDF_Squeezer/InputPDF_Documents/', Auth::user()->id.'_'.$file->getClientOriginalName());
        sleep(2);
        exec('bash /var/www/html/public/FDD_PDF_Tools/FDD_PDF_Squeezer/FDD_PDF_Squeezer.sh '.Auth::user()->id.'', $output, $return);
                        // Return will return non-zero upon an error
        if (!$return)
        {
            // sleep(3);
            // sub 2 credits to attorney account for new file processed.
            $new_credits=$old_credits - 2;
            $user->credits=$new_credits;
            $user->save();

            // to update user credit history
            $history= array(
                'user_id' => $user->id,
                'source' => 'User',
                'source_id' => NULL,
                'type' => 'debit',
                'number_of_credited_debited' => '2',
                'description' => '2 FDD CREDITS DEBITED FROM '.$user->name.'’s ACCOUNT FOR SQUEEZING A PDF FILE DATED '.date('m-d-Y'),
                'created_at' => now(),
                'updated_at' => now(),
            );
            $user_credits_history=Usercredithistory::create($history);
            // return redirect()->route('fdd_tools.pdf_tools_downloads');
            return redirect()->route('attorney.downloads')->with('success', 'Your drafts will be available in your download directory soon. If you do not see your file here after a few seconds then please try again or Email Us.');

        } else {
            die('Something went wrong. Please try again.');
        }

    }
     /* Show PDF Tools Processed Files */
    public function getPdfToolsDownloads(){
        // $path=( public_path() . '/uiodirs/'.Auth::user()->id.'/download/');
        // $files = File::allfiles($path);
        // // dd($files);
        $path=( public_path() . '/uiodirs/'.Auth::user()->id.'/download/');
        if(File::isDirectory($path)){
        } else {
            return redirect()->route('home')->with('error', 'Something went Wrong. Please contact Administrator.');
        }
        $files = collect(File::allfiles($path))->sortByDesc(function ($file) {
            return $file->getCTime();
        });

        return view('fdd_tools.download_pdf_tools_files',['files_data'=>$files]);
    }

    // to PDF OCR Ripper
    // public function pdfOcrRipper(Request $request){
    //     $user=User::find(Auth::user()->id);
    //     $old_credits=$user->credits;
    //     if($old_credits < 2 ){
    //         return redirect()->route('fdd_tools.pdf_tools')->with('error', 'Your Credit Balanace is not sufficient for this service. Please buy PDF Credits to use this service.');
    //     }

    //     $file=$request->file('file_to_ocrrip');
    //     $file->move(public_path() . '/FDD_PDF_Tools/FDD_PDF_OCR_Ripper/InputPDF_Documents/', $file->getClientOriginalName());
        // sleep(2);
    //     exec('bash /var/www/html/public/FDD_PDF_Toos/FDD_PDF_OCR_Ripper/FDD_PDF_OCRRipper.sh '.Auth::user()->id.'', $output, $return);
    //                     // Return will return non-zero upon an error
    //     if (!$return)
    //     {
    //         sleep(3);
    //         // sub 2 credits to attorney account for new file processed.
    //         // $user=User::find(Auth::user()->id);
    //         // $old_credits=$user->credits;
    //         $new_credits=$old_credits - 2;
    //         $user->credits=$new_credits;
    //         $user->save();

    //         // to update user credit history
    //         $history= array(
    //             'user_id' => $user->id,
    //             'source' => 'User',
    //             'source_id' => NULL,
    //             'type' => 'debit',
    //             'number_of_credited_debited' => '2',
    //             'description' => '2 FDD CREDITS DEBITED FROM '.$user->name.'’s ACCOUNT FOR RIPPING A PDF FILE DATED '.date('m-d-Y'),
    //             'created_at' => now(),
    //             'updated_at' => now(),
    //         );
    //         $user_credits_history=Usercredithistory::create($history);
    //         return redirect()->route('fdd_tools.pdf_tools_downloads');
    //     } else {
    //         die('Something went wrong. Please try again.');
    //     }
    // }

    // Use PDF Scrubber Tool
    public function pdfScrubber(Request $request){
        $user=User::find(Auth::user()->id);
        $old_credits=$user->credits;
        if($old_credits < 1 ){
            return redirect()->route('fdd_tools.pdf_tools')->with('error', 'Your Credit Balanace is not sufficient for this service. Please buy PDF Credits to use this service.');
        }

        $file=$request->file('file_to_super_scrub');
        $file->move(public_path() . '/FDD_PDF_Tools/FDD_PDF_Scrubber/InputPDF_Documents/', Auth::user()->id.'_'.$file->getClientOriginalName());
        sleep(2);
        exec('bash /var/www/html/public/FDD_PDF_Tools/FDD_PDF_Scrubber/FDD_PDF_Scrubber.sh '.Auth::user()->id.'', $output, $return);
                        // Return will return non-zero upon an error
        if (!$return)
        {
            // sleep(3);
            // sub 1 credits to attorney account for new file processed.
            // $user=User::find(Auth::user()->id);
            // $old_credits=$user->credits;
            $new_credits=$old_credits - 1;
            $user->credits=$new_credits;
            $user->save();

            // to update user credit history
            $history= array(
                'user_id' => $user->id,
                'source' => 'User',
                'source_id' => NULL,
                'type' => 'debit',
                'number_of_credited_debited' => '1',
                'description' => '1 FDD CREDITS DEBITED FROM '.$user->name.'’s ACCOUNT FOR SCRUBBING A PDF FILE DATED '.date('m-d-Y'),
                'created_at' => now(),
                'updated_at' => now(),
            );
            $user_credits_history=Usercredithistory::create($history);
            // return redirect()->route('fdd_tools.pdf_tools_downloads');
            return redirect()->route('attorney.downloads')->with('success', 'Your drafts will be available in your download directory soon. If you do not see your file here after a few seconds then please try again or Email Us.');

        } else {
            die('Something went wrong. Please try again.');
        }
    }

    // Use PDF Fixer Tool
    public function pdfFixer(Request $request){
        $user=User::find(Auth::user()->id);
        $old_credits=$user->credits;
        if($old_credits < 1 ){
            return redirect()->route('fdd_tools.pdf_tools')->with('error', 'Your Credit Balanace is not sufficient for this service. Please buy PDF Credits to use this service.');
        }

        $file=$request->file('file_to_fix');
        $file->move(public_path() . '/FDD_PDF_Tools/FDD_PDF_Fixer/InputPDF_Documents/', Auth::user()->id.'_'.$file->getClientOriginalName());
        sleep(2);
        exec('bash /var/www/html/public/FDD_PDF_Tools/FDD_PDF_Fixer/FDD_PDF_Fixer.sh '.Auth::user()->id.'', $output, $return);
                        // Return will return non-zero upon an error
        if (!$return)
        {
            // sleep(3);
            // sub 1 credits to attorney account for new file processed.
            // $user=User::find(Auth::user()->id);
            // $old_credits=$user->credits;
            $new_credits=$old_credits - 1;
            $user->credits=$new_credits;
            $user->save();

            // to update user credit history
            $history= array(
                'user_id' => $user->id,
                'source' => 'User',
                'source_id' => NULL,
                'type' => 'debit',
                'number_of_credited_debited' => '1',
                'description' => '1 FDD CREDITS DEBITED FROM '.$user->name.'’s ACCOUNT FOR FIXING A PDF FILE DATED '.date('m-d-Y'),
                'created_at' => now(),
                'updated_at' => now(),
            );
            $user_credits_history=Usercredithistory::create($history);
            // return redirect()->route('fdd_tools.pdf_tools_downloads');
            return redirect()->route('attorney.downloads')->with('success', 'Your drafts will be available in your download directory soon. If you do not see your file here after a few seconds then please try again or Email Us.');
        } else {
            die('Something went wrong. Please try again.');
        }
    }

    /* Show Sole/Shared And Split Computation Sheet access Form */
    public function fddQuickChildSupportWorksheetsTool($show){
        $id=Auth::user()->id;
        $attorney=User::find($id);
        $attorney_data = User::find($id)->attorney;
        if(Auth::user()->id == $attorney->id && Auth::user()->hasRole('attorney'))
        {
            if($show=='active')   {
                $users_attorney_submissions_sole_shared_data = DB::table('users_attorney_submissions')
                                ->join('states', 'users_attorney_submissions.form_state', '=', 'states.id')
                                ->join('sole_shared_submissions', 'users_attorney_submissions.id', '=', 'sole_shared_submissions.users_attorney_submissions_id')
                                ->where('users_attorney_submissions.user_id', Auth::user()->id)
                                ->whereNull('users_attorney_submissions.case_id')
                                ->where('users_attorney_submissions.active', '1')
                                ->select('users_attorney_submissions.id','users_attorney_submissions.form_state','users_attorney_submissions.form_custody','users_attorney_submissions.active','states.state', 'sole_shared_submissions.updated_at as sole_shared_submissions_updated_at', 'sole_shared_submissions.obligee_name', 'sole_shared_submissions.obligor_name')
                                ->orderBy('id', 'DESC')
                                ->get();
                $users_attorney_submissions_split_data = DB::table('users_attorney_submissions')
                                ->join('states', 'users_attorney_submissions.form_state', '=', 'states.id')
                                ->join('split_submissions', 'users_attorney_submissions.id', '=', 'split_submissions.users_attorney_submissions_id')
                                ->where('users_attorney_submissions.user_id', Auth::user()->id)
                                ->whereNull('users_attorney_submissions.case_id')
                                ->where('users_attorney_submissions.active', '1')
                                ->select('users_attorney_submissions.id','users_attorney_submissions.form_state','users_attorney_submissions.form_custody','users_attorney_submissions.active','states.state', 'split_submissions.updated_at as split_submissions_updated_at', 'split_submissions.parenta_name', 'split_submissions.parentb_name')
                                ->orderBy('id', 'DESC')
                                ->get();
            } else {
                $users_attorney_submissions_sole_shared_data = DB::table('users_attorney_submissions')
                                    ->join('states', 'users_attorney_submissions.form_state', '=', 'states.id')
                                    ->join('sole_shared_submissions', 'users_attorney_submissions.id', '=', 'sole_shared_submissions.users_attorney_submissions_id')
                                    ->where('users_attorney_submissions.user_id', Auth::user()->id)
                                    ->whereNull('users_attorney_submissions.case_id')
                                    ->select('users_attorney_submissions.id','users_attorney_submissions.form_state','users_attorney_submissions.form_custody','users_attorney_submissions.active','states.state', 'sole_shared_submissions.updated_at as sole_shared_submissions_updated_at', 'sole_shared_submissions.obligee_name', 'sole_shared_submissions.obligor_name')
                                    ->orderBy('id', 'DESC')
                                    ->get();
                $users_attorney_submissions_split_data = DB::table('users_attorney_submissions')
                                    ->join('states', 'users_attorney_submissions.form_state', '=', 'states.id')
                                    ->join('split_submissions', 'users_attorney_submissions.id', '=', 'split_submissions.users_attorney_submissions_id')
                                    ->where('users_attorney_submissions.user_id', Auth::user()->id)
                                    ->whereNull('users_attorney_submissions.case_id')
                                     ->select('users_attorney_submissions.id','users_attorney_submissions.form_state','users_attorney_submissions.form_custody','users_attorney_submissions.active','states.state', 'split_submissions.updated_at as split_submissions_updated_at', 'split_submissions.parenta_name', 'split_submissions.parentb_name')
                                    ->orderBy('id', 'DESC')
                                    ->get();
            }

            $users_attorney_submissions_data=[$users_attorney_submissions_sole_shared_data, $users_attorney_submissions_split_data];

            return view('fdd_tools.fdd_quick_child_support_worksheet',['attorney'=>$attorney, 'attorney_data' =>$attorney_data, 'users_attorney_submissions_data' =>$users_attorney_submissions_data]);
        } else {
            return redirect()->route('home');
        }
    }

    /* Show FDD Annual Income Calculator Tool */
    public function fddAnnualIncomeCalculatorTool(){
        $id=Auth::user()->id;
        $attorney=User::find($id);
        $attorney_data = User::find($id)->attorney;
        if(Auth::user()->id == $attorney->id && Auth::user()->hasRole('attorney'))
        {
            return view('fdd_tools.fdd_annual_income_calculator',['attorney'=>$attorney, 'attorney_data' =>$attorney_data]);
        } else {
            return redirect()->route('home');
        }
    }

    /* Show FDD Loan Finance Calculator Tool */
    public function fddLoanFinanceCalculatorTool(){
        $id=Auth::user()->id;
        $attorney=User::find($id);
        $attorney_data = User::find($id)->attorney;
        if(Auth::user()->id == $attorney->id && Auth::user()->hasRole('attorney'))
        {
            return view('fdd_tools.fdd_loan_finance_calculator',['attorney'=>$attorney, 'attorney_data' =>$attorney_data]);
        } else {
            return redirect()->route('home');
        }
    }

    /* Show FDD Annuity Value Calculator Tool */
    public function fddAnnuityValueCalculatorTool(){
        $id=Auth::user()->id;
        $attorney=User::find($id);
        $attorney_data = User::find($id)->attorney;
        if(Auth::user()->id == $attorney->id && Auth::user()->hasRole('attorney'))
        {
            return view('fdd_tools.fdd_annuity_value_calculator',['attorney'=>$attorney, 'attorney_data' =>$attorney_data]);
        } else {
            return redirect()->route('home');
        }
    }

    /* Show FDD Pension Value Calculator Tool */
    public function fddPensionValueCalculatorTool(){
        $id=Auth::user()->id;
        $attorney=User::find($id);
        $attorney_data = User::find($id)->attorney;
        if(Auth::user()->id == $attorney->id && Auth::user()->hasRole('attorney'))
        {
            return view('fdd_tools.fdd_pension_value_calculator',['attorney'=>$attorney, 'attorney_data' =>$attorney_data]);
        } else {
            return redirect()->route('home');
        }
    }

    /* Show FDD PDF Tools List */
    public function getFddPDFToolList(){
        $id=Auth::user()->id;
        $attorney=User::find($id);
        $attorney_fullname=$attorney->name;
        $attorney_fullname = explode(" ", $attorney_fullname);

        if(isset($attorney_fullname[0])){
            $firstname=$attorney_fullname[0];
        } else {
            $firstname='';
        }

        if(isset($attorney_fullname[1])){
            $lastname=' '.$attorney_fullname[1];
        } else {
            $lastname='';
        }

        if(isset($attorney_data->mname)){
            $mname=' '.$attorney_data->mname;
        } else {
            $mname='';
        }
        $attorney->name=$firstname.$mname.$lastname;
        $attorney_data = User::find($id)->attorney;

        $pdf_credits=Pdfcredit::all();
        $user=User::find($id);

        if(Auth::user()->id == $attorney->id && Auth::user()->hasRole('attorney'))
        {
            return view('fdd_tools.pdf_tools_list',['attorney'=>$attorney, 'attorney_data' =>$attorney_data, 'pdf_credits' => $pdf_credits, 'intent' => $user->createSetupIntent()]);
        } else {
            return redirect()->route('home');
        }
    }

    /* Purchase PDF Credits */
    public function buyPDFCredits(Request $request)
    {
        $user=User::find(Auth::user()->id);
        $old_credits=$user->credits;
        $paymentMethod = $request->payment_method;
        $pdf_credit_package_id = $request->pdf_credit_package_id;
        $pdfcredit=Pdfcredit::find($pdf_credit_package_id);
        $purchase_price=$pdfcredit->purchase_price;
        $number_of_credits=$pdfcredit->number_of_credits;
        $amount = intval($purchase_price * 100);

        $user->addPaymentMethod($paymentMethod);
        // if ($user->hasPaymentMethod()) {
        //     // $paymentMethods = $user->paymentMethods();
        //     $user->addPaymentMethod($paymentMethod);
        // } else {
        //     $user->addPaymentMethod($paymentMethod);
        // }
        // echo "<pre>"; print_r($user->paymentMethods());die;
        try {
            $payment = $user->charge($amount, $paymentMethod, [
                'metadata'=>array(
                    'user_id' => $user->id,
                    'user_name' => $user->name,
                    'pdf_credit_package_id' => $pdf_credit_package_id,
                    'number_of_credits' => $number_of_credits,
                ),
                'description' => $number_of_credits.' FDD CREDITS PURCHASED FOR AMOUNT $'.$purchase_price.' DATED '.date('m-d-Y').' BY '.$user->name,
            ]);
            $new_credits=$old_credits + $number_of_credits;
            $user->credits=$new_credits;
            $user->save();

            // to update user credit history
            $history= array(
                'user_id' => $user->id,
                'source' => 'PDF Credit Package',
                'source_id' => $pdf_credit_package_id,
                'stripe_transaction_id' => $payment->id,
                'type' => 'credit',
                'amount' => $purchase_price,
                'number_of_credited_debited' => $number_of_credits,
                'description' => $number_of_credits.' FDD CREDITS PURCHASED FOR AMOUNT $'.$purchase_price.' VIA TRANSACTION ID: '.$payment->id.' DATED '.date('m-d-Y').' BY '.$user->name,
                'created_at' => now(),
                'updated_at' => now(),
            );
            $user_credits_history=Usercredithistory::create($history);
            // $email_sent=Mail::to($client[0]->email)->send(new CaseRegistered());
            return redirect()->route('fdd_tools.pdf_tools')->with('success', 'Thanks. Your Transaction Completed Successfully.');
        } catch (Exception $e) {
             // return redirect()->back()->with('error', ['Something went Wrong. Please try again.']);
             return redirect()->route('fdd_tools.pdf_tools')->with('error', 'Something went Wrong. Please try again.');
        }
    }

    // FDD Quick Affidavit of Basic Information, Income, and Expenses related functions

    public function fddQuickAffidavitOfBasicInformation($show){
        $id=Auth::user()->id;
        $attorney=User::find($id);
        $attorney_data = User::find($id)->attorney;
        if(Auth::user()->id == $attorney->id && Auth::user()->hasRole('attorney'))
        {

            if($show=='active')   {
                $affidavit_sheet_submissions_data = DB::table('affidavit_sheet_submissions')
                                ->where('user_id', Auth::user()->id)
                                ->where('active', '1')
                                ->orderBy('id', 'DESC')
                                ->get();
            } else {
                $affidavit_sheet_submissions_data = DB::table('affidavit_sheet_submissions')
                                    ->where('user_id', Auth::user()->id)
                                    ->orderBy('id', 'DESC')
                                    ->get();
            }


            return view('fdd_tools.fdd_quick_affidavit_of_basic_information',['attorney'=>$attorney, 'attorney_data' =>$attorney_data, 'affidavit_sheet_submissions_data' =>$affidavit_sheet_submissions_data]);
        } else {
            return redirect()->route('home');
        }
    }

    // public function showAffidavitOfBasicInformationSheetForm(Request $request){
    //     $data=$request->all();
    //     $selected_state_info=State::find($data['affidavit_state']);
    //     $ohMinimumWageData=DB::select(DB::raw("select getOHMinimumWage2018(0) AS tmpResult"));
    //     $OH_Minimum_Wage = $ohMinimumWageData[0]->tmpResult;
    //     $data['OH_Minimum_Wage']=$OH_Minimum_Wage;

    //     return view('fdd_tools.fdd_quick_affidavit_of_basic_information_sheet', compact('data', 'selected_state_info'));
    // }

    // show  FDD Quick Coverture Calculator Tool
    public function fddQuickCovertureCalculatorTool(){
    	$id=Auth::user()->id;
        $attorney=User::find($id);
        $attorney_data = User::find($id)->attorney;
        if(Auth::user()->id == $attorney->id && Auth::user()->hasRole('attorney'))
        {
            return view('fdd_tools.fdd_quick_coverture_calculator',['attorney'=>$attorney, 'attorney_data' =>$attorney_data]);
        } else {
            return redirect()->route('home');
        }
    }

}
