@extends('admin.layouts.admin')

@section('links')
    <link href="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    <!-- Add datepicker CSS -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/css/bootstrap-datepicker.min.css"
        rel="stylesheet">
@stop

@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Students</h1>

        <!-- Date Filter -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Filter by Created Date</h6>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-3">
                        <label for="from_date">From:</label>
                        <input type="text" id="from_date" class="form-control datepicker" placeholder="YYYY-MM-DD"
                            autocomplete="off">
                    </div>
                    <div class="col-md-3">
                        <label for="to_date">To:</label>
                        <input type="text" id="to_date" class="form-control datepicker" placeholder="YYYY-MM-DD"
                            autocomplete="off">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button id="filter" class="btn btn-primary">Filter</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3 d-flex justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Student List</h6>
                <a href="{{ URL::to('/admin/create-student') }}" class="m-0 font-weight-bold text-primary">Create New
                    Student</a>
            </div>
            @if (session('success'))
                <div class="alert alert-success mt-4 alert-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
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
                                <th>Created At</th> <!-- Added Created At Column -->
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
                                        <td>{{ $student->created_at->format('Y-m-d') }}</td> <!-- Display Created At -->
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
    <script src="{{ asset('public/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('public/admin/js/demo/datatables-demo.js') }}"></script>

    <script>
        $(document).ready(function() {
            // Initialize the datepickers
            $('.datepicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true
            });

            // Initialize DataTable
            var table = $('#dataTable').DataTable();

            // Filter button click event
            $('#filter').click(function() {
                var fromDate = $('#from_date').val();
                var toDate = $('#to_date').val();

                // Filter by date range (if both fields have values)
                if (fromDate && toDate) {
                    $.fn.dataTable.ext.search.push(
                        function(settings, data, dataIndex) {
                            var createdAt = data[
                                12]; // Assuming Created At is in the 13th column (index 12)
                            if (createdAt >= fromDate && createdAt <= toDate) {
                                return true;
                            }
                            return false;
                        }
                    );
                    table.draw();
                    $.fn.dataTable.ext.search.pop();
                } else {
                    // Clear filter if no dates are selected
                    table.draw();
                }
            });
        });
    </script>
@stop
