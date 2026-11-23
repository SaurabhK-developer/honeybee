<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMarketplaceListingsTable extends Migration
{
    public function up()
    {
        Schema::create('marketplace_listings', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedInteger('category_id');
            $table->string('type', 20);
            $table->string('name');
            $table->text('detail');
            $table->string('country', 100);
            $table->string('state', 100);
            $table->string('city', 100);
            $table->string('area', 120);
            $table->decimal('price', 12, 2);
            $table->string('image_path')->nullable();
            $table->string('status', 20)->default('active');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('category_id')
                ->references('id')
                ->on('marketplace_categories')
                ->onDelete('restrict');
            $table->index(['status', 'created_at']);
            $table->index(['city', 'category_id']);
            $table->index(['country', 'state', 'city']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('marketplace_listings');
    }
}
