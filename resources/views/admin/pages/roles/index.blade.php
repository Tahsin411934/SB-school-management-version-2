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
                    <div class="card-header py-3">
                        <h6 class="m-0 font-weight-bold text-primary">Role List</h6>
                    </div>
                    <div class="card-body">
                        <P class="float-right mb-2">
                            @if (Auth::user()->can('role.create'))
                                <a class="btn btn-primary text-white" href="{{ URL::to('/admin/create-role') }}">Create New
                                    Role</a>
                            @endif
                        </P>
                        <div class="clearfix"></div>
                        <div class="data-tables">
                            <table id="dataTable" class="text-center">
                                <thead class="bg-light text-capitalize">
                                    <tr>
                                        <th width="5%">Sl</th>
                                        <th width="10%">Name</th>
                                        <th width="60%">Permissions</th>
                                        <th width="15%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($roles as $role)
                                        <tr>
                                            <td>{{ $loop->index + 1 }}</td>
                                            <td>{{ $role->name }}</td>
                                            <td>
                                                @foreach ($role->permissions as $perm)
                                                    <span class="badge badge-info mr-1">
                                                        {{ $perm->name }}
                                                    </span>
                                                @endforeach
                                            </td>
                                            <td>
                                                @if (Auth::user()->can('role.edit'))
                                                    <a class="btn btn-success text-white"
                                                        href="{{ URL::to('admin/edit-role/' . $role->id) }}">Edit</a>
                                                @endif

                                                @if (Auth::user()->can('role.edit'))
                                                    <a class="btn btn-danger text-white"
                                                        href="{{ URL::to('admin/delete-role/' . $role->id) }}"
                                                        onclick="event.preventDefault(); document.getElementById('delete-form-{{ $role->id }}').submit();">
                                                        Delete
                                                    </a>

                                                    <form id="delete-form-{{ $role->id }}"
                                                        action="{{ URL::to('admin/delete-role/' . $role->id) }}"
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
