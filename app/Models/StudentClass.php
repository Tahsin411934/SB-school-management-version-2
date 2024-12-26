<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentClass extends Model
{
    use HasFactory;
    public function admissionFees()
    {
        return $this->hasMany(AdmissionFee::class, 'class_id');
    }
    public function monthlyFees()
    {
        return $this->hasMany(MonthlyFee::class, 'class_id');
    }
    public function stationaryFees()
    {
        return $this->hasMany(StationaryFee::class, 'class_id');
    }
    public function eventFees()
    {
        return $this->hasMany(EventFee::class, 'class_id');
    }

}