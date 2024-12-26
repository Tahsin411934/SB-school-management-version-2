@extends('admin.layouts.single')
@section('single')
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            <div class="col-lg-5 d-none d-lg-block bg-register-image"></div>
            <div class="col-lg-7">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-4">Create an Account!</h1>
                    </div>
                    <form class="user" action="{{ URL::to('store-user') }}" method="POST">
                        {{ csrf_field() }}
                        <div class="form-group">
                            <input type="text" class="form-control form-control-user" id="name" name="name"
                                value="{{ old('name') }}" placeholder="Enter your name">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <select class="form-control form-select" name="type" id="type">
                                <option value="" {{ old('type') === null || old('type') == '' ? 'selected' : '' }}>
                                    Select User Type</option>
                                <option value="admin" {{ old('type') == 'admin' ? 'selected' : '' }}>Admin</option>
                                <option value="editor" {{ old('type') == 'editor' ? 'selected' : '' }}>Editor</option>
                            </select>
                            @if ($errors->has('type'))
                                <span class="text-danger">{{ $errors->first('type') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <input type="email" name="email" class="form-control form-control-user" id="email"
                                placeholder="Email Address" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-control form-control-user" id="password" name="password"
                                value="{{ old('password') }}" placeholder="Password">
                            @if ($errors->has('password'))
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            @endif
                        </div>
                        <input name="submit" type="submit" value="Register" class="btn btn-primary btn-user btn-block">

                        <hr>
                    </form>
                    <hr>
                    {{-- <div class="text-center">
                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                    </div> --}}
                    <div class="text-center">
                        <a class="small" href="{{ URL::to('login') }}">Already have an account? Login!</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop
