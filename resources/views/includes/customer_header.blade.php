<div class="page-header">
    <div class="header-wrapper row m-0">
        <div class="header-logo-wrapper col-auto p-0">
            <div class="logo-wrapper">
                <a href="{{URL('/customer/dashboard')}}">
                    <img class="img-fluid main-logo" src="{{URL::asset('public/admin/assets/images/logo.png')}}" alt="logo">
                    <img class="img-fluid white-logo" src="{{URL::asset('public/admin/assets/images/logo-white.png')}}" alt="logo">
                </a>
            </div>
            <div class="toggle-sidebar">
                <i class="status_toggle middle sidebar-toggle" data-feather="align-center"></i>
            </div>
        </div>
        <div class="nav-right col-4 pull-right right-header p-0">
            <ul class="nav-menus">    
                <li> <span class="header-search"><i data-feather="search"></i></span></li>
                <li class="onhover-dropdown">
                    <div class="notification-box"><i class="fa fa-bell-o"> </i><span class="badge rounded-pill badge-theme"> </span></div>
                    <ul class="notification-dropdown onhover-show-div">
                        <li><i data-feather="bell"></i>
                            <h6 class="f-18 mb-0">Notitications</h6>
                        </li>
                        <!-- <li>
                            <p><i class="fa fa-circle-o me-3 font-primary"> </i>Delivery processing <span class="pull-right">10 min.</span></p>
                        </li>
                        <li>
                            <p>
                                <i class="fa fa-circle-o me-3 font-success"></i>Order Complete<span class="pull-right">1 hr</span>
                            </p>
                        </li>
                        <li>
                            <p><i class="fa fa-circle-o me-3 font-info"></i>Tickets Generated<span class="pull-right">3 hr</span>
                            </p>
                        </li>
                        <li>
                            <p><i class="fa fa-circle-o me-3 font-danger"></i>Delivery Complete<span class="pull-right">6 hr</span></p>
                        </li>
                        <li><a class="btn btn-primary" href="#">Check all notification</a></li> -->
                    </ul>
                </li>
                <li class="maximize">
                    <a class="text-dark" href="#!" onclick="javascript:toggleFullScreen()"><i data-feather="maximize"></i></a>
                </li>
                <li class="profile-nav onhover-dropdown pe-0 me-0">
                    <div class="media profile-media">
                        <img class="user-profile rounded-circle" src="{{URL::asset('public/admin/assets/images/image2.png')}}" alt="profile-picture">
                        <div class="user-name-hide media-body"><span>{{auth()->user()->fname.' '.auth()->user()->lname}}</span>
                            <p class="mb-0 font-roboto">Admin <i class="middle fa fa-angle-down"></i></p>
                        </div>
                    </div>
                    <ul class="profile-dropdown onhover-show-div">
                        <li><a href="{{ url('customer/profile') }}"><i data-feather="user"></i><span>Account </span></a></li>
                        <li><a href="{{ url('customer/logout') }}"><i data-feather="log-out"> </i><span>Logout</span></a></li>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
</div>