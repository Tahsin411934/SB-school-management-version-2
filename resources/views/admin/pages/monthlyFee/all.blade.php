@extends('admin.layouts.admin')

@section('links')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@stop

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Monthly Fee List</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Monthly Fee List</h6>
            <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                data-bs-target="#createMonthlyFeeModal">
                Create New Monthly Fee
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
                <table id="example" class="table table-bordered" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Name</th>
                            <th>Due Date</th>
                            <th>Due Fine</th>
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
                                @if ($class->monthlyFees->isNotEmpty())
                                {{ $class->monthlyFees[0]->due_date }}
                                @else
                                <span>No due date</span>
                                @endif
                            </td>
                            <td>
                                @if ($class->monthlyFees->isNotEmpty())
                                {{ $class->monthlyFees[0]->due_fine }}
                                @else
                                <span>No due fine</span>
                                @endif
                            </td>
                            <td>
                                @if ($class->monthlyFees->isEmpty())
                                <span>No fees found</span>
                                @else
                                @foreach ($class->monthlyFees as $fee)
                                <p>{{ $fee->fees_name }} - {{ $fee->fees_amount }}</p>
                                @endforeach
                                @endif
                            </td>
                            <td>
                                <button type="button" onclick="setMonthlyFeeFormAction({{ json_encode($class) }})"
                                    class="btn btn-primary" data-bs-toggle="modal"
                                    data-bs-target="#updateMonthlyFeeModal">
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
                                                Are you sure you want to delete <b>{{ $class->name }}</b> and
                                                its associated fees?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <a href="{{ URL::to('admin/delete-monthlyFee/' . $class->id) }}"
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

<!-- Create Monthly Fee Modal -->
<div class="modal fade" id="createMonthlyFeeModal" tabindex="-1" aria-labelledby="createMonthlyFeeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createMonthlyFeeModalLabel">Create Monthly Fee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form id="createMonthlyFeeForm" action="{{ URL::to('admin/store-monthlyFee') }}" method="POST">
                    {{ csrf_field() }}
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Select your class</label>
                                <select class="form-control" id="class_id" name="class_id">
                                    <option value="" disabled selected>Select your class</option>
                                    @foreach ($studentClasses as $class)
                                    <option value="{{ $class->id }}"
                                        {{ old('class_id') == $class->id ? 'selected' : '' }}
                                        {{ in_array($class->id, $classesWithAdmissionFees) ? 'disabled style=color:grey;' : '' }}>
                                        {{ $class->name }}
                                    </option>
                                    @endforeach
                                </select>
                                @if ($errors->has('class_id'))
                                <span class="text-danger">{{ $errors->first('class_id') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Monthy Due Date</label>
                                <input type="date" name="due_date" class="form-control" placeholder="Monthy Due Date"
                                    required>
                                @if ($errors->has('due_date'))
                                <span class="text-danger">{{ $errors->first('due_date') }}</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="">Monthy Due Fine</label>
                                <input type="number" name="due_fine" class="form-control" placeholder="Monthy Due Date"
                                    required>
                                @if ($errors->has('due_fine'))
                                <span class="text-danger">{{ $errors->first('due_fine') }}</span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <div id="dynamic-field-container">
                        <h4>Setup Monthly Fee</h4>
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
                <button type="submit" form="createMonthlyFeeForm" class="btn btn-primary">Save changes</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Monthly Fee Modal -->
<div class="modal fade" id="updateMonthlyFeeModal" tabindex="-1" aria-labelledby="updateMonthlyFeeModalLabel"
    aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateMonthlyFeeModalLabel">Update Monthly Fee</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">X</button>
            </div>
            <div class="modal-body">
                <form id="updateMonthlyFeeForm" action="" method="POST">
                    {{ csrf_field() }}
                    @method('PUT')

                    <div class="row mb-3">
                        <!-- Hidden Class ID Input -->
                        <div class="col-12 d-none">
                            <div class="form-group">
                                <label for="class_id1">Select Class</label>
                                <input type="text" class="form-control" id="class_id1" name="class_id"
                                    placeholder="Enter your class ID" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="name">Class Name</label>
                                <input type="text" class="form-control" id="name" name="name"
                                    placeholder="Enter your class name" required>
                            </div>
                        </div>
                        <!-- Monthly Due Date -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="due_date">Monthly Due Date</label>
                                <input type="date" name="due_date" class="form-control" placeholder="Monthly Due Date"
                                    required>
                            </div>
                        </div>

                        <!-- Monthly Due Fine -->
                        <div class="col-md-4">
                            <div class="form-group">
                                <label for="due_fine">Monthly Due Fine</label>
                                <input type="number" name="due_fine" class="form-control" placeholder="Monthly Due Fine"
                                    required>
                            </div>
                        </div>

                        <!-- Class Name -->

                    </div>

                    <!-- Setup Monthly Fee Section -->
                    <h4 class="mt-4">Setup Monthly Fee</h4>
                    <div id="dynamic-field-container-update"></div>
                    <button type="button" class="btn btn-success mt-2" id="add-field-update">Add Fee</button>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary" form="updateMonthlyFeeForm">Save Changes</button>
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

    // Add a new field on button click for create modal
    $('#add-field').click(function() {
        $('#dynamic-field-container').append(fieldHTML);
    });

    // Remove a field for create modal
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

// Set form action and populate fields for update modal
function setMonthlyFeeFormAction(classData) {
    document.getElementById('name').value = classData.name || '';
    document.getElementById('class_id1').value = classData.id || '';
    const formAction = `update-monthlyFee/${classData.id}`;
    document.getElementById('updateMonthlyFeeForm').setAttribute('action', formAction);

    const container = document.getElementById('dynamic-field-container-update');
    container.innerHTML = ''; // Clear existing fields

    if (classData.monthly_fees && classData.monthly_fees.length > 0) {
        classData.monthly_fees.forEach(fee => {
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