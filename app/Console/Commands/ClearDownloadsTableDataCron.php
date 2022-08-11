<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Download;
use App\User;
use App\Setting;
use File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;

class ClearDownloadsTableDataCron extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cleardownloadstabledata:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron Job to Clear Downloads Table Data for Non Existing Computation Sheet Files in Attorneys Download Directory';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        \Log::info("Cron is working fine!");

        $destinationPath = ( public_path() . '/uiodirs/3/download/testcron');
        if (File::exists($destinationPath)) {
            File::delete($destinationPath);
        }

        // $users=User::role('attorney')->get()->all();
        // $downloads=Download::all();
        $users=User::role('attorney')->get()->all();
        $downloads=Download::all();
        foreach($users as $user){
        // delete 5 days older files from attorney download directory

            $user_id=$user->id;
            $path=( public_path() . '/uiodirs/'.$user_id.'/download/');
            $subDays=5;
            $days_before_delete=Setting::where('setting_key', 'days_before_delete')->pluck('setting_value')->first();
            if(isset($days_before_delete) && $days_before_delete !=''){
                $subDays=$days_before_delete;
            }

            if(File::isDirectory($path)){
                $files = collect(File::allfiles($path))->each(function($file, $user_id) {

                    if ($file->getCTime() < now()->subDays($subDays)->getTimestamp()) {
                        $file_deleted=File::delete($file->getPath().'/'.$file->getFileName().'');
                        // dd($file_deleted);
                        // delete records from downloads table for files which are deleted from directory.
                        Download::where([
                            ['attorney_id', $user_id],
                            ['file_name', $file->getFileName()]
                        ])->delete();

                    }
                });
            }
            // $files=collect(Storage::disk('public')->listContents('/uiodirs/3/download', true))
            // ->each(function($file) {
            //     if ($file['type'] == 'file' && $file['timestamp'] < now()->subDays(5)->getTimestamp()) {
            //         Storage::disk('public')->delete($file['path']);
            //     }
            // });
        }

        \Log::info("Cron is working fine! Old Files deleted after ".$subDays." days.");

        // delete records from downloads table for files which are deleted from directory.
            // foreach($downloads as $download){
            //     $file_name=$download->file_name;
            //     $path=( public_path() . '/uiodirs/'.$user->id.'/download/'.$file_name.'');
            //     $headers = array(
            //         'Content-Type'=> 'application/pdf'
            //     );
            //     if(file_exists($path)){
            //         // $response=response()->download($path, $file_name, $headers);
            //         echo "<br>";
            //         echo "File Exist";
            //     } else {
            //         Download::where([
            //             ['id', $download->id],
            //             ['attorney_id', $user->id],
            //             ['file_name', $file_name]
            //         ])->delete();
            //     }
            // }
      
        $this->info('ClearDownloadsTableDataCron:Cron Cummand Run successfully!'. $subDays);

        // send email on successfull cron run
        // $admin_email=Setting::where('setting_key', 'admin_email')->pluck('setting_value')->first();
        // $admin_email="testerfdd@yopmail.com";

        // $email_from= env('MAIL_FROM_ADDRESS');
        // $email_us=Mail::send('emails.cronmail',
        //     array(
        //         'cron_message' => "Cron job for deleting older files from attorneys download directory run successfully.",
        //     ), function($message) use ($admin_email, $email_from)
        //     {
        //         $message->from($email_from);
        //         $message->to($admin_email, 'Admin')->subject('FDD Cron Job Run Successfully');

        //     });
        //if($email_us){
            // \Log::info("Cron Email Sent Successfully!");
       // }

    }
}
