<?php

namespace App\Console;

use App\Console\Commands\GetNewEmails;
use App\Http\Controllers\GetNewEmailsController;
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
//        Commands\Inspire::class,
	    GetNewEmails::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {

	    $schedule->command( 'get_new_emails' )->cron( '* * * * *' );

    }
}
