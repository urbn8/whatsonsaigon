<?php namespace NetSTI\Frontend\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateStringsTable extends Migration
{

	public function up(){
		Schema::create('netsti_frontend_strings', function ($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->string('name');
			$table->string('slug');
			$table->string('text')->nullable();
			$table->string('type')->nullable();
			$table->longtext('textarea')->nullable();
			$table->longtext('richtext')->nullable();
			$table->longtext('markdown')->nullable();
			$table->nullableTimestamps();
		});
	}

	public function down(){
		Schema::dropIfExists('netsti_frontend_strings');
	}

}
