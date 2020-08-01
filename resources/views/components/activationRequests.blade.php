<div class="col-sm-12 col-lg-8">
    <div class="card">
      <div class="card-body">
        <h4 class="card-title">Recent Activation Requests</h4>
        <div class="table-responsive">
          <table class="table v-middle">
            <thead>
              <tr>
                <th class="border-top-0">Name</th>
                <th class="text-center border-top-0">Phone Number</th>
                <th class="text-center border-top-0">Account Name</th>
                <th class="text-center border-top-0">Payment Status</th>
                <th class="text-center border-top-0">Action/th>
              </tr>
            </thead>
            <tbody>
                @if ($activations->count())
                    @foreach ($activations as $activation)
                        <tr>
                            <td class="font-bold">{{getUser($activation->user_id)->name}}</td>
                            <td class="text-center">{{getUser($activation->user_id)->phone}}</td>
                            <td class="text-center">{{getUser($activation->user_id)->account_name}}</td>
                            @if ($activation->paid)
                                <td class="font-bold text-center">
                                  <button class="btn btn-success" title="Click here to view payment" data-toggle="modal"
                                data-target="#responsive-modal{{$activation->id}}">Paid (view)</button>
                                </td>
                                <!-- modal content -->
                                <div id="responsive-modal{{$activation->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                  aria-hidden="true" style="display: none;">
                                  <div class="modal-dialog">
                                  <div class="modal-content">
                                      <div class="modal-body">
                                      <h3>Payment Details</h3>
                                      <p style="font-size: 15px; line-height: 1.8;">Depositor's Name: {{ activationPayment($activation->id)->depositor_name }}<br>
                                      Receiver Account Name: {{ getUser(activationPayment($activation->id)->receiver)->account_name }}<br>
                                      Receiver Bank Name: {{ getUser(activationPayment($activation->id)->receiver)->bank_name }}<br>
                                      Receiver Account Number: {{ getUser(activationPayment($activation->id)->receiver)->account_number }}<br>
                                      <b>Proof</b> <br>
                                      <a href="{{ url('storage/images/'.activationPayment($activation->id)->proof) }}" target="_blank" title="click to enlarge" style="cursor:zoom-in">
                                        <img src="{{ url('storage/images/'.activationPayment($activation->id)->proof) }}" alt="" style="width: 300px; height: auto">
                                      </a>

                                      </p>
                                      
                                      </div>
                                      <div class="modal-footer">
                                      <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
          
                                              </div>
                                          </div>
                                          </div>
                                  </div>
                                  <!-- /.modal -->
                                  
                            @else
                            <td class="font-bold text-center">Not Paid</td>
                            @endif</td>
                            <td class="text-center"><button class="btn btn-primary" title="Click here to activate user" onclick="document.getElementById('confirm{{$activation->id}}').submit()">Activate</button></td>
                            <form action="{{url('/confirmPaymentAdmin')}}" id="confirm{{$activation->id}}" method="POST">
                              @csrf
                              <input type="hidden" name="confirm" value="{{$activation->id}}">
                            </form>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td><p>No activation requests</p></td>
                    </tr>
                @endif
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>