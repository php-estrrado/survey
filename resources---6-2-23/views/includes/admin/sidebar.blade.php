<aside class="app-sidebar">
        <div class="app-sidebar__logo">
                <a class="header-brand" href="{{url('/superadmin/dashboard')}}">
                        <img src="{{URL::asset('assets/images/brand/logo.png')}}" class="header-brand-img desktop-lgo" alt="Admintro logo">
                </a>
        </div>
        <div class="app-sidebar__user">
                <div class="dropdown user-pro-body text-center">
                        <div class="user-pic">
                                <img src="{{URL::asset('assets/images/users/2.jpg')}}" alt="user-img" class="avatar-xl rounded-circle mb-1">
                        </div>
                        <div class="user-info">
                                <h5 class=" mb-1">Jessica <i class="ion-checkmark-circled  text-success fs-12"></i></h5>
                                <span class="text-muted app-sidebar__user-name text-sm">Web Designer</span>
                        </div>
                </div>
                
        </div>
        <ul class="side-menu app-sidebar3">
<!--                <li class="side-item side-item-category mt-4">Main</li>-->
                <li class="slide">
                        <a class="side-menu__item"  href="{{url('/admin')}}">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M19 5v2h-4V5h4M9 5v6H5V5h4m10 8v6h-4v-6h4M9 17v2H5v-2h4M21 3h-8v6h8V3zM11 3H3v10h8V3zm10 8h-8v10h8V11zm-10 4H3v6h8v-6z"/></svg>
                        <span class="side-menu__label">Dashboard</span></a>
                </li>
                <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="#">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M16.66 4.52l2.83 2.83-2.83 2.83-2.83-2.83 2.83-2.83M9 5v4H5V5h4m10 10v4h-4v-4h4M9 15v4H5v-4h4m7.66-13.31L11 7.34 16.66 13l5.66-5.66-5.66-5.65zM11 3H3v8h8V3zm10 10h-8v8h8v-8zm-10 0H3v8h8v-8z"/></svg>
                        <span class="side-menu__label">User Management</span><i class="angle fa fa-angle-right"></i></a>
                        <ul class="slide-menu">
                                <li><a href="#" class="slide-item">Roles</a></li>
                                <li><a href="#" class="slide-item">Admins</a></li>
                        </ul>
                </li>
                <li class="slide">
                        <a class="side-menu__item" data-toggle="slide" href="#">
                        <svg class="side-menu__icon" xmlns="http://www.w3.org/2000/svg" height="24" viewBox="0 0 24 24" width="24"><path d="M0 0h24v24H0V0z" fill="none"/><path d="M4 8h4V4H4v4zm6 12h4v-4h-4v4zm-6 0h4v-4H4v4zm0-6h4v-4H4v4zm6 0h4v-4h-4v4zm6-10v4h4V4h-4zm-6 4h4V4h-4v4zm6 6h4v-4h-4v4zm0 6h4v-4h-4v4z"/></svg>
                        <span class="side-menu__label">Products</span><i class="angle fa fa-angle-right"></i></a>
                        <ul class="slide-menu">
                                <li><a href="#" class="slide-item">Admin Products</a></li>
                                <li><a href="#" class="slide-item">Seller Products</a></li>
                        </ul>
                </li>
                
        </ul>
</aside>
<!--aside closed-->