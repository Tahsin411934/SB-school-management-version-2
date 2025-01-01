<?php

namespace App\Http\Controllers;

use App\Models\AdmissionFee;
use App\Models\EventFeePayment;
use App\Models\MonthlyFeePayment;
use App\Models\MonthlyFeeStudent;
use App\Models\StationaryBuy;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\StudentLedger;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class StudentController extends Controller
{
  

    public function create()
    {
        if (!Auth::user()->hasPermissionTo('student.create')) {
            abort(403, 'You are not allowed to create student');
        }
        $classes = StudentClass::all();

        // Pass the classes to the view
        return view('admin.pages.student.create', compact('classes'));
    }

    public function store(Request $request)
    {
        if (!Auth::user()->hasPermissionTo('student.create')) {
            abort(403, 'You are not allowed to create student');
        }

        $validate = $request->validate([
            'firstName' => 'required|string|max:255',
            'middleName' => 'nullable|string|max:255',
            'lastName' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'nationality' => 'required|string|max:255',
            'birthCertificateNO' => 'required|string|max:255',
            'class_id' => 'required|exists:student_classes,id',  // Make sure the class exists
            'previousInstitution' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'phone' => 'required|string|max:25',
            'presentAddress' => 'required|string|max:255',
            'emergency_phone' => 'required|string|max:25',
            'studentBloodGroup' => 'nullable|string|max:20',
            'hobby' => 'nullable|string|max:255',
            'specialSkills' => 'nullable|string|max:255',
            'is_sibling' => 'required|boolean',
            'fathersName' => 'required|string|max:255',
            'fathers_occupation' => 'nullable|string|max:255',
            'fathersCompanyName' => 'nullable|string|max:255',
            'fathersOfficeAddress' => 'nullable|string|max:255',
            'fathers_phone' => 'required|string|max:25',
            'mothersName' => 'required|string|max:255',
            'mothers_occupation' => 'nullable|string|max:255',
            'mothersCompanyName' => 'nullable|string|max:255',
            'mothersOfficeAddress' => 'nullable|string|max:255',
            'mothers_phone' => 'required|string|max:25',
            'localGuardianName' => 'required|string|max:255',
            'localGuardian_occupation' => 'nullable|string|max:255',
            'localGuardian_phone' => 'required|string|max:25',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        
        // Handle image upload
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imagePath = $image->store('images', 'public');  // Store image in public storage under the 'images' directory
            $validate['image'] = $imagePath;  // Add image path to validated data
        }

        // Create new Student instance
        $obj = new Student($validate);

        // Save the Student
        $obj->save();
        $fees = AdmissionFee::where('class_id', $request->class_id)->get();
        $classes = StudentClass::where('id', $request->class_id)->firstOrFail();
        $totalFees = $fees->sum('fees_amount');
        $feeDescriptions = $fees->map(function ($fee) use ($classes) {
            return "{$fee->fees_name} : {$fee->fees_amount}, ";
        })->implode(", ");


      $check =   StudentLedger::create([
            'StudentID' => $obj->id,
            'TDate' => now(),
            'Head' => 'Admission Fee',
            'Description' => $feeDescriptions,
            'Ref' => '',
            'BillAmount' => $totalFees ,
            'Received' => 0.0,
            'Status' => 'due',
        ]);
        
        return redirect('/admin/student-profile/' . $obj->id);
    }

    public function getAllStudents()
    {
        if (!Auth::user()->hasPermissionTo('student.view')) {
            abort(403, 'You are not allowed to view student');
        }
        $students = Student::with('studentClass')->get()->map(function ($student) {
            $student->formatted_dob = Carbon::parse($student->dob)->format('d-m-Y');
            return $student;
        });

        // Pass the data to the view
        return view('admin.pages.student.all', compact('students'));
    }

   
    public function edit($id)
    {
        // Check if the user has permission to edit
        if (!Auth::user()->hasPermissionTo('student.edit')) {
            abort(403, 'You are not allowed to edit student');
        }

        // Fetch the student by ID, with related class
        $student = Student::with('studentClass')->findOrFail($id);

        // Fetch all classes for the dropdown
        $classes = StudentClass::all();

        // Pass the student data and classes to the view
        return view('admin.pages.student.edit', compact('student', 'classes'));
    }

    public function update(Request $request, $id)
    {
        // Check if the user has permission to update
        if (!Auth::user()->hasPermissionTo('student.edit')) {
            abort(403, 'You are not allowed to update student');
        }

        // dd($request->all());

        $validate = $request->validate([
            'firstName' => 'required|string|max:255',
            'middleName' => 'nullable|string|max:255',
            'lastName' => 'required|string|max:255',
            'dob' => 'required|date',
            'gender' => 'required|string',
            'nationality' => 'required|string|max:255',
            'birthCertificateNO' => 'required|string|max:255',
            'class_id' => 'required|exists:student_classes,id',  // Make sure the class exists
            'previousInstitution' => 'nullable|string|max:255',
            'area' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'phone' => 'required|string|max:25',
            'presentAddress' => 'required|string|max:255',
            'emergency_phone' => 'required|string|max:25',
            'studentBloodGroup' => 'nullable|string|max:20',
            'hobby' => 'nullable|string|max:255',
            'specialSkills' => 'nullable|string|max:255',
            'is_sibling' => 'required|boolean',
            'fathersName' => 'required|string|max:255',
            'fathers_occupation' => 'nullable|string|max:255',
            'fathersCompanyName' => 'nullable|string|max:255',
            'fathersOfficeAddress' => 'nullable|string|max:255',
            'fathers_phone' => 'required|string|max:25',
            'mothersName' => 'required|string|max:255',
            'mothers_occupation' => 'nullable|string|max:255',
            'mothersCompanyName' => 'nullable|string|max:255',
            'mothersOfficeAddress' => 'nullable|string|max:255',
            'mothers_phone' => 'required|string|max:25',
            'localGuardianName' => 'required|string|max:255',
            'localGuardian_occupation' => 'nullable|string|max:255',
            'localGuardian_phone' => 'required|string|max:25',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
        ]);

        // Find the student
        $student = Student::findOrFail($id);

        // Handle image upload
        if ($request->hasFile('image')) {
            // Delete the old image if exists
            if ($student->image && Storage::exists('public/' . $student->image)) {
                Storage::delete('public/' . $student->image);
            }

            // Store the new image
            $imagePath = $request->file('image')->store('images', 'public');
            $validate['image'] = $imagePath;
        }

        $student->update($validate);

        // Redirect with success message
        return redirect('admin/getAllStudents')->with('success', 'Student updated successfully.');
    }

    // public function generateInvoice($studentId)
    // {
    //     // Fetch student and related data
    //     $student = Student::find($studentId);
    //     $stationaryBuys = StationaryBuy::where('student_id', $studentId)
    //          ->where(function($query) {
    //                 $query->where('status', '!=', 'paid')
    //             ->orWhereNull('status');
    //         })
    //         ->get();

    //     $monthlyFeeStudent = MonthlyFeeStudent::where('student_id', $studentId)
    //         ->first();

    //     $monthlyFeePayments = MonthlyFeePayment::where('student_id', $studentId)
    //         ->get();

    //     // Generate PDF or handle invoice generation logic
    //     // You can use a package like Laravel PDF to generate the invoice

    //     return view('admin.pages.student.invoice', compact('student', 'stationaryBuys', 'monthlyFeeStudent', 'monthlyFeePayments'));
    // }

    public function generateInvoice($student_id, $month_name)
    {
        // Get the student details
        $student = Student::findOrFail($student_id);

        // Fetch the class ID for the student
        $class_id = $student->class_id;

        // Fetch related monthly fee payments for the specific month and student class
        $monthlyFeePayments = MonthlyFeePayment::join('monthly_fee_students', 'monthly_fee_students.student_id', '=', 'monthly_fee_payments.student_id')
            ->join('monthly_fees', 'monthly_fee_payments.class_id', '=', 'monthly_fees.class_id')
            ->join('students', 'students.id', '=', 'monthly_fee_payments.student_id')
            ->where('monthly_fee_students.student_id', $student_id)
            ->where('monthly_fee_students.month_name', $month_name)
            ->where('monthly_fee_payments.class_id', $class_id)
            ->select('students.*', 'monthly_fee_payments.*', 'monthly_fees.fees_name', 'monthly_fees.fees_amount', 'monthly_fees.sibbling_discount', 'monthly_fee_students.*')
            ->get();
        // dd($monthlyFeePayments[0]->is_sibling);

        // Fetch stationary buys for the specific student
        $stationaryBuys = StationaryBuy::where('student_id', $student_id)
            ->where('status', 'paid')  // Check if the status is 'paid'
            ->whereHas('monthlyFeeStudent', function ($query) {  // Assuming a relationship with monthly_fee_students
                $query->whereColumn('stationary_buys.payment', 'monthly_fee_students.payment_date');  // Match payment dates
            })
            ->with('stationaryFee')  // Assuming 'stationaryFee' is a relationship in StationaryBuy model
            ->get();

        // dd($stationaryBuys);

        // Load the invoice view with the required data
        $pdf = Pdf::loadView('admin.pages.student.invoice', compact('student', 'monthlyFeePayments', 'stationaryBuys'));

        // Return the PDF download
        return $pdf->stream('invoice_' . $student->id . '.pdf', ['Attachment' => false]);
    }

    public function show($id)
    {
        $student = Student::with(['studentClass', 'monthlyFeeStudents', 'stationaryBuys' => function ($query) {
            $query->where('status', 'paid');  // Filter by paid status
        }])
            ->findOrFail($id);

        $eventPayments = EventFeePayment::with('eventFee')->where('student_id', $student->id)->get();

        return view('admin.pages.student.profile', compact('student', 'eventPayments'));
    }

    public function delete($id)
    {
        if (!Auth::user()->hasPermissionTo('student.delete')) {
            abort(403, 'You are not allowed to delete class');
        }
        Student::find($id)->delete();
        return redirect()->back()->with('msg', 'Class deleted successfully');
    }

    public function getAllStudentClassWise()
    {
        if (!Auth::user()->hasPermissionTo('student.create')) {
            abort(403, 'You are not allowed to show ');
        }
        // Fetch monthly fee data grouped by month_name and class_id
        $monthlyFeeStudents = DB::table('monthly_fee_students')
            ->join('students', 'monthly_fee_students.student_id', '=', 'students.id')
            ->join('student_classes', 'students.class_id', '=', 'student_classes.id')  // Join to get class name
            ->select(
                'students.class_id',
                'student_classes.name as class_name',  // Select class name
                DB::raw('count(monthly_fee_students.id) as total_students')  // Counting students per group
            )
            ->groupBy('students.class_id', 'student_classes.name')  // Group by class name
            ->get();
        return view('admin.pages.student.promotion', compact('monthlyFeeStudents'));
    }

    public function getAllStudentClassWiseShifting()
    {
        if (!Auth::user()->hasPermissionTo('student.create')) {
            abort(403, 'You are not allowed to show ');
        }
        // Fetch monthly fee data grouped by month_name and class_id
        $monthlyFeeStudents = DB::table('monthly_fee_students')
            ->join('students', 'monthly_fee_students.student_id', '=', 'students.id')
            ->join('student_classes', 'students.class_id', '=', 'student_classes.id')  // Join to get class name
            ->select(
                'students.class_id',
                'student_classes.name as class_name',  // Select class name
                DB::raw('count(monthly_fee_students.id) as total_students')  // Counting students per group
            )
            ->groupBy('students.class_id', 'student_classes.name')  // Group by class name
            ->get();
        return view('admin.pages.student.shifting', compact('monthlyFeeStudents'));
    }

    public function showDetails(Request $request)
    {
        $classId = $request->query('class');

        $students = DB::table('students')
            ->where('students.class_id', $classId)
            ->select('students.*')  // Select all student fields or specific fields as needed
            ->get();
        return view('admin.pages.student.details', compact('students', 'classId'));
    }

    public function showShiftingDetails(Request $request)
    {
        $classId = $request->query('class');

        $students = DB::table('students')
            ->where('students.class_id', $classId)
            ->select('students.*')  // Select all student fields or specific fields as needed
            ->get();
        return view('admin.pages.student.shiftingDetails', compact('students', 'classId'));
    }

    public function promoteStudents(Request $request)
    {
        $studentIds = $request->input('student_ids');

        if ($studentIds) {
            // Perform the promotion logic
            foreach ($studentIds as $studentId) {
                $student = Student::find($studentId);
               
                if ($student) {
                    // Example promotion logic: increment the student's class
                    $student->class_id += 1;
                    $student->save();
                }
            }
            return redirect()->back()->with('success', 'Selected students have been promoted successfully.');
        }

        return redirect()->back()->with('error', 'No students selected for promotion.');
    }

    public function shiftingStudent(Request $request)
    {
        $studentId = $request->input('student_id');

        $student = Student::find($studentId);
        if ($student) {
            // Example promotion logic: increment the student's class
            $student->class_id += 1;
            $student->save();

            return redirect()->back()->with('success', 'Student has been promoted successfully.');
        }

        return redirect()->back()->with('error', 'Student not found.');
    }
}
