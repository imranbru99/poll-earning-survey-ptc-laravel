<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Illuminate\Support\Facades\DB;
use App\Console\Commands\DailyDeleteShowedAds;
use App\Ptc;
class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        DailyDeleteShowedAds::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->call(function () {
             return  info('will delete the Data showed every Day at 12 am at night');
            $adsrecords=Ptc::latest()->select('id', 'showed')->get();
            foreach ($adsrecords as $key => $record) {
                if ($key <=50) {
                    $record->update(['showed'=>0]);            
                }           
            }
        })->everyMinute();
        return  info('will delete the Data showed every Day at 12 am at night');
        //   ->dailyAt('12:00');
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
