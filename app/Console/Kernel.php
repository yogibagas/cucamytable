<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;
use Carbon\Carbon;
use DB;
use App\Point_log;
use App\Reservation;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();
               $schedule->call(function () {
                 \Log::info(['schedule' => now()]);
                 $timeNow = Carbon::now()->subHour(24);
              $data= Reservation::where('payment_status',-1)->where('created_at', '<=', $timeNow)->get();
              foreach($data as $dt){
                if($dt->discount <=0){

                  $dt->update([
                  'payment_status'=> -2,
                  'discount'=> 0,
                ]);
                }else{
                  $point = $dt->discount;
                  // input to discount log return the point
                  Point_log::create([
                    'id_user'=>$dt->id_user,
                    'points'=>$point,
                    'desc'=>"refund from reservation ".$dt->reservation_code,
                  ]);

                    $dt->update([
                    'payment_status'=> -2,
                    'discount'=> 0,
                  ]);
                }
              }

                \Log::info(['schedule' => now()]);
                // ->update(['payment_status' => '-2'])
       })->everyMinute();
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
