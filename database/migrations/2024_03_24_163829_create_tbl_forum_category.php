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
        Schema::create('tbl_forum_category', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('fc_forum_id');
            $table->unsignedBigInteger('fc_category_id');
            $table->timestamps();

            $table->foreign('fc_forum_id')->references('id')->on('tbl_forum_question')->onDelete('cascade');
            $table->foreign('fc_category_id')->references('id')->on('tbl_category')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tbl_forum_category');
    }
};
