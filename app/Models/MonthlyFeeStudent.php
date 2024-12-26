<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyFeeStudent extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'month_name',
        'month_date',
        'status',
        'payment_date',
    ];
    protected $casts = [
        'month_date' => 'date',
        'payment_date' => 'date',
    ];
    // Define relationship with Student
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    // Define relationship with StudentClass
    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }
}