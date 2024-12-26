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
                <h2>Monthly Collection and Due Summary for {{ $month }}</h2>

                <h4>Total Collected: {{ number_format($allTotalAmount, 2) }}</h4>
                <h4>Total Due: {{ number_format($monthlyDue, 2) }}</h4>
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
                            @if ($monthlyDetails->isNotEmpty())
                                @foreach ($monthlyDetails as $detail)
                                    <tr>
                                        <td>{{ $detail->firstName }} {{ $detail->lastName }}</td>
                                        <td>{{ $detail->class_name }}</td>
                                        <td>
                                            @if ($detail->status)
                                                Paid
                                            @else
                                                Unpaid
                                            @endif
                                        </td>
                                        <td>{{ $detail->month_name }}</td>
                                        <td>
                                            @if ($detail->payment_date)
                                                {{ \Carbon\Carbon::parse($detail->payment_date)->format('d-m-Y') }}
                                            @else
                                                N/A
                                            @endif
                                        </td>
                                        <td>{{ number_format($detail->total_after_sibling_discount_monthly_fee, 2) }}</td>
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
