@extends('admin.layouts.admin')

@section('links')
<link href="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop

@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Your Tasks</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <div class="d-flex align-items-center justify-content-between">
                <h6 class="m-0 font-weight-bold text-primary">Task Listt</h6>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                    Create new task
                </button>
            </div>

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
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Assigned To</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($tasks && count($tasks) > 0)
                        @foreach ($tasks as $task)
                        <tr>
                            <td>{{ $task->id }}</td>
                            <td>{{ $task->title }}</td>
                            <td>{{ $task->description }}</td>
                            <td>{{ $name }}</td> <!-- Assuming relation -->
                            <td>{{ ucfirst($task->status) }}</td>
                            <td>
                                <a href="#"
                                    onclick="setUpdate('{{ $task->id }}','{{ $task->title }}', '{{ $task->description }}', '{{ ucfirst($task->status) }}')"
                                    class="btn btn-warning btn-sm" data-toggle="modal"
                                    data-target="#updateModal">Edit</a>
                                <a data-toggle="modal" data-target="#deleteModal{{ $task->id }}" href=""
                                    class="btn btn-danger btn-sm">Delete</a>

                                <!-- Modal for Delete Confirmation -->
                                <div class="modal fade" id="deleteModal{{ $task->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h1 class="modal-title fs-5" id="deleteModalLabel">Delete
                                                    Confirmation
                                                </h1>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete the task
                                                <b>{{ $task->title }}</b>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <a href="{{ URL::to('admin/delete-task/' . $task->id) }}"
                                                    class="btn btn-danger">Delete</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                        @endforeach
                        @else
                        <tr>
                            <td colspan="6" class="text-center">No Tasks Found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>

<!-- create modal -->
<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="bg-white p-4 rounded-lg shadow-lg">
                <div class="card shadow mb-4">
                    <div class="card-header py-3 border-b">
                        <h6 class="m-0 font-semibold text-lg text-primary">Create Task</h6>
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
                            <div class="space-y-4">
                                <div class="flex gap-4">
                                    <div class="w-1/3">
                                        <div class="form-group">
                                            <label for="title" class="text-sm font-medium text-gray-700">Title</label>
                                            <input type="text"
                                                class="form-control p-2 border border-gray-300 rounded-md w-full"
                                                id="title" name="title" value="{{ old('title') }}"
                                                placeholder="Enter your title">
                                            @if ($errors->has('title'))
                                            <span class="text-sm text-red-500">{{ $errors->first('title') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="w-1/3">
                                        <div class="form-group">
                                            <label for="description"
                                                class="text-sm font-medium text-gray-700">Description</label>
                                            <input type="text"
                                                class="form-control p-2 border border-gray-300 rounded-md w-full"
                                                id="description" name="description" value="{{ old('description') }}"
                                                placeholder="Enter your description">
                                            @if ($errors->has('description'))
                                            <span
                                                class="text-sm text-red-500">{{ $errors->first('description') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="w-1/3">
                                        <div class="form-group">
                                            <label for="assign_to" class="text-sm font-medium text-gray-700">Assign
                                                to</label>
                                            <select class="form-control p-2 border border-gray-300 rounded-md w-full"
                                                id="assign_to" name="assign_to">
                                                <option value="" selected>Select your person</option>
                                                @foreach ($users as $class)
                                                <option value="{{ $class->id }}"
                                                    {{ old('assign_to') == $class->id ? 'selected' : '' }}>
                                                    {{ $class->name }}
                                                </option>
                                                @endforeach
                                            </select>
                                            @if ($errors->has('assign_to'))
                                            <span class="text-sm text-red-500">{{ $errors->first('assign_to') }}</span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit"
                    class="btn btn-primary bg-blue-600 hover:bg-blue-700 text-white py-2 px-4 rounded-md">
                    Save
                </button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- create modal end -->
<!-- update modal start -->

<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <!-- Modal Content -->
                <div class="card shadow mb-4">
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Edit Task</h6>
                    </div>
                    <div class="card-body">
                        <form id="updateForm" action="" method="POST">
                            {{ csrf_field() }}
                            {{ method_field('PUT') }}

                            <div class="form-group">
                                <label for="title">Title</label>
                                <input readonly type="text" class="form-control" id="title1" name="title"
                                     required>
                                @if ($errors->has('title'))
                                <span class="text-danger">{{ $errors->first('title') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="description">Description</label>
                                <input readonly type="text" class="form-control" id="description1" name="description"
                                    value="{{ $task->description }}" required>
                                @if ($errors->has('description'))
                                <span class="text-danger">{{ $errors->first('description') }}</span>
                                @endif
                            </div>

                            <div class="form-group">
                                <label for="status">Status</label>
                                <select class="form-control" id="status1" name="status" required>
                                    <option value="pending" {{ $task->status == 'pending' ? 'selected' : '' }}>Pending
                                    </option>
                                    <option value="ongoing" {{ $task->status == 'ongoing' ? 'selected' : '' }}>Ongoing
                                    </option>
                                    <option value="done" {{ $task->status == 'done' ? 'selected' : '' }}>Done</option>
                                </select>
                                @if ($errors->has('status'))
                                <span class="text-danger">{{ $errors->first('status') }}</span>
                                @endif
                            </div>

                           
                        
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <!-- Change the Save Changes button to type="submit" to submit the form -->
                <button type="submit" class="btn btn-primary">Save Changes</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- update modal end -->
@stop

@section('scripts')
<!-- Page level plugins -->
<script src="{{ asset('public/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('public/admin/js/demo/datatables-demo.js') }}"></script>

<script>
const setUpdate = (id, title, description, status) => {
    const formAction = `/admin/update-task/${id}`; // Corrected this line
    document.getElementById('updateForm').setAttribute('action', formAction);
    console.log(id, title, description, status);
    document.getElementById('title1').value = title;
    document.getElementById('description1').value = description;
}

</script>
@stop