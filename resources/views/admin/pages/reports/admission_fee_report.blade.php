@extends('admin.layouts.admin')

@section('content')
    <div class="container-fluid">
        <h1 class="h3 mb-2 text-gray-800">Admission Fee Collection Report</h1>

        <div class="card shadow mb-4">
            <div class="card-body">
                <h4>Total Admission Fee Collection: {{ number_format($totalCollections, 2) }}</h4>

                <h5 class="mt-4">Collections by Class:</h5>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Class</th>
                            <th>Total Collection</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($collectionsByClass as $collection)
                            <tr>
                                <td>{{ $collection->studentClass->name ?? 'N/A' }}</td> <!-- Use 'studentClass' here -->
                                <td>{{ number_format($collection->total, 2) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@stop
