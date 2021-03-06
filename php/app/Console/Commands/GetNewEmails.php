<?php

namespace App\Console\Commands;

use App\Http\Controllers\GetNewEmailsController;
use Illuminate\Console\Command;

class GetNewEmails extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'get_new_emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gets new emails from IMAP.';

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

	    ( new GetNewEmailsController() )->getNewEmails();

    }
}
