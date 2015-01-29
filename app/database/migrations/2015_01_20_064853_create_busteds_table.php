<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateBustedsTable extends Migration {

	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
		Schema::create('busteds', function(Blueprint $table)
		{
			$table->engine = 'InnoDB';

			$table->increments('id');
			$table->timestamps();
			$table->integer('uid')->unsigned()->index();
			$table->string('name');
			$table->string('mask');
			$table->integer('freq');
			$table->boolean('sinner')->default(false);
			$table->boolean('baptized')->default(false);
			$table->string('meeter')->default(false);
			$table->string('email')->nullable();
			$table->string('nick')->nullable();
			$table->string('church')->nullable();
			$table->softDeletes();
		});
	}

	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
		Schema::drop('busteds');
	}

}
