				<aside class="app-sidebar">
					<div class="app-sidebar__logo">
						<a class="header-brand" href="#">
							<img src="{{URL::asset('assets/images/brand/logo2.png')}}" class="header-brand-img desktop-lgo" alt="Admintro logo">
							<img src="{{URL::asset('assets/images/brand/logo2.png')}}" class="header-brand-img dark-logo" alt="Admintro logo">
							<img src="{{URL::asset('assets/images/brand/favicon.png')}}" class="header-brand-img mobile-logo" alt="Admintro logo">
							<img src="{{URL::asset('assets/images/brand/favicon1.png')}}" class="header-brand-img darkmobile-logo" alt="Admintro logo">
						</a>
					</div>
					<div class="app-sidebar__user">
						<div class="dropdown user-pro-body text-center">
							<div class="user-pic">
								<img src="{{URL('public/admin/assets/images/image2.png')}}" alt="user-img" class="avatar-xl rounded-circle mb-1">
							</div>
							<div class="user-info">
								<h5 class=" mb-1">{{auth()->user()->fname.' '.auth()->user()->lname}} <i class="ion-checkmark-circled  text-success fs-12"></i></h5>
								<span class="text-muted app-sidebar__user-name text-sm">Admin</span>
							</div>
						</div>
					</div>
					<ul class="side-menu app-sidebar3">

						<li class="slide">
							<a class="side-menu__item" href="{{url('/admin/dashboard')}}">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0V0z" fill="none" />
									<path d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z" />
								</svg>
								<span class="side-menu__label">Dashboard</span></a>
						</li>

						<li class="slide">
							<a class="side-menu__item" href="{{url('/admin/customers')}}">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0V0z" fill="none" />
									<path d="M12 2C8.13 2 5 5.13 5 9c0 5.25 7 13 7 13s7-7.75 7-13c0-3.87-3.13-7-7-7zM7 9c0-2.76 2.24-5 5-5s5 2.24 5 5c0 2.88-2.88 7.19-5 9.88C9.92 16.21 7 11.85 7 9z" />
									<circle cx="12" cy="9" r="2.5" />
								</svg>
								<span class="side-menu__label">Customers</span></a>
						</li>

						<li class="slide">
							<a class="side-menu__item" data-toggle="slide" href="{{ url('/' . $page='#')}}">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0V0z" fill="none" />
									<path d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z" />
								</svg>
								<span class="side-menu__label">Services And Requests</span><i class="angle fa fa-angle-right"></i></a>
							<ul class="slide-menu ">
								<li><a href="{{url('/admin/new_service_requests')}}" class="slide-item">New Service Request</a></li>
								<li><a href="{{url('/admin/requested_services')}}" class="slide-item">Requested Services</a></li>
							</ul>
						</li>

						<li class="slide">
							<a class="side-menu__item" href="{{url('#')}}">
								<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24">
									<path d="M0 0h24v24H0V0z" fill="none" />
									<path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V5h14v14zM7 10h2v7H7zm4-3h2v10h-2zm4 6h2v4h-2z" />
								</svg>
								<span class="side-menu__label">Support Management</span></a>
						</li>

					</ul>
				</aside>
				<!--aside closed-->