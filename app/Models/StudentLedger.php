<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentLedger extends Model
{
    use HasFactory;

    // Specify the table name (optional if the table name matches the plural of the model name)
    protected $table = 'studentledger';

    // Specify the primary key (optional if the primary key is 'id')
    protected $primaryKey = 'TrxNo';

    // Disable auto-incrementing of the primary key if necessary
    public $incrementing = true;
    public $timestamps = false;

   
  

    // Fields that can be mass-assigned
    protected $fillable = [
        'StudentID',
        'TDate',
        'Head',
        'Description',
        'Ref',
        'BillAmount',
        'Received',
        'Status',
    ];

    // Fields that should be cast to specific data types
    protected $casts = [
        'TDate' => 'date',
        'BillAmount' => 'decimal:2',
        'Received' => 'decimal:2',
    ];

    /**
     * Define relationships if required.
     * Example: If `StudentID` references a `students` table, you can define the relationship here.
     */

    // Relationship with the Student model (if it exists)
    public function student()
    {
        return $this->belongsTo(Student::class, 'StudentID', 'id'); // Adjust 'id' if the student table uses a different primary key
    }
}
