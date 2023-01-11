@extends('layouts.master5')
@section('css')
    <link href="{{URL::asset('assets/css/style.css')}}" rel="stylesheet" />
@endsection
@section('content')
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
                    <div class="login-main reg">
                        <form method="POST" id="customerLogin" action="{{ url('customer/register') }}" class="theme-form">
                            @csrf
                            <h4>Sign in to account</h4>
                            <p>Enter your email & password to login</p>
                            <div class="row">

                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="name">Name</label>
                                    <input class="form-control" type="text" name="name" placeholder="Name">
                                </div>
                
                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="firm">Name of Firm</label>
                                    <input class="form-control" type="text" name="firm" placeholder="Name of Firm">
                                </div>
                
                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="firm_type">Type of Firm</label>
                                    <select id="menu-type" class="js-example-basic-single col-sm-12" name="firm_type">
                                    <option value="">select</option>
                                    <option value="1">Government</option>
                                    <option value="2">Private</option>
                                    </select>
                                </div>
                
                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="email">Email ID</label>
                                    <input class="form-control" type="text" name="email" placeholder="Email ID">
                                </div>
                
                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="mobile">Mobile Number</label>
                                    <input class="form-control" type="text" name="mobile" placeholder="Mobile Number">
                                    <button class="btn btn-primary mt-3">Send OTP</button>
                                </div>
                
                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="otp">OTP</label>
                                    <input class="form-control" type="text" name="otp" placeholder="OTP">
                                    <button class="btn btn-primary mt-3">Verify</button>
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="valid_id">Valid Proof</label>
                                    <input class="form-control" type="text" name="valid_id" placeholder="Valid Proof">
                                </div>
                
                            </div>
                            <div class="row">
                
                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="password">Password</label>
                                    <input class="form-control" type="password" name="password" placeholder="Password">
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="password_confirmation">Confirm Password</label>
                                    <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password">
                                </div>
                
                            </div>
                            <div class="text-end mt-3">
                                <button class="btn btn-primary btn-block w-100" type="submit">Create Account</button>
                            </div>
                            <p class="mt-4 mb-0 text-center">Already have an account?<a class="ms-2"
                                    href="{{ URL('/customer/login')}}">Sign in</a>
                            </p>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@section('js')
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
                @foreach ($errors->all() as $error)
                    toastr.error("{{$error}}"); 
                @endforeach
            @endif
        });
    </script>
@endsection