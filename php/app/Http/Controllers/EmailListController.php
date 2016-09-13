<?php

namespace App\Http\Controllers;

use App\Email;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Cache;

class EmailListController extends Controller
{

	/**
	 * Create RSS feed of e-mails in DB
	 *
	 * @param string $access_token
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index( $access_token = null ) {

		if( $access_token !== config( 'auth.email_list_access_token' ) ) abort( 403, 'Unauthorized' );

		$xml_contents = Cache::remember( 'emails_xml_content', 60*60, function() {

			$xml = new \SimpleXMLElement( '<rss version="2.0"></rss>' );
			$channel = $xml->addChild( 'channel' );
			$channel->addChild( 'title', 'MailRSSer' );
			$channel->addChild( 'link', config( 'app.url' ) );
			$channel->addChild( 'description', 'Simple XML feed of subscribed emails' );

			$emails = Email::orderBy( 'created_at', 'desc' )->take( 50 )->get();

			/** @var Email $email */
			foreach( $emails as $email ) {

				$item = $channel->addChild( 'item' );
				$item->addChild( 'title', $email->subject );
				$item->addChild( 'link', $email->getPrivateLink() );

			}

			return $xml->asXML();

		} );

		return response()->make( $xml_contents, 200,[ 'Content-Type' => 'application/xml' ] );

	}

}
