<?php

namespace App\Console;

use App\Console\Commands\Notify;
use Illuminate\Console\Scheduling\Schedule;
use App\Console\Commands\SendMailToUser;
use App\Console\Commands\WordOfTheDay;

use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        SendMailToUser::class,
        Notify::class,
        WordOfTheDay::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->command('email:send')->everyMinute();
        $schedule->command('notify:user')->everyMinute();
        $schedule->command('word:day')->everyMinute();
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
