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
        Schema::create('course_coupons', function (Blueprint $table) {
            $table->id();
            $table->string('coupon');
            $table->date('coupon_start_date');
            $table->date('coupon_end_date');
            $table->integer('can_apply')->default(1);
            $table->string('apply_type',60);
            $table->string('has_minimum_price_for_apply',40);
            $table->float('minimum_price_for_apply');
            $table->float('coupon_discount');
            $table->string('coupon_discount_type',60);
            $table->string('has_maximum_discount',40);
            $table->float('maximum_discount');
            $table->text('coupon_details')->nullable();
            $table->boolean('applicable_for')->nullable();
            $table->boolean('coupon_status')->default(1);
            $table->boolean('coupon_delete')->default(0);
            $table->foreignId('created_by')->references('id')->on('admins');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('course_coupons');
    }
};
