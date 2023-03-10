@extends('layouts.admin.master4')
@section('css')
@endsection
@section('content')
<link rel="stylesheet" href="{{URL::asset('admin/assets/css/toastr.min.css')}}" />
<div class="page">
	<div class="page-single">
		<div class="container">
			<div class="row">
				<div class="col mx-auto">
					<div class="row justify-content-center">
						<div class="col-md-5">
							<div>
								<a class="logo" href="#">
									<img class="img-fluid for-light" src="{{url('admin/assets/images/logo.png')}}" alt="looginpage">
								</a>
							</div>
							<div class="card">
								<div class="card-body">
									<div class="text-center title-style mb-6">
										<h1 class="mb-2">Sign in to account</h1>
										<p class="text-muted text-left">Enter your email and OTP to login</p>
									</div>
									<form method="POST" id="adminLogin" action="{{ url('/superadmin/regVerifyotpemail') }}" class="theme-form">
										@csrf
										<label class="col-form-label form-label-title" for="email">Email ID</label>
										<div class="input-group mb-4">
											<input type="text" class="form-control" name="email" id="email" placeholder="Email ID" value="{{ old('email')}}">
											<div id="email_error"></div>
											@error('email')
												<p style="color: red">{{ $message }}</p>
											@enderror
										</div>
										<div class="row justify-content-end mb-4">
											<div class="col-4">
											<button type="button" class="btn  btn-primary btn-block px-4" id="send_otp" onclick="sendOtp()">Send OTP</button>
											</div>
										</div>
										<label class="col-form-label form-label-title" for="otp">OTP</label>
										<div class="input-group mb-4">
											<input type="password" class="form-control" name="otp" id="otp" placeholder="OTP">
											<div id="otp_error"></div>
											@error('otp')
												<p style="color: red">{{ $message }}</p>
											@enderror
										</div>
										<div class="row justify-content-end">
											<div class="col-4">
												<button type="submit" class="btn btn-primary btn-block px-4">Verify</button>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
	<script>
		function sendOtp()
		{
			var email = $('#email').val();

			$.ajax({
				url: "{{url('superadmin/sendotpemail')}}",
				type: "post",
				data: {
					"_token": "{{ csrf_token() }}",
					"email": email,
				},
				success: function(result)
				{
					var result = JSON.parse(result );
					
					if(result.status ==1)
					{
						toastr.success(result.message);
					}
					else
					{
						toastr.error(result.message);
					}	

				}
			});
		}
	</script>
@endsection
@section('js')
	<script src="{{URL::asset('admin/assets/js/toastr.min.js')}}"></script>
    <script type="text/javascript">
		
		@if(count($errors) > 0)
			@foreach($errors->all() as $error)
				toastr.error("{{ $error }}");
			@endforeach
		@endif
    </script>
@endsection