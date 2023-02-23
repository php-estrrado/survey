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
                        <form method="POST" id="adminLogin" action="{{ url('customer/login') }}" class="theme-form">
                            @csrf
                            <h4>Sign in to account</h4>
                            <p>Enter your email & password to login</p>
                            <div class="form-group">
                                <label class="col-form-label form-label-title ">Email ID</label>
                                <input class="form-control" type="email" name="email" required="" placeholder="Email ID">
                            </div>
                            <div class="form-group">
                                <label class="col-form-label form-label-title ">Password</label>
                                <div class="form-input position-relative">
                                    <input class="form-control" type="password" name="password" id="password" required=""
                                        placeholder="*********">
                                    <div class="show-hide"><span class="show" id="showPass" onclick="showPass()"> </span></div>
                                </div>
                            </div>
                            <div class="form-group mb-0">
                                <div class="checkbox p-0">
                                    <input id="remember" type="checkbox" name="remember">
                                    <label class="custom-control-label" for="remember" >Remember password</label>
                                </div>
                                <a class="link" href="{{url('/customer/forgotPassword')}}">Forgot password?</a>
                                <div class="text-end mt-3">
                                    <div class="g-recaptcha" data-sitekey="{{config('services.recaptcha.key')}}"></div>
                                    <br/>
                                    <button class="btn btn-primary btn-block w-100" type="submit">Sign in</button>
                                </div>
                            </div>
                            <p class="mt-4 mb-0 text-center">Don't have account?<a class="ms-2"
                                    href="{{ url('customer/register') }}">Create Account</a></p>
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
    <script src="https://www.google.com/recaptcha/api.js" async defer></script>
    <script type="text/javascript">
        $(document).ready(function(){
            @if(Session::has('message'))
                @if(session('message')['type'] =="success")
                    toastr.success("{{session('message')['text']}}"); 
                @else
                    toastr.error("{{session('message')['text']}}"); 
                @endif
            @endif
            
            @if ($errors->any())          
                toastr.error("{{$errors->all()[0]}}"); 
            @endif
        });

        function showPass()
        {
            var password=$("#password");

            if(password.attr('type')==='password')
            {
                password.attr('type','text');
                $('#showPass').addClass('hide').removeClass('show');
            }
            else
            {
                password.attr('type','password');
                $('#showPass').addClass('show').removeClass('hide');
            }
        }
    </script>
@endsection