<!-- Activation of Account Section -->
        <!-- ============================================================== -->

        <div class="row">
            <div class="col-12 m-t-30">
              <div class="card w-100">
                <div class="card-body">
                  <h3 class="card-title" style="text-align: center;">
                    Activation Fees <strong>NGN 1000</strong>
                  </h3>
                  <p class="card-text" style="font-size: 1.2rem; text-align: center;">
                    To activate your account, pay to the user below
                  </p>
                  <p class="card-text" style="font-size: 1.2rem; text-align: center;">Deadline Count Down</p>
                  <p class="card-text" id="demo__countdown" style="font-size: 2rem; text-align: center;"></p>
  
                  <table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe">
                    <thead>
                      <tr>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                          data-tablesaw-priority="3">
                          <strong>Full Name</strong>
                        </th>
                        <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">
                          <strong>{{ $receiver->name }}</strong>
                        </th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td><strong>Amount</strong></td>
                        <td><strong>NGN 1000</strong></td>
                      </tr>
                      <tr>
                        <td><strong>Mobile Number</strong></td>
                        <td><strong>{{ $receiver->phone }}</strong></td>
                      </tr>
                      <tr class="bg-secondary text-white">
                        <td>
                          <strong><span id="bank" style="
                                  font-size: 1rem;
                                  text-transform: uppercase;
                                ">Bank</span>
                            <br />
                            <span id="bank__details">{{ $receiver->bank_name }}</span></strong>
                        </td>
                        <td>
                          <strong><span id="account" style="
                                  font-size: 1rem;
                                  text-transform: uppercase;
                                ">Account Number</span>
                            <br />
                            <span id="account__details">{{ $receiver->account_number }}</span></strong>
                        </td>
                      </tr>
                      <tr class="bg-secondary text-white">
                        <td>
                          <strong><span id="accountname" style="
                                  font-size: 1rem;
                                  text-transform: uppercase;
                                ">Account Name</span>
                            <br />
                            <span id="accountname__details">{{ $receiver->account_name }}</span></strong>
                        </td>
                        <td>
                          <strong><span id="accountname" style="
                                  font-size: 1rem;
                                  text-transform: uppercase;
                                ">payment Method</span>
                            <br />
                            <span id="accountname__details">Mobile Transfer, Bank Deposit, Internet Banking</span></strong>
                        </td>
                      </tr>
                    </tbody>
                  </table>
                  @if ($investment->paid)
                    <button class="btn btn-danger" style="
                        width: 77%;
                        padding: 1.3rem;
                        font-size: 1.06rem;
                        margin-left: 10%;
                        margin-right: 10%;
                        cursor: not-allowed;
                      " id="payment__button" disabled>Payment Submitted</button>
                  @else
                  <a href="{{ url('/activationPaymentPage/'.$investment->id) }}" class="btn btn-success" style="
                        width: 77%;
                        padding: 1.3rem;
                        font-size: 1.06rem;
                        margin-left: 10%;
                        margin-right: 10%;
                      " id="payment__button">Make Payment</a>
                  @endif
                </div>
              </div>
            </div>
          </div>
  
  
          <!-- ============================================================== -->
          <!--End of Activation of Account Section -->
          <!-- ============================================================== -->