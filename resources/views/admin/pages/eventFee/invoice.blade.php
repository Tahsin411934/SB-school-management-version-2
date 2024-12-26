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
        }

        .invoice-header {
            text-align: center;
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
    <h2 class="invoice-header">Event Fee Invoice</h2>

    <div class="invoice-details">
        <p><strong>Student Name:</strong> {{ $student->firstName }} {{ $student->lastName }}</p>
        <p><strong>Class:</strong> {{ $student->studentClass->name }}</p>
        <p><strong>Student ID:</strong> {{ $student->id }}</p>
        {{-- <p><strong>Event:</strong> {{ $eventFee->event_title }}</p> --}}
        {{-- <p><strong>Amount:</strong> {{ $eventFee->event_amount }}</p> --}}

        <table>
            <thead>
                <tr>
                    <th>Event Name</th>
                    <th>Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>{{ $eventFee->event_title }}</td>
                    <td>{{ $eventFee->event_amount }}</td>
                </tr>
                <tr>
                    <td class="total">Total</td>
                    <td class="total">{{ $eventFee->event_amount }}</td>
                </tr>
            </tbody>
        </table>
    </div>
</body>

</html>
