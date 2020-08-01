@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-body">
                <h4 class="card-title"><a href="{{url('/admin')}}">Dashboard</a> / Active Users</h4>

                <div class="row well">
                    <a type="button" class="btn btn-primary pull-right delete_all"
                    style="color: #fff; margin-bottom: 10px;">Delete
                    Selected Users</a>
                    <span style="display:block; width: calc(1rem + 1vw);">&nbsp;</span>
                    <a type="button" class="btn btn-primary pull-right"
                    style="color: #fff; display: inline-block; margin-bottom: 10px;">Block
                    Selected Users</a>
                </div></br>
                <div class="table-responsive">
                    <div id="message"></div>
                    <table id="lang_opt" class="table table-striped table-bordered display" style="width:100%">
                    <thead>
                        <tr>
                        <th><input type="checkbox" id="master"></th>
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
                                <td><input type="checkbox" class="sub_chk" data-id="1"></td>
                                <td>{{$user->userID}}</td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>{{$user->phone}}</td>
                                <td>{{$user->balance}}</td>
                                <td>{{$user->created_at->format("F j, Y g:i a")}}</td>
                                <td><a class="remove-row pull-right" targetDiv="" data-id="1" href="javascript: void(0)"><i
                                        class="fas fa-trash"></i></a></td>
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

  </script>
@endsection