<?php

namespace App\Http\Controllers;

use App\Models\AdmissionFee;
use App\Models\AdmissionPayment;
use App\Models\Student;
use App\Models\StudentClass;
use App\Models\StudentLedger;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class AdmissionPaymentController extends Controller
{
    //
    public function create($id)
    {
        $student = Student::findOrFail($id);
        $classes = StudentClass::all();
        $data = AdmissionFee::with('studentClass')->where('class_id', $student->class_id)->first();
        
        $is_sibling = $student->is_sibling;
        return view('admin.pages.admissionPayment.create', compact('student', 'classes', 'data', 'is_sibling'));
    }

    public function store(Request $request)
    {
        // Replace commas in the amount, discount, and total fields to make them numeric
        $request->merge([
            'amount' => str_replace(',', '', $request->amount),
            'discount' => str_replace(',', '', $request->discount ?? 0),  // Default to 0 if discount is null
            'total' => str_replace(',', '', $request->total),
        ]);

        // Validate the request inputs
        $data = $request->validate([
            'student_id' => 'required|exists:students,id',
            'payment_type' => 'required|string',
            'class_id' => 'required|exists:student_classes,id',
            'amount' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'total' => 'required|numeric',
        ]);

        // Calculate total and store the data in the database
        $admissionPayment = new AdmissionPayment();
        $admissionPayment->student_id = $request->student_id;
        $admissionPayment->payment_type = $request->payment_type;
        $admissionPayment->class_id = $request->class_id;
        $admissionPayment->amount = $request->amount;
        $admissionPayment->discount = $request->discount ?? 0;  // Assign a default value of 0 if null
        $admissionPayment->total = $request->total;

        // Save to the database
        if ($admissionPayment->save()) {
            // Update the student's payment_status to true
            $student = Student::find($request->student_id);
            $ledger = StudentLedger::where('StudentID', $request->student_id)->first();
          
            if ($student) {
                $student->payment_status = true;  // Assuming 'payment_status' is a boolean field
                $student->save();  // Save the updated student
            }
            if ($ledger) {
                $ledger->Status = 'paid';  // Update the ledger status
                $ledger->Received = $ledger->Received + $request->total;  // Add the payment total to the received amount
                $ledger->save();
            }

            // Redirect to the student listing or another page with a success message
            return redirect('admin/generate-invoice/' . $student->id)
                ->with('success', 'Admission payment saved successfully!');
        }

        // Handle failure in saving payment (optional)
        return back()->with('error', 'There was an issue saving the payment.');
    }

    public function generateInvoice($student_id)
    {
        // Fetch the student, payment, and fee details
        $student = Student::find($student_id);
        $payment = AdmissionPayment::where('student_id', $student_id)->first();
        $fees = AdmissionFee::where('class_id', $student->class_id)->get();

        if (!$payment) {
            return redirect()->back()->with('error', 'No payment record found for this student.');
        }

        // Load the view and generate the PDF
        $pdf = Pdf::loadView('admin.pages.admissionFee.invoice', compact('student', 'payment', 'fees'));

        // Stream the generated invoice PDF in the browser
        return $pdf->stream('invoice_' . $student->id . '.pdf', ['Attachment' => false]);
    }
}
