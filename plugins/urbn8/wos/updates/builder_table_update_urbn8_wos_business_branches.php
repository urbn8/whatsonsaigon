<?php namespace Urbn8\Wos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableUpdateUrbn8WosBusinessBranches extends Migration
{
    public function up()
    {
        Schema::table('urbn8_wos_business_branches', function($table)
        {
            $table->integer('business_id');
        });
    }
    
    public function down()
    {
        Schema::table('urbn8_wos_business_branches', function($table)
        {
            $table->dropColumn('business_id');
        });
    }
}
