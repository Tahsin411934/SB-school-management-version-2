<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StationaryBuy extends Model
{
    use HasFactory;
    protected $fillable = [
        'class_id',
        'student_id',
        'stationary_id',
        'quantity',
        'total',
        'status',
    ];

    // Define the relationship to the StationaryFee model
    public function stationaryFee()
    {
        return $this->belongsTo(StationaryFee::class, 'stationary_id');
    }
    public function monthlyFeeStudent()
    {
        return $this->belongsTo(MonthlyFeeStudent::class, 'student_id', 'student_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}