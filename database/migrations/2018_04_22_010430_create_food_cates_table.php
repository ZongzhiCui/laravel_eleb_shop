<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodCatesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('food_cates', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('description')->default('');
            $table->string('type_accumulation')->default('');
            $table->unsignedInteger('is_selected')->default(0);
            $table->unsignedInteger('business_id')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('food_cates');
    }
}
