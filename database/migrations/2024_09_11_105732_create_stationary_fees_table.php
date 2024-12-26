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
        Schema::create('stationary_fees', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id');
            $table->string('fees_name');
            $table->decimal('fees_amount', 10, 2);
            $table->decimal('sibbling_discount', 10, 2)->nullable();
            $table->timestamps();
            $table->foreign('class_id')->references('id')->on('student_classes')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stationary_fees');
    }
};