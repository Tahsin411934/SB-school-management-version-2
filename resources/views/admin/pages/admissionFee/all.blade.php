@extends('admin.layouts.admin')
@section('links')
@stop
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Admission Fee List</h6>
            <!-- Button to trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                Create New Admission Fee
            </button>
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
                <table id="example" class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
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
                                @if ($class->admissionFees->isEmpty())
                                <span>No fees found</span>
                                @else
                                @foreach ($class->admissionFees as $fee)
                                <p>{{ $fee->fees_name }} - {{ $fee->fees_amount }}</p>
                                @endforeach
                                @endif
                            </td>

                            <td>
                                <a href="{{ URL::to('admin/edit-admissionFee/' . $class->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a>
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






    <!-- Modal Structure -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <!-- Added modal-lg for larger width -->
            <div class="modal-content">
                <!-- Modal Header -->
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Create Admission Fee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <!-- Modal Body -->
                <div class="modal-body">
                    <form id="createAdmissionFeeForm" action="{{ URL::to('admin/store-admissionFee') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <label for="class_id">Select Class</label>
                            <select class="form-control" id="class_id" name="class_id" required>
                                <option value="" disabled selected>Select your class</option>
                                @foreach ($studentClasses as $class)
                                <option value="{{ $class->id }}"
                                    {{ in_array($class->id, $classesWithAdmissionFees) ? 'disabled' : '' }}>
                                    {{ $class->name }}
                                </option>
                                @endforeach
                            </select>
                        </div>
                        <div id="dynamic-field-container">
                            <h4>Setup Admission Fee</h4>
                            <div class="row mb-2 dynamic-field">
                                <div class="col-md-4">
                                    <input type="text" name="fees_name[]" class="form-control" placeholder="Fees Name"
                                        required>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="fees_amount[]" class="form-control"
                                        placeholder="Fees Amount" required>
                                </div>
                                <div class="col-md-4">
                                    <input type="number" name="sibbling_discount[]" class="form-control"
                                        placeholder="Sibbling Discount" required>
                                </div>
                            </div>
                        </div>
                        <button type="button" class="btn btn-success mt-3" id="add-field">Add Field</button>
                    </form>
                </div>
                <!-- Modal Footer -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    <button type="submit" form="createAdmissionFeeForm" class="btn btn-primary">Save changes</button>
                </div>
            </div>
        </div>
    </div>

</div>
@stop

@section('scripts')
<!-- Page level plugins -->





<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script type="text/javascript">
$(document).ready(function() {
    let fieldHTML = `
            <div class="row mb-2 dynamic-field">
                <div class="col-md-4">
                    <input type="text" name="fees_name[]" class="form-control" placeholder="Fees Name" required>
                </div>
                <div class="col-md-4">
                    <input type="number" name="fees_amount[]" class="form-control" placeholder="Fees Amount" required>
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="number" name="sibbling_discount[]" class="form-control" placeholder="Sibbling Discount" required>
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger remove-field">Remove</button>
                        </div>
                    </div>
                </div>
            </div>`;

    // Add a new field on button click
    $('#add-field').click(function() {
        $('#dynamic-field-container').append(fieldHTML);
    });

    // Remove a field
    $(document).on('click', '.remove-field', function() {
        $(this).closest('.dynamic-field').remove();
    });
});
</script>
@stop