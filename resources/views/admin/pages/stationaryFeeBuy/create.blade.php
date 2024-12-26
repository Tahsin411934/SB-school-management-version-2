@extends('admin.layouts.admin')

@section('content')
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="offset-1 col-lg-10">
                <div class="">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Create Stationary Fee</h6>
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
                            <form class="user" action="{{ URL::to('admin/store-stationaryFeeBuy') }}" method="POST">
                                {{ csrf_field() }}

                                <h4>Setup Stationary Fee</h4>

                                <!-- Class Dropdown -->
                                <div class="row mb-3">
                                    <div class="col-md-6">
                                        <label for="class_id">Select Class</label>
                                        <select name="class_id" id="class_id" class="form-control" required>
                                            <option value="">Select Class</option>
                                            @foreach ($classes as $class)
                                                <option value="{{ $class->id }}">{{ $class->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <!-- Student ID input -->
                                    <div class="col-md-6">
                                        <label for="student_id">Select Student</label>
                                        <select name="student_id" id="student_id" class="form-control" required>
                                            <option value="">Select Student</option>
                                            <!-- Students will be populated dynamically -->
                                        </select>
                                    </div>
                                </div>

                                <!-- Dynamic Stationary Fee Fields -->
                                <div class="row mb-3">
                                    <div class="col-md-12">
                                        <div id="dynamic-field-container">
                                            <div class="row mb-2 dynamic-field">
                                                <!-- Fees Name Dropdown -->
                                                <div class="col-md-3">
                                                    <label for="fees_name[]">Stationary Fee</label>
                                                    <select name="fees_name[]" class="form-control fees-dropdown" required>
                                                        <option value="">Select Fee</option>
                                                        @foreach ($stationaryFees as $fee)
                                                            <option value="{{ $fee->id }}"
                                                                data-class="{{ $fee->class_id }}"
                                                                data-price="{{ $fee->fees_amount }}">
                                                                {{ $fee->fees_name }} ({{ $fee->fees_amount }})
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                </div>

                                                <!-- Quantity -->
                                                <div class="col-md-2">
                                                    <label for="quantity[]">Quantity</label>
                                                    <input type="number" name="quantity[]"
                                                        class="form-control quantity-field" placeholder="Quantity"
                                                        min="1" required>
                                                </div>

                                                <!-- Price -->
                                                <div class="col-md-3">
                                                    <label for="price[]">Price</label>
                                                    <input type="text" name="price[]" class="form-control price-field"
                                                        readonly>
                                                </div>

                                                <!-- Total -->
                                                <div class="col-md-3">
                                                    <label for="total[]">Total</label>
                                                    <input type="text" name="total[]" class="form-control total-field"
                                                        readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Button to add more fields -->
                                        <button type="button" class="btn btn-success" id="add-field">Add Field</button>

                                        <!-- Pay Now Checkbox -->
                                        <div class="form-check mt-3">
                                            <input class="form-check-input" type="checkbox" id="pay-now-checkbox"
                                                name="pay-now-checkbox" value="1">
                                            <label class="form-check-label" for="pay-now-checkbox">
                                                Pay Now
                                            </label>
                                        </div>

                                        <!-- Grand Total Field -->
                                        <div class="mt-3" id="grand-total-field" style="display: none;">
                                            <label for="grand_total">Grand Total</label>
                                            <input type="text" id="grand_total" class="form-control" readonly>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
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

@section('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const classSelect = document.getElementById('class_id');
            const studentSelect = document.getElementById('student_id');
            const payNowCheckbox = document.getElementById('pay-now-checkbox');
            const grandTotalField = document.getElementById('grand-total-field');
            const grandTotalInput = document.getElementById('grand_total');

            const students = @json($students);

            classSelect.addEventListener('change', function() {
                const selectedClassId = this.value;
                studentSelect.innerHTML = '<option value="">Select Student</option>';
                students.forEach(function(student) {
                    if (student.class_id == selectedClassId) {
                        const option = document.createElement('option');
                        option.value = student.id;
                        option.textContent = student.firstName;
                        studentSelect.appendChild(option);
                    }
                });
                updateFeesDropdown(selectedClassId);
            });

            function updateFeesDropdown(classId) {
                document.querySelectorAll('.fees-dropdown').forEach(function(dropdown) {
                    dropdown.querySelectorAll('option').forEach(function(option) {
                        if (option.getAttribute('data-class') == classId || classId == '') {
                            option.style.display = '';
                        } else {
                            option.style.display = 'none';
                        }
                    });
                    dropdown.value = '';
                    dropdown.dispatchEvent(new Event('change'));
                });
            }

            function calculateTotal(field) {
                const quantity = field.querySelector('.quantity-field').value;
                const price = field.querySelector('.price-field').value;
                const totalField = field.querySelector('.total-field');
                const total = (quantity * price).toFixed(2);
                totalField.value = total;
            }

            function calculateGrandTotal() {
                let grandTotal = 0;
                document.querySelectorAll('.total-field').forEach(function(totalField) {
                    grandTotal += parseFloat(totalField.value || 0);
                });
                grandTotalInput.value = grandTotal.toFixed(2);
            }

            document.querySelectorAll('.fees-dropdown').forEach(function(dropdown) {
                dropdown.addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const price = selectedOption.getAttribute('data-price');
                    const field = this.closest('.dynamic-field');
                    field.querySelector('.price-field').value = price;
                    calculateTotal(field);
                    if (payNowCheckbox.checked) calculateGrandTotal();
                });
            });

            document.querySelectorAll('.quantity-field').forEach(function(quantityField) {
                quantityField.addEventListener('input', function() {
                    const field = this.closest('.dynamic-field');
                    calculateTotal(field);
                    if (payNowCheckbox.checked) calculateGrandTotal();
                });
            });

            document.getElementById('add-field').addEventListener('click', function() {
                const container = document.getElementById('dynamic-field-container');
                const newField = container.querySelector('.dynamic-field').cloneNode(true);

                newField.querySelector('.fees-dropdown').value = '';
                newField.querySelector('.price-field').value = '';
                newField.querySelector('.quantity-field').value = '';
                newField.querySelector('.total-field').value = '';

                container.appendChild(newField);

                newField.querySelector('.fees-dropdown').addEventListener('change', function() {
                    const selectedOption = this.options[this.selectedIndex];
                    const price = selectedOption.getAttribute('data-price');
                    const field = this.closest('.dynamic-field');
                    field.querySelector('.price-field').value = price;
                    calculateTotal(field);
                    if (payNowCheckbox.checked) calculateGrandTotal();
                });

                newField.querySelector('.quantity-field').addEventListener('input', function() {
                    const field = this.closest('.dynamic-field');
                    calculateTotal(field);
                    if (payNowCheckbox.checked) calculateGrandTotal();
                });
            });

            payNowCheckbox.addEventListener('change', function() {
                if (this.checked) {
                    grandTotalField.style.display = 'block';
                    calculateGrandTotal();
                } else {
                    grandTotalField.style.display = 'none';
                    grandTotalInput.value = '';
                }
            });
        });
    </script>
@endsection
