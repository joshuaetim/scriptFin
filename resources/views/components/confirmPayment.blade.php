<!-- Activation of Account Section -->
        <!-- ============================================================== -->

        <div class="row">
            <div class="col-12 m-t-30">
              <div class="card w-100">
                <div class="card-body">
                  <h3 class="card-title" style="text-align: center;">
                    You are to receive payment. Check below for details.
                  </h3>
  
                  <table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe">
                    <thead>
                      <tr>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                          data-tablesaw-priority="3">
                          <strong>Full Name</strong>
                        </th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">
                          <strong>{{ $payer->name }}</strong>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><strong>Amount</strong></td>
                        <td><strong>NGN {{$paymentDetails->amount_offered}}</strong></td>
                      </tr>
                      <tr>
                        <td><strong>Payment Method</strong></td>
                        <td><strong>NGN {{$paid->method}}</strong></td>
                      </tr>
                      <tr>
                        <td><strong>Mobile Number</strong></td>
                        <td><strong>{{ $payer->phone }}</strong></td>
                      </tr>
                      <tr>
                        <td>
                          <strong><span id="bank" style="
                                  font-size: 1rem;
                                  text-transform: uppercase;
                                ">Bank</span>
                            <br />
                            <span id="bank__details">{{ $paid->bank }}</span></strong>
                        </td>
                        <td>
                          <strong><span id="account" style="
                                  font-size: 1rem;
                                  text-transform: uppercase;
                                ">Account Number</span>
                            <br />
                            <span id="account__details">{{ $paid->account_number }}</span></strong>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <strong><span id="accountname" style="
                                  font-size: 1rem;
                                  text-transform: uppercase;
                                ">Account Name</span>
                            <br />
                            <span id="accountname__details">{{ $paid->account_name }}</span></strong>
                        </td>
                        <td>
                          <strong><span id="accountname" style="
                                  font-size: 1rem;
                                  text-transform: uppercase;
                                ">Depositor Name</span>
                            <br />
                            <span id="accountname__details">{{ $paid->depositor_name }}</span></strong>
                        </td>
                      </tr>
                    </tbody>
                  </table>
  
                  <a href="{{ url('/confirmPayment') }}" class="btn btn-success" style="
                                    width: 77%;
                                    padding: 1.3rem;
                                    font-size: 1.06rem;
                                    margin-left: 10%;
                                    margin-right: 10%;
                                " id="confirm2">Confirm Payment</a>
                                <form action="/confirmPayment" method="post" id="confirmForm2">
                                    @csrf
                                    <input type="hidden" name="confirm" value="{{ $paymentDetails->id }}">
                                </form>
                </div>
              </div>
            </div>
          </div>
  
  
          <!-- ============================================================== -->
          <!--End of Activation of Account Section -->
          <!-- ============================================================== -->