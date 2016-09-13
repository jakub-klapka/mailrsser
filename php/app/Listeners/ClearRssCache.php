<?php

namespace App\Listeners;

use App\Email;
use Cache;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class ClearRssCache
{
    /**
     * Create the event listener.
     *
     */
    public function __construct()
    {
        //
    }

    /**
     * Clear cache of whole xml file
     *
     * @return void
     */
    public function handle()
    {

	    Cache::forget( 'emails_xml_content' );

    }
}
