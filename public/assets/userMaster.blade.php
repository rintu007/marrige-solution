<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <?php $u = Auth::user(); ?>
  <title> @yield('title') </title>
  <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" >
  <meta name="csrf-token" content="{{ csrf_token() }}">

  

  {{-- <meta name="google-site-verification" content="jf-0WbPqR8L6TXuqcrNtb-b5kBy68WBd78eURoM2ZWc" /> --}}
  
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

  @yield("metaKeywords")
 
  @yield("metaDescription")

<!--   <meta name="keywords" content="School, College, Class, Social, Teacher, Examination, Routine, Student">

<meta name="description" content="World's Largest Central Educational System."> -->

  <meta name="author" content="Masud Hasan">

  {{-- Example - Refresh document every 30 seconds: --}}
  {{-- <meta http-equiv="refresh" content="30"> --}}




  <link rel="stylesheet" type="text/css" href="{{asset('assets/css/w3.css')}}">

  <!-- Bootstrap 3.3.6 -->
  <link rel="stylesheet" type="text/css" href="{{asset('cp/bootstrap/css/bootstrap.min.css')}}">

  <!-- cropperjs-->
    <link href="{{asset('assets/cropperjs-master/dist/cropper.min.css')}}" rel='stylesheet' type='text/css'>

  <link rel="stylesheet" type="text/css" href="{{asset('assets/select2/dist/css/select2.min.css')}}">

  <!-- Font Awesome -->
  <link rel="stylesheet" type="text/css" href="{{asset('fonts/fa/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" type="text/css" href="{{asset('fonts/ion/css/ionicons.min.css')}}">
  <!-- foundation icons -->
  <link rel="stylesheet" type="text/css" href="{{asset('fonts/fi/foundation-icons.css')}}">
  <!--Font google -->
    <link href="{{asset('https://fonts.googleapis.com/css?family=Lato:100,300,400,700')}}" rel='stylesheet' type='text/css'>

  <!-- Theme style -->
  <link rel="stylesheet" type="text/css" href="{{asset('cp/dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" type="text/css" href="{{asset('cp/dist/css/skins/_all-skins.min.css')}}">

  <!-- iCheck -->
    <link rel="stylesheet" href="{{asset('cp/plugins/iCheck/flat/blue.css')}}">
<!-- iCheck for checkboxes and radio inputs -->
    <link rel="stylesheet" href="{{asset('cp/plugins/iCheck/all.css')}}">







  <style type="text/css">
  .navbar-nav>.user-menu>.dropdown-menu>.user-footer .btn-default {
    font-size: 11px;
}
.dropdown-menu{font-size: 12px;}
dropdown-menu>li>a {padding: 3px 14px;}
.box-header>.fa, .box-header>.glyphicon, .box-header>.ion, .box-header .box-title {
    /*font-size: 12px; */
}
  </style>

  <link rel="stylesheet" type="text/css" href="{{asset('css/custombtn.css')}}">

  @stack('css')



  <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

      <!-- sweetalert css and js -->
  <link rel="stylesheet" href="{{asset('assets/sweetalert2/dist/sweetalert2.css')}}">
  <script src="{{asset('assets/sweetalert2/dist/sweetalert2.min.js')}}"></script>

</head>
<body class="fixed hold-transition skin-green-light sidebar-mini">
<div class="wrapper">

@includeIf('user.layouts.header')
@includeIf('user.layouts.leftSidebar')  
  {{-- @yield('leftSidebar') --}}
  <!-- Full Width Column -->
  <div class="content-wrapper">

  @yield('content')
  
  </div>
  <!-- /.content-wrapper -->
@includeIf('user.layouts.footer')
@includeIf('user.layouts.rightSidebar')



</div>
<!-- ./wrapper -->


<!-- jQuery 2.2.3 -->
<script src="{{asset('cp/plugins/jQuery/jquery-2.2.3.min.js')}}"></script>

<script src="{{asset('assets/js/jquery-ui.js')}}"></script>
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.6 -->
<script src="{{asset('cp/bootstrap/js/bootstrap.min.js')}}"></script>


{{-- select2 --}}
{{-- <script src="{{asset('cp/plugins/select2/select2.full.min.js')}}"></script> --}}
<script src="{{asset('assets/select2/dist/js/select2.full.min.js')}}"></script>

<!-- iCheck 1.0.1 -->
    <script src="{{asset('cp/plugins/iCheck/icheck.min.js')}}"></script>

<!-- FastClick -->
<script src="{{asset('cp/plugins/fastclick/fastclick.js')}}"></script>

<!-- SlimScroll 1.3.0 -->
<script src="{{asset('cp/plugins/slimScroll/jquery.slimscroll.min.js')}}"></script>

<!-- AdminLTE App -->
<script src="{{asset('cp/dist/js/app.min.js')}}"></script>

<!-- Ilastic JS -->
    <script type="text/javascript" src="{{asset('assets/js/jquery.elastic.js')}}"></script>

    <!-- AutoGrowInput -->
    <script type="text/javascript" src="{{asset('assets/js/jquery.autoGrowInput.js')}}"></script>


     <script src="{{asset('https://cdnjs.cloudflare.com/ajax/libs/jquery.nicescroll/3.7.5/jquery.nicescroll.min.js')}}"></script>

<!-- cropperjs -->
     <script src="{{asset('assets/cropperjs-master/dist/cropper.min.js')}}"></script>

 


    <script src="{{asset('js/index.js')}}"></script>



<!-- AdminLTE dashboard demo (This is only for demo purposes) -->




@stack('js')


 
<script type="text/javascript">


  
</script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('cp/dist/js/demo.js')}}"></script>



@include('alerts.alertSweet')


</body>
</html>