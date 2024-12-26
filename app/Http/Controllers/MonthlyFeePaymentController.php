<?php

namespace App\Http\Controllers;

use App\Models\MonthlyFeePayment;
use App\Models\MonthlyFeeStudent;
use App\Models\StationaryBuy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class MonthlyFeePaymentController extends Controller
{
    

   
    public function store(Request $request)
    {
        

        // L
        // Format the numeric values to remove commas
        $totalAfterSiblingDiscount = str_replace(',', '', $request['total_after_sibling_discount_monthly_fee']);
        $totalStationary = str_replace(',', '', $request['total_stationary'] ?? 0);

        try {
            DB::transaction(function () use ($request, $totalAfterSiblingDiscount, $totalStationary) {
                // Log the validated data for debugging
                Log::info('Creating MonthlyFeePayment with data: ', [
                    'class_id' => $request['class_id'],
                    'student_id' => $request['student_id'],
                    'total_stationary' => $totalStationary,
                    'monthly_fees_id' => $request['monthly_fees_id'],
                    'total_after_sibling_discount_monthly_fee' => $totalAfterSiblingDiscount,
                ]);

                // Create the MonthlyFeePayment record
                $monthlyFeePayment = MonthlyFeePayment::create([
                    'class_id' => $request['class_id'],
                    'student_id' => $request['student_id'],
                    'total_stationary' => $totalStationary,
                    'monthly_fees_id' => $request['monthly_fees_id'],
                    'total_after_sibling_discount_monthly_fee' => $totalAfterSiblingDiscount,
                ]);

                if (!$monthlyFeePayment) {
                    throw new \Exception('MonthlyFeePayment creation failed.');
                }

                // Only update stationary buys if they exist
                if (isset($request['stationary_buys_ids']) && count($request['stationary_buys_ids']) > 0) {
                    StationaryBuy::whereIn('id', $request['stationary_buys_ids'])
                        ->update([
                            'status' => 'paid',
                            'payment' => now(),
                        ]);
                }

                // Update MonthlyFeeStudent records
                MonthlyFeeStudent::where('student_id', $request['student_id'])
                    ->update([
                        'status' => true,
                        'payment_date' => now(),
                    ]);
            });

            return redirect()->back()->with('success', 'Payment recorded successfully.');

        } catch (\Exception $e) {
            // Log detailed error
            Log::error('Error storing payment data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while recording the payment.');
        }
    }







}