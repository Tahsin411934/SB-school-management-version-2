@extends('admin.layouts.admin')
@section('links')
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
@stop
@section('content')
    <div class="card-body p-0">
        <!-- Nested Row within Card Body -->
        <div class="row">
            {{-- <div class="col-lg-5 d-none d-lg-block bg-register-image"></div> --}}
            <div class="offset-2 col-lg-8">
                <div class="p-5">
                    <div class="text-center">
                        <h1 class="h4 text-gray-900 mb-2">Create Product</h1>
                    </div>
                    <form class="user" action="{{ URL::to('admin/store-product') }}" method="POST"
                        enctype="multipart/form-data">
                        {{ csrf_field() }}

                        <div class="form-group">
                            <input type="text" class="form-control" id="name" name="name"
                                value="{{ old('name') }}" placeholder="Enter your product name">
                            @if ($errors->has('name'))
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            @endif
                        </div>

                        <div class="form-group">
                            <select class="form-select form-select-lg form-control" name="category_id" id="category_id">
                                <option value="" {{ old('category_id') == '' ? 'selected' : '' }}>Select category
                                </option>
                                @foreach ($categories as $d)
                                    <option value="{{ $d->id }}"
                                        {{ old('category_id') == $d->id ? 'selected' : '' }}>
                                        {{ $d->name }}
                                    </option>
                                @endforeach
                            </select>
                            @if ($errors->has('category_id'))
                                <span class="text-danger">{{ $errors->first('category_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="sub_category_id">SubCategory</label>
                            <select name="sub_category_id" id="sub_category_id"
                                class="form-select form-select-lg form-control" required>
                                <option value="" {{ old('sub_category_id') == '' ? 'selected' : '' }}>Select
                                    SubCategory</option>
                            </select>
                            @if ($errors->has('category_id'))
                                <span class="text-danger">{{ $errors->first('category_id') }}</span>
                            @endif
                        </div>
                        <div class="form-group">
                            <label for="photo">Select your image</label>
                            <input type="file" class="form-control" id="photo" name="photo">
                            @if ($errors->has('photo'))
                                <span class="text-danger">{{ $errors->first('photo') }}</span>
                            @endif
                        </div>

                        <input name="submit" type="submit" value="Create" class="btn btn-primary btn-user btn-block">
                    </form>
                </div>
            </div>
        </div>
    </div>
@stop

@section('scripts')
    <script>
        $(document).ready(function() {
            $('#category_id').on('change', function() {
                var categoryId = $(this).val();
                if (categoryId) {
                    $.ajax({
                        url: '{{ url('get-subcategories') }}/' + categoryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#sub_category_id').empty();
                            $('#sub_category_id').append(
                                '<option value="">Select SubCategory</option>');
                            $.each(data, function(key, value) {
                                $('#sub_category_id').append('<option value="' + value
                                    .id + '">' + value.name + '</option>');
                            });
                        }
                    });
                } else {
                    $('#sub_category_id').empty();
                    $('#sub_category_id').append('<option value="">Select SubCategory</option>');
                }
            });
        });
    </script>
@stop
