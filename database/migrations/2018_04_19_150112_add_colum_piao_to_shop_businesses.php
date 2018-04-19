<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AddColumPiaoToShopBusinesses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shop_businesses', function (Blueprint $table) {
            $table->unsignedTinyInteger('piao')->default(0)->after('bao');
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
            $table->dropColumn(['piao']);
        });
    }
}
