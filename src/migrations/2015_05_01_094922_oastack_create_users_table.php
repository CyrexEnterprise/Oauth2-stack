<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OastackCreateUsersTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('users'))
		
			Schema::create ('users', function (Blueprint $table)
			{
				$table->increments ('id');
				$table->unique ('email', 32);
				$table->string ('firstname', 32);
				$table->string ('lastname', 32);
				$table->string ('password', 64)->nullable ();
				$table->string ('reset_token', 40)->nullable ();
				
				$table->softDeletes ();
				$table->timestamps ();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists ('users');
	}

}
