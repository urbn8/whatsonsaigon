<?php namespace NetSTI\Frontend\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreatePopupTable extends Migration
{

	public function up()
	{
		Schema::create('netsti_frontend_popups', function ($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('title', 160);
			$table->string('slug', 160);
			$table->longtext('code')->nullable();
			$table->string('url')->nullable();
			$table->string('open_timeout')->nullable();
			$table->string('close_timeout')->nullable();
			$table->string('color_bg');
			$table->string('type', 30);
			$table->integer('clicks');
			$table->integer('bounces');
		});
	}

	public function down()
	{
		Schema::dropIfExists('netsti_frontend_popups');
	}

}
