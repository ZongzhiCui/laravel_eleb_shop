<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFoodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('foods', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->string('logo')->default('');
            $table->decimal('rating',3,1)->default(0);
            $table->decimal('price',8,2)->default(0);
            $table->unsignedInteger('month_sales')->default(0);
            $table->unsignedInteger('rating_count')->default(0);
            $table->string('tips')->default('');
            $table->unsignedInteger('satisfy_count')->default(0);
            $table->unsignedInteger('satisfy_rate')->default(0);
            $table->string('desc')->default('');
            $table->string('comment')->default('');
            $table->unsignedTinyInteger('norm')->default(0)->comment('0:小,1:中,2:大');
            $table->integer('business_is');
            $table->integer('food_cates_id');
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
        Schema::dropIfExists('foods');
    }
}
