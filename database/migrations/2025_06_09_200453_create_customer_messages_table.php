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
        Schema::create('customer_messages', function (Blueprint $table) {
            $table->id();
            $table->string('name',40);
            $table->string('email',40);
            $table->string('phone',15);
            $table->foreignId('subject')->references('id')->on('course_categories')->onDelete('cascade');
            $table->text('message');
            $table->text('reply_message')->nullable();
            $table->text('reply_type')->nullable();
            $table->boolean('reply_status')->default(0);
            $table->timestamp('reply_date')->nullable();
            $table->foreignId('replied_by')->nullable()->references('id')->on('admins')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customer_messages');
    }
};
