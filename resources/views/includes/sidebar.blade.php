<aside class="left-sidebar">
    <!-- Sidebar scroll-->
    <div class="scroll-sidebar">
      <!-- Sidebar navigation-->
      <nav class="sidebar-nav">
        <ul id="sidebarnav">
          <!-- User Profile-->
          <li>
            <!-- User Profile-->
            <div class="user-profile d-flex no-block dropdown mt-3">
              <div class="user-pic">
                <img src="{{url('assets/images/users/1.jpg')}}" alt="users" class="rounded-circle" width="40" />
              </div>
              <div class="user-content hide-menu ml-2">
                <a href="javascript:void(0)" class="" id="Userdd" role="button" data-toggle="dropdown"
                  aria-haspopup="true" aria-expanded="false">
                  <h5 class="mb-0 user-name font-medium">
                    {{auth()->user()->name}} <i class="fa fa-angle-down"></i>
                  </h5>
                  <span class="op-5 user-email">{{auth()->user()->email}}</span>
                </a>
                <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Userdd">
                  <a class="dropdown-item" href="{{url('/profile')}}"><i class="ti-user mr-1 ml-1"></i> My Profile</a>
                  <div class="dropdown-divider"></div>
                  <a class="dropdown-item" href="javascript:void(0)" onclick="event.preventDefault();
                  document.getElementById('logout-form').submit();"><i class="fa fa-power-off mr-1 ml-1"></i>
                    Logout</a>
                </div>
              </div>
            </div>
            <!-- End User Profile-->
          </li>

          <!-- User Profile-->
          <li class="nav-small-cap">
            <i class="mdi mdi-dots-horizontal"></i>
            <span class="hide-menu">Personal</span>
          </li>

          <li class="sidebar-item" id="dashboard__menu">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/home')}}"
              aria-expanded="false"><i class="mdi mdi-view-dashboard"></i><span class="hide-menu">Dashboard</span></a>
          </li>

          <li class="sidebar-item" id="profile__menu">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/profile')}}"
              aria-expanded="false"><i class="mdi mdi-account-convert"></i><span class="hide-menu">Profile</span></a>
          </li>

          <li class="sidebar-item" id="referral__menu">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/referral')}}"
              aria-expanded="false"><i class="mdi mdi-account-multiple-plus"></i><span
                class="hide-menu">Referral</span></a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/support')}}"
              aria-expanded="false"><i class="mdi mdi-comment-text"></i><span class="hide-menu">Support
                Tickets</span></a>
          </li>

          <!-- User Payment Menu-->
          <li class="nav-small-cap">
            <i class="mdi mdi-dots-horizontal"></i>
            <span class="hide-menu">Payments</span>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/withdraw_show') }}"
              aria-expanded="false"><i class="fas fa-hand-holding-usd"></i><span class="hide-menu">Withdraw</span></a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{ url('/newInvestment') }}"
              aria-expanded="false"><i class="fas fa-hands-helping"></i><span class="hide-menu">Make Investment</span></a>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/complain')}}"
              aria-expanded="false"><i class="mdi mdi-comment-text"></i><span class="hide-menu">Complaints</span></a>
          </li>

          <li class="nav-small-cap">
            <i class="mdi mdi-dots-horizontal"></i>
            <span class="hide-menu">Logout Account</span>
          </li>

          <li class="sidebar-item">
            <a class="sidebar-link waves-effect waves-dark sidebar-link" href="javascript:void(0)" onclick="event.preventDefault();
            document.getElementById('logout-form').submit();"
              aria-expanded="false"><i class="fa fa-power-off"></i><span class="hide-menu">Logout</span></a>
          </li>
        </ul>
      </nav>
      <!-- End Sidebar navigation -->
    </div>
    <!-- End Sidebar scroll-->
  </aside>