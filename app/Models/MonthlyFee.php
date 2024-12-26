<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyFee extends Model
{
    use HasFactory;
    protected $fillable = [
        'class_id',    // Add class_id to the fillable array
        'fees_name',
        'fees_amount',
        'sibbling_discount',
        'due_date',
        'due_fine'
    ];
    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }
}