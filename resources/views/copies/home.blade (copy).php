@extends('layouts.dashboard')

@section('content')
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

            @if(!$user->active && $user->matched)
                <h4 id="demo"></h4>
                <h4 id="demo2"></h4>
                <h4 class="text-danger">Pay activation Fee of #1000 to the below account</h4>
                <br>
                <h5>
                    Name: {{ $receiver->name }} <br>
                    Account Number: {{ $receiver->account_number }} <br>
                    Bank Name: {{ $receiver->bank_name }}
                <h5>
                <a href="{{ url('/paymentPage/'.$investment->id) }}" class="btn btn-primary" id="bast">Payment Page</a>

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
              
    <script>
        $(document).ready(function(){
            $("#confirm").on('click', function(){
                event.preventDefault()
                var confirmResponse = confirm('Are you sure you want to confirm payment?')
                if(confirmResponse){
                    $("#confirmForm").submit();
                }
            });

            $("#confirm2").on('click', function(){
                event.preventDefault()
                var confirmResponse = confirm('Are you sure you want to confirm payment?')
                if(confirmResponse){
                    $("#confirmForm2").submit();
                }
            });
        })
    </script>
    @if ($investment)
        <script>
            // Set the date we're counting down to
            var countDownDate = new Date('{{ $date->format("M j, Y H:i:s") }}').getTime();
            
            // Update the count down every 1 second
            var x = setInterval(function() {
            
            // Get today's date and time
            var now = new Date().getTime();
                
            // Find the distance between now and the count down date
            var distance = countDownDate - now;
                
            // Time calculations for days, hours, minutes and seconds
            var days = Math.floor(distance / (1000 * 60 * 60 * 24));
            var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                
            // Output the result in an element with id="demo"
            document.getElementById("demo").innerHTML = days + "d " + hours + "h "
            + minutes + "m " + seconds + "s ";
                
            // If the count down is over, write some text 
            if (distance < 0) {
                clearInterval(x);
                document.getElementById("demo").innerHTML = "EXPIRED";
            }
            }, 1000);
        </script>
    @endif
@endsection