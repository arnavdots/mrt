    </div>

    <!-- Scripts -->
    <script src="{{ asset('js/jquery-3.2.1.min.js') }}"></script>
    <script src="{{ asset('js/app.js') }}"></script>
    
    <!-- Bootstrap 3.3.5 -->
    <script src="{{ asset('bootstrap/js/bootstrap.min.js') }}"></script>
    
    <!-- DataTables -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables/dataTables.bootstrap.min.js') }}"></script>
    
    <!-- Alertify script -->
    <script src="{{ asset('js/alertify/alertify.min.js') }}"></script>

    <!-- loaders js -->
    <script src="{{ asset('js/loader/jquery.loading.js') }}"></script>
            
    <!-- js for common functions -->
    <script src="{{ asset('js/common.js') }}"></script>
            
    <!-- js for common functions -->
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap-confirmation.min.js') }}"></script>
    
  
    <script type="text/javascript">
    $(document).ready(function () {
        $('[data-toggle=confirmation]').confirmation({
            rootSelector: '[data-toggle=confirmation]',
            onConfirm: function (event, element) {
                element.closest('form').submit();
            }
        });   
    });
</script>
</body>
</html>