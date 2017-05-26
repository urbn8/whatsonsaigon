<?php namespace Urbn8\Wos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUrbn8WosEvents extends Migration
{
    public function up()
    {
        Schema::create('urbn8_wos_events', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('organiser_id')->nullable();

            $table->string('name', 255);
            $table->string('slug', 255);
            
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->integer('day')->nullable();
            $table->date('date')->nullable();
            $table->time('length')->nullable();
            $table->time('time')->nullable();
            $table->string('pattern', 255)->nullable();
            
            $table->string('district', 64)->nullable();
            $table->text('address')->nullable();
            $table->string('lat_long', 255)->nullable();

            $table->smallInteger('status');

            $table->text('desc')->nullable();
            $table->text('excerpt')->nullable();

            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('urbn8_wos_events');
    }
}
