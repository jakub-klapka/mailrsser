<?php

namespace App;

use App\Providers\ImapConnection;
use Event;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use PhpImap\IncomingMail;
use PhpImap\Mailbox;

/**
 * App\Email
 *
 * @property integer $id
 * @property string $sender
 * @property string $subject
 * @property string $content
 * @property string $access_token
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 */
class Email extends Model
{

	/** @var IncomingMail $incomingMail */
	private $incomingMail;

	public function __construct( $incoming_mail = null ) {

		parent::__construct();

		if( $incoming_mail !== null ) {
			$this->incomingMail = $incoming_mail;
		}

	}

	/**
	 * Add events to Model boot
	 */
	public static function boot() {
		parent::boot();
		
		static::saved( function ( $email ){
			Event::fire( 'email.saved', $email );
		} );
	}

	/**
	 * Save currently initialized E-mail to DB
	 */
	public function saveToDb() {

		$this->sender = $this->incomingMail->fromAddress;
		$this->subject = $this->incomingMail->subject;
		$this->content = ( !empty( $this->incomingMail->textHtml ) ) ? $this->incomingMail->textHtml : $this->incomingMail->textPlain;
		$this->access_token = md5( uniqid( null, true ) );

		$this->save();

	}

	/**
	 * Delete currently initialized e-mail from remote server
	 *
	 * @return bool|void
	 */
	public function deleteFromImap() {

		if( empty( $this->incomingMail ) ) return false;

		$imapConnection = app()->make( ImapConnection::class );

		$imapConnection->mailbox->deleteMail( $this->incomingMail->id );

	}

	/**
	 * Generate public URL for current e-mail
	 *
	 * @return string
	 */
	public function getPrivateLink() {

		return route( 'email_detail', [ $this->id, $this->access_token] );

	}

	/**
	 * Get new e-mails from remote server
	 *
	 * @return \Illuminate\Support\Collection
	 */
	public static function getNewEmails() {

		$imapConnection = app()->make( ImapConnection::class );
		$email_ids = $imapConnection->mailbox->searchMailbox();
		$emails = new Collection();

		foreach( $email_ids as $id ) {

			$incoing_email = $imapConnection->mailbox->getMail( $id );
			$email = new Email( $incoing_email );
			$emails = $emails->push( $email );

		}

		return $emails;

	}

}
