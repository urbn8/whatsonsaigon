<?php namespace Urbn8\BizCategories\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class AddLinkTargetField extends Migration
{

    public function up()
    {
        Schema::table('urbn8_bizcategories_menus', function($table)
        {
            $table->string('link_target')->default('_self');
        });
    }

    public function down()
    {
        Schema::table('urbn8_bizcategories_menus', function($table)
        {
            $table->dropColumn(array('link_target'));
        });
    }

}
