@extends('layouts.admin')

@section('content')

    @include('components.adminOverview')
          <div class="row">
            <!-- column -->
            @include('components.activationRequests')
            <!-- column -->
            @include('components.topReferrals')
          </div>
@endsection