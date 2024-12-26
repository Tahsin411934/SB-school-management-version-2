<?php

namespace App\Http\Controllers;

use App\Models\AdmissionPayment;
use App\Models\MonthlyFeePayment;
use App\Models\MonthlyFeeStudent;
use App\Models\Student;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    //
    public function dailyCollectionReport()
    {
        $today = now()->format('Y-m-d');
    
    // Fetch daily collections
    $dailyCollections = DB::table('monthly_fee_payments')
        ->join('students', 'monthly_fee_payments.student_id', '=', 'students.id') // Join with students
        ->join('monthly_fee_students', 'monthly_fee_payments.student_id', '=', 'monthly_fee_students.student_id') // Join with monthly_fee_students
        ->join('student_classes', 'students.class_id', '=', 'student_classes.id') // Join with student_classes
        ->select(
            'monthly_fee_payments.*',
            'students.firstName',
            'students.lastName',
            'student_classes.name as class_name',
            'monthly_fee_students.month_name',
            'monthly_fee_students.payment_date',
            DB::raw('(monthly_fee_payments.total_after_sibling_discount_monthly_fee + monthly_fee_payments.total_stationary) as total_collected')
        )
        ->where('monthly_fee_students.payment_date', $today) // Filter by today's date in payment_date
        ->whereDate('monthly_fee_payments.created_at', $today) // Filter by today's date in created_at
        ->where('monthly_fee_students.status', true) // Ensure status is 'paid'
        ->get();

        // dd($dailyCollections);
    
    // Calculate the total amount collected for today
    $totalCollected = $dailyCollections->sum('total_collected');

    // dd($totalCollected);
        
        return view('admin.pages.reports.daily_collection', compact('dailyCollections', 'totalCollected'));
    }

    public function getAllStudentMonthlyFee(){

        // Fetch monthly fee data grouped by month_name and class_id
        $monthlyFeeStudents = DB::table('monthly_fee_students')
        ->select('month_name') // Select only the month_name
        ->groupBy('month_name') // Group by month_name to get unique months
        ->get();
        return view('admin.pages.reports.monthlyAll', compact('monthlyFeeStudents'));

    }
    public function getAllStudentDueMonthlyFee(){

        // Fetch monthly fee data grouped by month_name and class_id
        $monthlyFeeStudents = DB::table('monthly_fee_students')
        ->select('month_name') // Select only the month_name
        ->groupBy('month_name') // Group by month_name to get unique months
        ->get();
        return view('admin.pages.reports.monthlyDue', compact('monthlyFeeStudents'));

    }

    public function monthlyTuitionSummary($month)
    {
        $monthlySummary = DB::table('monthly_fee_students')
            ->join('students', 'monthly_fee_students.student_id', '=', 'students.id') // Join with students to get class_id
            ->join('monthly_fee_payments', function ($join) {
                $join->on('monthly_fee_students.student_id', '=', 'monthly_fee_payments.student_id')
                    ->on('monthly_fee_students.payment_date', '=', DB::raw('DATE(monthly_fee_payments.created_at)'));
            })
            ->join('student_classes', 'students.class_id', '=', 'student_classes.id') // Join to get class name
            ->select(
                'monthly_fee_students.status',
                'monthly_fee_students.payment_date',
                'monthly_fee_students.month_name',
                'students.id', // Specific student fields
                'students.firstName', // Add any other student fields you need
                'students.lastName', // Add any other student fields you need
                'students.class_id', // Get class_id from students table
                'student_classes.name as class_name', // Get class name
                DB::raw('SUM(monthly_fee_payments.total_stationary + monthly_fee_payments.total_after_sibling_discount_monthly_fee) as total_amount') // Sum of total_stationary and total_after_sibling_discount_monthly_fee
            )
            ->where('monthly_fee_students.month_name', $month) // Filter by the selected month
            ->groupBy(
                'monthly_fee_students.status',
                'monthly_fee_students.payment_date',
                'monthly_fee_students.month_name',
                'students.id',
                'students.firstName',
                'students.lastName',
                'students.class_id',
                'student_classes.name'
            ) // Group by the correct columns
            ->get();

        // dd($monthlySummary);

        $months = $month;


        return view('admin.pages.reports.monthly_tuition_summary', compact('monthlySummary', 'months'));
    }

    public function monthlyCollectionDueSummary($month)
    {
        // Calculate total collected
        $monthlyPaid = DB::table('monthly_fee_students')
            ->join('students', 'monthly_fee_students.student_id', '=', 'students.id') // Join with students to get class_id
                ->join('monthly_fee_payments', function ($join) {
                    $join->on('monthly_fee_students.student_id', '=', 'monthly_fee_payments.student_id')
                        ->on('monthly_fee_students.payment_date', '=', DB::raw('DATE(monthly_fee_payments.created_at)'));
                })
                ->join('student_classes', 'students.class_id', '=', 'student_classes.id') // Join to get class name
                ->select(
                    'monthly_fee_students.status',
                    'monthly_fee_students.payment_date',
                    'monthly_fee_students.month_name',
                    'students.id', // Specific student fields
                    'students.firstName', // Add any other student fields you need
                    'students.lastName', // Add any other student fields you need
                    'students.class_id', // Get class_id from students table
                    'student_classes.name as class_name', // Get class name
                    DB::raw('SUM(monthly_fee_payments.total_stationary + monthly_fee_payments.total_after_sibling_discount_monthly_fee) as total_amount') // Sum of total_stationary and total_after_sibling_discount_monthly_fee
                )
                ->where('monthly_fee_students.month_name', $month) // Filter by the selected month
                ->groupBy(
                    'monthly_fee_students.status',
                    'monthly_fee_students.payment_date',
                    'monthly_fee_students.month_name',
                    'students.id',
                    'students.firstName',
                    'students.lastName',
                    'students.class_id',
                    'student_classes.name'
                ) // Group by the correct columns
                ->get();
        
        // dd($monthlyPaid);
        $allTotalAmount = $monthlyPaid->sum('total_amount');
        // Calculate total due
        $monthlyDue = DB::table('monthly_fee_students')
            ->whereMonth('month_date', $month)
            ->where('status', false)
            ->join('monthly_fee_payments', function ($join) {
                $join->on('monthly_fee_students.student_id', '=', 'monthly_fee_payments.student_id')
                    ->on('monthly_fee_students.payment_date', '=', DB::raw('DATE(monthly_fee_payments.created_at)'));
            })
            ->sum('monthly_fee_payments.total_after_sibling_discount_monthly_fee');

        // Get detailed records
        $monthlyDetails = DB::table('monthly_fee_students')
            ->join('students', 'monthly_fee_students.student_id', '=', 'students.id') // Join with students to get student details
            ->join('monthly_fee_payments', function ($join) {
                $join->on('monthly_fee_students.student_id', '=', 'monthly_fee_payments.student_id')
                    ->on('monthly_fee_students.payment_date', '=', DB::raw('DATE(monthly_fee_payments.created_at)'));
            })
            ->join('student_classes', 'students.class_id', '=', 'student_classes.id') // Join to get class name
            ->select(
                'monthly_fee_students.month_name',
                'students.firstName',
                'students.lastName',
                'student_classes.name as class_name',
                'monthly_fee_students.status',
                'monthly_fee_students.payment_date',
                DB::raw('SUM(monthly_fee_payments.total_stationary + monthly_fee_payments.total_after_sibling_discount_monthly_fee) as total_amount')
            )
            ->where('monthly_fee_students.month_date', $month) // Filter by the selected month
            ->groupBy('monthly_fee_students.month_name', 'students.id', 'students.firstName', 'students.lastName', 'student_classes.name', 'monthly_fee_students.status', 'monthly_fee_students.payment_date')
            ->get();

            // dd($monthlyDetails);

        return view('admin.pages.reports.monthly_collection_due_summary', compact('monthlyPaid', 'monthlyDue', 'monthlyDetails', 'month', 'allTotalAmount'));
    }

    public function getAllStudents(){
        
         $students = Student::with('studentClass')->get()->map(function ($student) {
            $student->formatted_dob = Carbon::parse($student->dob)->format('d-m-Y');
            return $student;
        });
    
        // Pass the data to the view
        return view('admin.pages.reports.allStudents', compact('students'));
    }
    public function getAllStudentsList(){
        
         $students = Student::with('studentClass')->get()->map(function ($student) {
            $student->formatted_dob = Carbon::parse($student->dob)->format('d-m-Y');
            return $student;
        });
    
        // Pass the data to the view
        return view('admin.pages.reports.allStudentList', compact('students'));
    }

    public function admissionFeeReport(Request $request)
    {
        // Get the total admission fee collections
        $totalCollections = AdmissionPayment::sum('total');

        // Get breakdown of collections by class
        $collectionsByClass = AdmissionPayment::select('class_id', DB::raw('SUM(total) as total'))
            ->groupBy('class_id')
            ->with('studentClass') // Use 'studentClass' to load the relationship
            ->get();

        return view('admin.pages.reports.admission_fee_report', compact('totalCollections', 'collectionsByClass'));
    }

}