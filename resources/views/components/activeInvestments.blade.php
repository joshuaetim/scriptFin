<h4 class="m-b-0">Active Investments</h4>
        <br>
    <div class="row">
            @foreach ($activeInvestments as $investment)
                @if (! $investment->withdraw)
                    <div class="col-md-6" style="text-align:center">
                        <div class="card bg-secondary text-white">
                            <div class="card-body">
                            <h3 class="card-title">Investment #{{$investment->uniqueID}}</h3>
                            <p class="card-text" style="font-size: 15px; font-weight: bold">
                                Amount Offered: {{$investment->main_offered}}
                            </p>
                            <p class="card-text" style="font-size: 15px; font-weight: bold">
                                Mature Date: {{getCarbonInstance($investment->mature_date)->format("F j, Y g:i a")}}
                            </p>
                            <p class="card-text" style="font-size: 15px; font-weight: bold">
                                Expected Yield: {{$investment->yield}}
                            </p>
                            <a href="{{url('/withdraw/'.$investment->id)}}" class="btn btn-success">Withdraw Investment</a>
                            </div>
                        </div>
                    </div>
                @endif
            @endforeach
    </div>