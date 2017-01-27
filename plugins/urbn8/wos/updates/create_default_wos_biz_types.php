<?php namespace Urbn8\Wos\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;
use Urbn8\Wos\Models\BizType;

class CreateDefaultUrbn8WosBizTypes extends Migration
{
    public function up()
    {
        $t1 = new BizType;
        $t1->name = 'Hotel';
        $t1->slug = 'hotel';
        $t1->save();
    }
    
    public function down()
    {
        BizType::truncate();
    }
}
