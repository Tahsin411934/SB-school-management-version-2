@extends('admin.layouts.admin')
@section('links')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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
            <button type="button" class="close" data-bs-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="card-body">
            <div class="table-responsive">
                <table id="example" class="table table-bordered"  width="100%" cellspacing="0">
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
                                <!-- <a href="{{ URL::to('admin/edit-admissionFee/' . $class->id) }}"
                                    class="btn btn-warning btn-sm">Edit</a> -->
                                <button type="button" onclick="setFormAction({{ json_encode($class) }})"
                                    class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateModal">
                                    Edit
                                </button>
                                <a data-toggle="modal" data-target="#exampleModal{{ $class->id }}" href=""
                                    class="btn btn-danger ">Reset</a>
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
                                                Are you sure you want to Reset <b>{{ $class->name }}</b> and
                                                its associated fees?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <a href="{{ URL::to('admin/delete-admissionFee/' . $class->id) }}"
                                                    class="btn btn-danger">Reset</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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

<!-- Create Admission Fee Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Create Admission Fee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
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
                                <input type="number" name="fees_amount[]" class="form-control" placeholder="Fees Amount"
                                    required>
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
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="createAdmissionFeeForm" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Admission Fee Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Admission Fee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form class="user" id="updateForm" action="" method="POST">
                    {{ csrf_field() }}
                    @method('PUT')
                    <div class="form-group d-none">
                        <label for="class_id1">Select Class</label>
                        <input type="text" class="form-control" id="class_id1" name="class_id"
                            placeholder="Enter your class ID" required>
                    </div>
                    <div class="form-group">
                        <label for="name">Class Name</label>
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter your class name" required>
                    </div>

                    <h4>Setup Admission Fee</h4>
                    <div id="dynamic-field-container-update"></div>
                    <button type="button" class="btn btn-success mt-2" id="add-field-update">Add Fee</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="updateForm">Save Changes</button>
            </div>
        </div>
    </div>
</div>

@stop

@section('scripts')

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
                        <input type="number" name="sibbling_discount[]" class="form-control" placeholder="Sibling Discount" required>
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

    // Add a new field for update modal
    $('#add-field-update').click(function() {
        $('#dynamic-field-container-update').append(fieldHTML);
    });

    // Remove a field for update modal
    $(document).on('click', '.remove-field', function() {
        $(this).closest('.dynamic-field').remove();
    });
});

function setFormAction(classData) {
    // Populate the 'name' and 'class_id' fields for update modal
    document.getElementById('name').value = classData.name || '';
    document.getElementById('class_id1').value = classData.id || '';

    // Set the form action dynamically for update
    const formAction = `update-admissionFee/${classData.id}`;
    document.getElementById('updateForm').setAttribute('action', formAction);

    // Populate the dynamic fields for admission fees
    const container = document.getElementById('dynamic-field-container-update');
    container.innerHTML = ''; // Clear existing fields

    if (classData.admission_fees && classData.admission_fees.length > 0) {
        classData.admission_fees.forEach(fee => {
            const feeFieldHTML = `
            <div class="row mb-2 dynamic-field">
                <div class="col-md-4">
                    <input type="text" name="fees_name[]" class="form-control" placeholder="Fees Name" value="${fee.fees_name}" required>
                </div>
                <div class="col-md-4">
                    <input type="number" name="fees_amount[]" class="form-control" placeholder="Fees Amount" value="${fee.fees_amount || 0}" required step="0.01">
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="number" name="sibbling_discount[]" class="form-control" placeholder="Sibling Discount" value="${fee.sibbling_discount || 0}" required step="0.01">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger remove-field">Remove</button>
                        </div>
                    </div>
                </div>
            </div>`;
            container.insertAdjacentHTML('beforeend', feeFieldHTML);
        });
    } else {
        container.innerHTML = '<div class="text-center">No Fees Found</div>';
    }
}
</script>
@stop