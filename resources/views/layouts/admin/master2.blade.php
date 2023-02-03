<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
		<!-- Meta data -->
		<meta charset="UTF-8">
		<meta name='viewport' content='width=device-width, initial-scale=1.0, user-scalable=0'>
		<meta content="Hydrographic Survey Wing" name="description">
    	<meta content="HSW" name="author">
    	<meta name="keywords" content="Hydrographic, Survey" />
		@include('layouts.custom-head')	
	</head>
	<body class="h-100vh bg-primary">
	<div class="box">
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
			<div></div>
		</div>
		@yield('content')	
		@include('layouts.custom-footer-scripts')	
	</body>
</html>