<?php

return [

	'host' => env('MAIL_DOWN_HOST' ),
	'port' => env('MAIL_DOWN_PORT' ),
	'name' => env('MAIL_DOWN_NAME' ),
	'pass' => env('MAIL_DOWN_PASS' ),
	'dont_delete_from_remote_server' => env( 'MAIL_DONT_DELETE_FROM_REMOTE_SERVER', false )

];