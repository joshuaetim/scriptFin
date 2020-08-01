@extends('layouts.dashboard')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="card">
                <form class="form-horizontal r-separator" method="post" action="{{ route('addSupport') }}">
                    @csrf
                <div class="card-body">
                    <h4 class="card-title">Support Ticket</h4>
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    <div class="form-group row p-b-15">
                    <label for="subject" class="col-sm-3 text-right control-label col-form-label">Subject</label>
                    <div class="col-sm-9">
                        <input type="text" name="title" class="form-control" id="subject" placeholder="Subject" required />
                    </div>
                    </div>
                    <div class="form-group row p-b-15">
                    <label for="message" class="col-sm-3 text-right control-label col-form-label">Message</label>
                    <div class="col-sm-9">
                        <textarea class="form-control" name="description" id="message" placeholder="Message" style="height: 8rem;"
                        required></textarea>
                    </div>
                    </div>

                    <button type="submit" class="btn btn-lg btn-block btn-outline-primary"
                    style="width: 60%; margin-left: auto;">Submit Ticket</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
        <div class="card">
            <div class="card-body">
            <h4 class="card-title">All Tickets</h4>

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
                            <p>{{ $ticket->description }}</p>
                            @if ($ticket->response)
                                <h3>Admin Reply</h3>
                                <p>{{ $ticket->response }}</p>
                            @endif
                            </div>
                            <div class="modal-footer">
                            <button type="button" class="btn btn-default waves-effect" data-dismiss="modal">Close</button>

                                    </div>
                                </div>
                                </div>
                            </div>
                            <!-- /.modal -->
                    @endforeach
                @else
                    <p>You don't have any support tickets</p>
                @endif
                </tbody>

                </table>
            </div>
            </div>
        </div>
        </div>
    </div>
@endsection