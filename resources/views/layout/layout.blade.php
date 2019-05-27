<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
@include('layout.head')
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
@include('layout.header')
@include('layout.sidebar')
    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        @section('content')
        @show
    </div>
    <!-- /.content-wrapper -->
    @include('layout.footer')
</div>

<!-- jQuery 3 -->
<script src="{{URL::to('/')}}/bower_components/jquery/dist/jquery.min.js"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{URL::to('/')}}/bower_components/jquery-ui/jquery-ui.min.js"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{URL::to('/')}}/bower_components/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- Morris.js charts -->
<script src="{{URL::to('/')}}/bower_components/raphael/raphael.min.js"></script>
<script src="{{URL::to('/')}}/bower_components/morris.js/morris.min.js"></script>
<!-- Sparkline -->
<script src="{{URL::to('/')}}/bower_components/jquery-sparkline/dist/jquery.sparkline.min.js"></script>
<!-- jvectormap -->
<script src="{{URL::to('/')}}/plugins/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="{{URL::to('/')}}/plugins/jvectormap/jquery-jvectormap-world-mill-en.js"></script>
<!-- jQuery Knob Chart -->
<script src="{{URL::to('/')}}/bower_components/jquery-knob/dist/jquery.knob.min.js"></script>
<!-- daterangepicker -->
<script src="{{URL::to('/')}}/bower_components/moment/min/moment.min.js"></script>
<script src="{{URL::to('/')}}/bower_components/bootstrap-daterangepicker/daterangepicker.js"></script>
<!-- datepicker -->
<script src="{{URL::to('/')}}/bower_components/bootstrap-datepicker/dist/js/bootstrap-datepicker.min.js"></script>
<!-- Bootstrap WYSIHTML5 -->
<script src="{{URL::to('/')}}/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js"></script>
<!-- Slimscroll -->
<script src="{{URL::to('/')}}/bower_components/jquery-slimscroll/jquery.slimscroll.min.js"></script>
<!-- FastClick -->
<script src="{{URL::to('/')}}/bower_components/fastclick/lib/fastclick.js"></script>
<!-- AdminLTE App -->
<script src="{{URL::to('/')}}/dist/js/adminlte.min.js"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{URL::to('/')}}/dist/js/pages/dashboard.js"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{URL::to('/')}}/dist/js/demo.js"></script>
</body>
</html>