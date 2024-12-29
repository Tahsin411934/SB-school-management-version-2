@extends('admin.layouts.admin')

@section('links')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
@stop

@section('content')
<div class="main-content-inner container">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <h3 style="margin-bottom: 0;">Manage Users</h3>
        <div>
            @if (Auth::user()->can('user.create'))
            <button class="btn btn-primary text-white" data-toggle="modal" data-target="#createUserModal">
                Create New User
            </button>
            @endif
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="example" class="table table-bordered table-striped text-center">
                            <thead class="thead-light">
                                <tr>
                                    <th width="5%">Sl</th>
                                    <th width="10%">Name</th>
                                    <th width="10%">Email</th>
                                    <th width="40%">Roles</th>
                                    <th width="15%">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($users as $user)
                                <tr>
                                    <td>{{ $loop->index + 1 }}</td>
                                    <td>{{ $user->name }}</td>
                                    <td>{{ $user->email }}</td>
                                    <td>
                                        @foreach ($user->roles as $role)
                                        <span class="badge badge-info mr-1">{{ $role->name }}</span>
                                        @endforeach
                                    </td>
                                    <td>
                                        @if (Auth::user()->can('user.edit'))
                                        <button class="btn btn-success text-white edit-user-btn" data-toggle="modal"
                                            data-target="#editUserModal" data-id="{{ $user->id }}"
                                            data-name="{{ $user->name }}" data-email="{{ $user->email }}"
                                            data-roles="{{ $user->roles->pluck('name')->implode(',') }}">
                                            Edit
                                        </button>
                                        @endif

                                        @if (Auth::user()->can('user.delete'))
                                        <a class="btn btn-danger text-white"
                                            href="{{ URL::to('admin/delete-user/' . $user->id) }}"
                                            onclick="event.preventDefault(); document.getElementById('delete-form-{{ $user->id }}').submit();">
                                            Delete
                                        </a>
                                        <form id="delete-form-{{ $user->id }}"
                                            action="{{ URL::to('admin/delete-user/' . $user->id) }}" method="POST"
                                            style="display: none;">
                                            @method('DELETE')
                                            @csrf
                                        </form>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create User Modal -->
<div class="modal fade" id="createUserModal" tabindex="-1" role="dialog" aria-labelledby="createUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createUserModalLabel">Create New User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ URL::to('admin/store-user') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">User Name</label>
                        <input type="text" class="form-control" id="name" name="name" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="email">User Email</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password"
                            placeholder="Enter Password">
                    </div>
                    <div class="form-group">
                        <label for="password_confirmation">Confirm Password</label>
                        <input type="password" class="form-control" id="password_confirmation"
                            name="password_confirmation" placeholder="Enter Password">
                    </div>
                    
                    <div class="form-group w-100">
                        <label for="roles">Assign Roles</label>
                        <select name="roles[]" id="roles" class="form-control select2 w-100" style="width: 460px;" multiple>
                            @foreach ($roles as $role)
                            <option value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Save User</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Edit User Modal -->
<div class="modal fade" id="editUserModal" tabindex="-1" role="dialog" aria-labelledby="editUserModalLabel"
    aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editUserModalLabel">Edit User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editUserForm" method="POST">
                    @method('PUT')
                    @csrf
                    <input type="hidden" id="editUserId" name="user_id">
                    <div class="form-group">
                        <label for="editName">User Name</label>
                        <input type="text" class="form-control" id="editName" name="name" placeholder="Enter Name">
                    </div>
                    <div class="form-group">
                        <label for="editEmail">User Email</label>
                        <input type="email" class="form-control" id="editEmail" name="email" placeholder="Enter Email">
                    </div>
                    <div class="form-group">
                        <label for="editPassword">Password</label>
                        <input type="password" class="form-control" id="editPassword" name="password"
                            placeholder="Enter Password">
                    </div>
                    <div class="form-group">
                        <label for="editPasswordConfirmation">Confirm Password</label>
                        <input type="password" class="form-control" id="editPasswordConfirmation"
                            name="password_confirmation" placeholder="Enter Password">
                    </div>
                    <div class="form-group w-100 input-group input-group-lg">
                        <label for="editRoles">Assign Roles</label>
                        <select name="roles[]" id="editRoles" class="form-control select2 w-100" style="width: 700px;"
                            multiple>
                            @foreach ($roles as $role)
                            <option class="w-100" value="{{ $role->name }}">{{ $role->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    

                    <button type="submit" class="btn btn-primary">Save Changes</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script src="{{ asset('public/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
    // Initialize Select2 for all select elements with class .select2
    $('.select2').select2();

    // Trigger Edit User Modal
    $('.edit-user-btn').on('click', function() {
        const userId = $(this).data('id');
        const userName = $(this).data('name');
        const userEmail = $(this).data('email');
        const userRoles = $(this).data('roles').split(',');

        // Populate the form fields with the user data
        $('#editUserId').val(userId);
        $('#editName').val(userName);
        $('#editEmail').val(userEmail);
        $('#editRoles').val(userRoles).trigger('change');

        // Set form action URL for editing
        $('#editUserForm').attr('action', `/admin/update-user/${userId}`);

        // Show the modal
        $('#editUserModal').modal('show');
    });

    // Re-initialize Select2 when the modal is shown (to handle dynamically added elements)
    $('#editUserModal').on('shown.bs.modal', function() {
        $('#editRoles').select2();
    });

    // Ensure modal closes properly and reset form fields
    $('#editUserModal').on('hidden.bs.modal', function () {
        // Reset the form fields to avoid any leftover values when reopening
        $('#editUserForm')[0].reset();
        $('#editRoles').val([]).trigger('change');

        // Manually remove 'show' class after modal has been hidden
        $(this).removeClass('show').css({
            'opacity': '1',
            'visibility': 'hidden',
        });

        // Manually reset the backdrop and other modal-related styles
        $('.modal-backdrop').remove();
        $('body').css('padding-right', '0px');
    });

    // Close modal when clicking outside or on the close button for Create User
    $('#createUserModal').on('hidden.bs.modal', function () {
        $('#createUserModal form')[0].reset();
        $('#roles').val([]).trigger('change');

        // Manually reset modal opacity and remove backdrop
        $(this).removeClass('show').css({
            'opacity': '1',
            'visibility': 'hidden',
        });

        $('.modal-backdrop').remove();
        $('body').css('padding-right', '0px');
    });
});
</script>
@stop
