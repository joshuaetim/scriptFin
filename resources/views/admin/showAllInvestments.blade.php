@extends('layouts.admin')

@section('content')
<div class="row">
    <div class="col-12">
      <div class="card">
        <div class="card-body">
            <h4 class="card-title"><a href="{{url('/admin')}}">Dashboard</a> / All Investments</h4>

          
          <div class="table-responsive">
            <table id="lang_opt" class="table table-striped table-bordered display" style="width:100%">
              <thead>
                <tr>
                  <th>Investment ID</th>
                  <th>User ID</th>
                  <th>Amount</th>
                  <th>Yield</th>
                  <th>Mature Date</th>
                  <th>Date Created</th>
                  <th>Status</th>
                </tr>
              </thead>
              <tbody style="font-size: 12px; font-weight: 200;">
                @foreach ($investments as $investment)
                    <tr data-row-id="1">
                        <td>{{$investment->uniqueID}}</td>
                        <td><a href="#" data-toggle="modal"
                            data-target="#responsive-modalUser{{$investment->id}}" title="click to view details">{{getUser($investment->user_id)->userID}}</a></td>

                        <!-- modal content for user info -->
                        <div id="responsive-modalUser{{$investment->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                            aria-hidden="true" style="display: none;">
                            <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-body">
                                    <h3>User Information</h3>
                                    <p style="font-size: 16px">
                                      @if (getUser($investment->user_id)->special)
                                                <b>Special User</b><br>
                                      @endif
                                        Fullname: {{getUser($investment->user_id)->name}}<br>
                                        Account Name: {{getUser($investment->user_id)->account_name}}<br>
                                        Account Balance: {{getUser($investment->user_id)->balance}}<br>
                                        Email: {{getUser($investment->user_id)->email}} <br>
                                        Phone: {{getUser($investment->user_id)->phone}} <br>
                                        Registration Date: {{getUser($investment->user_id)->created_at->format("F j, Y")}}<br>
                                    </p>
                                </div>
                                <div class="modal-footer">
                                <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
    
                                        </div>
                                    </div>
                                    </div>
                                </div>
                        <!-- /.modal -->

                        <td>{{$investment->amount_offered}}</td>
                        <td>{{$investment->yield}}</td>
                        <td>{{getCarbonInstance($investment->mature_date)->format("F j, Y g:i a")}}</td>
                        <td>{{$investment->created_at->format("F j, Y g:i a")}}</td>
                        @if ($investment->paid_complete)
                            <td style="color: #8F3739"><span
                                style="background:#00b33c;color: #FFF;padding: 3px 5px;border-radius:5px;">Completed</span>
                            </td>
                        @elseif(getUser($investment->user_id)->matched)
                            <td style="color: #8F3739"><span
                                style="background:#999900;color: #FFF;padding: 3px 5px;border-radius:5px;"><a style="color: #FFF;" href="#" title="click to view details">In Progress</a></span>
                            </td>
                        @else
                            <td style="color: #8F3739"><span
                                style="background:#ff6666;color: #FFF;padding: 3px 5px;border-radius:5px;">Not matched</span>
                            </td>
                        @endif
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