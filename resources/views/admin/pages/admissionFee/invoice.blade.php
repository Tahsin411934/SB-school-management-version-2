<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice</title>
    <style>
        body {
            font-family: Arial, sans-serif;
        }

        .invoice-box {
            max-width: 800px;
            margin: auto;
            padding: 30px;
            border: 1px solid #eee;
        }

        .table {
            width: 100%;
            margin-top: 20px;
            border-collapse: collapse;
        }

        .table th,
        .table td {
            padding: 10px;
            border: 1px solid #eee;
            text-align: left;
        }

        .table tfoot td {
            font-weight: bold;
        }

        .table tfoot .total {
            text-align: right;
            padding-right: 10px;
        }

        .right-align {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <h1 class="text-center">Invoice</h1>
        <p><strong>Student Name:</strong> {{ $student->firstName }} {{ $student->lastName }}</p>
        <p><strong>Class:</strong> {{ $student->studentClass->name }}</p>
        <p><strong>Payment Type:</strong> {{ $payment->payment_type }}</p>

        <h2>Payment Details</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Fee Name</th>
                    <th>Amount</th>
                    @if ($fees->contains('sibbling_discount'))
                        <!-- Only show if at least one discount exists -->
                        <th>Sibling Discount</th>
                        <th>Amount After Sibling Discount</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @foreach ($fees as $fee)
                    <tr>
                        <td>{{ $fee->fees_name }}</td>
                        <td>{{ $fee->fees_amount }}</td>

                        @if ($student->is_sibling)
                            <!-- Only show if discount exists -->
                            <td>{{ $fee->sibbling_discount }}</td>
                            @php
                                $discountedAmount = $fee->fees_amount - $fee->sibbling_discount;
                            @endphp
                            <td>{{ $discountedAmount }}</td>
                        @endif
                    </tr>
                @endforeach
            </tbody>
            @if ($student->is_sibling)
                <tfoot>
                    <tr>
                        <td colspan="3" class="total">Total:</td>
                        <td class="right-align">{{ $payment->amount }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="total">Discount:</td>
                        <td class="right-align">{{ $payment->discount }}</td>
                    </tr>
                    <tr>
                        <td colspan="3" class="total">Total Paid:</td>
                        <td class="right-align">{{ $payment->total }}</td>
                    </tr>
                </tfoot>
            @else
                <tfoot>
                    <tr>
                        <td colspan="1" class="total">Total:</td>
                        <td class="right-align">{{ $payment->amount }}</td>
                    </tr>
                    <tr>
                        <td colspan="1" class="total">Discount:</td>
                        <td class="right-align">{{ $payment->discount }}</td>
                    </tr>
                    <tr>
                        <td colspan="1" class="total">Total Paid:</td>
                        <td class="right-align">{{ $payment->total }}</td>
                    </tr>
                </tfoot>
            @endif
        </table>
    </div>
</body>

</html>
