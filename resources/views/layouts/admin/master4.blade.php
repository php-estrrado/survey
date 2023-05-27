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
	@include('layouts.admin.custom-head')
</head>

<body class="h-100vh log-bg">
	@yield('content')
	@include('layouts.admin.custom-footer-scripts')
</body>

</html>