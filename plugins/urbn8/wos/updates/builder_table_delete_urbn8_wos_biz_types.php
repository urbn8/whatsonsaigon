<?php namespace Urbn8\Wos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableDeleteUrbn8WosBizTypes extends Migration
{
    public function up()
    {
        Schema::dropIfExists('urbn8_wos_biz_types');
    }
    
    public function down()
    {
        Schema::create('urbn8_wos_biz_types', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name', 16)->nullable();
            $table->string('slug', 16)->nullable();
            $table->text('desc')->nullable();
            $table->smallInteger('status')->nullable()->default(1);
            $table->integer('updated_by')->nullable();
            $table->integer('sort_order');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
}
