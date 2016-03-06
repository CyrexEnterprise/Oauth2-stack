<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OastackCreateOauthScopesTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('oauth_scopes'))
		
			Schema::create ('oauth_scopes', function (Blueprint $table)
			{
				$table->increments ('id');
				$table->text ('scope')->nullable ();
				$table->tinyInteger('is_default');
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists ('oauth_scopes');
	}
}
