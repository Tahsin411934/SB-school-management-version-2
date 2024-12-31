<?php

namespace App\Http\Controllers;
use App\Models\StudentLedger;
use Illuminate\Http\Request;

class StudentLedgerController extends Controller
{
    public function getStudentLedger()
    {
        $studentLedger = StudentLedger::all();
        // dd($studentLedger);
        return view('admin.pages.student.studentLedger',compact('studentLedger'));
    }
}
