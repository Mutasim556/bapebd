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
        Schema::create('admin_profile_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('instructor_id')->references('id')->on('admins');
            $table->string('designation',70)->nullable();
            $table->string('department',70)->nullable();
            $table->string('facebook',200)->nullable();
            $table->string('twitter',200)->nullable();
            $table->string('linkedin',200)->nullable();
            $table->text('details')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_profile_details');
    }
};
