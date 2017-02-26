<?php namespace Urbn8\Wos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUrbn8WosBusinessBranchBizCategory extends Migration
{
    public function up()
    {
        Schema::create('urbn8_wos_business_branch_biz_category', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('biz_category_id');
            $table->integer('business_branch_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('urbn8_wos_business_branch_biz_category');
    }
}
