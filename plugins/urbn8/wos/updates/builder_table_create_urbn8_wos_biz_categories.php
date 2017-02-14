<?php namespace Urbn8\Wos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUrbn8WosBizCategories extends Migration
{
    public function up()
    {
        Schema::create('urbn8_wos_biz_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name', 16)->nullable();
            $table->string('slug', 16)->nullable();
            $table->text('desc')->nullable();
            $table->smallInteger('status')->default(1);
            $table->integer('updated_by')->nullable();
            $table->integer('sort_order');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('urbn8_wos_biz_categories');
    }
}
