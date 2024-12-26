@extends('admin.layouts.admin')

@section('content')
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            {{-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> --}}
            <div class="offset-1 col-lg-10">
                <div class="">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Create Event Fee</h6>
                            @if (Session::has('msg'))
                                <div class="alert alert-success mt-4">
                                    <strong>{{ Session::get('msg') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <form class="user" action="{{ URL::to('admin/store-eventFee') }}" method="POST">
                                {{ csrf_field() }}
                                <div class="row">
                                    <div class="col-md-6">
                                    </div>
                                </div>
                                <!-- Container for dynamically added fields -->
                                <h4>Setup Event Fee</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <label for="event_title">Event Title</label>
                                        <input type="text" name="event_title" class="form-control"
                                            placeholder="Event Title" required>
                                    </div>
                                    <div class="col-md-6">
                                        <label for="event_amount">Event Amount</label>
                                        <input type="number" name="event_amount" class="form-control"
                                            placeholder="Event Amount" required>
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
