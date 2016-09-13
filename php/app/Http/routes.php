<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get( 'email/{email}/{access_token?}', [ 'uses' => 'EmailDetailController@detail', 'as' => 'email_detail' ] );

Route::get( 'emails/{access_token}', 'EmailListController@index' );


/*
 * System routes
 * (Since there is no CLI on shared hosting)
 */
Route::group( [ 'prefix' => 'sys/' . config( 'auth.sys_routes_access_token' ) ], function() {

	Route::get( 'get_new_emails', 'GetNewEmailsController@getNewEmails' );

	Route::get( 'do_cron', 'SysController@do_cron' );

	Route::get( 'update_app', 'SysController@update_app' );

} );
