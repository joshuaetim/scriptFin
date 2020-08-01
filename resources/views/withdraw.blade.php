@extends('layouts.dashboard')

@section('content')
    <div class="col-12 m-t-30">
        <h4 class="m-b-0">Withdraw Investment</h4>
        <br>
        <div class="card w-100" style="margin-left: auto; margin-right: auto; width: 90%;">
            <div class="card-body">
                <h3 class="card-title"
                style="text-align: center; width: 100%; background-color:darkslategrey;color: floralwhite; padding: 1.1rem;">
                Withdraw Investment</h3>
                <br>
                <h3 class="card-title" style="color:darkslategrey; font-weight:800; font-size:2rem; text-align: center;">
                NGN <span id="donation-amount">0.00</span> </h3>
                

                <form action="{{ route('withdrawInvestment') }}" name="" id="investForm" method="post">
                    @csrf
                <small>
                    Amount:</small>
                <div class="input-group mb-3"
                    style="width: 100%; height: 3.53rem; margin-right: auto; margin-left: auto; border-color: darkslategrey; color: darkslategrey;">

                    <div class="input-group-prepend">
                    <span class="input-group-text"><strong> NGN </strong></span>
                    </div>
                    <input type="number" placeholder="0" name="amount" class="form-control" aria-label="Amount (to the nearest dollar)"
                    style="height: 3.4rem; border-color: darkslategrey;" id="donation-input"
                    onkeyup="OnDonationkeyUp()">
                    <div class="input-group-append">
                    <span class="input-group-text"> <strong>.00</strong></span>
                    </div>

                </div>
                <small>Minimum is NGN5000 | Maximum is NGN50,000</small>
                <small id="alert-donation" class="personalAlert"></small>
                <br><br><br><br>
                <button type="submit" class="btn btn-lg btn-block btn-outline-primary"
                    style="width: 80%; margin-left: auto; margin-right: auto;" id="provide__donation">Withdraw Investment
                </button>
                </form>
                </br>
                <br>
            </div>
        </div>

    </div>
    <script src="{{ asset('js/providehelp.js')}}"></script>
@endsection