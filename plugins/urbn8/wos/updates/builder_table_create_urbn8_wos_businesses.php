<?php namespace Urbn8\Wos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUrbn8WosBusinesses extends Migration
{
    public function up()
    {
        Schema::create('urbn8_wos_businesses', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 128);
            $table->string('slug', 128)->unique();
            $table->text('desc')->nullable();
            $table->smallInteger('status')->default(1);
            $table->string('updated_by');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('urbn8_wos_businesses');
    }
}
