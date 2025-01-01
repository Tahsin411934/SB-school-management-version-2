<?php

namespace App\Http\Controllers;

use App\Models\MonthlyFee;
use App\Models\MonthlyFeeStudent;
use App\Models\StationaryBuy;
use App\Models\Student;
use App\Models\StudentClass;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MonthlyFeeStudentController extends Controller
{
    //
    public function create(){
        if(!Auth::user()->hasPermissionTo('monthlyFeeStudent.create')){
            abort(403, 'You are not allowed to create admissionFee');
        }
        return view('admin.pages.monthlyFeeStudent.create');
    }
    public function storeStudentMonthlyFee(Request $request)
    {
        // Get the current month name and date
        $monthName = date('F'); // e.g., September
        $monthDate = date('Y-m-d'); // e.g., 2024-09-10

        // Fetch all students with payment_status = true
        $students = Student::where('payment_status', true)->get();

        // Loop through the students and insert monthly fees
        foreach ($students as $student) {
            MonthlyFeeStudent::create([
                'student_id' => $student->id,
                'month_name' => $monthName,
                'month_date' => $monthDate,
                'status' => 'false', // Default status
                'payment_date' => null, // Default payment date
            ]);
        }

        // Redirect back with a success message
        return redirect('admin/getAllMonthlyFee')->with('success', 'Monthly fees generated successfully for all eligible students.');
    }

    public function getAllStudentMonthlyFee(){
        if(!Auth::user()->hasPermissionTo('monthlyFeeStudent.view')){
            abort(403, 'You are not allowed to create admissionFee');
        }
        // Fetch monthly fee data grouped by month_name and class_id
        $monthlyFeeStudents = DB::table('monthly_fee_students')
        ->join('students', 'monthly_fee_students.student_id', '=', 'students.id')
        ->join('student_classes', 'students.class_id', '=', 'student_classes.id') // Join to get class name
        ->select(
            'monthly_fee_students.month_name',
            'students.class_id',
            'student_classes.name as class_name', // Select class name
            DB::raw('count(monthly_fee_students.id) as total_students') // Counting students per group
        )
        ->groupBy('monthly_fee_students.month_name', 'students.class_id', 'student_classes.name') // Group by class name
        ->get();
        return view('admin.pages.monthlyFeeStudent.all', compact('monthlyFeeStudents'));

    }

    public function showDetails(Request $request)
    {
        $month = $request->query('month');
        $classId = $request->query('class');


        $students = DB::table('monthly_fee_students')
        ->join('students', 'monthly_fee_students.student_id', '=', 'students.id')
        ->where('monthly_fee_students.month_name', $month)
        ->where('students.class_id', $classId)
        ->select(
            'students.*', 
            'monthly_fee_students.*', 
            'monthly_fee_students.student_id as mfs_student_id' // Alias for student_id
        )
        ->get();
    

        

        return view('admin.pages.monthlyFeeStudent.details', compact('students', 'month', 'classId'));
    }

    public function MonthlyFee($id)
    {
        $student = Student::findOrFail($id);
        $classes = StudentClass::all();
        $data = MonthlyFee::with('studentClass')->where('class_id', $student->class_id)->first();
        $is_sibling = $student->is_sibling;
        //here i want to check today date is big then $data->due_date i want to show due fine
        // Check if $data is not null to avoid errors
        if ($data) {

            $dueDate = Carbon::parse($data->due_date); 
            // Check if today’s date is past the due date
            if (now()->gt( $dueDate)) {
                // Calculate the fine or set a flag to indicate a fine is due
                $dueFine = $data->due_fine; // Example calculation, adjust as needed
            } else {
                $dueFine = 0; // No fine if the due date hasn't passed
            }
        } else {
            $dueFine = 0; // No fine if no data found
        }

        // dd($dueFine);

        return view('admin.pages.monthlyFeeStudent.feeData', compact('student', 'classes', 'data', 'is_sibling', 'dueFine'));
    }

    public function getStationaryFeeData($studentId)
    {
        $stationaryData = StationaryBuy::where('student_id', $studentId)
            ->with('stationaryFee') // Assuming `stationaryFee` is a relationship in StationaryBuy model
             ->where(function($query) {
                    $query->where('status', '!=', 'paid')
                ->orWhereNull('status');
            })
            ->get();

        $response = $stationaryData->map(function($item) {
            return [
                'id' => $item['id'],
                'fee_name' => $item->stationaryFee->fees_name, // Adjust according to your model's attribute
                'quantity' => $item->quantity,
                'total' => number_format($item->total, 2)
            ];
        });

        return response()->json($response);
    }


}