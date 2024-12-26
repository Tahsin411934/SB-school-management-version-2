@extends('admin.layouts.admin')

@section('content')
    <div class="card-body p-0">
        <h2>Daily Collection Report for {{ now()->format('d-m-Y') }}</h2>
        <table class="table">
            <thead>
                <tr>
                    <th>Student Name</th>
                    <th>Class</th>
                    <th>Total Collected</th>
                    <th>Payment Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($dailyCollections as $collection)
                    <tr>
                        <td>{{ $collection->firstName }} {{ $collection->lastName }}</td>
                        <td>{{ $collection->class_name }}</td>
                        <td>{{ $collection->total_collected }}</td>
                        <td>{{ $collection->payment_date }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h4>Total Collected: {{ $totalCollected }}</h4>

    </div>
@stop
