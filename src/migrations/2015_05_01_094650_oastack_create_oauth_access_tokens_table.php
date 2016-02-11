<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OastackCreateOauthAccessTokensTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('oauth_access_tokens'))
			
			Schema::create ('oauth_access_tokens', function (Blueprint $table)
			{
				$table->increments ('id');
				$table->string ('access_token', 40);
				$table->string ('client_id', 80);
				$table->integer ('user_id');
				$table->timestamp ('expires');
				$table->string ('scope', 80)->nullable ();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists ('oauth_access_tokens');
	}

}
