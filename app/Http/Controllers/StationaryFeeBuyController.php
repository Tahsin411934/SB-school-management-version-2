<?php

namespace App\Http\Controllers;

use App\Models\StationaryBuy;
use App\Models\StationaryFee;
use App\Models\StudentLedger;
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
            'pay-now-checkbox' => 'nullable|boolean', // Checkbox is optional and should be boolean
        ]);
    
        // Retrieve the class_id and student_id from the request
        $classId = $request->input('class_id');
        $studentId = $request->input('student_id');
        
        // Retrieve fees, quantities, and totals from the request
        $fees = $request->input('fees_name');
        $quantities = $request->input('quantity');
        $totals = $request->input('total');
    
        // Check if "pay-now-checkbox" is checked
        $payNow = $request->has('pay-now-checkbox'); // Correctly retrieves the checkbox value
    
        // Initialize totalFees and feeDescriptions for StudentLedger
        $totalFees = 0;
        $feeDescriptions = '';
    
        // Store each fee purchase
        foreach ($fees as $index => $feeId) {
            $quantity = $quantities[$index];
            $total = $totals[$index];
    
            // Create a StationaryBuy record
            StationaryBuy::create([
                'class_id' => $classId,
                'student_id' => $studentId,
                'stationary_id' => $feeId,
                'quantity' => $quantity,
                'total' => $total,
                'status' => $payNow ? 'paid' : 'due', // Assign status based on checkbox
            ]);
            $item= StationaryFee::where('id',$feeId)->firstOrFail();
           
            // Update total fees and fee descriptions
            $totalFees += $total;
            $feeDescriptions .= "{$item->fees_name}: {$total}, ";
        }
    
        // Remove trailing comma and space from the fee descriptions
        $feeDescriptions = rtrim($feeDescriptions, ', ');
    
        // Create a StudentLedger entry
        StudentLedger::create([
            'StudentID' => $studentId,
            'TDate' => now(),
            'Head' => 'Stationary Fee',
            'Description' => $feeDescriptions,
            'Ref' => '',
            'BillAmount' => $totalFees,
            'Received' => $payNow ? $totalFees : 0.0, // If paid, mark as received
            'Status' => $payNow ? 'paid' : 'due', // Status based on payment
        ]);
    
        // Return a success response
        return redirect()->back()->with('success', 'Stationary fees have been successfully recorded.');
    }
    


    

}