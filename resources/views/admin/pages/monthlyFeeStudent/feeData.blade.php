@extends('admin.layouts.admin')

@section('content')
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            {{-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> --}}
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Student Monthly Payments</h6>
                            @if (Session::has('msg'))
                                <div class="alert alert-success mt-4">
                                    <strong>{{ Session::get('msg') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <form class="user" action="{{ URL::to('admin/store-monthly-payment') }}" method="POST">
                                {{ csrf_field() }}
                                <h3>Student Information</h3>
                                <br />
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="studentId">Student Id</label>
                                            <input readonly type="text" class="form-control" id="studentId"
                                                name="student_id" value="{{ old('student_id', $student->id) }}"
                                                placeholder="Student Id" readonly>
                                            @if ($errors->has('student_id'))
                                                <span class="text-danger">{{ $errors->first('student_id') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="studentName">Student Name</label>
                                            <input readonly type="text" class="form-control" id="studentName"
                                                name="student_name"
                                                value="{{ old('student_name', $student->firstName . ' ' . ($student->middleName ?? '') . ' ' . $student->lastName) }}"
                                                placeholder="Student Name" readonly>
                                            @if ($errors->has('student_name'))
                                                <span class="text-danger">{{ $errors->first('student_name') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="class_id">Class</label>
                                            <select readonly class="form-control" id="class_id" name="class_id">
                                                <option value="" disabled
                                                    {{ is_null($student->class_id) ? 'selected' : '' }}>
                                                    Select your class (Currently not assigned)
                                                </option>
                                                @foreach ($classes as $class)
                                                    <option value="{{ $class->id }}"
                                                        {{ old('class_id', $student->class_id) == $class->id ? 'selected' : '' }}>
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
                                            <label for="payment_type">Payment Type</label>
                                            <select class="form-control" id="payment_type" name="payment_type">
                                                <option value="" disabled selected>
                                                    Select your class payment type
                                                </option>
                                                <option value="bkash">Bkash</option>
                                                <option value="cash">Cash</option>
                                                <option value="cheque">Cheque</option>
                                            </select>
                                            @if ($errors->has('payment_type'))
                                                <span class="text-danger">{{ $errors->first('payment_type') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>

                                <h3>Setup Monthly Fee</h3>
                                <br />
                                <div class="row">
                                    <div class="col-md-12">
                                        <div id="fee-table-container">
                                            @if ($data && $data->studentClass && $data->studentClass->monthlyFees->count())

                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th>Fees Name</th>
                                                            <th>Fees Amount</th>
                                                            @if ($is_sibling)
                                                                <th>Sibling Discount (%)</th>
                                                                <th>Sibling Discount Amount</th>
                                                                <th>Amount After Discount</th>
                                                            @endif
                                                        </tr>
                                                    </thead>
                                                    <tbody id="fees-tbody">
                                                        @php
                                                            $totalFeesAmount = 0;
                                                            $totalSiblingDiscount = 0;
                                                            $totalSiblingDiscountAmount = 0;
                                                            $totalAmountAfterDiscount = 0;
                                                        @endphp

                                                        @foreach ($data->studentClass->monthlyFees as $fee)
                                                            @php
                                                                $siblingDiscountAmount = $is_sibling
                                                                    ? ($fee->fees_amount * $fee->sibbling_discount) /
                                                                        100
                                                                    : 0;
                                                                $amountAfterDiscount =
                                                                    $fee->fees_amount - $siblingDiscountAmount;

                                                                $totalFeesAmount += $fee->fees_amount;
                                                                $totalSiblingDiscount += $is_sibling
                                                                    ? $fee->sibbling_discount
                                                                    : 0;
                                                                $totalSiblingDiscountAmount += $siblingDiscountAmount;
                                                                $totalAmountAfterDiscount += $amountAfterDiscount;
                                                            @endphp
                                                            <tr>
                                                                <td>{{ $fee->fees_name }}
                                                                    <input type="hidden" name="monthly_fees_id"
                                                                        id="monthly_fees_id" value="{{ $fee->id }}">
                                                                </td>
                                                                <td>{{ number_format($fee->fees_amount, 2) }}</td>
                                                                @if ($is_sibling)
                                                                    <td>{{ number_format($fee->sibbling_discount, 2) }}
                                                                    </td>
                                                                    <td>{{ number_format($siblingDiscountAmount, 2) }}</td>
                                                                    <td>{{ number_format($amountAfterDiscount, 2) }}</td>
                                                                @endif
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                    <tfoot>
                                                        <tr>
                                                            <td><strong>Total</strong></td>
                                                            <td><strong>{{ number_format($totalFeesAmount, 2) }}</strong>
                                                            </td>
                                                            @if ($is_sibling)
                                                                <td><strong>{{ number_format($totalSiblingDiscount, 2) }}</strong>
                                                                </td>
                                                                <td><strong>{{ number_format($totalSiblingDiscountAmount, 2) }}</strong>
                                                                </td>
                                                                <td><strong
                                                                        id="total-after-discount">{{ number_format($totalAmountAfterDiscount, 2) }}</strong>
                                                                </td>
                                                            @endif
                                                        </tr>
                                                        @if ($dueFine)
                                                            <tr>
                                                                <td><strong>Due Fine</strong></td>
                                                                <td colspan="{{ $dueFine ? '4' : '2' }}">
                                                                    <strong id="">
                                                                        {{ number_format($dueFine, 2) }}
                                                                        <input type="hidden" name="due-fine" id="due-fine"
                                                                            value="{{ number_format($dueFine, 2) }}">
                                                                    </strong>
                                                                </td>
                                                            </tr>
                                                        @endif

                                                        <tr>
                                                            <td><strong>Grand Totals</strong></td>
                                                            <td colspan="{{ $is_sibling ? '4' : '2' }}">
                                                                <strong id="">
                                                                    @if ($is_sibling)
                                                                        @php
                                                                            $totalDuePayment =
                                                                                $totalAmountAfterDiscount + $dueFine;
                                                                        @endphp
                                                                        {{ number_format($totalDuePayment, 2) }}


                                                                        <input type="hidden"
                                                                            name="total_after_sibling_discount_monthly_fee"
                                                                            id="total_after_sibling_discount_monthly_fee"
                                                                            value="{{ number_format($totalDuePayment, 2) }}">
                                                                    @else
                                                                        @php
                                                                            $totalDuePayment =
                                                                                $totalFeesAmount + $dueFine;
                                                                        @endphp
                                                                        {{ number_format($totalDuePayment, 2) }}
                                                                        <input type="hidden"
                                                                            name="total_after_sibling_discount_monthly_fee"
                                                                            id="total_after_sibling_discount_monthly_fee"
                                                                            value="{{ number_format($totalDuePayment, 2) }}">
                                                                    @endif
                                                                </strong>
                                                            </td>
                                                        </tr>

                                                    </tfoot>
                                                </table>
                                            @else
                                                <div class="text-center">No Fees Found</div>
                                            @endif

                                        </div>
                                    </div>
                                </div>

                                <div class="row mt-5 mb-5">
                                    <!-- Button to trigger modal -->
                                    <button type="button" class="btn btn-primary bt-modal" data-toggle="modal"
                                        data-target="#stationaryFeeModal">
                                        Add Stationary Data
                                    </button>
                                    <!-- Modal -->
                                    <div class="modal fade" id="stationaryFeeModal" tabindex="-1" role="dialog"
                                        aria-labelledby="stationaryFeeModalLabel" aria-hidden="true">
                                        <div class="modal-dialog" role="document">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="stationaryFeeModalLabel">Stationary Fee Data
                                                    </h5>
                                                    <button type="button" class="close" data-dismiss="modal"
                                                        aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body" id="stationaryFeeData">
                                                    <!-- Dynamic content will be loaded here -->
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Close</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>

                                <div class="stationary-data-container mt-5"></div>
                                <input type="hidden" name="stationary_buys_ids[]" id="stationary-buys-ids"
                                    value="">
                                <input type="hidden" name="discount" id="hidden-discount">
                                <input type="hidden" name="total" id="hidden-grand-total">
                                <input type="hidden" name="total_stationary" id="hidden-stationary-total">
                                <input name="submit" type="submit" value="Create"
                                    class="btn btn-primary btn-user btn-block">
                            </form>
                        </div>
                    </div>



                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        function calculateTotal() {
            console.log("Calculating total");
            const feeRows = document.querySelectorAll('#fees-tbody tr');
            let totalFeesAmount = 0;
            let totalAmountAfterDiscount = 0;
            let dueFine = document.getElementById('due-fine')?.value || 0;


            feeRows.forEach(row => {
                const feeAmount = parseFloat(row.cells[1].textContent.replace(/,/g, ''));
                const siblingDiscount = parseFloat(row.cells[2]?.textContent.replace(/,/g, '') || 0);
                const siblingDiscountAmount = siblingDiscount > 0 ? (feeAmount * siblingDiscount) / 100 : 0;
                const amountAfterDiscount = feeAmount - siblingDiscountAmount;

                totalFeesAmount += feeAmount;
                totalAmountAfterDiscount += amountAfterDiscount;
            });
            // Add due fine to the total
            totalAmountAfterDiscount += parseFloat(dueFine);

            document.getElementById('grand-total').textContent = totalAmountAfterDiscount.toFixed(2);
            document.getElementById('hidden-grand-total').value = totalAmountAfterDiscount.toFixed(2);
        }

        function resetDiscount() {
            // Reset the discount input value to 0
            document.getElementById('discount').value = 0;

            // Recalculate totals after resetting the discount
            calculateTotal();
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Initialize the array to store stationary IDs
            let stationaryIds = [];
            let totalSum = 0;

            function updateStationaryIds() {
                document.querySelector('#stationary-buys-ids').value = stationaryIds.join(',');
            }

            document.querySelector('.bt-modal').addEventListener('click', function() {
                const studentId = "{{ $student->id }}";

                fetch(`/admin/get-stationary-fee-data/${studentId}`)
                    .then(response => response.json())
                    .then(data => {
                        const modalBody = document.getElementById('stationaryFeeData');
                        modalBody.innerHTML = '';

                        if (data.length) {
                            const table = document.createElement('table');
                            table.classList.add('table', 'table-bordered');

                            let thead =
                                '<thead><tr><th>Fee Name</th><th>Quantity</th><th>Total</th><th>Action</th></tr></thead>';
                            let tbody = '<tbody>';

                            data.forEach(item => {
                                tbody += `<tr>
                            <td>${item.fee_name}</td>
                            <td>${item.quantity}</td>
                            <td>${item.total}</td>
                            <td><button class="btn btn-primary add-stationary" data-id="${item.id}" data-fee-name="${item.fee_name}" data-quantity="${item.quantity}" data-total="${item.total}">Add</button></td>
                        </tr>`;
                            });

                            tbody += '</tbody>';
                            table.innerHTML = thead + tbody;
                            modalBody.appendChild(table);
                        } else {
                            modalBody.innerHTML = '<p>No stationary data found.</p>';
                        }
                    })
                    .catch(error => console.error('Error fetching data:', error));
            });

            document.addEventListener('click', function(event) {
                if (event.target && event.target.classList.contains('add-stationary')) {
                    event.preventDefault();

                    const feeName = event.target.getAttribute('data-fee-name');
                    const quantity = event.target.getAttribute('data-quantity');
                    const total = parseFloat(event.target.getAttribute('data-total'));
                    const id = event.target.getAttribute('data-id');

                    if (!stationaryIds.includes(id)) {
                        stationaryIds.push(id);
                    }
                    totalSum += total;

                    const stationaryDataDiv = document.querySelector('.stationary-data-container');
                    let stationaryTable = document.querySelector('#stationaryTable tbody');
                    if (!stationaryTable) {
                        const tableHTML = `
                <table class="table table-bordered" id="stationaryTable">
                    <thead>
                        <tr>
                            <th>Fee Name</th>
                            <th>Quantity</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody></tbody>
                    <tfoot>
                        <tr>
                            <td colspan="2"><strong>Total Sum</strong></td>
                            <td id="total-sum">0.00</td>
                        </tr>
                    </tfoot>
                </table>`;
                        stationaryDataDiv.innerHTML = tableHTML;
                        stationaryTable = document.querySelector('#stationaryTable tbody');
                    }

                    const newRow = document.createElement('tr');
                    newRow.innerHTML = `
            <td>${feeName}</td>
            <td>${quantity}</td>
            <td>${total.toFixed(2)}</td>`;
                    stationaryTable.appendChild(newRow);

                    document.getElementById('total-sum').textContent = totalSum.toFixed(2);
                    document.getElementById('hidden-stationary-total').value = parseFloat(totalSum.toFixed(
                        2))

                    updateStationaryIds();

                    $('#stationaryFeeModal').modal('hide');
                }
            });
        });
    </script>
@endsection
