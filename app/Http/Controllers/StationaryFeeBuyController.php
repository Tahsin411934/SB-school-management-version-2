<?php

namespace App\Http\Controllers;

use App\Models\StationaryBuy;
use App\Models\StationaryFee;
use App\Models\Student;
use App\Models\StudentClass;
use Illuminate\Http\Request;

class StationaryFeeBuyController extends Controller
{
    //
    public function create()
    {
        $classes = StudentClass::all(); // Fetch all student classes
        $students = Student::all(); // Fetch all students
        $stationaryFees = StationaryFee::all(); // Fetch all stationary fees

        return view('admin.pages.stationaryFeeBuy.create', compact('classes', 'students', 'stationaryFees'));
    }

    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'class_id' => 'required|exists:student_classes,id',
            'student_id' => 'required|exists:students,id',
            'fees_name.*' => 'required|exists:stationary_fees,id',
            'quantity.*' => 'required|integer|min:1',
            'price.*' => 'required|numeric',
            'total.*' => 'required|numeric',
            'pay-now-checkbox' => 'nullable|boolean', // Updated to match the form field name
        ]);

        // Retrieve the class_id and student_id from the request
        $classId = $request->input('class_id');
        $studentId = $request->input('student_id');
        
        // Retrieve fees, quantities, prices, and totals from the request
        $fees = $request->input('fees_name');
        $quantities = $request->input('quantity');
        $totals = $request->input('total');

        // Accessing the checkbox value correctly
        $payNow = $request->has('pay-now-checkbox'); // Corrected checkbox access

        // dd($payNow);

        // Store each fee purchase
        if ($payNow == true) {
            foreach ($fees as $index => $feeId) {
            StationaryBuy::create([
                'class_id' => $classId,
                'student_id' => $studentId,
                'stationary_id' => $feeId,
                'quantity' => $quantities[$index],
                'total' => $totals[$index],
                'status' => 'paid' // Assign status based on checkbox
            ]);
        }
        } else {
            foreach ($fees as $index => $feeId) {
            StationaryBuy::create([
                'class_id' => $classId,
                'student_id' => $studentId,
                'stationary_id' => $feeId,
                'quantity' => $quantities[$index],
                'total' => $totals[$index],
            ]);
        }
        }
        

        // Redirect or return success message
        return redirect()->back()->with('success', 'Stationary fees have been successfully recorded.');
    }


    

}