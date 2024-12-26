@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid">
        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Edit Task</h1>

        <!-- Edit Task Form -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Edit Task</h6>
            </div>
            <div class="card-body">
                <form action="{{ URL::to('admin/update-task/' . $task->id) }}" method="POST">
                    {{ csrf_field() }}
                    {{ method_field('PUT') }}

                    <div class="form-group">
                        <label for="title">Title</label>
                        <input readonly type="text" class="form-control" id="title" name="title"
                            value="{{ $task->title }}" required>
                        @if ($errors->has('title'))
                            <span class="text-danger">{{ $errors->first('title') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <input readonly type="text" class="form-control" id="description" name="description"
                            value="{{ $task->description }}" required>
                        @if ($errors->has('description'))
                            <span class="text-danger">{{ $errors->first('description') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <label for="status">Status</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending</option>
                            <option value="ongoing" {{ $task->status == 'ongoing' ? 'selected' : '' }}>Ongoing</option>
                            <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Done</option>
                        </select>
                        @if ($errors->has('status'))
                            <span class="text-danger">{{ $errors->first('status') }}</span>
                        @endif
                    </div>

                    <input name="submit" type="submit" value="Update Task" class="btn btn-primary btn-user btn-block">
                </form>
            </div>
        </div>
    </div>
@stop
