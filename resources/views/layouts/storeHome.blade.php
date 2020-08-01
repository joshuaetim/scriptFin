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
  <link href="{{url('assets/libs/toastr/build/toastr.min.css')}}" rel="stylesheet">
  <link href="{{url('dist/css/style.min.css')}}" rel="stylesheet" />
  <link href="{{url('css/dashboard.css')}}" rel="stylesheet" />
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
              {{ session('status') }}
          </div>
        @endif
        <!-- ============================================================== -->
        <!-- Earnings Summery -->
        <!-- ============================================================== -->
        <div class="row">
          <!-- column -->
          <div class="col-sm-12 col-lg-4">
            <div class="card card-hover">
              <div class="card-body">
                <div class="d-flex">
                  <div class="m-r-10">
                    <span>Recommit Balance</span>
                    <h4>NGN 3,567.53</h4>
                  </div>
                  <div class="ml-auto">
                    <div style="max-width: 130px; height: 15px;" class="m-b-40">
                      <i class="fas fa-money-bill-alt" style="font-size: 3rem;"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- column -->
          <div class="col-sm-12 col-lg-4">
            <div class="card card-hover">
              <div class="card-body">
                <div class="d-flex">
                  <div class="m-r-10">
                    <span>Pending Payout</span>
                    <h4>NGN 3,567.53</h4>
                  </div>
                  <div class="ml-auto">
                    <div style="max-width: 130px; height: 15px;" class="m-b-40">
                      <i class="fas fa-newspaper" style="font-size: 3rem;"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- column -->
          <div class="col-sm-12 col-lg-4">
            <div class="card card-hover">
              <div class="card-body">
                <div class="d-flex">
                  <div class="m-r-10">
                    <span>Profit Balance</span>
                    <h4>NGN 3,567.53</h4>
                  </div>
                  <div class="ml-auto">
                    <div style="max-width: 130px; height: 15px;" class="m-b-40">
                      <i class="fas fa-hand-holding-usd" style="font-size: 3rem;"></i>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Earnings Summery -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        <!-- Donation cards -->
        <!-- ============================================================== -->

        <div class="row">
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h3 class="card-title">Get Donation</h3>
                <p class="card-text">
                  Recieve 50% ROI of your Investment
                </p>
                <a href="user-getdonation.html" class="btn btn-success">Get Donation</a>
              </div>
            </div>
          </div>
          <div class="col-md-6">
            <div class="card">
              <div class="card-body">
                <h3 class="card-title">Provide Donation</h3>
                <p class="card-text">
                  Make an Investment from various packages
                </p>
                <a href="user-providedonation.html" class="btn btn-success">Choose Package</a>
              </div>
            </div>
          </div>
        </div>

        <!-- ============================================================== -->
        <!-- End of Donation cards -->
        <!-- ============================================================== -->
        <!-- ============================================================== -->
        
        @if(!$user->active && $user->matched)

          @include('components.activation')
          
        @elseif($user->active) 

            @if ($investment) 
                <p>Pay {{ $investment->amount_offered }} to <br>
                <h3>{{ $receiver->name }}</h3></p>
                <a href="{{ url('/paymentPage/'.$investment->id) }}" class="btn btn-primary" id="bast">Payment Page</a>

            @elseif($withdrawal)
                <h4>You are to receive payment. Check below for details. <br>
                    Amount: {{$paymentDetails->amount_offered}} <br>
                    Deadline: {{ $date->format(" M j, Y H:i") }} <br>
                    Payer: {{ $payer->name }}
                </h4>
                <a href="{{ url('/confirmPayment') }}" class="btn btn-primary mt-4" id="confirm">Confirm Payment</a>
                <form action="/confirmPayment" method="post" id="confirmForm">
                    @csrf
                    <input type="hidden" name="confirm" value="{{ $paymentDetails->id }}">
                </form>

            @elseif($paid)
                <h4>You are to receive payment. Check below for details. <br>
                    Amount: {{$paymentDetails->amount_offered}} <br>
                    Deadline: {{ $date->format(" M j, Y H:i") }} <br>
                    Payer: {{ $payer->name }}
                </h4>
                <a href="{{ url('/confirmPayment') }}" class="btn btn-primary mt-4" id="confirm2">Confirm Payment</a>
                <form action="/confirmPayment" method="post" id="confirmForm2">
                    @csrf
                    <input type="hidden" name="confirm" value="{{ $paymentDetails->id }}">
                </form>

            @elseif($payment)
                <h4>You have successfully made payment to <b>{{ $receiver->name }}</b><br>
                    Please await confirmation.
                </h4>
            @else
                <h4>You have no pending investments yet.</h4> 
                <br>
                <a href="{{ url('newInvestment') }}" class="btn btn-primary">Create Investment</a>
            @endif
            
        @endif

        <!-- ============================================================== -->
        <!--Payment Page Section -->
        <!-- ============================================================== -->

        <div class="row" id="payment__page">
          <div class="col-12 m-t-30">
            <div class="card w-100">
              <div class="card-body">
                <form enctype="multipart/form-data" id="something" class="form-horizontal">
                  <h3>Enter Payment Details</h3>
                  <input name="id" type="hidden" value="4">
                  <div class="form-group row" style="padding: 5px 15px;padding-left: 0px;padding-right: 0px;">
                    <label class="col-sm-3 form-control-label">Payment Method</label>
                    <div class="col-sm-9">
                      <select id="payment_method" name="payment_method" required="required" class="form-control">
                        <option value="" selected="selected">Select Payment Method</option>
                        <option value="Bitcoin Wallet">Bitcoin Wallet</option>
                        <option value="Bank Transfer">Bank Transfer</option>
                        <option value="Bank Deposit">Bank Deposit</option>
                      </select>
                    </div>
                  </div>

                  <div class="form-group row" style="padding: 5px 15px;padding-left: 0px;padding-right: 0px;">
                    <label class="col-sm-3 form-control-label">Bank</label>
                    <div class="col-sm-9">
                      <input id="inputHorizontalSuccess" name="bankname" type="text" placeholder="Your Bank Name"
                        class="form-control form-control-success">
                    </div>
                  </div>

                  <div class="form-group row" style="padding: 5px 15px;padding-left: 0px;padding-right: 0px;">
                    <label class="col-sm-3 form-control-label">Account Number</label>
                    <div class="col-sm-9">
                      <input id="inputHorizontalSuccess" type="text" name="accountnumber"
                        placeholder="Account Number Paid Into" class="form-control form-control-success">
                    </div>
                  </div>


                  <div class="form-group row" style="padding: 5px 15px;padding-left: 0px;padding-right: 0px;">
                    <label class="col-sm-3 form-control-label">Account Name</label>
                    <div class="col-sm-9">
                      <input id="inputHorizontalSuccess" type="text" name="accountname"
                        placeholder="Account Name Paid Into" class="form-control form-control-success">
                    </div>
                  </div>

                  <div class="form-group row" style="padding: 5px 15px;padding-left: 0px;padding-right: 0px;">
                    <label class="col-sm-3 form-control-label">Depositor's Name</label>
                    <div class="col-sm-9">
                      <input id="inputHorizontalSuccess" name="depositor" type="text"
                        placeholder="Enter the Depositor's Name" class="form-control form-control-success">
                    </div>
                  </div>

                  <div class="form-group row" style="padding: 5px 15px;padding-left: 0px;padding-right: 0px;">
                    <label class="col-sm-3 form-control-label">Payment Location</label>
                    <div class="col-sm-9">
                      <input id="inputHorizontalSuccess" name="paymentlocal" type="text"
                        placeholder="Enter the Depositor's Location" class="form-control form-control-success">
                    </div>
                  </div>


                  <div class="form-group row" style="padding: 5px 15px;padding-left: 0px;padding-right: 0px;">
                    <label class="col-sm-3 form-control-label">Bitcoin Transaction Hash ID</label>
                    <div class="col-sm-9">
                      <input id="inputHorizontalSuccess" name="txtid" type="text"
                        placeholder="Bitcoin transaction hash id" class="form-control form-control-success">
                    </div>
                  </div>

                  <div class="form-group row" style="padding: 5px 15px;padding-left: 0px;padding-right: 0px;">
                    <label class="col-sm-3 form-control-label">Screenshot</label>
                    <div class="col-sm-9">
                      <input type="file" id="fileToUpload" name="fileToUpload" required="required">
                    </div>
                  </div>
                  <div class="form-group row" style="padding: 5px 15px;padding-left: 0px;padding-right: 0px;">
                    <div class="row">
                      <div class="col-md-3 offset-md-1">
                        <input type="submit" name="confirmPay" value="Make Payment" class="btn btn-primary btn-lg"
                          style="margin-bottom: 5px;">
                      </div>
                      <div class="col-md-2 offset-md-4">
                        <input type="submit" value="I can't Pay" name="cannotPay" class="btn btn-danger btn-lg"
                          style="margin-bottom: 5px;">
                      </div>
                    </div>
                </form>
              </div>
            </div>
          </div>
        </div>

        <!-- ============================================================== -->
        <!--End of Payment page Section -->
        <!-- ============================================================== -->
      </div>
      <!-- ============================================================== -->
      <!-- End of Container fluid  -->
      <!-- ============================================================== -->


      <!-- ============================================================== -->
      <!-- footer -->
      <!-- ============================================================== -->
      <footer class="footer text-center" style="
            background-color: darkslategrey;
            color: blanchedalmond;
            padding: 1.5rem;
            font-size: 1.06rem;
          " id="footer">
        All Rights Reserved by Financial Aid. &copy; 2020.
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
  <script src="{{url('assets/libs/jquery/dist/jquery.min.js')}}"></script>
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
  <script src="{{url('js/app.js')}}"></script>
</body>

</html>