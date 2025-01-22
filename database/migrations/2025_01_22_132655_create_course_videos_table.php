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
        Schema::create('course_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('course_id')->references('id')->on('courses')->onDelete('cascade');
            $table->string('video_group');
            $table->string('videos_file')->nullable();
            $table->string('video_no',30);
            $table->string('video_link');
            $table->text('video_title');
            $table->string('video_duration',30);
            $table->string('video_type',30);
            $table->boolean('video_status')->default(1);
            $table->boolean('video_delete')->default(0);
            $table->foreignId('admin_id')->references('id')->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_videos');
    }
};
