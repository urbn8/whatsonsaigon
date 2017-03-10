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
            $table->string('name', 255);
            $table->string('slug', 255);
            $table->integer('business_id')->nullable();
            $table->integer('year')->nullable();
            $table->integer('month')->nullable();
            $table->integer('day')->nullable();
            $table->date('date')->nullable();
            $table->time('length')->nullable();
            $table->time('time')->nullable();
            $table->text('address')->nullable();
            $table->string('lat_long', 255)->nullable();
            $table->smallInteger('status');
            $table->string('pattern', 255)->nullable();
            $table->text('description')->nullable();
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
