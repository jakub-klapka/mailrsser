<?php

namespace App\Http\Controllers;

use Cache;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class SysController extends Controller
{

	public function do_cron() {

		//Dont work without exec()
		//\Artisan::call( 'schedule:run' );

		if( !Cache::has( 'email_check_timeout' ) ) {

			Cache::put( 'email_check_timeout', true, 60 );

			app()->make( GetNewEmailsController::class )->getNewEmails();

		}


	}

	public function update_app() {

		\Artisan::call( 'down' );

		\Artisan::call( 'clear-compiled' );
		\Artisan::call( 'cache:clear' );
		\Artisan::call( 'config:clear' );
		\Artisan::call( 'route:clear' );
		\Artisan::call( 'view:clear' );

		\Artisan::call( 'migrate' );

		\Artisan::call( 'optimize' );
		\Artisan::call( 'config:cache' );
		\Artisan::call( 'route:cache' );

		\Artisan::call( 'up' );

	}

}
