<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateShopBusinessesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shop_businesses', function (Blueprint $table) {
            $table->engine = 'InnoDB';
            $table->increments('id');
            $table->string('shop_name');
            $table->string('shop_img')->default('');
            $table->decimal('shop_rating',3,1)->default(0);
            $table->unsignedTinyInteger('brand')->default(0);
            $table->unsignedTinyInteger('on_time')->default(0);
            $table->unsignedTinyInteger('fengniao')->default(0);
            $table->unsignedTinyInteger('bao')->default(0);
            $table->unsignedTinyInteger('zhun')->default(0);
            $table->decimal('start_send',5,1)->default(0);
            $table->decimal('send_cost',5,1)->default(0);
            $table->string('estimate_time')->default('');
            $table->string('notice')->default('');
            $table->string('discount')->default('');
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
        Schema::dropIfExists('shop_businesses');
    }
}
