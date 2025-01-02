@extends('admin.layouts.admin')

@section('links')
<link href="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop
@section('content')

<div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary"> Student List</h6>
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
                    <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Class</th>
                                <th>Details</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($Classes->isNotEmpty())
                                @foreach ($Classes as $Class)
                                    <tr>
                                        <td>{{ $Class->name }}</td>
                                        <td>
                                            <a href="{{ route('student.classWise', ['class_id' => $Class->id]) }}">
                                                Details
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="4" class="text-center">No Data Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>

        </div>
@stop