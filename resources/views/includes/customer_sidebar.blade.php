@php 
    $sidebar = sidebarMenu();
@endphp
<div class="sidebar-wrapper">
    <div>
        <div class="logo-wrapper">
            <span class="back">Back</span>
            <div class="back-btn"><i class="fa fa-angle-left"></i></div>
            <div class="toggle-sidebar"><i class="status_toggle middle sidebar-toggle" data-feather="grid">
                </i></div>
        </div>
        <div class="logo-icon-wrapper"><a href="{{URL('/customer/dashboard')}}"><img class="img-fluid"
                    src="img/logo-icon.png" alt=""></a></div>
        <nav class="sidebar-main">
            <div class="left-arrow" id="left-arrow"><i data-feather="arrow-left"></i></div>
            <div id="sidebar-menu">
                <ul class="sidebar-links" id="simple-bar">
                    <li class="back-btn"><a href="{{URL('/customer/dashboard')}}"><img class="img-fluid"
                                src="img/logo-icon.png" alt=""></a>
                        <div class="mobile-back text-end"><span>Back</span><i class="fa fa-angle-right ps-2"
                                aria-hidden="true"></i></div>
                    </li>
                    @foreach($sidebar as $row)
			            @php  $pt = $row['parent'];  $child = $row['child']; @endphp 
			            @if($pt['is_active'] !=1) @php $pr_class="pr_hide"; @endphp  @else @php $pr_class=""; @endphp  @endif

                        @if(auth()->user()->role_id == 6)
                            <li class="sidebar-list">
                                <a @if($pt['id'] == 1) class="sidebar-link sidebar-title link-nav" @else class="sidebar-link sidebar-title active" @endif @if($child && count($child) > 0) @endif @if($pt['link'] == '#') href="#" @else href="{{url('/customer')}}{{ $pt['link'] }}" @endif>
                                    @if($pt['menu_icon'] !="")
                                        @if($pt['id'] == 1)
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-home"><path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path><polyline points="9 22 9 12 15 12 15 22"></polyline></svg>
                                        @else
                                            <?php echo $pt['menu_icon'];?>
                                        @endif
                                    @else
                                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
                                    @endif
                                    <span class="side-menu__label">{{$pt['module_name']}}</span>
                                    @if($child && count($child) > 0) 
                                        <!-- <i class="angle fa fa-angle-right"></i> -->
                                        </a>
                                        <ul class="sidebar-submenu customer">
                                            @foreach($child as $ch) 
                                                @if($ch['is_active'] !=1)  @php $ch_class="ch_hide"; @endphp @else  @php $ch_class=""; @endphp @endif
                                                <?php $menu_link = $ch['link']; ?>
                                                <li class='<?php echo activeMenu(url("$menu_link")); ?> {{ $ch_class }}'><a href="{{url('/customer')}}{{$menu_link}}" class="slide-item">{{$ch['module_name']}}</a></li>
                                            @endforeach
                                        </ul>
                                    @else
                                        </a>
                                    @endif
                            </li>
                        @endif

                        <!-- <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
                                href="{{URL('/customer/dashboard')}}"><i data-feather="home"> </i><span>Dashboard</span></a>
                        </li>

                        <li class="sidebar-list"><a class="sidebar-link sidebar-title active" href="#"><i
                                    data-feather="map"></i><span>Services</span></a>
                            <ul class="sidebar-submenu customer" style="display: block;">
                                <li><a href="{{URL('/customer/hydrographic_survey')}}">Hydrographic Survey</a></li>
                                <li><a href="{{URL('/customer/tidal_observation')}}">Tidal observation</a></li>
                                <li><a href="{{URL('/customer/bottomsample')}}">Bottom sample collection</a></li>
                                <li><a href="{{URL('/customer/dredging_survey')}}">Dredging Survey</a></li>
                                <li><a href="{{URL('/customer/hydrographic_data')}}">Hydrographic data/charts</a></li>
                                <li><a href="{{URL('/customer/underwater_videography')}}">Underwater videography</a></li>
                                <li><a href="{{URL('/customer/currentmeter_observation')}}">Current meter observations</a></li>
                                <li><a href="{{URL('/customer/sidescanningsonar_survey')}}">Side scan sonar observation</a></li>
                                <li><a href="{{URL('/customer/topographic_survey')}}">Topographic survey</a></li>
                                <li><a href="{{URL('/customer/subbottom_profilling')}}">Sub Bottom Profiling</a></li>
                                <li><a href="{{URL('/customer/bathymetry_survey')}}">Bathymetry Survey</a></li>
                            </ul>
                        </li>

                        <li class="sidebar-list">
                            <a class="linear-icon-link sidebar-link sidebar-title" href="#"><i
                                    data-feather="briefcase"></i><span>My Requests</span>
                            </a>
                            <ul class="sidebar-submenu customer">
                                <li><a href="{{URL('/customer/requested_services')}}">Requested Services</a></li>
                            </ul>
                        </li> -->
                    @endforeach
                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
@php
	function activeMenu($uri = '')
	{
		$active = '';

		$cur_url = url()->current();

		if($cur_url ==$uri)
		{
    		$active = 'active';
		}

		return $active;
		return $active;
	}
@endphp