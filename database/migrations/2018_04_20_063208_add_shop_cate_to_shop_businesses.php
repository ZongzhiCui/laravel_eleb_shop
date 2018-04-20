<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddShopCateToShopBusinesses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_businesses', function (Blueprint $table) {
            $table->unsignedTinyInteger('category_id')->default(0)->after('notice');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shop_businesses', function (Blueprint $table) {
            $table->dropColumn(['category_id']);
        });
    }
}
