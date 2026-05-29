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
        Schema::table('pacs', function (Blueprint $table) {
            $table->string('masa_khidmat')->nullable()->after('ketua_pac');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('pacs', function (Blueprint $table) {
            $table->dropColumn('masa_khidmat');
        });
    }
};
