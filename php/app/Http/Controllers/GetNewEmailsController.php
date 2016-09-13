<?php

namespace App\Http\Controllers;

use App\Email;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Cache;

use App\Http\Requests;
use App\Http\Controllers\Controller;

class GetNewEmailsController extends Controller
{

	/**
	 * Run task for new e-mails check and download
	 */
	public function getNewEmails() {

		\Log::debug( 'Starting import of new emails' );

		/** @var Collection $new_emails */
		$new_emails = Email::getNewEmails();

		if( !$new_emails->isEmpty() ) {

			//We have new emails
			\Log::debug( "Saving {$new_emails->count()} new emails to DB and deleting from IMAP." );

			/** @var Email $email */
			foreach( $new_emails as $email ) {

				$email->saveToDb();
				if( !config( 'mail_download.dont_delete_from_remote_server' ) ) {
					$email->deleteFromImap();
				}

			};

		}

		\Log::debug( 'Import of new emails complete.' );

	}

}
