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
                      <span>Account Balance</span>
                      <h4>NGN {{$user->balance}}</h4>
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
                      <h4>NGN {{$user->pending_payout}}</h4>
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
                      <span>Referral Balance</span>
                      <h4>NGN {{$user->referral_balance}}</h4>
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
                  <h3 class="card-title">Withdraw</h3>
                  <p class="card-text">
                    Get your Investment <b>+</b> 50% profit
                  </p>
                  <a href="{{url('/withdraw_show')}}" class="btn btn-success">Withdraw Investment</a>
                </div>
              </div>
            </div>
            <div class="col-md-6">
              <div class="card">
                <div class="card-body">
                  <h3 class="card-title">Make Investment</h3>
                  <p class="card-text">
                    Make an Investment suited for you
                  </p>
                  <a href="{{ url('/newInvestment') }}" class="btn btn-success">Start Now</a>
                </div>
              </div>
            </div>
          </div>