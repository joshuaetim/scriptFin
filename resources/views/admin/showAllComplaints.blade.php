@extends('layouts.admin')

@section('content')
    <div class="row">
        <div class="col-12">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title"><a href="{{url('/admin')}}">Dashboard</a> / Complain Tickets</h4>

            <div class="table-responsive">
                <table id="lang_opt" class="table table-striped table-bordered display" style="width:100%">
                <thead>
                    <tr>
                    <th>Date</th>
                    <th>Subject</th>
                    <th>Status</th>
                    <th>Panel</th>
                    </tr>
                </thead>
                <tbody>
                
                @if ($tickets)
                    @foreach ($tickets as $ticket)
                        <tr>
                            <td>{{$ticket->created_at->format("F j, Y, g:i a")}}</td>
                            <td>{{$ticket->title}}</td>
                            @if ($ticket->resolved)
                                <td class="bg-success text-white"><strong>Resolved</strong></td>
                            @else
                                <td class="bg-danger text-white"><strong>Unresolved</strong></td>
                            @endif    
                            </strong></td>
                            <td> <button type="button" class="btn btn-default waves-effect" data-toggle="modal"
                                data-target="#responsive-modal{{$ticket->id}}">View Message</button></td>
                        </tr>
                         <!-- sample modal content -->
                        <div id="responsive-modal{{$ticket->id}}" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
                        aria-hidden="true" style="display: none;">
                        <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-body">
                            <h3>Message</h3>
                            <p>
                                <a href="{{ asset('storage/images/'.$ticket->attachment) }}" target="_blank">
                                    <img src="{{ asset('storage/images/'.$ticket->attachment) }}" alt="Attachment" style="width: 300px; height: auto">
                                </a>
                            </p>
                            <p>{{ $ticket->description }}</p>
                            @if ($ticket->response)
                                <h3>Admin Reply</h3>
                                <p>{{ $ticket->response }}</p>
                            @else
                                <div id="replyMessage{{$ticket->id}}"></div>
                                <form action="{{ url('replyComplain') }}" id="replyForm{{$ticket->id}}" method="POST">
                                    @csrf
                                    <div id="formID{{$ticket->id}}">
                                        <input type="hidden" name="complain" value="{{$ticket->id}}">
                                        <div class="form-group">
                                            <label for="message-text" class="control-label">Send a Reply:</label>
                                            <textarea class="form-control" name="response" id="message-text{{$ticket->id}}"></textarea>
                                            </div>
                                            <button type="submit" class="btn btn-default" id="reply{{$ticket->id}}">Post</button>
                                    </div>
                                </form>
                            @endif
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>

                                    </div>
                                </div>
                                </div>
                                <script>
                                    jQuery("#reply{{$ticket->id}}").on('click', function(){
                                        event.preventDefault()
                                        $("#formID{{$ticket->id}}").fadeOut(1000, function(){
                                            $("#replyForm{{$ticket->id}}").submit()
                                        });
                                        var message = $("#message-text{{$ticket->id}}").val()
                                        var post = "<h4> Admin Reply </h4> " + message
                                        // alert(message)
                                        $("#replyMessage{{$ticket->id}}").html(post)
                                    })
                                </script>
                            </div>
                            <!-- /.modal -->
                    @endforeach
                @else
                    <p>You don't have any complain tickets</p>
                @endif
                </tbody>

                </table>
            </div>
            </div>
        </div>
        </div>
    </div>
@endsection