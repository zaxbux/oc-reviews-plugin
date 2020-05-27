<?php namespace Zaxbux\Reviews\Updates;

use Schema;
use October\Rain\Database\Updates\Migration;

class BuilderTableCreateZaxbuxReviewsReviews extends Migration
{
    public function up()
    {
        Schema::create('zaxbux_reviews_reviews', function($table)
        {
            $table->engine = 'InnoDB';
            $table->increments('id')->unsigned();
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('country', 2);
            $table->timestamp('check_in');
            $table->integer('rating')->unsigned();
            $table->string('title');
            $table->text('content');
            $table->text('reply_content')->nullable();
            $table->boolean('featured')->default(false);
            $table->boolean('approved')->default(false);
            $table->boolean('visible')->default(true);
            $table->timestamp('created_at')->nullable();
            $table->timestamp('updated_at')->nullable();
            $table->timestamp('deleted_at')->nullable();
        });
    }
    
    public function down()
    {
        Schema::dropIfExists('zaxbux_reviews_reviews');
    }
}
