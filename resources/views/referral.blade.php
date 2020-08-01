@extends('layouts.dashboard')

@section('content')
    <!-- Row -->
    <div class="row">


        <!-- Column -->
        <div class="col-sm-12 col-md-6">
          <div class="card bg-success">
            <div class="card-body text-white">
              <div class="d-flex flex-row">
                <div class="align-self-center display-6"><i class="ti-wallet"></i></div>
                <div class="p-10 align-self-center">
                  <h4 class="m-b-0">Available Balance</h4>
                  <span>Balance</span>
                  <br><br>
                </div>
                <div class="ml-auto align-self-center">
                  <h2 class="font-medium m-b-0">NGN {{ $user->referral_balance }}</h2>
                </div>
                <br><br><br><br><br><br>
              </div>
            </div>
          </div>
        </div>
        <!-- Column -->

        <!-- Column -->
        <div class="col-sm-12 col-md-6">
          <div class="card bg-success">
            <div class="card-body text-white">
              <div class="d-flex flex-row">
                <div class="align-self-center display-6"><i class="ti-user"></i></div>
                <div class="p-10 align-self-center">
                  <h4 class="m-b-0">Total Referrals</h4>
                  <div class="form-group">
                    <label class="form-control-label" style="color: #fff;">Your Referral Link</label>

                    <div class="input-group">

                      <input type="text" value="{{url('?ref='.$user->userID)}}"
                        id="ReferralLink" class="form-control">
                      <div class="input-group-append">
                        <button onclick="copyFunction()" class="btn btn-primary">copy!</button>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="ml-auto align-self-center">
                  <h2 class="font-medium m-b-0"> {{$getReferrals->count()}} </h2>
                </div>
                <br><br><br><br><br><br>
              </div>
            </div>
          </div>
        </div>
        <!-- Column -->

      </div>
      <!-- Row -->


      <!-- language options -->
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Referral Earnings</h4>

              <div class="table-responsive">
                <table id="lang_opt" class="table table-striped table-bordered display" style="width:100%">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Referee Name</th>
                      <th>Amount Earned</th>
                    </tr>
                  </thead>
                  <tbody>


                  @if ($referrals->count())
                    @foreach ($referrals as $referral)
                      <tr>
                        <td>{{$referral->created_at->format("F j, Y g:i a")}}</td>
                        <td>{{getUser($referral->user_id)->name}}</td>
                        <td>{{$referral->amount}}</td>
                      </tr>
                    @endforeach
                  @endif
                  </tbody>

                </table>
              </div>
            </div>
          </div>
        </div>
      </div>

      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Your Referrals</h4>

              <div class="table-responsive">
                <table id="lang_opt" class="table table-striped table-bordered display" style="width:100%">
                  <thead>
                    <tr>
                      <th>Date</th>
                      <th>Name</th>
                      <th>Phone</th>
                    </tr>
                  </thead>
                  <tbody>


                  @if ($getReferrals->count())
                    @foreach ($getReferrals as $referral)
                      <tr>
                        <td>{{$referral->created_at->format("F j, Y g:i a")}}</td>
                        <td>{{$referral->name}}</td>
                        <td>{{$referral->phone}}</td>
                      </tr>
                    @endforeach
                  @endif
                  </tbody>

                </table>
              </div>
            </div>
          </div>
        </div>
      </div>
@endsection