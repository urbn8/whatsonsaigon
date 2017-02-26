<?php namespace Urbn8\Wos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteUrbn8WosBiz extends Migration
{
    public function up()
    {
        Schema::dropIfExists('urbn8_wos_biz');
    }
    
    public function down()
    {
        Schema::create('urbn8_wos_biz', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 128);
            $table->string('slug', 128);
            $table->text('desc');
            $table->integer('updated_by')->nullable();
            $table->integer('sort_order');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
}
