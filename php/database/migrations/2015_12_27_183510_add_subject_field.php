<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddSubjectField extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {

        Schema::table( 'emails', function( Blueprint $table ){

	        $table->string( 'subject' )->after( 'sender' )->nullable();

        } );

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

	    Schema::table( 'emails', function( Blueprint $table ){

		    $table->dropColumn( 'subject' );

	    } );

    }
}
