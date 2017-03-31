<?php namespace Urbn8\Wos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateUrbn8WosOrganiserOCategory extends Migration
{
  public function up()
  {
      Schema::create('urbn8_wos_organiser_o_category', function($table)
      {
          $table->engine = 'InnoDB';
          $table->integer('o_category_id');
          $table->integer('organiser_id');
          $table->primary(['o_category_id','organiser_id'], 'oc_o_key');
      });
  }

  public function down()
  {
      Schema::dropIfExists('urbn8_wos_organiser_o_category');
  }
}
