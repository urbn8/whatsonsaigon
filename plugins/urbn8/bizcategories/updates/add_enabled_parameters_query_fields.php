<?php namespace Urbn8\BizCategory\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddEnabledParametersQueryFields extends Migration
{

    public function up()
    {
        Schema::table('urbn8_bizcategories_menus', function($table)
        {
            $table->integer('enabled')->default(1);
            $table->string('parameters')->nullable();
            $table->string('query_string')->nullable();
        });
    }

    public function down()
    {
        Schema::table('urbn8_bizcategories_menus', function($table)
        {
            $table->dropColumn('enabled');
            $table->dropColumn('parameters');
            $table->dropColumn('query_string');
        });
    }

}
