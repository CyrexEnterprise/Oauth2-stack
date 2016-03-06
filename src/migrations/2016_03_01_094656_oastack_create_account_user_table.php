<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OastackCreateAccountUserTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up ()
	{
		if (!Schema::hasTable('account_user'))
		
			Schema::create ('account_user', function (Blueprint $table)
			{
				$table->integer ('account_id');
				$table->integer ('user_id');
				$table->string ('invitation_token', 32)->nullable ();
				$table->string ('reset_token', 32)->nullable ();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down ()
	{
		Schema::dropIfExists ('account_user');
	}

}
