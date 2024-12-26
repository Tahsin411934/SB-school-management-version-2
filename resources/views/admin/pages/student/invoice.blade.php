<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            margin: 20px;
        }

        .invoice-header {
            text-align: center;
            margin-bottom: 20px;
        }

        .invoice-details {
            margin-top: 20px;
        }

        .invoice-details table {
            width: 100%;
            border-collapse: collapse;
        }

        .invoice-details th,
        .invoice-details td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="invoice-header">
        <h2>Invoice</h2>
        <p><strong>Student Name:</strong> {{ $student->firstName }} {{ $student->lastName }}</p>
        <p><strong>Class:</strong> {{ $student->studentClass->name }}</p>
        <p><strong>Month:</strong> {{ $monthlyFeePayments->first()->month_name ?? 'N/A' }}</p>
    </div>

    <div class="invoice-details">
        <h3>Monthly Fees</h3>
        <table>
            <thead>
                <tr>
                    <th>Fee Name</th>
                    <th>Fee Amount</th>
                    @if ($monthlyFeePayments[0]->is_sibling == 1)
                        <th>Total Sibling Discount %</th>
                        <th>Total Sibling Discount Price</th>
                    @else
                        <th>Total Price</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @php
                    $totalMonthlyFees = 0;
                    $totalFeesAmount = 0;
                    $totalSiblingDiscount = 0;
                    $totalSiblingDiscountAmount = 0;
                    $totalAmountAfterDiscount = 0;
                @endphp
                @foreach ($monthlyFeePayments as $payment)
                    <tr>
                        <td>{{ $payment->fees_name }}</td>
                        <td>{{ number_format($payment->fees_amount, 2) }}</td>
                        @if ($monthlyFeePayments[0]->is_sibling == 1)
                            @php
                                // Calculate the sibling discount amount
                                $siblingDiscountAmount = ($payment->fees_amount * $payment->sibbling_discount) / 100;
                                // Calculate the amount after discount
                                $amountAfterDiscount = $payment->fees_amount - $siblingDiscountAmount;
                            @endphp
                            <td>{{ $payment->sibbling_discount }}</td>
                            <td>{{ number_format($amountAfterDiscount, 2) }}</td>
                            <!-- Display the amount after discount -->
                        @else
                            <td>{{ number_format($payment->fees_amount, 2) }}</td>
                            <!-- Display original fee if no sibling discount -->
                        @endif
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr>
                    <td><strong>Total</strong></td>
                    @if ($monthlyFeePayments[0]->is_sibling == 1)
                        {{-- For sibling discount --}}
                        <td colspan="4" style="text-align: right;">
                            {{ number_format($payment->total_after_sibling_discount_monthly_fee, 2) }}</td>
                        @php
                            $totalMonthlyFees += $payment->total_after_sibling_discount_monthly_fee;
                        @endphp
                    @else
                        {{-- For no sibling discount --}}
                        @php
                            $totalMonthlyFees += $payment->fees_amount;
                        @endphp
                        <td colspan="4" style="text-align: right;">
                            {{ number_format($payment->total_after_sibling_discount_monthly_fee, 2) }}
                        </td>
                    @endif
                </tr>
            </tfoot>

        </table>

        <h3>Stationary Purchases</h3>
        <table>
            <thead>
                <tr>
                    <th>Stationary Item</th>
                    <th>Quantity</th>
                    <th>Total</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $totalStationary = 0;
                @endphp
                @foreach ($stationaryBuys as $buy)
                    <tr>
                        <td>{{ $buy->stationaryFee->fees_name }}</td>
                        <td>{{ $buy->quantity }}</td>
                        <td>{{ number_format($buy->total, 2) }}</td>
                        @php
                            $totalStationary += $buy->total;
                        @endphp
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Grand Total</h3>
        <table>
            <tfoot>
                <tr>
                    <td colspan="2" class="total">Grand Total</td>
                    <td class="total">
                        {{ number_format($totalStationary + $payment->total_after_sibling_discount_monthly_fee, 2) }}
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</body>

</html>
