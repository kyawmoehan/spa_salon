<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('item_vouchers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('voucher_id')->constrained()->onDelete('cascade');;
            $table->foreignId('item_id');
            $table->integer('quantity');
            $table->integer('item_price');
            $table->integer('total');
            $table->string('source');
            $table->date('date');
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
        Schema::dropIfExists('item_vouchers');
    }
};
