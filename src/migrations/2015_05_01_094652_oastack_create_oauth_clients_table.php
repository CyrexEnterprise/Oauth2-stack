<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OastackCreateOauthClientsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('oauth_clients'))
		
			Schema::create ('oauth_clients', function (Blueprint $table)
			{
				$table->increments ('id');
				$table->string ('client_id', 80);
				$table->string ('client_secret', 80);
				$table->string ('client_name', 80);
				$table->string ('redirect_uri', 256);
				$table->string ('grant_types', 80)->nullable ();
				$table->string ('scope', 80)->nullable ();
				$table->string ('user_id', 80);
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists ('oauth_clients');
	}

}
