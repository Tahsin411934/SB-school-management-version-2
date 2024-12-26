@extends('admin.layouts.admin')
@section('links')
    <link href="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>

        <!-- DataTables Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Event Fee Student List</h6>
                @if (session('success'))
                    <div class="alert alert-success mt-4 alert-dismissible" role="alert">
                        {{ session('success') }}
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
                                <th>Class</th>
                                <th>Event Title</th>
                                <th>Total Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($groupedEventFees->isNotEmpty())
                                @foreach ($groupedEventFees as $fee)
                                    <tr>
                                        <form action="{{ route('eventFee.update') }}" method="POST">
                                            @csrf
                                            <td>
                                                <input type="hidden" name="id" value="{{ $fee->id }}">
                                                <input readonly type="text" name="class_name"
                                                    value="{{ $fee->studentClass->name }}" class="form-control">
                                            </td>
                                            <td>
                                                <input readonly type="text" name="event_title"
                                                    value="{{ $fee->event_title }}" class="form-control">
                                            </td>
                                            <td>
                                                <input type="text" name="total_amount" value="{{ $fee->total_amount }}"
                                                    class="form-control">
                                            </td>
                                            <td><a
                                                    href="{{ route('eventFee.details', ['event_name' => $fee->event_title, 'class' => $fee->class_id]) }}">Details</a>
                                                |
                                                <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                            </td>
                                        </form>
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
