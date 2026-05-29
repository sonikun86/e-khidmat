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
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->string('nomor_surat');
            $table->string('perihal');
            $table->string('pengirim');
            $table->string('penerima');
            $table->string('file_surat');
            $table->enum('tipe_surat', ['masuk', 'keluar']);
            $table->enum('status', ['draft', 'terkirim', 'diarsipkan'])->default('draft');
            $table->timestamp('tgl_kirim')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
