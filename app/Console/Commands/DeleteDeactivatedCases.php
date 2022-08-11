<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Courtcase;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class DeleteDeactivatedCases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deletedeactivatedcases:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron Job to Delete 6 months old Deactivated cases.';

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
     * @return mixed
     */
    public function handle()
    {
        $subMonthsFamLaw=36;
        \Log::info(Carbon::now()->subMonths($subMonthsFamLaw));
        // $cases=Courtcase::where("deactivated_at","<", Carbon::now()->subMonths($subMonthsFamLaw))->get()->all();
        // foreach($cases as $case){
        // // delete 6 months older deactivated cases.
        //     $case_type_ids=$case->case_type_ids;
        //     $case_type_ids=explode(",",$case_type_ids);
        //     $array=array('1', '2', '3', '4', '5', '6', '7', '8', '9', '49', '50', '51', '52');
        //     $hascaseid = !empty(array_intersect($array, $case_type_ids));
        //     if(isset($hascaseid) && $hascaseid=='1'){
        //         $courtcase=Courtcase::find($case->id);
        //         $courtcase->delete();
        //     }
        // }

        DB::table('courtcases')->where("deactivated_at","<", Carbon::now()->subMonths($subMonthsFamLaw))
        ->chunkById(100, function ($cases) {
            foreach ($cases as $case) {
                $case_type_ids=$case->case_type_ids;
                $case_type_ids=explode(",",$case_type_ids);
                $array=array('1', '2', '3', '4', '5', '6', '7', '8', '9', '49', '50', '51', '52');
                $hascaseid = !empty(array_intersect($array, $case_type_ids));
                DB::table('courtcases')
                    ->where('id', $case->id)
                    ->delete();
            }
        });

        \Log::info("Cron is working fine! 36 months old deactivated cases deleted successfully.");

        $subMonthsNonFamLaw=6;
        \Log::info(Carbon::now()->subMonths($subMonthsNonFamLaw));
        // $cases=Courtcase::where("deactivated_at","<", Carbon::now()->subMonths($subMonthsNonFamLaw))->get()->all();
        // foreach($cases as $case){
        // // delete 6 months older deactivated cases.
        //     $case_type_ids=$case->case_type_ids;
        //     $case_type_ids=explode(",",$case_type_ids);
        //     $array=array('1', '2', '3', '4', '5', '6', '7', '8', '9', '49', '50', '51', '52');
        //     $hascaseid = !empty(array_intersect($array, $case_type_ids));
        //     if(isset($hascaseid) && $hascaseid=='1'){
        //     } else {
        //         $courtcase=Courtcase::find($case->id);
        //         $courtcase->delete();
        //     }
        // }

        DB::table('courtcases')->where("deactivated_at","<", Carbon::now()->subMonths($subMonthsNonFamLaw))
        ->chunkById(100, function ($cases) {
            foreach ($cases as $case) {
                $case_type_ids=$case->case_type_ids;
                $case_type_ids=explode(",",$case_type_ids);
                $array=array('1', '2', '3', '4', '5', '6', '7', '8', '9', '49', '50', '51', '52');
                $hascaseid = !empty(array_intersect($array, $case_type_ids));
                if(isset($hascaseid) && $hascaseid=='1'){
                } else {
                    DB::table('courtcases')
                        ->where('id', $case->id)
                        ->delete();
                }
            }
        });

        \Log::info("Cron is working fine! 6 months old deactivated cases deleted successfully.");

    }
}
