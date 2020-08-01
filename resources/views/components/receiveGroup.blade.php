@foreach ($receiveGroup as $receive)
    @if ($receive->payer)
        <div class="row">
            <div class="col-12 m-t-30">
                <div class="card w-100">
                    <div class="card-body">
                    <h3 class="card-title" style="text-align: center;">
                        You are to receive payment of <strong>NGN {{$receive->amount}}</strong>
                    </h3>
                    <p class="card-text" style="font-size: 1.2rem; text-align: center;">
                        See details of payer below
                    </p>
                    <p class="card-text" style="font-size: 1.2rem; text-align: center; font-weight:bold">Deadline: {{ getCarbonInstance($receive->mature_date)->format(" M j, Y H:i") }}</p>
                    <p class="card-text" id="demo__countdown" style="font-size: 2rem; text-align: center;"></p>

                    <table class="tablesaw table-bordered table-hover table" data-tablesaw-mode="swipe">
                        <thead>
                        <tr>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-sortable-default-col
                            data-tablesaw-priority="3">
                            <strong>Full Name</strong>
                            </th>
                            <th scope="col" data-tablesaw-sortable-col data-tablesaw-priority="2">
                            <strong>{{getUser($receive->payer)->name}}</strong>
                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td><strong>Amount</strong></td>
                            <td><strong>NGN {{$receive->amount}}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Mobile Number</strong></td>
                            <td><strong>{{ getUser($receive->payer)->phone }}</strong></td>
                        </tr>
                        <tr>
                            <td><strong>Email</strong></td>
                            <td><strong>{{ getUser($receive->payer)->email }}</strong></td>
                        </tr>
                        <tr>
                            <td>
                            <strong><span id="bank" style="
                                    font-size: 1rem;
                                    text-transform: uppercase;
                                    ">Bank</span>
                                <br />
                                <span id="bank__details">{{ getUser($receive->payer)->bank_name }}</span></strong>
                            </td>
                            <td>
                            <strong><span id="account" style="
                                    font-size: 1rem;
                                    text-transform: uppercase;
                                    ">Account Number</span>
                                <br />
                                <span id="account__details">{{ getUser($receive->payer)->account_number }}</span></strong>
                            </td>
                        </tr>
                        <tr>
                            <td>
                            <strong><span id="accountname" style="
                                    font-size: 1rem;
                                    text-transform: uppercase;
                                    ">Account Name</span>
                                <br />
                                <span id="accountname__details">{{ getUser($receive->payer)->account_name }}</span></strong>
                            </td>
                            <td>
                            <strong><span id="account-type" style="
                                    font-size: 1rem;
                                    text-transform: uppercase;
                                    ">Payment method</span>
                                <br />
                                <span id="account-type__details">Transfer, Deposit</span></strong>
                            </td>
                        </tr>
                        <tr>
                            <td><strong>Payment Status</strong></td>
                            @if ($receive->submitted_payment)
                                <td class="bg-success text-white"><strong>SUBMITTED</strong></td>
                            @else
                                <td class="bg-danger text-white"><strong>NOT SUBMITTED</strong></td>
                            @endif
                        </tr>
                        @if ($receive->submitted_payment)
                            <tr>
                                <td><strong>Depositor Name</strong></td>
                                <td><strong>{{ getPaymentDetails($receive->payment)->depositor_name }}</strong></td>
                            </tr>
                            <tr>
                                <td><strong>Proof of payment</strong></td>
                                <td><a href="{{ url('download/'.getPaymentDetails($receive->payment)->proof) }}">Click here to download</a></td>
                            </tr>
                        @endif
                        </tbody>
                    </table>

                    <a href="#" class="btn btn-success" style="
                            width: 77%;
                            padding: 1.3rem;
                            font-size: 1.06rem;
                            margin-left: 10%;
                            margin-right: 10%;
                        " id="confirm{{$receive->id}}" onclick="confirmPayment({{$receive->id}})">Confirm Withdrawal</a>
                        <form action="{{ route('confirmPayment') }}" method="post" id="{{$receive->id}}">
                            @csrf
                            <input type="hidden" name="confirm" value="{{$receive->id}}">
                        </form>
                    </div>
                </div>
            </div>
        </div>
    @else
        <div class="row">
            <div class="col-12 m-t-30">
                <div class="card w-100">
                    <div class="card-body">
                        <h3 class="card-title" style="text-align: center;">
                            Please wait for matching for Withdrawal {{ $receive->id }}
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
    @endif
@endforeach