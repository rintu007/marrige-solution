<!DOCTYPE html>
<html>
<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  
  <?php $me = Auth::user(); ?>

   @if ($websiteParameter->favicon)
  <link rel="shortcut icon" href="{{ asset('storage/favicon/'. $websiteParameter->favicon) }}" type="image/x-icon">
  <link rel="icon" href="{{ asset('storage/favicon/'. $websiteParameter->favicon) }}" type="image/x-icon">

  @else

  <link rel="shortcut icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
    <link rel="icon" href="{{ asset('img/favicon.ico') }}" type="image/x-icon">
  @endif

<title>
  @if ($websiteParameter->title)
  {!! $websiteParameter->title !!}
  @else
  {{ env('APP_NAME_BIG') }} | Matrimony Service in Bangladesh | Marriage Media Service provider in Bangladesh | 
  Matchmaker Service in Bangladesh
  @endif
</title>

  <meta name="csrf-token" content="{{ csrf_token() }}">
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">

   {{-- <meta name="google-site-verification" content="hXsQ0jlq5t5lKq_HJiI4fkx7B7hAQnWFEgr4OnUzpo0" /> --}}

  <meta name="description" 
    content="{{ $websiteParameter->meta_description ?: 'Matrimony Service in Bangladesh
Marriage Media Service provider in Bangladesh
Matchmaker Service in Bangladesh Looing for Marriage Media In Bangladesh? Taslima marriage media is the trustworthy media in Dhaka, Bangladesh. We offer you the best matched life parner according to your profile. Create a free account and search your partner.' }}">

        <meta name="author" content="{{ $websiteParameter->meta_author ?: 'Taslima' }}">
        <meta name="keywords" content="{{ $websiteParameter->meta_keyword ?: 'Matrimony Service in Bangladesh
Marriage Media Service provider in Bangladesh
Matchmaker Service in Bangladesh' }}">

@if ($websiteParameter->google_analytics_code)
  {!! $websiteParameter->google_analytics_code !!}
@endif

@if ($websiteParameter->facebook_pixel_code)
  {!! $websiteParameter->facebook_pixel_code !!}
@endif

  <link rel="stylesheet" type="text/css" href="{{asset('css/w3.css')}}">

  <!-- Bootstrap 3.3.7 -->
  <link rel="stylesheet" href="{{asset('cp/bower_components/bootstrap/dist/css/bootstrap.min.css')}}">
  
  <!-- Select2 -->
  <link rel="stylesheet"  href="{{asset('assets/select2/dist/css/select2.min.css')}}">
  <!-- Font Awesome -->
  <link rel="stylesheet" href="{{asset('cp/bower_components/font-awesome/css/font-awesome.min.css')}}">
  <!-- Ionicons -->
  <link rel="stylesheet" href="{{asset('cp/bower_components/Ionicons/css/ionicons.min.css')}}">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{asset('cp/dist/css/AdminLTE.min.css')}}">
  <!-- AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. -->
  <link rel="stylesheet" href="{{asset('cp/dist/css/skins/_all-skins.min.css')}}">
  <link rel="stylesheet" href="{{asset('css/custom.css')}}">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
  <![endif]-->

  <!-- Google Font -->
  <link rel="stylesheet" href="{{asset('https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic')}}">

  <style>
    .pr-rating-area{
  font-size: 20px;
  color:red;
  letter-spacing:-2px;
}

.r-fill:before{
  content: "\2605";
  position: absolute;
}
  </style>

  <style>
@media (max-width: 767px)
{
   .main-header .navbar .dropdown-menu li a {
    color: #333 !important;
  }
}

</style>

   @stack('css')

     <!-- Scripts -->
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>

    <link rel="stylesheet" href="{{asset('assets/sweetalert2/dist/sweetalert2.css')}}">
  <script src="{{asset('assets/sweetalert2/dist/sweetalert2.min.js')}}"></script>

</head>
<body class="hold-transition skin-purple sidebar-mini">
<div class="wrapper">

  @include('admin.layouts.header')
  @include('admin.layouts.leftSidebar')

  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">

     @yield('content')

  </div>
  <!-- /.content-wrapper -->

    @include('admin.layouts.footer')

</div>
<!-- ./wrapper -->


<!-- jQuery 3 -->
<script src="{{asset('cp/bower_components/jquery/dist/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('cp/bower_components/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
  $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.7 -->
<script src="{{asset('cp/bower_components/bootstrap/dist/js/bootstrap.min.js')}}"></script>
<!-- Select2 -->
<script src="{{asset('assets/select2/dist/js/select2.full.min.js')}}"></script>
<!-- Slimscroll -->
<script src="{{asset('cp/bower_components/jquery-slimscroll/jquery.slimscroll.min.js')}}"></script>
<!-- FastClick -->
<script src="{{asset('cp/bower_components/fastclick/lib/fastclick.js')}}"></script>

<script src="{{asset('js/custom.js')}}"></script>

<script>
  $(function(){
          $('.slim-media').slimScroll({
              height: '500px'
          });
        });


      $(document).ready(function() { 
      
      $(document).on('keypress', '.user-search', function(e) {
        if(e.which == 13) {
            e.preventDefault();
        }
    });


     /////////////////////////////////////

     var delay = (function(){
        var timer = 0;
        return function(callback, ms){
          clearTimeout (timer);
          timer = setTimeout(callback, ms);
        };
        })();

     $(document).on("keyup", ".user-search", function(e){
    e.preventDefault();
    var that = $( this );
    var q = e.target.value;
    var url = that.attr("data-url");
    var urls = url+'?q='+q;
    // var datalist = $("#products");
    // datalist.empty();
    // alert(urls);
    

    delay(function(){  
    $.ajax({
      url: urls,
      type: 'GET',
      cache: false,
      dataType: 'json',
      success: function(response)
      {
        // console.log(response);
        $(".user-table-body").empty().append(response.page);
      },
      error: function(){}
    });
  }, 999);
  });

 
    });

$(function(){
    $(document).on('change','.image-check',function(e){
    e.preventDefault();

    var that = $( this );
    var url = that.attr("data-url");

    $.ajax({
      url: url,
      type: 'GET',
      cache: false,
      dataType: 'json',
      success: function(response)
      {
        // alert('ok');
      },
      error: function(){
        // alert('error');
      }
    });
  });
});

$(function(){
    $(document).on('click','.sms-send-to-user',function(e){
    e.preventDefault();

    var that = $( this );
    var url = that.attr("data-url");

    $.ajax({
      url: url,
      type: 'GET',
      cache: false,
      dataType: 'json',
      success: function(response)
      {
        // alert('ok');
        if(response.success)
        {
          that.find('.sms-count').empty().append(response.sms_count);
        }
      },
      error: function(){
        // alert('error');
      }
    });
  });
});


</script>



<!-- AdminLTE App -->
<script src="{{asset('cp/dist/js/adminlte.min.js')}}"></script>

 @stack('js')


</body>
</html>

