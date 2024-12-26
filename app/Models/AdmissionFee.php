<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdmissionFee extends Model
{
    use HasFactory;
    protected $fillable = [
        'class_id',    // Add class_id to the fillable array
        'fees_name',
        'fees_amount',
        'sibbling_discount',
    ];
    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }
}