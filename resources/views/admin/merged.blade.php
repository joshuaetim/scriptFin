@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><a href="{{url('/admin')}}">Dashboard</a> / Merged Withdraws</h4>

            
            <div class="table-responsive">
                <table id="lang_opt" class="table table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                    <th>Payer</th>
                    <th>Receiver</th>
                    <th>Amount</th>
                    <th>Merged Date</th>
                    <th>Expiry Date</th>
                    <th>Status</th>
                    </tr>
                </thead>
                <tbody style="font-size: 12px; font-weight: 200;">
                    @foreach ($withdraws as $withdraw)
                        <tr data-row-id="1">
                            <td><a href="#" data-toggle="modal"
                                data-target="#responsive-modalUser{{$withdraw->id}}" title="click to view details">{{getUser($withdraw->payer)->userID}}</a></td>
    
                            <!-- modal content for user info -->
                            <div id="responsive-modalUser{{$withdraw->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h3>User Information</h3>
                                        <p style="font-size: 16px">
                                            @if (getUser($withdraw->payer)->special)
                                                <b>Special User</b><br>
                                            @endif
                                            Fullname: {{getUser($withdraw->payer)->name}}<br>
                                            Account Name: {{getUser($withdraw->payer)->account_name}}<br>
                                            Account Balance: {{getUser($withdraw->payer)->balance}}<br>
                                            Email: {{getUser($withdraw->payer)->email}} <br>
                                            Phone: {{getUser($withdraw->payer)->phone}} <br>
                                            Registration Date: {{getUser($withdraw->payer)->created_at->format("F j, Y")}}<br>
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                            <!-- /.modal -->
                            <td><a href="#" data-toggle="modal"
                                data-target="#responsive-modalPayee{{$withdraw->id}}" title="click to view details">{{getUser($withdraw->user_id)->userID}}</a></td>
    
                            <!-- modal content for user info -->
                            <div id="responsive-modalPayee{{$withdraw->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h3>User Information</h3>
                                        <p style="font-size: 16px">
                                            @if (getUser($withdraw->payer)->special)
                                                <b>Special User</b><br>
                                            @endif
                                            Fullname: {{getUser($withdraw->user_id)->name}}<br>
                                            Account Name: {{getUser($withdraw->user_id)->account_name}}<br>
                                            Account Balance: {{getUser($withdraw->user_id)->balance}}<br>
                                            Email: {{getUser($withdraw->user_id)->email}} <br>
                                            Phone: {{getUser($withdraw->user_id)->phone}} <br>
                                            Registration Date: {{getUser($withdraw->user_id)->created_at->format("F j, Y")}}<br>
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                            <!-- /.modal -->
                            <td>{{$withdraw->amount}}</td>
                            <td>{{$withdraw->updated_at->format("F j, Y g:i a")}}</td>
                            <td>{{getCarbonInstance($withdraw->mature_date)->format("F j, Y g:i a")}}</td>
                            <td style="color: #8F3739">
                                @if ($withdraw->paid)
                                    <span
                                    style="background:#00b33c;color: #FFF;padding: 3px 5px;border-radius:5px;">Paid</span>
                                @else
                                    <span
                                    style="background:#ff6666;color: #FFF;padding: 3px 5px;border-radius:5px;">Unpaid</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
                </table>


            </div>
            </div>
        </div>
        </div>
    </div>
  <!-- /. ROW  -->
@endsection