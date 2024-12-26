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
                <h6 class="m-0 font-weight-bold text-primary">Student List for (Class ID:
                    {{ $classId }})</h6>
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
                <form action="{{ route('student.promote') }}" method="POST">
                    @csrf
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th><input type="checkbox" id="selectAll"></th> <!-- Checkbox for select all -->
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Class</th>
                                    <!-- Add more columns as needed -->
                                </tr>
                            </thead>
                            <tbody>
                                @if ($students->isNotEmpty())
                                    @foreach ($students as $student)
                                        <tr>
                                            <td><input type="checkbox" name="student_ids[]" value="{{ $student->id }}">
                                            </td>
                                            <!-- Checkbox for individual student -->
                                            <td>{{ $student->id }}</td>
                                            <td>{{ $student->firstName }} {{ $student->lastName }}</td>
                                            <td>{{ $student->class_id }}</td>
                                            <!-- Add more columns as needed -->
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="4" class="text-center">No Students Found</td>
                                        <!-- Adjusted colspan -->
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                    <!-- Promotion Button -->
                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary">Promote Selected Students</button>
                    </div>
                </form>
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

    <script>
        // Select/Deselect all checkboxes
        $('#selectAll').click(function(e) {
            $('input[name="student_ids[]"]').prop('checked', this.checked);
        });
    </script>
@stop
