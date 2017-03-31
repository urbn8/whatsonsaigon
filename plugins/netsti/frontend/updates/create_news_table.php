<?php namespace NetSTI\Frontend\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class CreateNewsTable extends Migration
{

    public function up()
    {
        Schema::create('netsti_frontend_articles', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->integer('user_id')->unsigned()->nullable()->index();
            $table->string('title')->nullable();
            $table->string('slug')->index();
            $table->text('content')->nullable();
            $table->json('tags')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->boolean('published')->default(false);
			$table->integer('views');
            $table->timestamps();
        });

        Schema::create('netsti_frontend_categories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('name')->nullable();
            $table->string('slug')->nullable()->index();
            $table->string('code')->nullable();
            $table->text('description')->nullable();
            $table->integer('parent_id')->unsigned()->index()->nullable();
            $table->integer('nest_left')->nullable();
            $table->integer('nest_right')->nullable();
            $table->integer('nest_depth')->nullable();
            $table->timestamps();
        });

        Schema::create('netsti_frontend_newscategories', function($table)
        {
            $table->engine = 'InnoDB';
            $table->integer('article_id')->unsigned();
            $table->integer('category_id')->unsigned();
            $table->primary(['article_id', 'category_id']);
        });
    }

    public function down()
    {
        Schema::drop('netsti_frontend_articles');
        Schema::drop('netsti_frontend_categories');
        Schema::drop('netsti_frontend_newscategories');
    }

}
