@extends('admin.layouts.admin')

@section('content')
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            @if (session('success'))
                <div class="alert alert-success mt-4 a-dismissible" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" -dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            {{-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> --}}
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Student Admission Payment</h1>
                    </div>
                    <form class="user" action="{{ URL::to('admin/store-admission-payment') }}" method="POST">
                        {{ csrf_field() }}
                        <h3>Student Information</h3>
                        <br />
                        <div class="row align-items-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="studentId">Student Id</label>
                                    <input readonly type="text" class="form-control" id="studentId" name="student_id"
                                        value="{{ old('student_id', $student->id) }}" placeholder="Student Id" readonly>
                                    @if ($errors->has('student_id'))
                                        <span class="text-danger">{{ $errors->first('student_id') }}</span>
                                    @endif
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="studentName">Student Name</label>
                                    <input readonly type="text" class="form-control" id="studentName" name="student_name"
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
                                        <option value="" disabled {{ is_null($student->class_id) ? 'selected' : '' }}>
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

                        <h3>Setup Admission Fee</h3>
                        <br />
                        <div class="row">
                            <div class="col-md-12">
                                <div id="fee-table-container">
                                    @if ($data && $data->studentClass && $data->studentClass->admissionFees->count())

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

                                                @foreach ($data->studentClass->admissionFees as $fee)
                                                    @php
                                                        $siblingDiscountAmount = $is_sibling
                                                            ? ($fee->fees_amount * $fee->sibbling_discount) / 100
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
                                                        <td>{{ $fee->fees_name }}</td>
                                                        <td>{{ number_format($fee->fees_amount, 2) }}</td>
                                                        @if ($is_sibling)
                                                            <td>{{ number_format($fee->sibbling_discount, 2) }}</td>
                                                            <td>{{ number_format($siblingDiscountAmount, 2) }}</td>
                                                            <td>{{ number_format($amountAfterDiscount, 2) }}</td>
                                                        @endif
                                                    </tr>
                                                @endforeach
                                            </tbody>
                                            <tfoot>
                                                <tr>
                                                    <td><strong>Total</strong></td>
                                                    <td><strong>{{ number_format($totalFeesAmount, 2) }}</strong></td>
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
                                                <tr>
                                                    <td><strong>Totals</strong></td>
                                                    <td colspan="{{ $is_sibling ? '4' : '2' }}">
                                                        <strong id="">
                                                            @if ($is_sibling)
                                                                {{ number_format($totalAmountAfterDiscount, 2) }}

                                                                <input type="hidden" name="amount" id="amount"
                                                                    value="{{ number_format($totalAmountAfterDiscount, 2) }}">
                                                            @else
                                                                {{ number_format($totalFeesAmount, 2) }}
                                                                <input type="hidden" name="amount" id="amount"
                                                                    value="{{ number_format($totalFeesAmount, 2) }}">
                                                            @endif
                                                        </strong>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Discount</strong></td>
                                                    <td colspan="{{ $is_sibling ? '4' : '2' }}">
                                                        <strong id="additional-discount">0.00</strong>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td><strong>Grand Total</strong></td>
                                                    <td colspan="{{ $is_sibling ? '4' : '2' }}">
                                                        <strong
                                                            id="grand-total">{{ number_format($totalAmountAfterDiscount, 2) }}</strong>

                                                    </td>
                                                </tr>
                                            </tfoot>
                                        </table>

                                        @csrf
                                        <div class="form-group">
                                            <label for="discount">Additional Discount (%)</label>
                                            <input type="number" id="discount" name="discount" class="form-control"
                                                value="0" step="0.01" min="0">
                                        </div>
                                        <button type="button" class="btn btn-primary" onclick="calculateTotal()">Apply
                                            Discount</button>
                                        <button type="button" class="btn btn-secondary" onclick="resetDiscount()">Reset
                                            Discount</button>
                                    @else
                                        <div class="text-center">No Fees Found</div>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <input type="hidden" name="discount" id="hidden-discount">
                        <input type="hidden" name="total" id="hidden-grand-total">
                        <input name="submit" type="submit" value="Create" class="btn btn-primary btn-user btn-block">
                    </form>




                </div>
            </div>
        </div>
    </div>
@stop
<script>
    function calculateTotal() {
        const discountInput = document.getElementById('discount');
        const discountPercentage = parseFloat(discountInput.value) || 0;
        const feeRows = document.querySelectorAll('#fees-tbody tr');
        let totalFeesAmount = 0;
        let totalAmountAfterDiscount = 0;
        let totalAdditionalDiscount = 0;

        feeRows.forEach(row => {
            const feeAmount = parseFloat(row.cells[1].textContent.replace(/,/g, ''));
            const siblingDiscount = parseFloat(row.cells[2]?.textContent.replace(/,/g, '') || 0);
            const siblingDiscountAmount = siblingDiscount > 0 ? (feeAmount * siblingDiscount) / 100 : 0;
            const amountAfterDiscount = feeAmount - siblingDiscountAmount;

            totalFeesAmount += feeAmount;
            totalAmountAfterDiscount += amountAfterDiscount;

            if (discountPercentage > 0) {
                const additionalDiscountAmount = (amountAfterDiscount * discountPercentage) / 100;
                totalAdditionalDiscount += additionalDiscountAmount;
                totalAmountAfterDiscount -= additionalDiscountAmount;
            }
        });

        document.getElementById('additional-discount').textContent = totalAdditionalDiscount.toFixed(2);
        document.getElementById('grand-total').textContent = totalAmountAfterDiscount.toFixed(2);


        // Update hidden inputs
        document.getElementById('hidden-discount').value = totalAdditionalDiscount.toFixed(2);
        document.getElementById('hidden-grand-total').value = totalAmountAfterDiscount.toFixed(2);
    }

    function resetDiscount() {
        // Reset the discount input value to 0
        document.getElementById('discount').value = 0;

        // Recalculate totals after resetting the discount
        calculateTotal();
    }
</script>
