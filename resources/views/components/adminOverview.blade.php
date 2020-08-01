    <!-- Earnings -->
        <!-- ============================================================== -->
        <div class="row">
            <!-- Column -->
            <div class="col-sm-12 col-lg-4">
              <div class="card">
                <div class="card-body">
                  <span class="display-5"><i class="mdi mdi-account-box"></i></span>
                  <h4 class="card-title">All Users</h4>
                  <h5 class="card-subtitle">Total active users on site</h5>
                  <h2 class="font-medium">{{$users->count()}}</h2>
                </div>
              </div>
            </div>
            <!-- Column -->
            <div class="col-sm-12 col-lg-8">
              <div class="card">
                <div class="card-body border-bottom">
                  <h4 class="card-title">Overview</h4>
                  <h5 class="card-subtitle">Total Earnings of users on site</h5>
                </div>
                <div class="card-body">
                  <div class="row m-t-10">
                    <!-- col -->
                    <div class="col-md-6 col-sm-12 col-lg-4">
                      <div class="d-flex align-items-center">
                        <div class="m-r-10"><span class="text-orange display-5"><i class="mdi mdi-cash-100"></i></span>
                        </div>
                        <div><span class="text-muted">Pending Payouts</span>
                          <h3 class="font-medium m-b-0">₦{{$totalPending}}</h3>
                        </div>
                      </div>
                    </div>
                    <!-- col -->
                    <!-- col -->
                    <div class="col-md-6 col-sm-12 col-lg-4">
                      <div class="d-flex align-items-center">
                        <div class="m-r-10"><span class="text-primary display-5"><i class="mdi mdi-wallet "></i></span>
                        </div>
                        <div><span class="text-muted">Total Balance</span>
                          <h3 class="font-medium m-b-0">₦{{$totalBalance}}</h3>
                        </div>
                      </div>
                    </div>
                    <!-- col -->
                    <!-- col -->
                    <div class="col-md-6 col-sm-12 col-lg-4">
                      <div class="d-flex align-items-center">
                        <div class="m-r-10"><span class="display-5"><i class="mdi mdi-cash-multiple"></i></span></div>
                        <div><span class="text-muted">Total Paid</span>
                          <h3 class="font-medium m-b-0">₦{{$totalPaid ?? '0'}}</h3>
                        </div>
                      </div>
                    </div>
                    <!-- col -->
                  </div>
                </div>
              </div>
            </div>
          </div>
          <!-- ============================================================== -->
          <!--End Of Earnings -->
          <!-- ============================================================== -->