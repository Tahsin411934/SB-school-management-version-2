<?php

namespace App\Http\Controllers;

use App\Models\EventFee;
use App\Models\EventFeePayment;
use App\Models\Student;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class EventFeePaymentController extends Controller
{
    //
    public function payFee($student_id, $class_id, $event_id)
    {
        // Check if the payment already exists to avoid duplicate payments
        $paymentExists = EventFeePayment::where('student_id', $student_id)
                                        ->where('class_id', $class_id)
                                        ->where('event_id', $event_id)
                                        ->exists();

        if (!$paymentExists) {
            // Insert payment data into event_fee_payments table
            EventFeePayment::create([
                'student_id' => $student_id,
                'class_id' => $class_id,
                'event_id' => $event_id,
            ]);

            // You can add logic to generate an invoice or return the payment status
            // Redirect back with a success message
            return redirect()->back()->with('success', 'Payment successful and invoice generated.');
        }

        return redirect()->back()->with('info', 'Payment already made.');
    }

    public function generateInvoice($student_id, $class_id, $event_id)
    {
        // Get the student and event details
        $student = Student::find($student_id);
        $eventFee = EventFee::find($event_id);

        // Load the invoice view with the required data
        $pdf = Pdf::loadView('admin.pages.eventFee.invoice', compact('student', 'eventFee'));

        // Return the PDF download
        return $pdf->stream('invoice_' . $student->id . '.pdf', ['Attachment' => false]);
    }
}