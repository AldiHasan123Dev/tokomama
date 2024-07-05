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
        Schema::create('surat_jalan', function (Blueprint $table) {
            $table->id();
            $table->string('invoice')->nullable();
            $table->date('tgl_invoice')->nullable();
            $table->string('nomor_surat')->nullable();
            $table->string('kepada')->nullable();
            $table->integer('jumlah')->nullable();
            $table->integer('jumlah_satuan')->nullable();
            $table->integer('total')->nullable();
            $table->string('satuan')->nullable();
            $table->string('jenis_barang')->nullable();
            $table->string('nama_kapal')->nullable();
            $table->string('no_cont')->nullable();
            $table->string('no_seal')->nullable();
            $table->string('no_pol')->nullable();
            $table->string('no_job')->nullable();
            $table->string('tujuan')->nullable();
            $table->string('status')->default('pre')->nullable();
            $table->integer('harga_beli')->nullable();
            $table->integer('harga_jual')->nullable();
            $table->integer('profit')->nullable();
            $table->string('kota_pengirim')->default('surabaya')->nullable();
            $table->string('nama_pengirim')->default('FIRDA')->nullable();
            $table->string('nama_penerima')->default('IFAN')->nullable();
            $table->integer('no')->default(0);
            $table->timestamps();
            $table->softDeletes('deleted_at', precision: 0);
            $table->foreignId('created_by')->nullable()->constrained('users');
            $table->foreignId('updated_by')->nullable()->constrained('users');
            // $table->unsignedBigInteger('created_by')->nullable();
            // $table->foreign('created_by')->references('id')->on('users');
            // $table->unsignedBigInteger('updated_by')->nullable();
            // $table->foreign('updated_by')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surat_jalan');
    }
};
