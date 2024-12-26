@extends('admin.layouts.single')
@section('single')
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-12">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Forget Your Password</h1>
                        @if (Session::has('err_msg'))
                            <div class="alert alert-danger mt-5">
                                <strong>{{ Session::get('err_msg') }}</strong>
                            </div>
                        @endif
                    </div>
                    <form class="user" action="{{ URL::to('login-store') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input value="{{ old('email') }}" type="email" class="form-control form-control-user"
                                id="exampleInputEmail" name="email" aria-describedby="emailHelp"
                                placeholder="Enter Email Address...">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>

                        <input type="submit" name="submit" class="btn btn-primary btn-user btn-block"
                            value="Send Reset Email">


                        <hr>

                    </form>

                </div>
            </div>
        </div>
    </div>
@stop
