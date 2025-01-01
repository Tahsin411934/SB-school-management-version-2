@extends('admin.layouts.admin')

@section('links')
<link href="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Event Fee Management</h1>

    <!-- Event Fee Student List -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Event Fee Student List</h6>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#createEventFeeModal">
                    Create Event Fee
                </button>
            </div>


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
                        @forelse ($groupedEventFees as $fee)
                        <tr>
                            <form action="{{ route('eventFee.update') }}" method="POST">
                                @csrf
                                <td>
                                    <input type="hidden" name="id" value="{{ $fee->id }}">
                                    <input readonly type="text" name="class_name" value="{{ $fee->studentClass->name }}"
                                        class="form-control">
                                </td>
                                <td>
                                    <input readonly type="text" name="event_title" value="{{ $fee->event_title }}"
                                        class="form-control">
                                </td>
                                <td>
                                    <input type="text" name="total_amount" value="{{ $fee->total_amount }}"
                                        class="form-control">
                                </td>
                                <td>
                                    <a href="{{ route('eventFee.details', ['event_name' => $fee->event_title, 'class' => $fee->class_id]) }}"
                                        class="btn btn-info btn-sm">Details</a>
                                    <button type="submit" class="btn btn-primary btn-sm">Update</button>
                                </td>
                            </form>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="text-center">No Data Found</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="createEventFeeModal" tabindex="-1" role="dialog" aria-labelledby="createEventFeeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createEventFeeModalLabel">Create Event Fee</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::to('admin/store-eventFee') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="event_title">Event Title</label>
                        <input type="text" name="event_title" class="form-control" placeholder="Enter Event Title"
                            required>
                    </div>
                    <div class="form-group">
                        <label for="event_amount">Event Amount</label>
                        <input type="number" name="event_amount" class="form-control" placeholder="Enter Event Amount"
                            required>
                    </div>
                    <button type="submit" class="btn btn-primary btn-block">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>
@stop

@section('scripts')
<script src="{{ asset('public/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="{{ asset('public/admin/js/demo/datatables-demo.js') }}"></script>
@stop