<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EventFeePayment extends Model
{
    use HasFactory;
    protected $fillable = [
        'student_id',
        'class_id',
        'event_id',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
    public function eventFee()
    {
        return $this->belongsTo(EventFee::class, 'event_id');
    }
}