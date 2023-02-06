<!DOCTYPE html>
<html lang="en" dir="ltr">
	<head>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="Hydrographic Survey Wing">
        <meta name="keywords" content="Hydrographic, Survey">
        <meta name="author" content="HSW">
        <link rel="icon" href="../assets/images/favicon.png" type="image/x-icon">
        <link rel="shortcut icon" href="../assets/images/favicon.png" type="image/x-icon">
        <title>Hydrographic Survey Wing</title>
        <!-- Google font-->
        <link
            href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@200&family=Nunito:ital,wght@0,200;0,300;0,400;0,600;0,700;0,800;0,900;1,200;1,300;1,400;1,600;1,700;1,800;1,900&display=swap"
            rel="stylesheet">
        <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/css/font-awesome.css')}}">
        <!-- Themify icon-->
        <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/css/vendors/themify.css')}}">
        <!-- Feather icon-->
        <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/css/vendors/feather-icon.css')}}">
        <!-- Plugins css start-->
        <!-- Plugins css Ends-->
        <!-- Bootstrap css-->
        <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/css/bootstrap.css')}}">
        <!-- App css-->
        <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/css/style.css')}}">

        <!-- Responsive css-->
        <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/css/responsive.css')}}">

        <!-- Custom css-->
        <link href="{{URL::asset('assets/css/custom.css')}}" rel="stylesheet" />
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