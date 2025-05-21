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
        Schema::create('logos', function (Blueprint $table) {
            $table->id('logo_id');
            $table->string('logo_position');
            $table->string('logo_for');
            $table->string('company_name');
            $table->string('logo_type');
            $table->string('logo_image');
            $table->string('logo_image_dimention')->nullable()->comment('Width x Height');
            $table->string('logo_image_size')->nullable()->comment('KB');
            $table->text('logo_status')->default('Active');
            $table->integer('logo_delete')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logos');
    }
};
