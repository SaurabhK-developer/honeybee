<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketplaceCategoriesTable extends Migration
{
    public function up()
    {
        Schema::create('marketplace_categories', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('slug')->unique();
            $table->unsignedInteger('parent_id')->nullable();
            $table->timestamps();

            $table->foreign('parent_id')
                ->references('id')
                ->on('marketplace_categories')
                ->onDelete('set null');
            $table->index('parent_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('marketplace_categories');
    }
}
