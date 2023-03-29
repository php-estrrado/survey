@extends('layouts.customer_layout')
@section('css')
    <link href="{{URL::asset('admin/assets/traffic/web-traffic.css')}}" rel="stylesheet" type="text/css">
    		<link href="{{URL::asset('admin/assets/css/daterangepicker.css')}}" rel="stylesheet" />
<style>
.card-options {
	margin-left: 50%;
}
</style>
@endsection
@section('content')
<div class="page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header-title card-header">
                        <h5>Profile</h5>
                    </div>
                    <div class="card-body">
                        <form method="POST" id="customerLogin" action="{{ url('customer/edit_profile') }}" class="theme-form" enctype="multipart/form-data" autocomplete="off">
                            @csrf
                            <input type="hidden" id="id" name="id" value="{{$id}}">
                            <input type="hidden" id="cust_id" name="cust_id" value="{{$cust_id}}">
                            <div class="row">
                                <div class="col-sm-6">
                                    <label class="form-label mt-3" for="name">Name <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="name" placeholder="Name" value="{{ $cust_info->name }}">
                                    <div id="name_error"></div>
                                    @error('name')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                
                                <div class="col-sm-6">
                                    <label class="form-label mt-3" for="firm">Name of Firm <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="firm" placeholder="Name of Firm" value="{{ $cust_info->firm }}">
                                    <div id="firm_error"></div>
                                    @error('firm')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                
                                <div class="col-sm-6">
                                    <label class="form-label mt-3" for="firm_type">Type of Firm <span class="text-red">*</span></label>
                                    <select id="menu-type" class="js-example-basic-single col-sm-12" name="firm_type">
                                        <option value="">Select</option>
                                        <option value="1" {{ $cust_info->firm_type == 1 ? 'selected' : '' }}>Government</option>
                                        <option value="2" {{ $cust_info->firm_type == 2 ? 'selected' : '' }}>Private</option>
                                        <option value="3" {{ $cust_info->firm_type == 3 ? 'selected' : '' }}>Individual</option>
                                        <option value="4" {{ $cust_info->firm_type == 4 ? 'selected' : '' }}>Quasi Government</option>
                                        <option value="5" {{ $cust_info->firm_type == 5 ? 'selected' : '' }}>Research Organisation</option>
                                        <option value="6" {{ $cust_info->firm_type == 6 ? 'selected' : '' }}>State Government</option>
                                        <option value="7" {{ $cust_info->firm_type == 7 ? 'selected' : '' }}>Central Government</option>
                                    </select>
                                    <div id="firm_type_error"></div>
                                    @error('firm_type')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                
                                <div class="col-sm-6">
                                    <label class="form-label mt-3" for="email">Email ID <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="email" placeholder="Email ID" value="{{ $username }}">
                                    <div id="email_error"></div>
                                    @error('email')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                
                                <div class="col-sm-6">
                                    <label class="form-label mt-3" for="mobile">Mobile Number <span class="text-red">*</span></label>
                                    <input class="form-control" type="number" name="mobile" placeholder="Mobile Number" value="{{ $cust_mobile }}">
                                    <div id="mobile_error"></div>
                                    @error('mobile')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                    <!-- <button class="btn btn-primary mt-3">Send OTP</button> -->
                                </div>
                
                                <!-- <div class="col-sm-6">
                                    <label class="form-label mt-3" for="otp">OTP <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="otp" placeholder="OTP" value="{{ old('otp') }}">
                                    <div id="otp_error"></div>
                                    @error('otp')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                    <button class="btn btn-primary mt-3">Verify</button>
                                </div> -->

                                <div class="col-sm-6">
                                    <label class="form-label mt-3" for="valid_id">Valid ID Proof Number (Aadhaar, Voter ID, License) <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="valid_id" placeholder="Valid Proof" value="{{ $cust_info->valid_id }}">
                                    <div id="valid_id_error"></div>
                                    @error('valid_id')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label mt-3" for="id_file_front">Upload ID Proof Front <span class="text-red">*</span></label>
                                    <input class="form-control" type="file" name="id_file_front" id="id_file_front" placeholder="Choose Valid ID">
                                    <div id="id_file_front_error"></div>
                                    @error('id_file_front')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label mt-3" for="id_file_back">Upload ID Proof Back <span class="text-red">*</span></label>
                                    <input class="form-control" type="file" name="id_file_back" id="id_file_back" placeholder="Choose Valid ID">
                                    <div id="id_file_back_error"></div>
                                    @error('id_file_back')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row" style="margin-top: 10px;">
                                <h5>Change Password</h5>
                                <div class="col-sm-6">
                                    <label class="form-label mt-3" for="password">Password <span class="text-red">*</span></label>
                                    <input class="form-control" type="password" name="password" placeholder="Password" value="{{ old('password') }}">
                                    <div id="password_error"></div>
                                    @error('password')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>

                                <div class="col-sm-6">
                                    <label class="form-label mt-3" for="password_confirmation">Confirm Password <span class="text-red">*</span></label>
                                    <input class="form-control" type="password" name="password_confirmation" placeholder="Confirm Password" value="{{ old('password_confirmation') }}">
                                    <div id="password_confirmation_error"></div>
                                    @error('password_confirmation')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                </div>
                            </div>
                            <div class="row mt-3">
                                <div class="g-recaptcha" data-sitekey="{{config('services.recaptcha.key')}}"></div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <button class="btn btn-primary mt-3" style="float:right ;" type="submit">Save</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @include('includes.customer_footer')
</div>
@endsection