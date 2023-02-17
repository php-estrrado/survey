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
                                        <h4>Survey Report Received</h4>
                                    </div>
                                </div>
                            </div>

                            <div class="row g-2">
                                <div class="col-md-1">
                                    <img src="{{url('admin/assets/images/file_image.png')}}" alt="report-img" width="50px">
                                </div>
                                <div class="col-md-2">
                                    Survey_report.pdf <br />
                                    <a href="{{$final_report}}" target="_blank"><button class="btn btn-primary">Download</button></a>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid">
            <!-- footer start-->
            <footer class="footer">
                <div class="row">
                    <div class="col-md-12 footer-copyright text-center">
                        <p class="mb-0">Copyright © 2022 . Powered by GAUDE.  All rights reserved. </p>
                    </div>
                </div>
            </footer>
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