


<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
	
    @include('includes.head')
	</head>

	<body class="app sidebar-mini">
		<!---Global-loader-->
		<div id="global-loader" >
			<img src="{{URL::asset('assets/images/svgs/loader.svg')}}" alt="loader">
		</div>
		<!--- End Global-loader-->
		<!-- Page -->
		<div class="page">
			<div class="page-main">
				@include('includes.sidebar')
				<!-- App-Content -->			
				<div class="app-content main-content">
					<div class="side-app">
						@include('includes.header')
						@yield('page-header')
						@yield('content')
						@include('includes.footer')
                                        </div>
                                </div>
                        </div>
		</div><!-- End Page -->
			@include('includes.foot')
	</body>
</html>
