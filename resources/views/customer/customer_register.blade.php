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
                    <div class="login-main reg">
                        <form method="POST" id="customerLogin" action="{{ url('customer/register') }}" class="theme-form" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <h4>Create a new account</h4>
                            <div class="row">

                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="name">Name <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="name" placeholder="Name" value="{{ old('name') }}">
                                    <div id="name_error"></div>
                                    @error('name')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                
                                <!-- <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="firm">Name of Firm <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="firm" placeholder="Name of Firm" value="{{ old('firm') }}">
                                    <div id="firm_error"></div>
                                    @error('firm')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div> -->

                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="firm">Name of Organization <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="firm" placeholder="Name of Organization" value="{{ old('firm') }}">
                                    <div id="firm_error"></div>
                                    @error('firm')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                
                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="firm_type">Type of Organization <span class="text-red">*</span></label>
                                    <select id="menu-type" class="js-example-basic-single col-sm-12" name="firm_type">
                                        <option value="">Select</option>
                                        <option value="1" {{ old('firm_type') == 1 ? 'selected' : '' }}>Government</option>
                                        <option value="2" {{ old('firm_type') == 2 ? 'selected' : '' }}>Private</option>
                                        <option value="3" {{ old('firm_type') == 3 ? 'selected' : '' }}>Individual</option>
                                        <option value="4" {{ old('firm_type') == 4 ? 'selected' : '' }}>Quasi Government</option>
                                        <option value="5" {{ old('firm_type') == 5 ? 'selected' : '' }}>Research Organisation</option>
                                        <option value="6" {{ old('firm_type') == 6 ? 'selected' : '' }}>State Government</option>
                                        <option value="7" {{ old('firm_type') == 7 ? 'selected' : '' }}>Central Government</option>
                                    </select>
                                    <div id="firm_type_error"></div>
                                    @error('firm_type')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                
                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="email">Email ID <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="email" placeholder="Email ID" value="{{ old('email') }}" autocomplete="off">
                                    <div id="email_error"></div>
                                    @error('email')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                
                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="mobile">Mobile Number <span class="text-red">*</span></label>
                                    <input class="form-control" type="number" name="mobile" placeholder="Mobile Number" value="{{ old('mobile') }}">
                                    <div id="mobile_error"></div>
                                    @error('mobile')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                    <!-- <button class="btn btn-primary mt-3">Send OTP</button> -->
                                </div>
                
                                <!-- <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="otp">OTP <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="otp" placeholder="OTP" value="{{ old('otp') }}">
                                    <div id="otp_error"></div>
                                    @error('otp')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                    <button class="btn btn-primary mt-3">Verify</button>
                                </div> -->

                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="valid_id">Valid ID Proof Number(Aadhaar, Voter ID, License) <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="valid_id" placeholder="Valid Proof" value="{{ old('valid_id') }}">
                                    <div id="valid_id_error"></div>
                                    @error('valid_id')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="id_file_front">Upload ID Proof * <span class="text-red" style="color: #ff0000;">(format:- .pdf, Maximum size: 10mb)</span></label>
                                    <input class="form-control" type="file" name="id_file_front" id="id_file_front" placeholder="Choose Valid ID">
                                    <div id="id_file_front_error"></div>
                                    @error('id_file_front')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="id_file_back">Authorisation letter, if any <span class="text-red" style="color: #ff0000;">(format:- .pdf, Maximum size: 10mb) </span></label>
                                    <input class="form-control" type="file" name="id_file_back" id="id_file_back" placeholder="Choose Valid ID">
                                    <div id="id_file_back_error"></div>
                                    @error('id_file_back')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                
                            </div>
                            <div class="row">
                
                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="password">Password <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="password" placeholder="Password" value="{{ old('password') }}" onfocus="this.setAttribute('type', 'password')">
                                    <div id="password_error"></div>
                                    @error('password')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="password_confirmation">Confirm Password <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="password_confirmation" placeholder="Confirm Password" value="{{ old('password_confirmation') }}" onfocus="this.setAttribute('type', 'password')">
                                    <div id="password_confirmation_error"></div>
                                    @error('password_confirmation')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                
                            </div>
                            <div class="row mt-3">
                                <div class="g-recaptcha" data-sitekey="{{config('services.recaptcha.key')}}"></div>
                                </div>
                            <div class="text-end mt-3">
                                
                                <button class="btn btn-primary btn-block w-100" type="submit">Submit</button>
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
        });
    </script>
@endsection