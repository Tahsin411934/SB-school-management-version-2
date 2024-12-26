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
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->string('firstName');
            $table->string('middleName')->nullable();
            $table->string('lastName');
            $table->date('dob');
            $table->string('gender');
            $table->string('nationality');
            $table->string('birthCertificateNO');
            
            // Change 'class' to a foreign key reference
            $table->unsignedBigInteger('class_id'); 
            $table->foreign('class_id')->references('id')->on('student_classes')->onDelete('cascade');

            $table->string('previousInstitution')->nullable();
            $table->string('area')->nullable();
            $table->string('city')->nullable();
            $table->string('phone');
            $table->string('presentAddress');
            $table->string('emergency_phone');
            $table->string('studentBloodGroup')->nullable();
            $table->string('hobby')->nullable();
            $table->string('specialSkills')->nullable();

            // Father's information
            $table->string('fathersName');
            $table->string('fathers_occupation')->nullable();
            $table->string('fathersCompanyName')->nullable();
            $table->string('fathersOfficeAddress')->nullable();
            $table->string('fathers_phone');

            // Mother's information
            $table->string('mothersName');
            $table->string('mothers_occupation')->nullable();
            $table->string('mothersCompanyName')->nullable();
            $table->string('mothersOfficeAddress')->nullable();
            $table->string('mothers_phone');

            // Local Guardian information
            $table->string('localGuardianName');
            $table->string('localGuardian_occupation')->nullable();
            $table->string('localGuardian_phone');

            //status
            $table->boolean('is_sibling')->default(false);
            $table->boolean('payment_status')->default(false);
            
            
            $table->timestamps();
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};