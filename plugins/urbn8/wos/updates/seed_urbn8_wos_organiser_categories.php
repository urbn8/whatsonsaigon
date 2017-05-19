<?php namespace Urbn8\Wos\Updates;

use Db;
use Schema;
use October\Rain\Database\Updates\Migration;

use Urbn8\Wos\Models\OCategory;

class SeedOCategories extends Migration
{
    public function up()
    {
        $c = new OCategory;
        $c->name = 'Happy hour';
        $c->slugAttributes();
        $c->save();

        $party = new OCategory;
        $party->name = 'Party';
        $party->slugAttributes();
        $party->save();

        $c = new OCategory;
        $c->name = 'Bar';
        $c->parent = $party;
        $c->slugAttributes();
        $c->save();

        $c = new OCategory;
        $c->name = 'Restaurant';
        $c->parent = $party;
        $c->slugAttributes();
        $c->save();

        $c = new OCategory;
        $c->name = 'Pool party';
        $c->parent = $party;
        $c->slugAttributes();
        $c->save();
    }
    
    public function down()
    {
      Db::table('urbn8_wos_organiser_categories')->truncate();
    }
}
