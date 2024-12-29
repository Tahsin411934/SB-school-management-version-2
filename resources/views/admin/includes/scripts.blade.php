 <!-- Bootstrap core JavaScript-->
 <script src="{{ asset('/admin/vendor/jquery/jquery.min.js') }}"></script>
 <script src="{{ asset('/admin/vendor/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

 <!-- Core plugin JavaScript-->
 <script src="{{ asset('/admin/vendor/jquery-easing/jquery.easing.min.js') }}"></script>

 <!-- Custom scripts for all pages-->
 <script src="{{ asset('/admin/js/sb-admin-2.min.js') }}"></script>

 <!-- Page level plugins -->
 <script src="{{ asset('/admin/vendor/chart.js/Chart.min.js') }}"></script>

 <!-- Page level custom scripts -->
 <script src="{{ asset('/admin/js/demo/chart-area-demo.js') }}"></script>
 <script src="{{ asset('/admin/js/demo/chart-pie-demo.js') }}"></script>
 <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/2.3.0/js/buttons.colVis.min.js"></script>
<script>
$(document).ready(function () {
    $('#example').DataTable({
        dom: 'Bfrtip',  // The button placement
        lengthMenu: [10, 25, 50, 75, 100],  // Number of rows per page
        buttons: [
            'copy',  // Copy to clipboard
            'excel',  // Export to Excel
            'csv',  // Export to CSV
            'pdf',  // Export to PDF
            'print',  // Print the table
            {
                extend: 'colvis',  // Column visibility toggle
                text: 'Column Visibility'
            }
        ]
    });
});
</script>