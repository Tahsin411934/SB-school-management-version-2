@extends('admin.layouts.admin')
@section('links')
    <link href="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop
@section('content')
    <h3>Students for Event: {{ $eventDetails->event_title }} (Class: {{ $eventDetails->studentClass->name }})</h3>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Student Name</th>
                <th>Id Number</th>
                <th>Class</th>
                <th>Event</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            @forelse($students as $student)
                <tr>
                    <td>{{ $student->firstName }} {{ $student->lastName }}</td>
                    <td>{{ $student->id }}</td>
                    <td>{{ $student->studentClass->name }}</td>
                    <td>{{ $eventDetails->event_title }}</td>
                    <td>
                        @php
                            // Check if the payment exists for the student, class, and event
                            $paymentExists = \App\Models\EventFeePayment::where('student_id', $student->id)
                                ->where('class_id', $student->class_id)
                                ->where('event_id', $eventDetails->id)
                                ->exists();
                        @endphp

                        @if ($paymentExists)
                            <!-- Show Generate Invoice Button if payment is done -->
                            <form
                                action="{{ route('eventFee.generateInvoice', ['student_id' => $student->id, 'class_id' => $student->class_id, 'event_id' => $eventDetails->id]) }}"
                                method="GET">
                                <button type="submit" class="btn btn-sm btn-info">Generate Invoice</button>
                            </form>
                        @else
                            <!-- Show Pay Button if payment is not done -->
                            <form
                                action="{{ route('eventFee.pay', ['student_id' => $student->id, 'class_id' => $student->class_id, 'event_id' => $eventDetails->id]) }}"
                                method="POST">
                                @csrf
                                <button type="submit" class="btn btn-sm btn-primary">Pay</button>
                            </form>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No students found for this event and class.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
@endsection
@section('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('public/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('public/admin/js/demo/datatables-demo.js') }}"></script>
@stop
