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
        Schema::create('home_aboutuses', function (Blueprint $table) {
            $table->id();
            $table->string('headline')->nullable();
            $table->text('short_details')->nullable();
            $table->text('points')->nullable();
            $table->string('button_text',50)->nullable();
            $table->string('number_of_experience',40)->nullable();
            $table->string('image1')->nullable();
            $table->string('image2')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('home_aboutuses');
    }
};
