<?php namespace NetSTI\Frontend\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateVisitsTable extends Migration
{

	public function up()
	{
		Schema::create('netsti_frontend_visits', function ($table) {
			$table->engine = 'InnoDB';
			$table->increments('id');
			$table->integer('record_id')->unsigned()->nullable()->index();
			$table->string('type', 60);

			$table->string('uid')->nullable();
			$table->string('ip', 28)->nullable();
			$table->string('country', 160)->nullable()->default('Private');
			$table->string('region', 160)->nullable()->default('Private');
			$table->string('city', 160)->nullable()->default('Private');
			$table->string('isp', 160)->nullable()->default('Private');
			$table->string('timezone', 160)->nullable()->default('Private');
			$table->string('os', 60)->nullable();

			$table->string('region_code', 10)->nullable();
			$table->string('country_code', 10)->nullable();
			$table->float('lon')->nullable()->default(0);
			$table->float('lat')->nullable()->default(0);

			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::dropIfExists('netsti_frontend_visits');
	}
}
