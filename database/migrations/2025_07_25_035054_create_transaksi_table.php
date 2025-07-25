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
        Schema::create('transaksi', function (Blueprint $table) {
           $table->id('transaksi_id');
            $table->unsignedBigInteger('user_id');
            $table->dateTime('tanggal')->useCurrent();
            $table->decimal('total_harga', 12, 2)->default(0);
            $table->enum('status', ['diproses', 'selesai', 'dibatalkan'])->default('diproses');
            $table->enum('metode_pembayaran', ['tunai', 'transfer', 'qris'])->default('tunai');
            $table->text('keterangan')->nullable();
            $table->timestamps();

            $table->foreign('user_id')->references('user_id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaksi');
    }
};
