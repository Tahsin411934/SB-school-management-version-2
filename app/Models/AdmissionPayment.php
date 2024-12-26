<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionPayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'payment_type',
        'class_id',
        'amount',
        'discount',
        'total',
    ];

    // Define the belongsTo relationship
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }
}