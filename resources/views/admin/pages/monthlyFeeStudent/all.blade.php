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
                <h6 class="m-0 font-weight-bold text-primary">Monthly Fee Student List</h6>
                @if (session('success'))
                <div class="alert alert-success mt-4 a-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" -dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Month</th>
                                <th>Class</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($monthlyFeeStudents->isNotEmpty())
                                @foreach ($monthlyFeeStudents as $fee)
                                    <tr>
                                        <td>{{ $fee->month_name }}</td>
                                        <td>{{ $fee->class_name }}</td>
                                        <td>
                                            <a
                                                href="{{ route('monthlyFeeStudent.details', ['month' => $fee->month_name, 'class' => $fee->class_id]) }}">
                                                Details
                                            </a>
                                        </td>
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
