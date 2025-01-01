@extends('admin.layouts.admin')

@section('links')
    <link href="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Students</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Student List</h6>
                <a href="{{ URL::to('/admin/create-student') }}" class="m-0 btn btn-primary font-weight-bold text-white">Create New
                    Student</a>
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
                    <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>First Name</th>
                                <th>Middle Name</th>
                                <th>Last Name</th>
                                <th>Date of Birth</th>
                                <th>Gender</th>
                                <th>Class</th>
                                <th>Phone</th>
                                <th>Present Address</th>
                                <th>Father's Name</th>
                                <th>Mother's Name</th>
                                <th>Payment Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if ($students->count())
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $student->id }}</td>
                                        <td>{{ $student->firstName }}</td>
                                        <td>{{ $student->middleName }}</td>
                                        <td>{{ $student->lastName }}</td>
                                        <td>{{ $student->formatted_dob }}</td>
                                        <td>{{ $student->gender }}</td>
                                        <td>{{ $student->studentClass->name ?? 'N/A' }}</td>
                                        <td>{{ $student->phone }}</td>
                                        <td>{{ $student->presentAddress }}</td>
                                        <td>{{ $student->fathersName }}</td>
                                        <td>{{ $student->mothersName }}</td>
                                        <td>{{ $student->payment_status ? 'Admitted' : 'Due' }}</td>
                                        <td>
                                            @if ($student->payment_status)
                                                <a href="{{ URL::to('admin/student-profile/' . $student->id) }}"
                                                    class="btn btn-success btn-sm">Profile</a>
                                            @endif
                                            @if ($student->payment_status)
                                                <a href="{{ URL::to('admin/generate-invoice/' . $student->id) }}"
                                                    class="btn btn-warn btn-sm">Generate Invoice</a>
                                            @else
                                                <a href="{{ URL::to('admin/admission-payment/' . $student->id) }}"
                                                    class="btn btn-info btn-sm">Pay</a>
                                            @endif
                                            <a href="{{ URL::to('admin/edit-student/' . $student->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <a data-toggle="modal" data-target="#exampleModal{{ $student->id }}"
                                                class="btn btn-danger btn-sm">Delete</a>
                                            <div class="modal fade" id="exampleModal{{ $student->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete
                                                                Confirmation</h1>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete <b>{{ $student->firstName }}
                                                                {{ $student->lastName }}</b>?
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <a href="{{ URL::to('admin/delete-student/' . $student->id) }}"
                                                                class="btn btn-danger">Delete</a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="32" class="text-center">No Data Found</td>
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
   
@stop
