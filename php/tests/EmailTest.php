<?php

use App\Email;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmailTest extends TestCase
{

	use DatabaseTransactions;

	public function testSaveToDb() {

		$this->saveToDbEmail();
		$this->saveToDbEmail( true );

	}

	private function saveToDbEmail( $plain = false ) {

		$incomingEmail = new stdClass();
		$incomingEmail->fromAddress = "from@example.com";
		$incomingEmail->subject = "Example Subject";
		$incomingEmail->textPlain = "Plaintext";
		if( $plain !== true ) $incomingEmail->textHtml = "<h1>Example HTML</h1>";

		$email = new Email( $incomingEmail );
		$email->saveToDb();

		$expected_content = ( $plain ) ? "Plaintext" : "<h1>Example HTML</h1>";

		$this->seeInDatabase( 'emails', [
			'sender' => "from@example.com",
			'subject' => "Example Subject",
			'content' => $expected_content
		] );

		$email_db = Email::find( $email->id );
		$this->assertNotEmpty( $email_db->access_token );
		$this->assertNotEmpty( $email_db->created_at );
		$this->assertNotEmpty( $email_db->updated_at );

	}

	public function testGetPrivateLink() {

		$incomingEmail = new stdClass();
		$incomingEmail->fromAddress = "from@example.com";
		$incomingEmail->subject = "Example Subject";
		$incomingEmail->textPlain = "Plaintext";
		$incomingEmail->textHtml = "<h1>Example HTML</h1>";

		$email = new Email( $incomingEmail );
		$email->saveToDb();

		$expected_link_regex = "/https\:\/\/.+?email\/{$email->id}\/{$email->access_token}/";

		$this->assertRegExp( $expected_link_regex, $email->getPrivateLink() );

	}

}
