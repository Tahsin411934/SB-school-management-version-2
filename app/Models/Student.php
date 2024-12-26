<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;
    protected $fillable = [
        'firstName', 'middleName', 'lastName', 'dob', 'gender', 'nationality', 'birthCertificateNO',
        'class_id', 'previousInstitution', 'area', 'city', 'phone', 'presentAddress', 'emergency_phone',
        'studentBloodGroup', 'hobby', 'specialSkills', 'fathersName', 'fathers_occupation', 'fathersCompanyName',
        'fathersOfficeAddress', 'fathers_phone', 'mothersName', 'mothers_occupation', 'mothersCompanyName',
        'mothersOfficeAddress', 'mothers_phone', 'localGuardianName', 'localGuardian_occupation', 'localGuardian_phone','is_sibling','payment_status', 'image'
    ];

    // Define the relationship with StudentClass
    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }
    public function admissionPayments()
    {
        return $this->hasMany(AdmissionPayment::class, 'student_id');
    }
    public function monthlyFeeStudents()
    {
        return $this->hasMany(MonthlyFeeStudent::class, 'student_id');
    }
    public function stationaryBuys()
    {
        return $this->hasMany(StationaryBuy::class);
    }
}