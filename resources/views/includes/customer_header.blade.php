<style type="text/css">
	.n_count{
        display: block;
        position: absolute;
        top: -5px;
        right: 0px;
        left: 15px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #FED204;
        cursor: pointer;
        color: #000;
        font-size: 12px;
	}
</style>
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
                    @php 
                        use App\Models\UsrNotification;
                        use App\Models\Admin;
                        use App\Models\customer\CustomerMaster;

                        $newnotification = 0;
                        $cust_email = Admin::where('id',auth()->user()->id)->first()->email;
                        $cust_id = CustomerMaster::where('username',$cust_email)->first()->id;
                        $notifications = UsrNotification::where('role_id',6)->where('notify_to',$cust_id)->limit(5)->orderby('id','desc')->get();
                        $n_count = UsrNotification::where('role_id',6)->where('notify_to',auth()->user()->id)->where('viewed',0)->count(); 							
                    @endphp
                    <!-- <div class="notification-box"><i class="fa fa-bell-o"> </i><span class="badge rounded-pill badge-theme"> </span></div> -->
                    <div class="notification-box">
                        <i class="fa fa-bell-o"> </i>
                        @if($notifications)<span class="n_count">{{ $n_count }}</span>@endif
                    </div>
                    <ul class="notification-dropdown onhover-show-div marknotifications">
                        
                        <li><i data-feather="bell"></i>
                            <h6 class="f-18 mb-0">Notitications</h6>
                        </li>
                        @if($notifications && count($notifications)>0)
                            @foreach($notifications as $notify)
                                <li>
                                    <a href="{{url($notify->ref_link)}}" data-id="{{ $notify->id }}">
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