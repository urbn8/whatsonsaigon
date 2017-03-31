<?php namespace NetSTI\Frontend\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateTestimonialsTable extends Migration
{

	public function up()
	{
		Schema::create('netsti_frontend_testimonials', function ($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name', 160);
			$table->string('place', 220);
			$table->text('content');
			$table->string('source', 160);
			$table->string('url', 255);
			$table->date('date');
			$table->integer('published');
		});
	}

	public function down()
	{
		Schema::dropIfExists('netsti_frontend_testimonials');
	}

}
