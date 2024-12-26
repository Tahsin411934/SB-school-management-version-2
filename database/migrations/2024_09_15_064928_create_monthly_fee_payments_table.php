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
        Schema::create('monthly_fee_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')->references('id')->on('student_classes')->onDelete('cascade');
            $table->unsignedBigInteger('student_id'); 
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->decimal('total_stationary', 10,2)->nullable();
            $table->unsignedBigInteger('monthly_fees_id'); 
            $table->foreign('monthly_fees_id')->references('id')->on('monthly_fees')->onDelete('cascade');
            $table->decimal('total_after_sibling_discount_monthly_fee', 10,2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_fee_payments');
    }
};