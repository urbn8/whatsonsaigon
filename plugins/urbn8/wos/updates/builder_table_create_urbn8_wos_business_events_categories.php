<?php namespace Urbn8\Wos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUrbn8WosBusinessEventsCategories extends Migration
{
    public function up()
    {
        Schema::create('urbn8_wos_business_events_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('event_id');
            $table->integer('category_id');
            $table->primary(['event_id','category_id'], 'event_category');
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('urbn8_wos_business_events_categories');
    }
}
