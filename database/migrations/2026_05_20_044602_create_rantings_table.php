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
        Schema::create('rantings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pac_id')->constrained('pacs')->onDelete('cascade');
            $table->string('nama_ranting');
            $table->string('nama_ketua')->nullable();
            $table->string('masa_khidmat')->nullable();
            $table->integer('makesta')->default(0);
            $table->integer('lakmud')->default(0);
            $table->integer('latin')->default(0);
            $table->integer('lakut')->default(0);
            $table->integer('laknas')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rantings');
    }
};
