<?php

namespace App\Http\Controllers;

use App\Email;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class EmailDetailController extends Controller
{

	/**
	 * Display detail of specific e-mail
	 * Check for correct access token
	 *
	 * @param Email $email
	 * @param string $access_token
	 *
	 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
	 */
	public function detail( Email $email, $access_token = null ) {

		//Deny without access token
		if( $access_token !== $email->access_token ) abort( 401, 'Unauthorized' );

		return view( 'email_detail', [
			'title' => $email->subject,
			'content' => $email->content
		] );

	}

}
