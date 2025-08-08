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
         Schema::create('units', function (Blueprint $table) {
            $table->id('unit_id'); // Primary Key
            $table->string('nama_unit', 100);
            $table->unsignedBigInteger('kategori_id'); // Foreign key ke kategori
            // $table->unsignedBigInteger('usaha_id');    // Foreign key ke usaha
            $table->text('deskripsi')->nullable();
            $table->decimal('harga', 12, 2)->default(0);
            $table->integer('stok')->default(0);
            $table->string('gambar', 255)->nullable(); // nama file gambar
            $table->timestamps();
            // Foreign Key Constraints
            $table->foreign('kategori_id')->references('kategori_id')->on('kategori')->onDelete('cascade');
            // $table->foreign('usaha_id')->references('usaha_id')->on('usaha')->onDelete('cascade');
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('units');
    }
};