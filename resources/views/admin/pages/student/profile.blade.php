@extends('admin.layouts.admin')

@section('content')
    <div class="container">
        <h1>Student Profile</h1>
        <div class="card">
            <div class="card-header">
                <h4>{{ $student->firstName }} {{ $student->middleName }} {{ $student->lastName }}</h4>
            </div>
            @if ($student->image)
                <!-- Display the current image -->
                <div class="mb-2 text-center">
                    <img src="{{ asset('public/storage/' . $student->image) }}" alt="Profile Image" class="img-fluid"
                        style="max-height: 100px;">
                </div>
            @endif
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h5>Basic Information</h5>
                        <ul class="list-group mb-4">
                            <li class="list-group-item"><strong>Date of Birth:</strong> {{ $student->dob }}</li>
                            <li class="list-group-item"><strong>Gender:</strong> {{ ucfirst($student->gender) }}</li>
                            <li class="list-group-item"><strong>Nationality:</strong> {{ $student->nationality }}</li>
                            <li class="list-group-item"><strong>Birth Certificate No:</strong>
                                {{ $student->birthCertificateNO }}
                            </li>
                            <li class="list-group-item"><strong>Class:</strong> {{ $student->studentClass->name }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5>Contact Information</h5>
                        <ul class="list-group mb-4">
                            <li class="list-group-item"><strong>Phone:</strong> {{ $student->phone }}</li>
                            <li class="list-group-item"><strong>Present Address:</strong> {{ $student->presentAddress }}
                            </li>
                            <li class="list-group-item"><strong>Emergency Phone:</strong> {{ $student->emergency_phone }}
                            </li>
                        </ul>
                    </div>
                </div>

                <h5>Family Information</h5>
                <div class="row">
                    <div class="col-md-6">
                        <h6>Father</h6>
                        <ul class="list-group mb-4">
                            <li class="list-group-item"><strong>Name:</strong> {{ $student->fathersName }}</li>
                            <li class="list-group-item"><strong>Occupation:</strong> {{ $student->fathers_occupation }}
                            </li>
                            <li class="list-group-item"><strong>Company Name:</strong> {{ $student->fathersCompanyName }}
                            </li>
                            <li class="list-group-item"><strong>Phone:</strong> {{ $student->fathers_phone }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h6>Mother</h6>
                        <ul class="list-group mb-4">
                            <li class="list-group-item"><strong>Name:</strong> {{ $student->mothersName }}</li>
                            <li class="list-group-item"><strong>Occupation:</strong> {{ $student->mothers_occupation }}
                            </li>
                            <li class="list-group-item"><strong>Company Name:</strong> {{ $student->mothersCompanyName }}
                            </li>
                            <li class="list-group-item"><strong>Phone:</strong> {{ $student->mothers_phone }}</li>
                        </ul>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-6">
                        <h5>Local Guardian</h5>
                        <ul class="list-group mb-4">
                            <li class="list-group-item"><strong>Name:</strong> {{ $student->localGuardianName }}</li>
                            <li class="list-group-item"><strong>Occupation:</strong>
                                {{ $student->localGuardian_occupation }}</li>
                            <li class="list-group-item"><strong>Phone:</strong> {{ $student->localGuardian_phone }}</li>
                        </ul>
                    </div>
                    <div class="col-md-6">
                        <h5>Status</h5>
                        <ul class="list-group">
                            <li class="list-group-item"><strong>Is Sibling:</strong>
                                {{ $student->is_sibling ? 'Yes' : 'No' }}</li>
                            <li class="list-group-item"><strong>Admission Payment Status:</strong>
                                @if ($student->payment_status)
                                    <span class="badge badge-success">Paid</span>
                                @else
                                    <span class="badge badge-danger">Unpaid</span>
                                @endif
                            </li>
                        </ul>
                    </div>
                </div>





                {{-- <a href="{{ route('student.edit', $student->id) }}" class="btn btn-primary mt-3">Edit</a> --}}
            </div>
        </div>

        <div class="">
            <h5 class="mt-2 mb-2">Monthly Payment List</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Payment Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student->monthlyFeeStudents as $monthlyFee)
                        <tr>
                            <td>{{ $monthlyFee->month_name }}</td>
                            <td>{{ $monthlyFee->month_date->format('d-m-Y') }}</td>
                            <td>
                                @if ($monthlyFee->status == 1)
                                    <span class="badge badge-success">Paid</span>
                                @else
                                    <span class="badge badge-danger">Unpaid</span>
                                @endif
                            </td>
                            <td>
                                @if ($monthlyFee->payment_date)
                                    {{ $monthlyFee->payment_date->format('d-m-Y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if ($monthlyFee->status == 'false')
                                    <a href="{{ URL::to('admin/student-monthly-payment/' . $student->id) }}"
                                        class="btn btn-primary btn-sm">Pay</a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div class="">
            <h5 class="mt-2 mb-2">All Payment List</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Month</th>
                        <th>Date</th>
                        <th>Status</th>
                        <th>Payment Date</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student->monthlyFeeStudents as $monthlyFee)
                        <tr>
                            <td>{{ $monthlyFee->month_name }}</td>
                            <td>{{ $monthlyFee->month_date->format('d-m-Y') }}</td>
                            <td>
                                @if ($monthlyFee->status)
                                    <span class="badge badge-success">Paid</span>
                                @else
                                    <span class="badge badge-danger">Unpaid</span>
                                @endif
                            </td>
                            <td>
                                @if ($monthlyFee->payment_date)
                                    {{ $monthlyFee->payment_date->format('d-m-Y') }}
                                @else
                                    N/A
                                @endif
                            </td>
                            <td>
                                @if (!$monthlyFee->status)
                                    <a href="{{ URL::to('admin/student-monthly-payment/' . $student->id) }}"
                                        class="btn btn-primary btn-sm">Pay</a>
                                @else
                                    <span class="text-muted">N/A</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <h5>Stationary Buys (Paid):</h5>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Item</th>
                        <th>Amount</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($student->stationaryBuys as $buy)
                        <tr>
                            <td>{{ $buy->stationaryFee->fees_name }}</td> <!-- Assuming there's an 'item_name' field -->
                            <td>{{ number_format($buy->total, 2) }}</td> <!-- Assuming there's an 'amount' field -->
                            <td>{{ $buy->created_at->format('Y-m-d') }}</td>
                            <!-- Assuming you want to show the purchase date -->
                        </tr>
                    @endforeach
                    @if ($student->stationaryBuys->isEmpty())
                        <tr>
                            <td colspan="3" class="text-center">No paid stationary buys found.</td>
                        </tr>
                    @endif
                </tbody>
            </table>

            {{-- <h6 class="mt-4">Event Payment List</h5>. --}}
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Event Title</th>
                        <th>Status</th>
                        <th>Payment Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($eventPayments as $eventPayment)
                        <tr>
                            <td>{{ $eventPayment->eventFee->event_title ?? 'N/A' }}</td>

                            <td>
                                <span class="badge badge-success">Paid</span>
                            </td>
                            <td>
                                {{ $eventPayment->created_at->format('d-m-Y') }}
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

    </div>
@endsection
