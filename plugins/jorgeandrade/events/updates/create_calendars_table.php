<?php namespace JorgeAndrade\Events\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreateCalendarsTable extends Migration
{

    public function up()
    {
        Schema::create('jorgeandrade_events_calendars', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->integer('is_active')->default(1);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jorgeandrade_events_calendars');
    }

}
