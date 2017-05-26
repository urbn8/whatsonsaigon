<?php namespace Urbn8\Wos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUrbn8WosOrganiserOrganiserCategory extends Migration
{
  public function up()
  {
      Schema::create('urbn8_wos_organiser_category_joins', function($table)
      {
          $table->engine = 'InnoDB';
          $table->integer('category_id');
          $table->integer('organiser_id');
          $table->primary(['category_id','organiser_id'], 'oc_o_key');
      });
  }

  public function down()
  {
      Schema::dropIfExists('urbn8_wos_organiser_category_joins');
  }
}
