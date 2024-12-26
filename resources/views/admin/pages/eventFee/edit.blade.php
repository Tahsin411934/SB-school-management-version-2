@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-4 text-gray-800">Edit Event Fee</h1>

        <!-- Edit Form -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Total Amount for {{ $eventFee->event_title }}</h6>
            </div>
            <div class="card-body">
                <form action="{{ route('eventFee.update', ['id' => $eventFee->id]) }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="total_amount">Total Amount</label>
                        <input type="number" class="form-control" id="total_amount" name="total_amount"
                            value="{{ old('total_amount', $eventFee->event_amount) }}" required step="0.01">
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
        </div>
    </div>
@stop
