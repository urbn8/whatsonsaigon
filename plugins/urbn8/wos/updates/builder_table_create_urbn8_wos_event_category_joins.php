<?php namespace Urbn8\Wos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUrbn8WosEventCategoryJoins extends Migration
{
  public function up()
  {
      Schema::create('urbn8_wos_event_category_joins', function($table)
      {
          $table->engine = 'InnoDB';
          $table->integer('category_id');
          $table->integer('event_id');
          $table->primary(['category_id','event_id'], 'oc_o_key');
      });
  }

  public function down()
  {
      Schema::dropIfExists('urbn8_wos_event_category_joins');
  }
}
