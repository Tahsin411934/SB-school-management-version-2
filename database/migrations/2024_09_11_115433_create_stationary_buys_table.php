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
        Schema::create('stationary_buys', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('class_id');
            $table->foreign('class_id')->references('id')->on('student_classes')->onDelete('cascade');
            $table->unsignedBigInteger('student_id'); 
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
            $table->unsignedBigInteger('stationary_id');
            $table->foreign('stationary_id')->references('id')->on('stationary_fees')->onDelete('cascade');
            $table->integer('quantity');
            $table->decimal('total', 10, 2); // Changed to decimal(10,2)
            $table->string('status')->nullable(); // Changed to decimal(10,2)
            $table->date('payment')->nullable(); // Changed to decimal(10,2)
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stationary_buys');
    }
};