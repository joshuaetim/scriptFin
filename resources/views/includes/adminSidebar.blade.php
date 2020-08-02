<!-- Left Sidebar - style you can find in sidebar.scss  -->
    <!-- ============================================================== -->
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
                    <img src="../../assets/images/users/1.jpg" alt="users" class="rounded-circle" width="40" />
                  </div>
                  <div class="user-content hide-menu ml-2">
                    <a href="javascript:void(0)" class="" id="Userdd" role="button" data-toggle="dropdown"
                      aria-haspopup="true" aria-expanded="false">
                      <h5 class="mb-0 user-name font-medium">
                        {{auth('admin')->user()->fullname}} <i class="fa fa-angle-down"></i>
                      </h5>
                      <span class="op-5 user-email">{{auth('admin')->user()->email}}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="Userdd">
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
                <span class="hide-menu">Personal | Users</span>
              </li>
  
              <li class="sidebar-item" id="dashboard__menu">
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/admin')}}"
                  aria-expanded="false"><i class="fas fa-th"></i><span class="hide-menu">Dashboard</span></a>
              </li>
  
  
              <li class="sidebar-item"> <a class="sidebar-link has-arrow waves-effect waves-dark"
                  href="javascript:void(0)" aria-expanded="false"><i class="mdi mdi-account-multiple-plus"></i><span
                    class="hide-menu">Users</span></a>
                <ul aria-expanded="false" class="collapse  first-level">
                  
                  <li class="sidebar-item"><a href="{{url('/createUser')}}" class="sidebar-link"><i class="mdi mdi-account-plus">
                  </i><span class="hide-menu"> Create Special Users </span></a></li>

                  <li class="sidebar-item"><a href="{{url('/activeUsers')}}" class="sidebar-link"><i class="mdi mdi-call-merge">
                      </i><span class="hide-menu"> Active Users </span></a></li>

                  <li class="sidebar-item"><a href="{{url('/blockedUsers')}}" class="sidebar-link"><i
                        class="fas fa-ban"></i><span class="hide-menu"> Blocked Users</span></a></li>
  
                </ul>
              </li>
  
              <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/viewSupport')}}"
                  aria-expanded="false"><i class="mdi mdi-email-alert"></i><span class="hide-menu">Supports
                  </span></a>
              </li>
              <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/viewComplaints')}}"
                  aria-expanded="false"><i class="mdi mdi-email-alert"></i><span class="hide-menu">Complaints
                  </span></a>
              </li>
  
              <!-- User Payment Menu-->
              <li class="nav-small-cap">
                <i class="mdi mdi-dots-horizontal"></i>
                <span class="hide-menu">Payments | Merging</span>
              </li>

              <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/showInvestments')}}"
                  aria-expanded="false"><i class="fas fa-donate"></i><span
                  class="hide-menu">Investments</span></a></a>
              </li>
  
  
              <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/merged')}}" aria-expanded="false"><i
                    class="mdi mdi-cash-multiple"></i><span class="hide-menu">Merged Withdraws</span></a>
              </li>
  
              <li class="sidebar-item">
                <a class="sidebar-link waves-effect waves-dark sidebar-link" href="{{url('/manualMerge')}}"
                  aria-expanded="false"><i class="fas fa-people-carry"></i><span class="hide-menu">Manual
                    Merging</span></a>
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
      <!-- ============================================================== -->
      <!-- End Left Sidebar - style you can find in sidebar.scss  -->