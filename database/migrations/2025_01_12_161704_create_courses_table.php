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
        Schema::create('courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->references('id')->on('course_categories');
            $table->foreignId('sub_category_id')->nullable()->references('id')->on('course_sub_categories');
            $table->text('course_name');
            $table->text('course_headline');
            $table->text('course_details');
            $table->integer('no_of_videos');
            $table->float('course_duration');
            $table->string('course_duration_type',30);
            $table->string('course_type',40);
            $table->float('course_price');
            $table->string('course_price_currency',40);
            $table->integer('course_discount');
            $table->string('course_discount_type',20);
            $table->float('course_discount_price');
            $table->boolean('has_enroll_limit')->nullable();
            $table->integer('enrolled_count')->nullable();
            $table->text('course_images');
            $table->boolean('course_cupon_status')->default(1);
            $table->boolean('course_multiple_cupon_status')->default(1);
            // $table->foreignId('instructor_id')->nullable()->references('id')->on('admins');
            $table->boolean('course_status')->default(1);
            $table->boolean('course_delete')->default(0)->comment('0=Not Deleted 1=Deleted');
            $table->foreignId('course_added_by')->references('id')->on('admins');
            $table->foreignId('course_updated_by')->references('id')->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('courses');
    }
};
