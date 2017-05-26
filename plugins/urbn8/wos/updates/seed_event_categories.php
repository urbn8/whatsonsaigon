<?php namespace Urbn8\Wos\Updates;

use Schema;
use Db;
use October\Rain\Database\Updates\Migration;

use Urbn8\Wos\Models\EventCategory;

class SeedEventCategories extends Migration
{
    public function up()
    {
        $c = new EventCategory;
        $c->name = 'Happy hour';
        $c->slugAttributes();
        $c->save();

        $party = new EventCategory;
        $party->name = 'Party';
        $party->slugAttributes();
        $party->save();

        $c = new EventCategory;
        $c->name = 'Bar';
        $c->parent = $party;
        $c->slugAttributes();
        $c->save();

        $c = new EventCategory;
        $c->name = 'Restaurant';
        $c->parent = $party;
        $c->slugAttributes();
        $c->save();

        $c = new EventCategory;
        $c->name = 'Pool party';
        $c->parent = $party;
        $c->slugAttributes();
        $c->save();
    }
    
    public function down()
    {
      Db::table('urbn8_wos_event_categories')->truncate();
    }
}
