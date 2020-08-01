@extends('layouts.admin')

@section('content')
    <!-- Row -->
    <form action="{{route('merge')}}" method="post">
      @csrf
    <h3>Manual Merging</h3>
    <div class="row">
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Available Payer(s)</h4>
              <h6 class="card-subtitle">Select up to {{$payers->count()}} payer(s)</h6>
              <div class="form-horizontal p-t-20">
                <div class="form-group row">
                  <label class="col-sm-3 text-right control-label col-form-label">Select</label>
                  <div class="col-sm-9">
                    <select multiple class="form-control" id="payer" name="payers[]" required>
                      <option disabled>Choose Your Option</option>
                      @foreach ($payers as $payer)
                        <option value="{{ $payer->id }}">{{getUser($payer->user_id)->name}} - Offer Amount: ₦{{$payer->amount_offered}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>


              </div>
            </div>
          </div>
        </div>
        <div class="col-lg-6">
          <div class="card">
            <div class="card-body">
              <h4 class="card-title">Reciever</h4>
              <h6 class="card-subtitle">Select a single Reciever</h6>
              <div class="form-horizontal p-t-20">

                <div class="form-group row">
                  <label class="col-sm-3 text-right control-label col-form-label">Select</label>
                  <div class="col-sm-9">
                    <select class="form-control" name="receiver">
                      <option disabled>Choose Your Option</option>
                      @foreach ($receivers as $receiver)
                        <option value="{{ $receiver->id }}">{{getUser($receiver->user_id)->name}} - Request Amount: ₦{{$receiver->amount}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <br><br><br>

              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- End Row -->

      <br>
      <div class="row well">
        <button type="submit" class="btn btn-primary pull-right"
          style="color: #fff; margin-bottom: 10px; margin-right: auto; margin-left: auto;">Proceed to
          Merging</button>
      </div></br><br>
    </form>
@endsection