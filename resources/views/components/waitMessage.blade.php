<div class="row">
    <div class="col-12 m-t-30">
      <div class="card w-100">
        <div class="card-body">
          <h3 class="card-title" style="text-align: center;">
            Please await matching on your investment, {{ $user->name }}
          </h3>
          <br>
          <a href="{{ url('/newInvestment') }}" class="btn btn-success" style="
                width: 77%;
                padding: 1.3rem;
                font-size: 1.06rem;
                margin-left: 10%;
                margin-right: 10%;
              " id="payment__button">Make New Investment</a>
        </div>
      </div>
    </div>
  </div>