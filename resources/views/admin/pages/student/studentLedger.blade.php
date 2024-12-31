@extends('admin.layouts.admin')
@section('links')
   
@stop
@section('content')
    <div class="container-fluid">

        <!-- Page Heading -->
        <h1 class="h3 mb-2 text-gray-800">Student Ledger</h1>

        <!-- DataTales Example -->
        <div class="card shadow mb-4">
            <div class="card-header py-3">
                <h6 class="m-0 font-weight-bold text-primary">Student Ledger List</h6>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered" id="example" width="100%" cellspacing="0">
                        <thead>
                            <tr>
                                <th>TrxNo</th>
                                <th>StudentID</th>
                                <th>Date</th>
                                <th>Head</th>
                                <th>Description</th>
                                <th>Reference</th>
                                <th>Bill Amount</th>
                                <th>Received</th>
                                <th>Due</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @if ($studentLedger->isNotEmpty())
                                @foreach ($studentLedger as $entry)
                                    <tr>
                                        <td>{{ $entry->TrxNo }}</td>
                                        <td>{{ $entry->StudentID }}</td>
                                        <td>{{ $entry->TDate }}</td>
                                        <td>{{ $entry->Head }}</td>
                                        <td>{{ $entry->Description }}</td>
                                        <td>{{ $entry->Ref }}</td>
                                        <td>{{ $entry->BillAmount }}</td>
                                        <td>{{ $entry->Received }}</td>
                                        <td>
                                            {{ number_format($entry->BillAmount - $entry->Received, 2) }}
                                        </td>
                                        <td>
                                            <span class="badge {{ $entry->Status == 'due' ? 'badge-warning' : 'badge-success' }}">
                                                {{ ucfirst($entry->Status) }}
                                            </span>
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="9" class="text-center">No records found</td>
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
   
    <script src="{{ asset('public/admin/vendor/datatables/dataTables.bootstrap4.min.js') }}"></script>

    <!-- Page level custom scripts -->
    <script>
        $(document).ready(function () {
            $('#dataTable').DataTable();
        });
    </script>
@stop
