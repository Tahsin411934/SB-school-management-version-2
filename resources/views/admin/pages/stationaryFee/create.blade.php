@extends('admin.layouts.admin')

@section('content')
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            {{-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> --}}
            <div class="offset-1 col-lg-10">
                <div class="mt-3">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Create Stationary Fee</h6>
                            @if (Session::has('msg'))
                                <div class="alert alert-success mt-4">
                                    <strong>{{ Session::get('msg') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <form class="user" action="{{ URL::to('admin/store-stationaryFee') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for=""></label>
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
                                </div>
                                <!-- Container for dynamically added fields -->
                                <h4>Setup Stationary Fee</h4>
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="dynamic-field-container">
                                            <div class="row mb-2 dynamic-field">
                                                <div class="col-md-4">
                                                    <input type="text" name="fees_name[]" class="form-control"
                                                        placeholder="Fees Name" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <input type="number" name="fees_amount[]" class="form-control"
                                                        placeholder="Fees Amount" required>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="input-group">
                                                        <input type="number" name="sibbling_discount[]"
                                                            class="form-control" placeholder="Sibbling Discount" required>
                                                        <div class="input-group-append">
                                                            {{-- <button type="button"
                                                        class="btn btn-danger remove-field">Remove</button> --}}
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-success" id="add-field">Add Field</button>
                                    </div>
                                </div>
                                <input name="submit" type="submit" value="Create"
                                    class="mt-3 btn btn-primary btn-user btn-block">
                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop


<!-- JavaScript to handle dynamic fields -->
<!-- JavaScript to handle dynamic fields -->
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
