@php 
    $sidebar = sidebarMenu();
@endphp
<aside class="app-sidebar">
	<div class="app-sidebar__logo">
		@if(auth()->user()->role_id == 1)
			<a class="header-brand" href="{{url('/superadmin/dashboard')}}">
		@elseif(auth()->user()->role_id == 2 || auth()->user()->role_id == 7)
			<a class="header-brand" href="{{url('/admin/dashboard')}}">
		@elseif(auth()->user()->role_id == 3)
			<a class="header-brand" href="{{url('/surveyor/dashboard')}}">
		@elseif(auth()->user()->role_id == 4)
			<a class="header-brand" href="{{url('/draftsman/dashboard')}}">
		@elseif(auth()->user()->role_id == 5)
			<a class="header-brand" href="{{url('/accountant/dashboard')}}">
		@elseif(auth()->user()->role_id == 6)
			<a class="header-brand" href="{{url('/customer/dashboard')}}">
		@endif
			<img src="{{URL('admin/assets/images/logo.png')}}" class="header-brand-img desktop-lgo" alt="Jalanetra logo">
			<img src="{{URL('admin/assets/images/logo.png')}}" class="header-brand-img dark-logo" alt="Jalanetra logo">
			<!-- <img src="{{URL::asset('assets/images/brand/favicon.png')}}" class="header-brand-img mobile-logo" alt="Jalanetra logo">
			<img src="{{URL::asset('assets/images/brand/favicon1.png')}}" class="header-brand-img darkmobile-logo" alt="Jalanetra logo"> -->
		</a>
	</div>
	<div class="app-sidebar__user">
		<div class="dropdown user-pro-body text-center">
			<div class="user-pic">
				@php
					use App\Models\Admin;
					$avatar = Admin::where('id',auth()->user()->id)->first()->avatar;
				@endphp
				@if(isset($avatar) && !empty($avatar))
					<img src="{{$avatar}}" alt="user-img" class="avatar-xl rounded-circle mb-1">
				@else
					<img src="{{URL('public/admin/assets/images/image2.png')}}" alt="user-img" class="avatar-xl rounded-circle mb-1">
				@endif
				
			</div>
			<div class="user-info">
				<h5 class=" mb-1">{{auth()->user()->fname.' '.auth()->user()->lname}}</h5>
				@if(auth()->user()->role_id == 1)
					<span class="text-muted app-sidebar__user-name text-sm">Super Admin</span>
				@elseif(auth()->user()->role_id == 2 || auth()->user()->role_id == 7)
					<span class="text-muted app-sidebar__user-name text-sm">Admin</span>
				@elseif(auth()->user()->role_id == 3)
					<span class="text-muted app-sidebar__user-name text-sm">Surveyor</span>
				@elseif(auth()->user()->role_id == 4)
					<span class="text-muted app-sidebar__user-name text-sm">Draftsman</span>
				@elseif(auth()->user()->role_id == 5)
					<span class="text-muted app-sidebar__user-name text-sm">Accounts Officer</span>
				@elseif(auth()->user()->role_id == 6)
					<span class="text-muted app-sidebar__user-name text-sm">Customer</span>
				@endif
			</div>
		</div>
	</div>
	<ul class="side-menu app-sidebar3">
		@foreach($sidebar as $row)
			@php  $pt = $row['parent'];  $child = $row['child']; @endphp 
			@if($pt['is_active'] !=1) @php $pr_class="pr_hide"; @endphp  @else @php $pr_class=""; @endphp  @endif
			@if(auth()->user()->role_id == 1)
				<li class="slide {{ $pr_class }}">
					<a class="side-menu__item {{ $pt['class'] }} " @if($child && count($child) > 0)  data-toggle="slide" @endif @if($pt['link'] == '#') href="#" @else href="{{url('/superadmin')}}{{ $pt['link'] }}" @endif>
						@if($pt['menu_icon'] !="")
							<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"> <?php echo $pt['menu_icon']; ?> </svg>
						@else
							<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
						@endif
						<span class="side-menu__label">{{$pt['module_name']}}&nbsp;</span>
						@if($child && count($child) > 0) 
							<i class="angle fa fa-angle-right"></i>
							</a>
							<ul class="slide-menu">
								@foreach($child as $ch) 
									@if($ch['is_active'] !=1)  @php $ch_class="ch_hide"; @endphp @else  @php $ch_class=""; @endphp @endif
									<?php $menu_link = $ch['link']; ?>
									<li class='<?php echo activeMenu(url("$menu_link")); ?> {{ $ch_class }}'><a href="{{url('/superadmin')}}{{$menu_link}}" class="slide-item">{{$ch['module_name']}}</a></li>
								@endforeach
							</ul>
						@else
							</a>
						@endif
				</li>
			@elseif(auth()->user()->role_id == 2)
				<li class="slide {{ $pr_class }}">
					<a class="side-menu__item {{ $pt['class'] }} " @if($child && count($child) > 0)  data-toggle="slide" @endif @if($pt['link'] == '#') href="#" @else href="{{url('/admin')}}{{ $pt['link'] }}" @endif>
						@if($pt['menu_icon'] !="")
							<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"> <?php echo $pt['menu_icon']; ?> </svg>
						@else
							<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
						@endif
						<span class="side-menu__label">{{$pt['module_name']}}</span>
						@if($child && count($child) > 0) 
							<i class="angle fa fa-angle-right"></i>
							</a>
							<ul class="slide-menu">
								@foreach($child as $ch) 
									@if($ch['is_active'] !=1)  @php $ch_class="ch_hide"; @endphp @else  @php $ch_class=""; @endphp @endif
									<?php $menu_link = $ch['link']; ?>
									<li class='<?php echo activeMenu(url("$menu_link")); ?> {{ $ch_class }}'><a href="{{url('/admin')}}{{$menu_link}}" class="slide-item">{{$ch['module_name']}}</a></li>
								@endforeach
							</ul>
						@else
							</a>
						@endif
				</li>
			@elseif(auth()->user()->role_id == 7)
				<li class="slide {{ $pr_class }}">
					<a class="side-menu__item {{ $pt['class'] }} " @if($child && count($child) > 0)  data-toggle="slide" @endif @if($pt['link'] == '#') href="#" @else href="{{url('/admin')}}{{ $pt['link'] }}" @endif>
						@if($pt['menu_icon'] !="")
							<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"> <?php echo $pt['menu_icon']; ?> </svg>
						@else
							<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
						@endif
						<span class="side-menu__label">{{$pt['module_name']}}</span>
						@if($child && count($child) > 0) 
							<i class="angle fa fa-angle-right"></i>
							</a>
							<ul class="slide-menu">
								@foreach($child as $ch) 
									@if($ch['is_active'] !=1)  @php $ch_class="ch_hide"; @endphp @else  @php $ch_class=""; @endphp @endif
									<?php $menu_link = $ch['link']; ?>
									<li class='<?php echo activeMenu(url("$menu_link")); ?> {{ $ch_class }}'><a href="{{url('/admin')}}{{$menu_link}}" class="slide-item">{{$ch['module_name']}}</a></li>
								@endforeach
							</ul>
						@else
							</a>
						@endif
				</li>
			@elseif(auth()->user()->role_id == 3)
				<li class="slide {{ $pr_class }}">
					<a class="side-menu__item {{ $pt['class'] }} " @if($child && count($child) > 0)  data-toggle="slide" @endif @if($pt['id'] == 7) href="{{url('/surveyor/service_requests')}}"@else href="{{url('/surveyor')}}{{ $pt['link'] }}" @endif>
						@if($pt['menu_icon'] !="")
							<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"> <?php echo $pt['menu_icon']; ?> </svg>
						@else
							<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
						@endif
						<span class="side-menu__label">{{$pt['module_name']}}</span>
						@if($child && count($child) > 0) 
							<i class="angle fa fa-angle-right"></i>
							</a>
							<ul class="slide-menu">
								@foreach($child as $ch) 
									@if($ch['is_active'] !=1)  @php $ch_class="ch_hide"; @endphp @else  @php $ch_class=""; @endphp @endif
									<?php $menu_link = $ch['link']; ?>
									<li class='<?php echo activeMenu(url("$menu_link")); ?> {{ $ch_class }}'><a href="{{url('/surveyor')}}{{$menu_link}}" class="slide-item">{{$ch['module_name']}}</a></li>
								@endforeach
							</ul>
						@else
							</a>
						@endif
				</li>
			@elseif(auth()->user()->role_id == 4)
				<li class="slide {{ $pr_class }}">
					<a class="side-menu__item {{ $pt['class'] }} " @if($child && count($child) > 0)  data-toggle="slide" @endif @if($pt['id'] == 7) href="{{url('/draftsman/service_requests')}}"@else href="{{url('/draftsman')}}{{ $pt['link'] }}" @endif>
						@if($pt['menu_icon'] !="")
							<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"> <?php echo $pt['menu_icon']; ?> </svg>
						@else
							<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
						@endif
						<span class="side-menu__label">{{$pt['module_name']}}</span>
						@if($child && count($child) > 0) 
							<i class="angle fa fa-angle-right"></i>
							</a>
							<ul class="slide-menu">
								@foreach($child as $ch) 
									@if($ch['is_active'] !=1)  @php $ch_class="ch_hide"; @endphp @else  @php $ch_class=""; @endphp @endif
									<?php $menu_link = $ch['link']; ?>
									<li class='<?php echo activeMenu(url("$menu_link")); ?> {{ $ch_class }}'><a href="{{url('/draftsman')}}{{$menu_link}}" class="slide-item">{{$ch['module_name']}}</a></li>
								@endforeach
							</ul>
						@else
							</a>
						@endif
				</li>
			@elseif(auth()->user()->role_id == 5)
				<li class="slide {{ $pr_class }}">
					<a class="side-menu__item {{ $pt['class'] }} " @if($child && count($child) > 0)  data-toggle="slide" @endif @if($pt['id'] == 7) href="{{url('/accountant/service_requests')}}"@else href="{{url('/accountant')}}{{ $pt['link'] }}" @endif>
						@if($pt['menu_icon'] !="")
							<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"> <?php echo $pt['menu_icon']; ?> </svg>
						@else
							<svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
						@endif
						<span class="side-menu__label">{{$pt['module_name']}}</span>
						@if($child && count($child) > 0) 
							<i class="angle fa fa-angle-right"></i>
							</a>
							<ul class="slide-menu">
								@foreach($child as $ch) 
									@if($ch['is_active'] !=1)  @php $ch_class="ch_hide"; @endphp @else  @php $ch_class=""; @endphp @endif
									<?php $menu_link = $ch['link']; ?>
									<li class='<?php echo activeMenu(url("$menu_link")); ?> {{ $ch_class }}'><a href="{{url('/accountant')}}{{$menu_link}}" class="slide-item">{{$ch['module_name']}}</a></li>
								@endforeach
							</ul>
						@else
							</a>
						@endif
				</li>
			@endif
		@endforeach
	</ul>
</aside>

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
<!--aside closed-->