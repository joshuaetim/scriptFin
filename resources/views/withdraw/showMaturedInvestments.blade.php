@extends('layouts.dashboard')

@section('content')
    <h4 class="m-b-0">Matured Investments</h4>
        <br>
    <div class="row">
        @if ($investments)
            @foreach ($investments as $investment)
                @if (! $investment->withdraw)
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-body">
                            <h3 class="card-title">Investment #{{$investment->id}}</h3>
                            <p class="card-text" style="font-size: 15px; font-weight: bold">
                                Yield: {{$investment->yield}}
                            </p>
                            <a href="{{url('/withdraw/'.$investment->id)}}" class="btn btn-success">Withdraw Investment</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
        @endif
    </div>
@endsection