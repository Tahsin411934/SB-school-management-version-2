@extends('admin.layouts.admin')

@section('content')
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="offset-1 col-lg-10">
                <div class="">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edit monthly Fee</h6>
                            @if (Session::has('msg'))
                                <div class="alert alert-success mt-4">
                                    <strong>{{ Session::get('msg') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <form class="user" action="{{ URL::to('admin/update-monthlyFee/' . $data->id) }}"
                                method="POST">
                                {{ csrf_field() }}
                                {{ method_field('PUT') }}

                                <!-- Class Selection -->
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="class_id">Class</label>
                                            <select class="form-control" id="class_id" name="class_id">
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}"
                                                        {{ $data->class_id == $class->id ? 'selected' : '' }}>
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
                                            <label for="due_date">Monthly Due Date</label>
                                            <input type="date" name="due_date" class="form-control"
                                                placeholder="Monthly Due Date"
                                                value="{{ old('due_fine', isset($data->studentClass->monthlyFees[0]) ? $data->studentClass->monthlyFees[0]->due_date : '') }}">
                                            @if ($errors->has('due_date'))
                                                <span class="text-danger">{{ $errors->first('due_date') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="due_fine">Monthly Due Fine</label>
                                            <input type="number" name="due_fine" class="form-control"
                                                placeholder="Monthly Due Fine"
                                                value="{{ old('due_fine', isset($data->studentClass->monthlyFees[0]) ? $data->studentClass->monthlyFees[0]->due_fine : '') }}">
                                            @if ($errors->has('due_fine'))
                                                <span class="text-danger">{{ $errors->first('due_fine') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>


                                <!-- Dynamic Fields Container -->
                                <h4>Setup Admission Fee</h4>
                                <div id="dynamic-field-container">
                                    @forelse ($data->studentClass->monthlyFees as $index => $fee)
                                        <div class="row mb-2 dynamic-field">
                                            <div class="col-md-4">
                                                <input type="text" name="fees_name[]" class="form-control"
                                                    placeholder="Fees Name" value="{{ $fee->fees_name }}" required>
                                            </div>
                                            <div class="col-md-4">
                                                <input type="number" name="fees_amount[]" class="form-control"
                                                    placeholder="Fees Amount" value="{{ $fee->fees_amount }}" required
                                                    step="0.01">
                                            </div>
                                            <div class="col-md-4">
                                                <div class="input-group">
                                                    <input type="number" name="sibbling_discount[]" class="form-control"
                                                        placeholder="Sibling Discount"
                                                        value="{{ $fee->sibbling_discount }}" step="0.01">
                                                    <div class="input-group-append">
                                                        <button type="button"
                                                            class="btn btn-danger remove-field">Remove</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @empty
                                        <div class="text-center">No Fees Found</div>
                                    @endforelse
                                </div>

                                <button type="button" class="btn btn-success" id="add-field">Add Field</button>

                                <input name="submit" type="submit" value="Update"
                                    class="btn btn-primary btn-user btn-block mt-3">
                            </form>
                        </div>

                    </div>



                </div>
            </div>
        </div>
    </div>

    <!-- JavaScript for Dynamic Fields -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const container = document.getElementById('dynamic-field-container');
            const addButton = document.getElementById('add-field');

            addButton.addEventListener('click', function() {
                const newField = document.createElement('div');
                newField.classList.add('row', 'mb-2', 'dynamic-field');
                newField.innerHTML = `
                <div class="col-md-4">
                    <input type="text" name="fees_name[]" class="form-control" placeholder="Fees Name" required>
                </div>
                <div class="col-md-4">
                    <input type="number" name="fees_amount[]" class="form-control" placeholder="Fees Amount" required step="0.01">
                </div>
                <div class="col-md-4">
                    <div class="input-group">
                        <input type="number" name="sibbling_discount[]" class="form-control" placeholder="Sibling Discount" required step="0.01">
                        <div class="input-group-append">
                            <button type="button" class="btn btn-danger remove-field">Remove</button>
                        </div>
                    </div>
                </div>
            `;
                container.appendChild(newField);
            });

            container.addEventListener('click', function(e) {
                if (e.target && e.target.classList.contains('remove-field')) {
                    e.target.closest('.dynamic-field').remove();
                }
            });
        });
    </script>
@stop
