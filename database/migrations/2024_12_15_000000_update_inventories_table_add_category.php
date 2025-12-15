<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->string('category')->default('General')->after('item_name');
            $table->integer('unit_price')->default(0)->after('quantity');
            $table->string('unit')->default('pcs')->after('unit_price');
        });
    }

    public function down()
    {
        Schema::table('inventories', function (Blueprint $table) {
            $table->dropColumn(['category', 'unit_price', 'unit']);
        });
    }
};
