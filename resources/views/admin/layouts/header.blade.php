<!-- start: header -->
<header class="header">
    <div class="logo-container">
        <a href="/" class="logo">
            {{-- <img src="assets/img/logo.png" width="75" height="35" alt="Porto Admin" /> --}}
            <h4 class="font-weight-bolder text-dark">ADMIN DASHBOARD </h4>
        </a>
        <div class="d-md-none toggle-sidebar-left" data-toggle-class="sidebar-left-opened" data-target="html"
            data-fire-event="sidebar-left-opened">
            <i class="fas fa-bars" aria-label="Toggle sidebar"></i>
        </div>
    </div>

    <!-- start: search & user box -->
    <div class="header-right">



        <span class="separator"></span>

        <ul class="notifications">

            <li>
                <a href="#" class="dropdown-toggle notification-icon" data-toggle="dropdown">
                    <i class="fas fa-bell"></i>
                    <span class="badge count-notif">0</span>
                </a>
                <form id="link-extra-info">
                    <input type="hidden" name="id" value="0">
                </form>
                <div class="dropdown-menu notification-menu">
                    <div class="notification-title">
                        <span class="float-right badge badge-default">0</span>
                        Alerts
                    </div>

                    <div class="content">
                        <ul class="sub-notif">
                        
                        
                         
                          
                        </ul>

                        <hr />

                        <div class="text-right readall">
                            
                        </div>
                    </div>
                </div>
            </li>
        </ul>

        <span class="separator"></span>

        <div id="userbox" class="userbox">
            <a href="#" data-toggle="dropdown">
                <figure class="profile-picture">
                    <!-- <img src="{{Auth::guard('admin')->user()->image}}" alt="Joseph Doe" class="rounded-circle" -->
                        <!-- data-lock-picture="/assets/img/!logged-user.jpg" /> -->
                </figure>
                <div class="profile-info" data-lock-name="John Doe" data-lock-email="johndoe@okler.com">
                    <span class="name">{{$admin->name}}</span>
                    <span class="role">{{$admin->role}}</span>
                </div>

                <i class="fa custom-caret"></i>
            </a>

            <div class="dropdown-menu">
                <ul class="list-unstyled mb-2">
                    <li class="divider"></li>
                    <li>
                        <a role="menuitem" tabindex="-1" href="{{Route('admin.profile')}}"><i class="fas fa-user"></i> My
                            Profile</a>
                    </li>
                  
                    <li>
                        <a role="menuitem" tabindex="-1" href="/admin/logout"><i class="fas fa-power-off"></i>
                            Logout</a>
                    </li>
                </ul>
            </div>
        </div>
    </div>
    <!-- end: search & user box -->
</header>
<!-- end: header -->