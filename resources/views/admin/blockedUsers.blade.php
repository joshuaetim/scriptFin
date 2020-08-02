@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title"><a href="{{url('/admin')}}">Dashboard</a> / Blocked Users</h4>

                
                <div class="table-responsive">
                    <div id="message"></div>
                    <table id="lang_opt" class="table table-striped table-bordered display" style="width:100%">
                    <thead>
                        <tr>
                        <th style="font-weight: bold !important">User ID</th>
                        <th style="font-weight: bold !important">Full Name</th>
                        <th style="font-weight: bold !important">Email</th>
                        <th style="font-weight: bold !important">Phone</th>
                        <th style="font-weight: bold !important">Balance</th>
                        <th style="font-weight: bold !important">Registration Date</th>
                        <th style="font-weight: bold !important" class="pull-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr data-row-id="{{$user->id}}">
                                <td><a href="#" data-toggle="modal"
                                    data-target="#responsive-modalUser{{$user->id}}" title="click to view details">{{$user->userID}}</a></td>
                                  <!-- modal content for user info -->
                              <div id="responsive-modalUser{{$user->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                                aria-hidden="true" style="display: none;">
                                <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <h3>User Information</h3>
                                        <p style="font-size: 16px">
                                            @if ($user->special)
                                                <b>Special User</b><br>
                                            @endif
                                            Fullname: {{$user->name}}<br>
                                            Account Name: {{$user->account_name}}<br>
                                            Email: {{$user->email}} <br>
                                            Phone: {{$user->phone}} <br>
                                            Account Balance: {{$user->balance}}<br>
                                            Pending Payout: {{$user->pending_payout}}<br>
                                            Referral Balance: {{$user->referral_balance}}<br>
                                            Registration Date: {{$user->created_at->format("F j, Y")}}<br>
                                        </p>
                                    </div>
                                    <div class="modal-footer">
                                    <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>
        
                                            </div>
                                        </div>
                                        </div>
                                    </div>
                            <!-- /.modal -->
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->balance}}</td>
                                <td>{{$user->created_at->format("F j, Y g:i a")}}</td>
                                <td>
                                  <a class="remove-row pull-right" href="#" onclick="document.getElementById('block{{$user->id}}').submit()"><i
                                    class="fas fa-check" title="UnBlock User"></i></a>
                                    <a class="remove-row pull-right ml-3" href="#" title="Delete User" onclick="event.preventDefault(); document.getElementById('delete{{$user->id}}').submit();"><i
                                        class="fas fa-trash"></i></a>
                                        <form action="{{url('/unblockUser')}}" method="POST" id="block{{$user->id}}" style="display: none;">
                                          @csrf
                                          <input type="hidden" name="user_id" value="{{$user->id}}">
                                        </form>
                                        <form action="{{url('/deleteUser')}}" method="POST" id="delete{{$user->id}}" style="display: none;">
                                          @csrf
                                          <input type="hidden" name="user_id" value="{{$user->id}}">
                                        </form>
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
  <script>
    function subForm(id){
      event.preventDefault();
      alert('hey')
    }
  </script>
  {{-- <script>
      jQuery("#master").on("click", function (e) {
  if ($(this).is(":checked", true)) {
    $(".sub_chk").prop("checked", true);
  } else {
    $(".sub_chk").prop("checked", false);
  }
});

jQuery(".delete_all").on("click", function (e) {
  var allVals = [];
  $(".sub_chk:checked").each(function () {
    allVals.push($(this).attr("data-id"));
  });
  //alert(allVals.length); return false;
  if (allVals.length <= 0) {
    alert("Please select row.");
  } else {
    //$("#loading").show();
    WRN_PROFILE_DELETE = "Are you sure you want to delete this row?";
    var check = confirm(WRN_PROFILE_DELETE);
    if (check == true) {
      $.each(allVals, function (index, value) {
        $("table tr")
          .filter("[data-row-id='" + value + "']")
          .remove();
      });
      $.ajax({
        type: "POST",
        url: "/deleteUsers",
        data: {
            '_token' : "{{ csrf_token() }}"
        },
        success: function(response)
        {
          $("#message").text(response);
        }
      });
    }
  }
});

jQuery(".remove-row").on("click", function (e) {
  WRN_PROFILE_DELETE = "Are you sure you want to delete this row?";
  var check = confirm(WRN_PROFILE_DELETE);
  if (check == true) {
    $("table tr")
      .filter("[data-row-id='" + $(this).attr("data-id") + "']")
      .remove();
  }
});

  </script> --}}
@endsection