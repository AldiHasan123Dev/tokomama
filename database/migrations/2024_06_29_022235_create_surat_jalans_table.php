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
        Schema::create('surat_jalans', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->string('kepada');
            $table->integer('jumlah');
            $table->string('satuan');
            $table->string('jenis_barang');
            $table->string('nama_kapal');
            $table->string('no_cont');
            $table->string('no_seal');
            $table->string('no_pol');
            $table->string('tujuan');
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
            $table->unsignedBigInteger('created_by')->nullable();
            $table->foreign('created_by')->references('id')->on('users');
            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_jalans');
    }
};
