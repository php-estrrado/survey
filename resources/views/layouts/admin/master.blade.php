<!DOCTYPE html>
<html lang="en" dir="ltr">

<head>
	<!-- Meta data -->
	<meta charset="UTF-8">
	<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
	<meta content="Hydrographic Survey Wing" name="description">
	<meta content="HSW" name="author">
	<meta name="keywords" content="Hydrographic, Survey" />
	<meta http-equiv="X-Frame-Options" content="deny">
	<?php
            $allowed_host = array('localhost');

            
            if (!isset($_SERVER['HTTP_HOST']) || !in_array($_SERVER['HTTP_HOST'], $allowed_host)) 
            {
                header($_SERVER['SERVER_PROTOCOL'] . ' 400 Bad Request');
                exit;
            }
        ?>
	@include('layouts.admin.head')
</head>

<body class="app sidebar-mini">
	<!---Global-loader-->
	<div id="global-loader">
		<img src="{{URL::asset('assets/images/svgs/loader.svg')}}" alt="loader">
	</div>
	<!--- End Global-loader-->
	<!-- Page -->
	<div class="page">
		<div class="page-main">
			@include('layouts.admin.aside-menu')
			<!-- App-Content -->
			<div class="app-content main-content">
				<div class="side-app">
					@include('layouts.admin.header')
					@yield('page-header')
					@yield('content')
					@include('layouts.admin.footer')
				</div><!-- End Page -->
				@include('layouts.admin.footer-scripts')
</body>

</html>