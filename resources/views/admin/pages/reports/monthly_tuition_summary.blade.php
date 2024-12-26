@extends('admin.layouts.admin')
@section('links')
    <link href="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Monthly Tuition Summary for {{ $months }}</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Student Name</th>
                                <th>Class</th>
                                <th>Status</th>
                                <th>Month</th>
                                <th>Payment Date</th>
                                <th>Total Amount</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($monthlySummary->isNotEmpty())
                                @foreach ($monthlySummary as $summary)
                                    <tr>
                                        <td>{{ $summary->firstName }} {{ $summary->lastName }}</td>
                                        <td>{{ $summary->class_name }}</td>
                                        <td>
                                            @if ($summary->status)
                                                Paid
                                            @else
                                                Unpaid
                                            @endif
                                        </td>
                                        <td>{{ $summary->month_name }}</td>
                                        <td>
                                            @if ($summary->payment_date)
                                                {{ $summary->payment_date }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ $summary->total_amount }}</td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">No Data Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
    </div>
@stop
@section('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('public/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('public/admin/js/demo/datatables-demo.js') }}"></script>
@stop
