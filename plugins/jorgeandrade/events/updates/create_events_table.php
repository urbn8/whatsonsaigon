<?php namespace JorgeAndrade\Events\Updates;

use October\Rain\Database\Updates\Migration;
use Schema;

class CreateEventsTable extends Migration
{

    public function up()
    {
        Schema::create('jorgeandrade_events_events', function ($table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name');
            $table->string('slug');
            $table->longText('detail')->nullable();
            $table->text('excerpt')->nullable();
            $table->text('address')->nullable();
            $table->text('lat_long')->nullable();
            $table->integer('status')->default(1);
            $table->boolean('is_allday')->default(false);
            $table->integer('calendar_id')->default(1);
            $table->timestamp('start_at')->nullable();
            $table->timestamp('ends_at')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('jorgeandrade_events_events');
    }

}
