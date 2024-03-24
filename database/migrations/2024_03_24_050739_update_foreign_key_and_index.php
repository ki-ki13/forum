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
         // Update tbl_users Foreign Key
         Schema::table('tbl_users', function (Blueprint $table) {
            $table->foreign('group_id')->references('id')->on('tbl_group')->onDelete('cascade');
            $table->index('group_id');
        });

        // Update tbl_category Foreign Key
        Schema::table('tbl_category', function (Blueprint $table) {
            $table->index('c_created_by');
        });

        // Update tbl_forum_question Foreign Key
        Schema::table('tbl_forum_question', function (Blueprint $table) {
            $table->foreign('fq_category_id')->references('id')->on('tbl_category')->onDelete('cascade');
            $table->foreign('fq_created_by')->references('id')->on('tbl_users')->onDelete('cascade');
            $table->foreign('fq_updated_by')->references('id')->on('tbl_users');
            $table->foreign('fq_group_id')->references('id')->on('tbl_group');
            $table->index('fq_category_id');
            $table->index('fq_created_by');
            $table->index('fq_updated_by');
        });

        // Update tbl_forum_detail Foreign Key
        Schema::table('tbl_forum_detail', function (Blueprint $table) {
            $table->foreign('fd_forum_id')->references('id')->on('tbl_forum_question')->onDelete('cascade');
            $table->foreign('fd_user_id')->references('id')->on('tbl_users')->onDelete('cascade');
            $table->index('fd_forum_id');
            $table->index('fd_user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('tbl_users', function (Blueprint $table) {
            $table->dropForeign(['group_id']);
            $table->dropIndex(['group_id']);
        });
    
        Schema::table('tbl_category', function (Blueprint $table) {
            $table->dropForeign(['c_group_id']);
            $table->dropIndex(['c_group_id']);
            $table->dropIndex(['c_created_by']);
        });
    
        Schema::table('tbl_forum_question', function (Blueprint $table) {
            $table->dropForeign(['fq_category_id']);
            $table->dropForeign(['fq_created_by']);
            $table->dropForeign(['fq_updated_by']);
            $table->dropIndex(['fq_category_id']);
            $table->dropIndex(['fq_created_by']);
            $table->dropIndex(['fq_updated_by']);
        });
    
        Schema::table('tbl_forum_detail', function (Blueprint $table) {
            $table->dropForeign(['fd_forum_id']);
            $table->dropForeign(['fd_user_id']);
            $table->dropIndex(['fd_forum_id']);
            $table->dropIndex(['fd_user_id']);
        });
    }
};
