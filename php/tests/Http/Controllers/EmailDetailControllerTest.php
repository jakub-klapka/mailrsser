<?php

use App\Email;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EmailDetailControllerTest extends TestCase
{

	use DatabaseTransactions;

	public function testDetail() {

		$incomingEmail = new stdClass();
		$incomingEmail->fromAddress = "from@example.com";
		$incomingEmail->subject = "Example Subject";
		$incomingEmail->textPlain = "Plaintext";
		$incomingEmail->textHtml = "<h1>Example HTML</h1>";

		$email = new Email( $incomingEmail );
		$email->saveToDb();

		$this->visit( $this->baseUrl . "/email/{$email->id}/{$email->access_token}" )
			->see( "Example Subject" )
			->see( "<h1>Example HTML</h1>" );

	}

	public function testDetailUnauthorized() {

		/** @var Email $email */
		$email = factory( Email::class )->create();

		$this->visit( $this->baseUrl . "/email/{$email->id}/string" )
			->assertResponseStatus( 401 );

	}

}
