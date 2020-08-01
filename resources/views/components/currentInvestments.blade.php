@foreach ($currentInvestments as $investment)
    <div class="row">
        <div class="col-12 m-t-30">
            <div class="card w-100">
                <div class="card-body">
                <h3 class="card-title" style="text-align: center; line-height: 1.6">
                    Investment #{{$investment->uniqueID}}
                    <br>
                    Amount: NGN {{$investment->amount_offered}} <br>
                    Investment Yield: NGN {{$investment->yield}} <br>
                    Please await matching on this investment
                </h3>
                </div>
            </div>
        </div>
    </div>
@endforeach