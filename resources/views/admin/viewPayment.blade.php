@extends('layouts.app')

@section('content')
    <div class="container">
        {{ $investment->user_id }} <br>
        {{ $user->name }} <br>
        {{ $user->bank_name }}
        <br>
        @if ($investment->paid_complete)
            <a href="#" class="btn btn-danger mt-4 disabled" id="confirm">Payment Already Confirmed</a>
        @else
            <a href="{{ url('/confirmPayment') }}" class="btn btn-primary mt-4" id="confirm">Confirm Payment</a>
            <form action="/confirmPaymentAdmin" method="post" id="confirmForm">
                @csrf
                <input type="hidden" name="confirm" value="{{ $investment->id }}">
            </form>
        @endif
    </div>
    <script>
        $(document).ready(function(){
            $("#confirm").on('click', function(){
                event.preventDefault()
                var confirmResponse = confirm('Are you sure you want to confirm payment?')
                if(confirmResponse){
                    $("#confirmForm").submit();
                }
            })
        })
    </script>
@endsection