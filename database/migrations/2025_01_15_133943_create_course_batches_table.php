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
        Schema::create('course_batches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->references('id')->on('courses');
            $table->text('batch_name');
            $table->string('batch_code');
            $table->integer('batch_number');
            $table->string('batch_instructor');
            $table->date('batch_start_date');
            $table->date('batch_end_date');
            $table->time('batch_time');
            $table->integer('enroll_limit');
            $table->integer('enrolled_count');
            $table->string('live_in');
            $table->string('link_or_address');
            $table->boolean('batch_status')->default(1);
            $table->boolean('batch_delete')->default(0)->comment('0=Not Deleted 1=Deleted');
            $table->foreignId('batch_added_by')->references('id')->on('admins');
            $table->foreignId('batch_updated_by')->references('id')->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_batches');
    }
};
