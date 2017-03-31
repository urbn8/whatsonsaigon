<?php namespace Urbn8\Wos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUrbn8WosOrganiserUser extends Migration
{
    public function up()
    {
        Schema::create('urbn8_wos_organiser_user', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('organiser_id');
            $table->integer('user_id');
            $table->primary(['organiser_id','user_id']);
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('urbn8_wos_organiser_user');
    }
}
