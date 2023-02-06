@extends('layouts.master5')
@section('css')
    <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet" />
@endsection
@section('content')
<link rel="stylesheet" href="{{URL::asset('admin/assets/css/toastr.min.css')}}" />
<div class="container-fluid p-0">
    <div class="row m-0">
        <div class="col-12 p-0">
            <div class="login-card">
                <div>
                    <div>
                        <a class="logo" href="index.html">
                            <img class="img-fluid for-light" src="{{URL::asset('admin/assets/images/logo.png')}}" alt="looginpage">
                            <img class="img-fluid for-dark" src="{{URL::asset('admin/assets/images/logo.png')}}" alt="looginpage">
                        </a>
                    </div>
                    <div class="login-main">
                        <form class="theme-form" action="{{url('customer/update_password')}}" method="post">
                            <h4>Forgot Password?</h4>
                            <p>Enter your Email & password to login</p>
                            <div class="form-group">
                                <label class="col-form-label form-label-title" for="email">Email</label>
                                <input class="form-control" type="email" name="email" id="email" placeholder="Email">
                                <button class="btn btn-primary mt-3" id="send_otp" onclick="sendOtp()">Send OTP</button>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label form-label-title" for="otp">OTP</label>
                                <input class="form-control" type="text" name="otp" id="otp" placeholder="OTP">
                                <button class="btn btn-primary mt-3" id="verify_otp" onclick="verifyOtp()">Verify</button>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label form-label-title" for="password">New Password</label>
                                <div class="form-input position-relative">
                                    <input class="form-control" type="password" name="password" id="password" placeholder="*********">
                                    <div class="show-hide"><span class="show"> </span></div>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-form-label form-label-title" for="confirm_password">Confirm Password</label>
                                <div class="form-input position-relative">
                                    <input class="form-control" type="password" name="confirm_password" id="confirm_password" placeholder="*********">
                                    <div class="show-hide"><span class="show"> </span></div>
                                </div>
                            </div>
                            <div class="text-end mt-3">
                                <button class="btn btn-primary btn-block w-100" type="submit">Save</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
 <script src="{{URL::asset('admin/assets/js/toastr.min.js')}}"></script> 
    <script type="text/javascript">
        $(document).ready(function(){
            @if(Session::has('message'))
                @if(session('message')['type'] =="success")
                    toastr.success("{{session('message')['text']}}"); 
                @else
                    toastr.error("{{session('message')['text']}}"); 
                @endif
            @endif
        });
    </script>
    <script>
		function sendOtp()
		{
			var email = $('#email').val();

			$.ajax({
				url: "{{url('/customer/send_otp')}}",
				type: "post",
				data: {
					"_token": "{{ csrf_token() }}",
					"email": email,
				},
				success: function(result)
				{
					console.log(result);
				}
			});
		}

        function verifyOtp()
		{
			var email = $('#email').val();
            var otp = $('#otp').val();

            console.log(email);
            console.log(otp);

			$.ajax({
				url: "{{url('/customer/verify_otp')}}",
				type: "post",
				data: {
					"_token": "{{ csrf_token() }}",
					"email": email,
                    "otp": otp,
				},
				success: function(result)
				{
					console.log(result);
				}
			});
		}
	</script>
@endsection