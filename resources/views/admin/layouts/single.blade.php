<!DOCTYPE html>
<html lang="en">

<head>

    @include('admin.includes.head')
    <!-- jQuery and DataTables Scripts -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- DataTables Core Script -->
    <script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>

    <!-- DataTables Buttons Extension -->
    <script src="https://cdn.datatables.net/buttons/2.3.0/js/dataTables.buttons.min.js"></script>

    <!-- JSZip for Excel Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>

    <!-- PDFMake for PDF Export -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    <!-- DataTables Buttons for Export Options -->
    <script src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.print.min.js"></script>

    <!-- DataTables Column Visibility Button -->
    <script src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.colVis.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.1/css/jquery.dataTables.min.css">
    <!-- DataTables Buttons CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.0/css/buttons.dataTables.min.css">

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    {{-- Include Toastify --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/toastify-js/src/toastify.min.css">
    <script src="https://cdn.jsdelivr.net/npm/toastify-js"></script>
</head>

<body class="bg-white d-flex justify-content-center align-items-center vh-100">

    <div class="container">
        <div class="row justify-content-center align-items-center vh-100">
            <div class="col-12 col-xl-6 col-lg-6 col-md-6 d-flex justify-content-center">
                <div class="card o-hidden border-0 shadow-lg w-75">
                    @yield('single')
                </div>
            </div>
        </div>
    </div>

    @include('admin.includes.scripts')

</body>

</html>
