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
                            <h6 class="m-0 font-weight-bold text-primary">Create Task</h6>
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
                            <form class="user" action="{{ URL::to('admin/store-task') }}" method="POST">
                                {{ csrf_field() }}
                                <br />
                                <div class="row align-items-center">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="title">Title</label>
                                            <input type="text" class="form-control" id="title" name="title"
                                                value="{{ old('title') }}" placeholder="Enter your title">
                                            @if ($errors->has('title'))
                                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="description">Descriptions</label>
                                            <input type="text" class="form-control" id="description" name="description"
                                                value="{{ old('description') }}" placeholder="Enter your description">
                                            @if ($errors->has('description'))
                                                <span class="text-danger">{{ $errors->first('description') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <label for="assign_to">Assign to</label>
                                            <select class="form-control" id="assign_to" name="assign_to">
                                                <option value="" selected>Select your person</option>
                                                @foreach ($users as $class)
                                                    <option value="{{ $class->id }}"
                                                        {{ old('assign_to') == $class->id ? 'selected' : '' }}>
                                                        {{ $class->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('assign_to'))
                                                <span class="text-danger">{{ $errors->first('assign_to') }}</span>
                                            @endif
                                        </div>
                                    </div>

                                </div>

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
