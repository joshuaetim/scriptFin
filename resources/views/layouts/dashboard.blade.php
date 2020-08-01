<!DOCTYPE html>
<html dir="ltr" lang="en">

<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <!-- Tell the browser to be responsive to screen width -->
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <meta name="description" content="" />
  <meta name="author" content="" />
  <!-- Favicon icon -->
  <link rel="icon" type="image/png" sizes="16x16" href="assets/img/favicon.png" />
  <title>
    {{config('app.name').' | ' . $title}}
  </title>
  <link href="https://fonts.googleapis.com/css?family=Lato:400,700,900|Pacifico&display=swap" rel="stylesheet" />
  <!-- Custom CSS -->
  <!-- Custom CSS -->
  <link href="{{url('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.css')}}" rel="stylesheet">
  
  <link href="{{url('assets/libs/toastr/build/toastr.min.css')}}" rel="stylesheet">
  <link href="{{url('dist/css/style.min.css')}}" rel="stylesheet" />
  <link href="{{url('css/dashboard.css')}}" rel="stylesheet" />
  <script src="{{url('assets/libs/jquery/dist/jquery.min.js')}}"></script>
  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
  <!-- ============================================================== -->
  <!-- Preloader - style you can find in spinners.css -->
  <!-- ============================================================== -->
  <div class="preloader">
    <div class="lds-ripple">
      <div class="lds-pos"></div>
      <div class="lds-pos"></div>
    </div>
  </div>
  <!-- ============================================================== -->
  <!-- Main wrapper - style you can find in pages.scss -->
  <!-- ============================================================== -->
  <div id="main-wrapper">
    <!-- ============================================================== -->
    <!-- Topbar header - style you can find in pages.scss -->
    <!-- ============================================================== -->
    @include('includes.header')
    <!-- ============================================================== -->
    <!-- End Topbar header -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    @include('includes.sidebar')
    <!-- ============================================================== -->
    <!-- End Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
    <div class="page-wrapper">
      <!-- ============================================================== -->
      <!-- Container fluid  -->
      <!-- ============================================================== -->
      <div class="container-fluid" id="dashboard">
        @if (session('status'))
          <div class="alert alert-success" role="alert">
              <b>{{ session('status') }}</b>
          </div>
        @endif

        @if (session('error'))
          <div class="alert alert-danger" role="alert">
              <b>{{ session('error') }}</b>
          </div>
        @endif
       
          @yield('content')

      <!-- ============================================================== -->
      <!-- footer -->
      <!-- ============================================================== -->
      <footer class="footer text-center" style="
            background-color: darkslategrey;
            color: blanchedalmond;
            padding: 1.5rem;
            font-size: 1.06rem;
          " id="footer">
        All Rights Reserved by {{config('app.name')}}. &copy; {{now()->format('Y')}}.
      </footer>
      <!-- ============================================================== -->
      <!-- End footer -->
      <!-- ============================================================== -->
    </div>
    <!-- ============================================================== -->
    <!-- End Page wrapper  -->
    <!-- ============================================================== -->
  </div>
  <!-- ============================================================== -->
  <!-- End Wrapper -->
  <!-- ============================================================== -->
  <!-- ============================================================== -->
  <!-- All Jquery -->
  <!-- ============================================================== -->
  
  <!-- Bootstrap tether Core JavaScript -->
  <script src="{{url('assets/libs/popper.js/dist/umd/popper.min.js')}}"></script>
  <script src="{{url('assets/libs/bootstrap/dist/js/bootstrap.min.js')}}"></script>
  <!-- apps -->
  <script src="{{url('dist/js/app.min.js')}}"></script>
  <script src="{{url('dist/js/app.init.light-sidebar.js')}}"></script>
  <script src="{{url('dist/js/app-style-switcher.js')}}"></script>
  <!-- slimscrollbar scrollbar JavaScript -->
  <script src="{{url('assets/libs/perfect-scrollbar/dist/perfect-scrollbar.jquery.min.js')}}"></script>
  <script src="{{url('assets/extra-libs/sparkline/sparkline.js')}}"></script>
  <!--Wave Effects -->
  <script src="{{url('dist/js/waves.js')}}"></script>
  <!--Menu sidebar -->
  <script src="{{url('dist/js/sidebarmenu.js')}}"></script>
  <!--Custom JavaScript -->
  <script src="{{url('dist/js/custom.min.js')}}"></script>
  <!--This page JavaScript -->
  <script src="{{url('assets/libs/toastr/build/toastr.min.js')}}"></script>
  <script src="{{url('assets/extra-libs/toastr/toastr-init.js')}}"></script>
  <script src="{{url('assets/extra-libs/DataTables/datatables.min.js')}}"></script>
  <script src="{{url('dist/js/pages/datatable/datatable-basic.init.js')}}"></script>
  <script src="{{url('js/app.js')}}"></script>
</body>

</html>