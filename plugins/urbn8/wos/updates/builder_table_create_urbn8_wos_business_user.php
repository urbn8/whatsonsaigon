<?php namespace Urbn8\Wos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUrbn8WosBusinessUser extends Migration
{
    public function up()
    {
        Schema::create('urbn8_wos_business_user', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('business_id');
            $table->integer('user_id');
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('urbn8_wos_business_user');
    }
}
