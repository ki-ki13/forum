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
        Schema::create('tbl_forum_question', function (Blueprint $table) {
            $table->id();
            $table->text('fq_question');
            $table->unsignedBigInteger('fq_created_by');
            $table->unsignedBigInteger('fq_updated_by');
            $table->unsignedBigInteger('fq_group_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_forum_question');
    }
};
