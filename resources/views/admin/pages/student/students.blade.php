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
                <h6 class="m-0 font-weight-bold text-primary">Student List for (Class ID: )</h6>
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
                    <table class="table table-bordered" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Class</th>
                                <th>Gender</th>
                                <th>Father Name</th>
                                <th>Mother Name</th>
                                <th>Phone</th>
                                <th>Present Address</th>
                                <th>Action</th> <!-- New column for the action button -->
                            </tr>
                        </thead>
                        <tbody>
                            @if ($students->isNotEmpty())
                                @foreach ($students as $student)
                                    <tr>
                                        <td>{{ $student->id }}</td>
                                        <td>{{ $student->firstName }} {{ $student->lastName }}</td>
                                        <td>{{ $student->StudentClass->name }}</td>
                                        <td>{{ $student->gender }}</td>
                                        <td>{{ $student->fathersName }}</td>
                                        <td>{{ $student->mothersName }}</td>
                                        <td>{{ $student->phone }}</td>
                                        <td>{{ $student->presentAddress }}</td>
                                        <td>
                                            <!-- Form to promote individual student -->
                                            <a href="{{ URL::to('admin/student-profile/' . $student->id) }}"
                                                    class="btn btn-success mb-1 btn-sm">Profile</a> <br>
                                                    <a href="{{ URL::to('admin/edit-student/' . $student->id) }}"
                                                class="btn btn-warning btn-sm mb-1 px-3">Edit</a>
                                            <a data-toggle="modal" data-target="#exampleModal{{ $student->id }}"
                                                class="btn btn-danger btn-sm">Delete</a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">No Students Found</td>
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
