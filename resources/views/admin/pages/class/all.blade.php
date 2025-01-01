@extends('admin.layouts.admin')

@section('links')
<link href="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-2 text-gray-800">Tables</h1>

    <!-- DataTales Example -->
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">Class List</h6>
            <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#createModal">Create New Class</a>
        </div>
        @if (session('success'))
        <div class="alert alert-success mt-4 alert-dismissible" role="alert">
            {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        @endif

        <div class="card-body">
            <div class="table-responsive">
                <table  class="table table-bordered" id="example" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if ($data)
                        @foreach ($data as $c)
                        <tr>
                            <td>{{ $c->name }}</td>
                            <td>
                                <!-- Edit Button -->
                                <button class="btn btn-primary " onclick="setFormAction({{ json_encode($c) }})"
                                    data-toggle="modal" data-target="#updateModal">
                                    Edit 
                                </button>
                                <a data-toggle="modal" data-target="#deleteModal{{ $c->id }}" href="#"
                                    class="btn btn-danger ">Delete</a>

                                <!-- Delete Modal -->
                                <div class="modal fade" id="deleteModal{{ $c->id }}" tabindex="-1"
                                    aria-labelledby="deleteModalLabel{{ $c->id }}" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="deleteModalLabel{{ $c->id }}">Delete
                                                    Confirmation</h5>
                                                <button type="button" class="close" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">
                                                Are you sure you want to delete <b>{{ $c->name }}</b>?
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-dismiss="modal">Close</button>
                                                <a href="{{ URL::to('admin/delete-studentClass/' . $c->id) }}"
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
                            <td colspan="2" class="text-center">No Data Found</td>
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Update Modal -->
<div class="modal fade" id="updateModal" tabindex="-1" role="dialog" aria-labelledby="updateModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateModalLabel">Update Student Class</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="user" id="updateForm" action="" method="POST">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name"
                            placeholder="Enter your class name">
                        @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                    <input name="submit" type="submit" value="Update" class="btn btn-primary btn-user btn-block">
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Create Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="createModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createModalLabel">Create New Class</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class="user" method="POST" action="{{ URL::to('admin/store-studentClass') }}">
                {{ csrf_field() }}
                <div class="modal-body">
                    <div class="form-group">
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter class name"
                            required>
                        @if ($errors->has('name'))
                        <span class="text-danger">{{ $errors->first('name') }}</span>
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Create Class</button>
                </div>
            </form>
        </div>
    </div>
</div>

@stop

@section('scripts')
<!-- Page level plugins -->
<script src="{{ asset('public/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

<!-- Page level custom scripts -->
<script src="{{ asset('public/admin/js/demo/datatables-demo.js') }}"></script>

<script>
function setFormAction(c) {
    // Example: Log the full class object
    console.log(c); // This will show all properties of the class object

    // Fill the modal fields with the class data
    document.getElementById('name').value = c.name; // Example: fill the name field

    // You can also dynamically set the form action
    const url = `/admin/update-studentClass/${c.id}`;
    const form = document.getElementById('updateForm');
    form.setAttribute('action', url);
}
</script>
@stop