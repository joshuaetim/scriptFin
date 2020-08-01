@extends('layouts.dashboard')

@section('content')
  <!-- Row -->
  <div class="row">
    <div class="col-12">
      <div class="card">
        <form class="form-horizontal r-separator" id="personal" action="{{route('activationPay')}}" method="post" enctype="multipart/form-data">
          @csrf
          @if ($errors->any())
              @foreach ($errors->all() as $error)
                  <div class="alert alert-danger">
                      {{ $error }}
                  </div>
              @endforeach
          @endif
          <div class="card-body">
            <h4 class="card-title">Enter Payment Details</h4>
            <input type="hidden" name="investmentiD" value="{{$investment->id}}">
            <div class="form-group row p-b-15">
              <label for="firstname" class="col-sm-3 text-right control-label col-form-label">Payment Method</label>
              <div class="col-sm-9">
                <select id="payment_method" name="method" required="required" class="form-control">
                  <option value="" selected="selected">Select Payment Method</option>
                  <option value="Bank Transfer">Bank Transfer</option>
                  <option value="Bank Deposit">Bank Deposit</option>
                </select>

                <small id="alert-firstname" class="personalAlert"></small>
              </div>
            </div>

            <div class="form-group row p-b-15">
              <label for="firstname" class="col-sm-3 text-right control-label col-form-label">Bank</label>
              <div class="col-sm-9">
                <input id="inputHorizontalSuccess" name="bank" type="text" placeholder="Your Bank Name"
                  class="form-control form-control-success" value="{{$receiver->bank_name}}">
                <span> <i class="fa fa-check complete" aria-hidden="true"></i></span>

                <small id="alert-firstname" class="personalAlert"></small>
              </div>
            </div>

            <div class="form-group row p-b-15">
              <label for="firstname" class="col-sm-3 text-right control-label col-form-label">Account Number</label>
              <div class="col-sm-9">
                <input id="inputHorizontalSuccess" name="account_number" type="text" placeholder="Your Bank Name"
                  class="form-control form-control-success" value="{{$receiver->account_number}}">
                <span> <i class="fa fa-check complete" aria-hidden="true"></i></span>

                <small id="alert-firstname" class="personalAlert"></small>
              </div>
            </div>

            <div class="form-group row p-b-15">
              <label for="firstname" class="col-sm-3 text-right control-label col-form-label">Account Name</label>
              <div class="col-sm-9">
                <input id="inputHorizontalSuccess" name="account_name" type="text" placeholder="Your Bank Name"
                  class="form-control form-control-success" value="{{$receiver->account_name}}">
                <span> <i class="fa fa-check complete" aria-hidden="true"></i></span>

                <small id="alert-firstname" class="personalAlert"></small>
              </div>
            </div>

            <div class="form-group row p-b-15">
              <label for="firstname" class="col-sm-3 text-right control-label col-form-label">Depositor Name</label>
              <div class="col-sm-9">
                <input id="inputHorizontalSuccess" name="depositor_name" type="text" placeholder="Name of Depositor"
                  class="form-control form-control-success" value="{{old('depositor_name')}}">
                <span> <i class="fa fa-check complete" aria-hidden="true"></i></span>

                <small id="alert-firstname" class="personalAlert"></small>
              </div>
            </div>

            <div class="form-group row p-b-15">
              <label for="firstname" class="col-sm-3 text-right control-label col-form-label">Payment Location</label>
              <div class="col-sm-9">
                <input id="inputHorizontalSuccess" name="payment_location" type="text" placeholder="Enter payment location"
                  class="form-control form-control-success" value="{{old('payment_location')}}">
                <span> <i class="fa fa-check complete" aria-hidden="true"></i></span>

                <small id="alert-firstname" class="personalAlert"></small>
              </div>
            </div>

            <div class="form-group row p-b-15">
              <label for="firstname" class="col-sm-3 text-right control-label col-form-label">Screenshot</label>
              <div class="col-sm-9">
                <input id="inputHorizontalSuccess" name="proof" type="file"
                  class="form-control form-control-success">
                <span> <i class="fa fa-check complete" aria-hidden="true"></i></span>

                <small id="alert-firstname" class="personalAlert"></small>
              </div>
            </div>
            <button type="submit" class="btn btn-success" style="
              width: 77%;
              padding: 1.3rem;
              font-size: 1.06rem;
              margin-left: 10%;
              margin-right: 10%;
            " id="payment__button">Make Payment</button>
            {{-- <div class="form-group m-b-0 text-right">
              <button type="submit" id="account__submit" class="btn btn-info waves-effect waves-light btn-large">
                Make Payment
              </button>
            </div> --}}

            </div>
        </form>


      </div>
   
    </div>
  </div>
@endsection