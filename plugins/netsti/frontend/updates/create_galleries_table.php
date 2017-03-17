<?php namespace NetSTI\Frontend\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateGalleriesTable extends Migration
{

	public function up()
	{
		Schema::create('netsti_frontend_galleries', function ($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('title', 160);
			$table->string('slug', 160);
			$table->longtext('description')->nullable();
		});
	}

	public function down()
	{
		Schema::dropIfExists('netsti_frontend_galleries');
	}

}
