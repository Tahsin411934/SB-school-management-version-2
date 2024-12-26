@extends('admin.layouts.admin')
@section('links')
    <link href="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
@stop
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Tables</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Category List</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>Id</th>
                                <th>Tile</th>
                                <th>Category</th>
                                <th>Short Description</th>
                                {{-- <th>Details</th> --}}
                                <th>Main Image</th>
                                <th>Thumbnail Image</th>
                                <th>Writer</th>
                                <th>Publish Date</th>
                                <th>Status</th>
                                <th>Show home page</th>
                                <th>Feature</th>
                                <th>Other Images</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        {{-- <tfoot>
                            <tr>
                                <th>Id</th>
                                <th>Name</th>
                                <th>Action</th>
                            </tr>
                        </tfoot> --}}
                        <tbody>

                            @if ($articles)
                                @foreach ($articles as $c)
                                    <tr>
                                        <td scope="row">{{ $c->id }}</td>
                                        <td>{{ $c->title }}</td>
                                        <td>{{ $c->category->name }}</td>
                                        <td>{{ $c->short_description }}</td>
                                        {{-- <td>{!! html_entity_decode($c->details) !!}</td> --}}
                                        <td>
                                            <img src="{{ asset($c->main_image) }}" alt="main" width="100px" />
                                        </td>
                                        <td>
                                            <img src="{{ asset($c->thumbnail_image) }}" alt="main" width="100px" />
                                        </td>
                                        <td>{{ $c->writer }}</td>
                                        <td>{{ $c->publish_date }}</td>
                                        <td>{{ $c->status ? 'Active' : 'Inactive' }}</td>
                                        <td>{{ $c->show_home_page ? 'Yes' : 'No' }}</td>
                                        <td>{{ $c->features ? 'Yes' : 'No' }}</td>
                                        <td>
                                            @foreach ($c->images as $image)
                                                <div class="mb-2">
                                                    <img src="{{ asset($image->image_path) }}" alt="image"
                                                        width="100px" />
                                                    <p><b>{{ $image->caption }}</b></p>
                                                </div>
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ URL::to('/edit-article/' . $c->id) }}"
                                                class="btn btn-warning btn-sm">Edit</a>
                                            <a data-toggle="modal" data-target="#exampleModal{{ $c->id }}"
                                                href="" class="btn btn-danger btn-sm">Delete</a>
                                            <div class="modal fade" id="exampleModal{{ $c->id }}" tabindex="-1"
                                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                            <h1 class="modal-title fs-5" id="exampleModalLabel">Delete
                                                                Confirmation
                                                            </h1>
                                                            <button type="button" class="close" data-dismiss="modal"
                                                                aria-label="Close">
                                                                <span aria-hidden="true">&times;</span>
                                                            </button>
                                                        </div>
                                                        <div class="modal-body">
                                                            Are you sure you want to delete <b>{{ $c->name }}</b>
                                                        </div>
                                                        <div class="modal-footer">
                                                            <button type="button" class="btn btn-secondary"
                                                                data-dismiss="modal">Close</button>
                                                            <a href="{{ URL::to('/delete-category/' . $c->id) }}"
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
                                    <td colspan="3" class="text-center">No Data Found</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@stop
@section('scripts')
    <!-- Page level plugins -->
    <script src="{{ asset('admin/vendor/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script src="{{ asset('admin/js/demo/datatables-demo.js') }}"></script>
@stop
