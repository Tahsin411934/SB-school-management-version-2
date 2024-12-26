@extends('admin.layouts.admin')



@section('links')
    <link href="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop



@section('content')
    <div class="main-content-inner">
        <div class="row">
            <!-- data table start -->
            <div class="col-12 mt-5">
                <div class="card">
                    <div class="card-body">
                        <P class="float-right mb-2">
                            @if (Auth::user()->can('user.create'))
                                <a class="btn btn-primary text-white" href="{{ URL::to('/admin/create-user') }}">Create New
                                    User</a>
                            @endif
                        </P>
                        <div class="data-tables">

                            <table id="dataTable" class="text-center">
                                <thead class="bg-light text-capitalize">
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
                                                    <span class="badge badge-info mr-1">
                                                        {{ $role->name }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if (Auth::user()->can('user.edit'))
                                                    <a class="btn btn-success text-white"
                                                        href="{{ URL::to('admin/edit-user/' . $user->id) }}">Edit</a>
                                                @endif

                                                @if (Auth::user()->can('user.delete'))
                                                    <a class="btn btn-danger text-white"
                                                        href="{{ URL::to('admin/delete-user/' . $user->id) }}"
                                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $user->id }}').submit();">
                                                        Delete
                                                    </a>
                                                    <form id="delete-form-{{ $user->id }}"
                                                        action="{{ URL::to('admin/delete-user/' . $user->id) }}"
                                                        method="POST" style="display: none;">
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
            <!-- data table end -->

        </div>
    </div>
@endsection


@section('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('public/admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('public/admin/js/demo/datatables-demo.js') }}"></script>
@stop
