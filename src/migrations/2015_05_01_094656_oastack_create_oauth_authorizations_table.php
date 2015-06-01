<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OastackCreateOauthAuthorizationsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('oauth_authorizations'))
		
			Schema::create ('oauth_authorizations', function (Blueprint $table)
			{
				$table->string ('client_id', 80)->primary ();
				$table->integer('user_id');
				$table->dateTime('authorization_date');
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists ('oauth_authorizations');
	}

}
