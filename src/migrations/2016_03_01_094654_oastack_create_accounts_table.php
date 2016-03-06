<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class OastackCreateAccountsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		if (!Schema::hasTable('accounts'))
		
			Schema::create('accounts', function(Blueprint $table)
			{
				$table->increments('id');
				$table->string('name', 32);
				$table->string('slug', 32);
				
				$table->softDeletes();
				$table->timestamps();
			});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::dropIfExists ('accounts');
	}

}
