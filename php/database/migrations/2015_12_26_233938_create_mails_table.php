<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMailsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::create( 'emails', function( Blueprint $table ) {

	        $table->increments( 'id' );
	        $table->string( 'sender', 64 )->nullable();
	        $table->mediumText( 'content' )->nullable();
	        $table->string( 'access_token', 64 )->nullable();
	        $table->timestamps();

        } );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

	    Schema::drop( 'emails' );

    }
}
