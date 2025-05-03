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
        Schema::create('purchase_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('purchase_id')->references('id')->on('purchases');
            $table->foreignId('user_id')->references('id')->on('users');
            $table->foreignId('course_id')->references('id')->on('courses');
            $table->string('course_type');
            $table->integer('batch_id')->references('id')->on('purchases')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_courses');
    }
};
