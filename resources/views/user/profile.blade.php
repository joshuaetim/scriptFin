@extends('layouts.dashboard')

@section('content')
            <!-- ============================================================== -->
            <!-- Start Page Content -->
            <!-- ============================================================== -->
            <!-- Row -->
            <div class="row">
              <div class="col-12">
                <div class="card">
                  <form class="form-horizontal r-separator" id="personal" action="{{route('update')}}" method="post">
                    @csrf
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger">
                                {{ $error }}
                            </div>
                        @endforeach
                    @endif
                    <div class="card-body">
                      <h4 class="card-title">Personal Info</h4>

                      <div class="form-group row p-b-15">
                        <label for="firstname" class="col-sm-3 text-right control-label col-form-label">Full Name</label>
                        <div class="col-sm-9">
                          <input type="text" name="name" class="form-control" id="firstname" placeholder="Full Name Here" value="{{$user->name}}" required />
                          <span> <i class="fa fa-check complete" aria-hidden="true"></i></span>
    
                          <small id="alert-firstname" class="personalAlert"></small>
                        </div>
                      </div>

                      <div class="form-group row p-b-15">
                        <label for="inputemail" class="col-sm-3 text-right control-label col-form-label">Email</label>
                        <div class="col-sm-9">
                          <input type="email" name="email" class="form-control" id="inputemail" placeholder="Email Here" value="{{$user->email}}" required />
                          <span> <i class="fa fa-check complete" aria-hidden="true"></i></span>
    
                          <small id="alert-email" class="personalAlert"></small>
                        </div>
                      </div>

                      <div class="form-group row p-b-15">
                        <label for="inputphone" class="col-sm-3 text-right control-label col-form-label">Mobile No</label>
                        <div class="col-sm-9">
                          <input type="text" name="phone" value="{{$user->phone}}" class="form-control" id="inputphone" placeholder="+234" maxlength="15"
                            required />
                          <span> <i class="fa fa-check complete" aria-hidden="true"></i></span>
    
                          <small id="alert-inputphone" class="personalAlert"></small>
                        </div>
                      </div>
                      <h4 class="card-title">Account Info</h4>
                        <div class="row">
                          <div class="col-sm-12 col-lg-6">
                            <div class="form-group row">
                              <label for="accountName" class="col-sm-3 text-right control-label col-form-label">Account
                                Name</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" id="accountName" placeholder="Account Name Here" value="{{$user->account_name}}" name="account_name"
                                  required />
                              </div>
                            </div>
                          </div>
                          <div class="col-sm-12 col-lg-6">
                            <div class="form-group row">
                              <label for="inputaccount" class="col-sm-3 text-right control-label col-form-label">Account
                                Number</label>
                              <div class="col-sm-9">
                                <input type="number" class="form-control" name="account_number" id="inputaccount"
                                  placeholder="Account Number Here" maxlength="10" value="{{$user->account_number}}" required />
                                <small id="alert-inputaccount" class="personalAlert"></small>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="row">
                          <div class="col-sm-12 col-lg-6">
                            <div class="form-group row p-t-15">
                              <label for="inputEmail3" class="col-sm-3 text-right control-label col-form-label">Bank
                                Name</label>
                              <div class="col-sm-9">
                                <input type="text" class="form-control" name="bank_name" id="accountName" value="{{$user->bank_name}}" placeholder="Bank Name Here"
                                required />
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="form-group m-b-0 text-right">
                          <button type="submit" id="account__submit" class="btn btn-info waves-effect waves-light btn-large">
                            Update Information
                          </button>
                        </div>
                      </div>
                  </form>
    
    
                </div>
             
              </div>
            </div>
         
@endsection