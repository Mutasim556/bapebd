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
        Schema::create('course_sub_categories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->references('id')->on('course_categories');
            $table->string('sub_category_name');
            $table->string('sub_category_image')->nullable();
            $table->boolean('sub_category_status')->default(1);
            $table->boolean('sub_category_delete')->default(0)->comment('0=Not Deleted 1=Deleted');
            $table->foreignId('sub_category_added_by')->references('id')->on('admins');
            $table->foreignId('sub_category_updated_by')->references('id')->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_sub_categories');
    }
};
