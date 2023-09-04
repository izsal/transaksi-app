<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('transaksi_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('transaksi_id')->unsigned()->index()->nullable();
            $table->bigInteger('category_id')->unsigned()->index()->nullable();
            $table->string('nama_transaksi');
            $table->string('nominal');
            $table->timestamps();
        });

        Schema::table('transaksi_detail', function (Blueprint $table) {
            $table->foreign('transaksi_id')->references('id')->on('transaksi')->onDelete('cascade');
            $table->foreign('category_id')->references('id')->on('category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi_detail');
    }
};
