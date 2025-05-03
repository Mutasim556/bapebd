<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use phpDocumentor\Reflection\Types\Nullable;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('purchases', function (Blueprint $table) {
            $table->id();
            
            $table->string('courses');
            $table->float('total_amount');
            $table->float('dicount_amount');
            $table->float('subtotal');
            $table->string('payment_method',30);
            $table->boolean('payment_status')->default(0);
            $table->string('transaction_id')->nullable();
            $table->string('payment_option')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchases');
    }
};
