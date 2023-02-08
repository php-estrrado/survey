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

                    <li class="sidebar-list"><a class="sidebar-link sidebar-title link-nav"
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
                        </ul>
                    </li>

                    <li class="sidebar-list">
                        <a class="linear-icon-link sidebar-link sidebar-title" href="#"><i
                                data-feather="briefcase"></i><span>My Requests</span>
                        </a>
                        <ul class="sidebar-submenu customer">
                            <li><a href="{{URL('/customer/requested_services')}}">Requested Services</a></li>
                        </ul>
                    </li>

                </ul>
            </div>
            <div class="right-arrow" id="right-arrow"><i data-feather="arrow-right"></i></div>
        </nav>
    </div>
</div>
