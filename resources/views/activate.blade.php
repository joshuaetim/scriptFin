@extends('layouts.app')

@section('content')
    <div class="container">
        <h3>Payment Activation</h3>
        <p><b>Pay #1000 to </b> </p>
        <h5>
            {{ $matched->name }}<br>
            {{ $matched->account_number}}<br>
            {{ $matched->bank_name}}
        </h5>
        <form action="{{ route('pay') }}" method="post">
            @csrf
            <input type="hidden" name="number" value="{{ $matched->name }}">
        </form>
    </div>
@endsection