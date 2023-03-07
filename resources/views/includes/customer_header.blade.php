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
                <!-- <li> <span class="header-search"><i data-feather="search"></i></span></li> -->
                <li class="maximize">
                    <a class="text-dark" href="{{url('/customer/help')}}"><i data-feather="help-circle"></i></a>
                </li>
                <li class="onhover-dropdown">
                    <div class="notification-box"><i class="fa fa-bell-o"> </i><span class="badge rounded-pill badge-theme"> </span></div>
                    <ul class="notification-dropdown onhover-show-div">
                        @php 
							use App\Models\UsrNotification;

							$newnotification = 0;
							$notifications = UsrNotification::where('role_id',6)->where('notify_to',auth()->user()->id)->limit(5)->orderby('id','desc')->get();							
					    @endphp
                        <li><i data-feather="bell"></i>
                            <h6 class="f-18 mb-0">Notitications</h6>
                        </li>
                        @if($notifications && count($notifications)>0)
                            @foreach($notifications as $notify)
                                <li>
                                    <a href="{{url($notify->ref_link)}}">
                                        <p>{{$notify->title}} <span class="pull-right">{{date('d/m/Y',strtotime($notify->created_at))}}.</span></p>
                                    </a>
                                </li>
                            @endforeach
                        @endif
                        <li><a class="btn btn-primary" href="{{url('/customer/notifications')}}">Check all notification</a></li>
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