<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head> @include('includes.customer_head')</head>
    <body>
        <!---Global-loader-->
        <div id="global-loader">
            <img src="{{URL::asset('assets/images/svgs/loader.svg')}}" alt="loader">
        </div>
        <!--- End Global-loader-->
        <!-- tap on top starts-->
        <div class="tap-top"><i data-feather="chevrons-up"></i></div>
        <!-- tap on tap ends-->
        <!-- page-wrapper Start-->
        <div class="page-wrapper compact-wrapper modern-type" id="pageWrapper">
            <!-- Page Header Start-->
            <!-- @yield('page-header') -->
            @include('includes.customer_header')
            <!-- Page Header Ends -->
            <!-- Page Body Start-->
            <div class="page-body-wrapper">
                <!-- Page Sidebar Start-->
                @include('includes.customer_sidebar')
                <!-- Page Sidebar Ends-->
                <!-- Page Content Start-->
                @yield('content')
                <!-- Page Content Ends-->
            </div>
            <!-- Page Body Ends -->
        </div>
        @include('includes.customer_foot')
        @include('includes.customer_modals')
        @yield('js')
    </body>
</html>