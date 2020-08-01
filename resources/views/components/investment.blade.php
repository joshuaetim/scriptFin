<!-- Activation of Account Section -->
        <!-- ============================================================== -->
        @if ($singlePayment->submitted_payment)
          <div class="row">
            <div class="col-12 m-t-30">
              <div class="card w-100">
                  <div class="card-body">
                  <h3 class="card-title" style="text-align: center;">
                      You have successfully made payment to <b>{{ getUser($singlePayment->user_id)->name }}</b>
                      <br>
                      Please wait for confirmation.
                  </h3>
                  <br>
                  <a href="{{ url('/newInvestment') }}" class="btn btn-success" style="
                          width: 77%;
                          padding: 1.3rem;
                          font-size: 1.06rem;
                          margin-left: 10%;
                          margin-right: 10%;
                      " id="payment__button">Make New Investment</a>
                  </div>
              </div>
            </div>
          </div>
        @else
          <div class="row">
            <div class="col-12 m-t-30">
              <div class="card w-100">
                <div class="card-body">
                  <h3 class="card-title" style="text-align: center;">
                    Make payment of <strong>NGN {{$singlePayment->amount}}</strong>
                  </h3>
                  <p class="card-text" style="font-size: 1.2rem; text-align: center;">
                    to the user below
                  </p>
                  <p class="card-text" style="font-size: 1.2rem; text-align: center; font-weight:bold">Deadline:</p>
                  <p class="card-text" id="demo__countdown" style="font-size: 2rem; text-align: center;"></p>

                  <table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe">
                    <thead>
                      <tr>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                          data-tablesaw-priority="3">
                          <strong>Full Name</strong>
                        </th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">
                          <strong>{{getUser($singlePayment->user_id)->name}}</strong>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><strong>Amount</strong></td>
                        <td><strong>NGN {{$singlePayment->amount}}</strong></td>
                      </tr>
                      <tr>
                        <td><strong>Mobile Number</strong></td>
                        <td><strong>{{ getUser($singlePayment->user_id)->phone }}</strong></td>
                      </tr>
                      <tr>
                        <td><strong>Email</strong></td>
                        <td><strong>{{ getUser($singlePayment->user_id)->email }}</strong></td>
                      </tr>
                      <tr>
                        <td>
                          <strong><span id="bank" style="
                                  font-size: 1rem;
                                  text-transform: uppercase;
                                ">Bank</span>
                            <br />
                            <span id="bank__details">{{ getUser($singlePayment->user_id)->bank_name }}</span></strong>
                        </td>
                        <td>
                          <strong><span id="account" style="
                                  font-size: 1rem;
                                  text-transform: uppercase;
                                ">Account Number</span>
                            <br />
                            <span id="account__details">{{ getUser($singlePayment->user_id)->account_number }}</span></strong>
                        </td>
                      </tr>
                      <tr>
                        <td>
                          <strong><span id="accountname" style="
                                  font-size: 1rem;
                                  text-transform: uppercase;
                                ">Account Name</span>
                            <br />
                            <span id="accountname__details">{{ getUser($singlePayment->user_id)->account_name }}</span></strong>
                        </td>
                        <td>
                          <strong><span id="account-type" style="
                                  font-size: 1rem;
                                  text-transform: uppercase;
                                ">Payment method</span>
                            <br />
                            <span id="account-type__details">Transfer, Deposit</span></strong>
                        </td>
                      </tr>
                    </tbody>
                  </table>

                  <a href="{{url('/paymentPage/'.$singlePayment->id)}}" class="btn btn-success" style="
                        width: 77%;
                        padding: 1.3rem;
                        font-size: 1.06rem;
                        margin-left: 10%;
                        margin-right: 10%;
                      " id="payment__button">Make Payment</a>
                </div>
              </div>
            </div>
          </div>
        @endif
          <!-- ============================================================== -->
          <!--End of Activation of Account Section -->
          <!-- ============================================================== -->