<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventFee extends Model
{
    use HasFactory;
    protected $fillable = ['class_id', 'event_title', 'event_amount'];

    // Define the relationship with StudentClass
    public function studentClass()
    {
        return $this->belongsTo(StudentClass::class, 'class_id');
    }
    public function payments()
    {
        return $this->hasMany(EventFeePayment::class, 'event_id');
    }

}