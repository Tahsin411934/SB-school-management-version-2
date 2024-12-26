<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyFeePayment extends Model
{
    use HasFactory;
     protected $fillable = [
        'class_id',
        'student_id',
        'stationary_buys_id',
        'total_stationary',
        'monthly_fees_id',
        'total_after_sibling_discount_monthly_fee',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class);
    }

    public function stationaryBuy()
    {
        return $this->belongsTo(StationaryBuy::class);
    }

    public function monthlyFee()
    {
        return $this->belongsTo(MonthlyFee::class);
    }
    
}