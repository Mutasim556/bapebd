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
        Schema::create('homepage_silders', function (Blueprint $table) {
            $table->id();
            $table->text('slider_title')->nullable();
            $table->text('slider_short_description')->nullable();
            $table->text('slider_link')->nullable();
            $table->text('slider_button_text')->nullable();
            $table->text('slider_image')->nullable();
            $table->boolean('status')->default(1);
            $table->boolean('delete')->default(0)->comment('0= Not Deleted & 1=Deleted');
            $table->foreignId('created_by')->references('id')->on('admins');
            $table->foreignId('updated_by')->references('id')->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('homepage_silders');
    }
};
