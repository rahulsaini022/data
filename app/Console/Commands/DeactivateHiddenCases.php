<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Courtcase;
use Carbon\Carbon;

class DeactivateHiddenCases extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'deactivatehiddencases:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Cron Job to Deactivate 6 months old hidden cases.';

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
        \Log::info(Carbon::now()->subMonths(6));
        $cases=Courtcase::where("hidden_at","<", Carbon::now()->subMonths(6))->get()->all();
        foreach($cases as $case){
        // deactivate 6 months older cases.

            $courtcase=Courtcase::find($case->id);
            $courtcase->deactivated_at=now();
            $courtcase->payment_status='0';
            $courtcase->save();
        }

        \Log::info("Cron is working fine! 6 months old cases deactivated successfully.");
    }
}
