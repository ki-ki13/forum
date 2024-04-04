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
        Schema::create('tbl_group', function (Blueprint $table) {
            $table->id();
            $table->string('g_nama');
            $table->string('g_tipe');
            $table->string('g_status');
            $table->unsignedBigInteger('g_created_by');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_group');
    }
};
