<?php

namespace App\Providers;


use PhpImap\Mailbox;

class ImapConnection {

	public $mailbox;

	public function __construct() {

		$mailbox_conn_string = sprintf( '{%s:%s/imap/ssl}INBOX', config( 'mail_download.host' ), config( 'mail_download.port' ) );
		$this->mailbox = new Mailbox( $mailbox_conn_string, config( 'mail_download.name' ), config( 'mail_download.pass' ) );

	}

}