<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        Commands\ClearDownloadsTableDataCron::class,
        Commands\DeactivateHiddenCases::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('cleardownloadstabledata:cron')
                 ->hourlyAt(40);
        // $schedule->command('cleardownloadstabledata:cron')
        //          ->twiceDaily(1, 13);
        // $schedule->command('cleardownloadstabledata:cron')
        //          ->daily();
        // $schedule->command('cleardownloadstabledata:cron')
        //          ->everySixHours();
        $schedule->command('backup:clean')->saturdays()->hourlyAt(40)->between('10:00', '11:00');
        $schedule->command('backup:run')->sundays()->hourlyAt(40)->between('10:00', '11:00');

        // command to deactivate 6 months old hidden cases
        $schedule->command('deactivatehiddencases:cron')
                 ->hourlyAt(40);

        // command to delete 6/36 months old deactivated cases
        $schedule->command('deletedeactivatedcases:cron')
                 ->hourlyAt(40);

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
