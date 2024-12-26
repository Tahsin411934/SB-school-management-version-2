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
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Stationary Fee List</h6>
                <a href="{{ URL::to('/admin/create-stationaryFee') }}" class="m-0 font-weight-bold text-primary">Create New
                    Stationary Fee</a>
            </div>
            @if (session('success'))
                <div class="alert alert-success mt-4 a-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" -dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Class Name</th>
                                <th>Fees Name - Fees Amount</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @if ($data)
                                @foreach ($data as $class)
                                    <tr>
                                        <td scope="row">{{ $class->id }}</td>
                                        <td>{{ $class->name }}</td>
                                        <td>
                                            @if ($class->stationaryFees->isEmpty())
                                                <span>No fees found</span>
                                            @else
                                                @foreach ($class->stationaryFees as $fee)
                                                    <p>{{ $fee->fees_name }} - {{ $fee->fees_amount }}</p>
                                                @endforeach
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ URL::to('admin/edit-stationaryFee/' . $class->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            {{-- <a data-toggle="modal" data-target="#exampleModal{{ $class->id }}"
                                                href="" class="btn btn-danger btn-sm">Delete</a>
                                            <div class="modal fade" id="exampleModal{{ $class->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete
                                                                Confirmation
                                                            </h1>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete <b>{{ $class->name }}</b> and
                                                            its associated fees?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <a href="{{ URL::to('admin/delete-stationaryFee/' . $class->id) }}"
                                                                class="btn btn-danger">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> --}}
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6" class="text-center">No Data Found</td>
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
