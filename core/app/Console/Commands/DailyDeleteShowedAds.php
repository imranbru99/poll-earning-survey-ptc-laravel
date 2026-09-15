<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Ptc;
class DailyDeleteShowedAds extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'showedAds:delete';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Remove all showed records of Ads every day at 12:00am at night';

    /**
     * *are u there
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
        return  info('will delete the Data showed every Day at 12 am at night');
        $adsrecords=Ptc::latest()->select('id', 'showed')->get();
        // $adsrecords->update(['showed'=>0]);
        foreach ($adsrecords as $key => $record) {
            if ($key <=15) {
                $record->update(['showed'=>0]);            
            }           
        }
        return  info('will delete the Data showed every Day at 12 am at night');
    }
}
