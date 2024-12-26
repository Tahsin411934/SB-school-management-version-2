@extends('admin.layouts.admin')

@section('content')
    <div class="p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            {{-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> --}}
            <div class="offset-3 col-lg-6">

                <div class="p-5">
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary">Edit Class</h6>
                            @if (Session::has('msg'))
                                <div class="alert alert-success mt-4">
                                    <strong>{{ Session::get('msg') }}</strong>
                                </div>
                            @endif
                        </div>
                        <div class="card-body">
                            <form class="user" action="{{ URL::to('admin/update-studentClass/' . $data->id) }}"
                                method="POST">
                                {{ csrf_field() }}
                                <div class="form-group">
                                    <input type="text" class="form-control" id="name" name="name"
                                        value="{{ $data->name }}" placeholder="Enter your class name">
                                    @if ($errors->has('name'))
                                        <span class="text-danger">{{ $errors->first('name') }}</span>
                                    @endif
                                </div>
                                <input name="submit" type="submit" value="Update"
                                    class="btn btn-primary btn-user btn-block">


                            </form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
@stop
