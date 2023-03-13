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
                        <div class="card-header  card-header--2 package-card">
                            <div>
                                <h5>HSW{{$id}}</h5>
                            </div>
                        </div>

                        <div class="card-body">

                            <div class="row g-2 mb-3">
                                <div class="col-md-6">
                                    <div class="about-sec">
                                        <p>Requested Service</p>
                                        <h4>{{$service_name}}</h4>
                                    </div>
                                </div>
                                <div class="col-md-6 margin-up">
                                    <div class="about-sec">
                                        <p>Status</p>
                                        <h4>{{$status_name}}</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-2">
                                <div class="col-md-12">
                                    <div class="about-sec">
                                        <h4>Remarks</h4>
                                        <div>{{$remarks}}</div>                                        
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card newser">
                        <div class="card-body">
                            {{ Form::open(array('url' => "/customer/customer_receipt_upload/", 'id' => 'receiptForm', 'name' => 'receiptForm', 'class' => '','files'=>'true')) }}
                                @csrf
                                {{Form::hidden('id',$id,['id'=>'id'])}}
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <label class="form-label-title mt-3" for="receipt">Upload receipt</label>
                                        <input class="form-control" type="file" name="receipt" id="receipt" placeholder="Choose Valid File">
                                        <div id="receipt_error"></div>
                                        @error('receipt')
                                            <p style="color: red">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="btn-list d-flex justify-content-end">
                                        <button class="btn btn-primary" style="float:right ;" type="submit">Submit</button>
                                        <a href="{{URL('/customer/requested_services')}}" class="btn btn-danger">Cancel</a>
                                    </div>
                                </div>
                            {{Form::close()}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @include('includes.customer_footer')
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