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

                            <div class="description-section tab-section">
                                <div class="detail-img">
                                    <img src="../assets/images/tours/spain.jpg" class="img-fluid blur-up lazyload" alt="">
                                </div>
                                <div class="description-details tab-content" id="top-tabContent">
                                    <div class="menu-part about tab-pane fade show active" id="highlight">
                                        <ul class="timelineleft pb-5 mt-5">
                                            @if($survey_datas && count($survey_datas) > 0)
                                                @foreach($survey_datas as $survey_data)
                                                    <li> <i class="fa fa-clock-o bg-pink"></i>
                                                        <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> {{date('d/m/Y',strtotime($survey_data->log_date))}}</span>
                                                            @if($survey_data->survey_status == 27)
                                                                <h3 class="timelineleft-header"><a href="{{url('/customer/survey_report')}}/{{$survey_data->survey_request_id}}" target="_blank">{{$survey_data->status_name}}</a></h3>
                                                            @elseif($survey_data->survey_status == 15)
                                                                <h3 class="timelineleft-header"><a href="{{url('/customer/request_service_performa_invoice')}}/{{$survey_data->survey_request_id}}">{{$survey_data->status_name}}</a></h3>
                                                            @elseif($survey_data->survey_status == 51)
                                                                <h3 class="timelineleft-header"><a href="{{url('/customer/request_service_invoice')}}/{{$survey_data->survey_request_id}}">{{$survey_data->status_name}}</a></h3>
                                                            @else
                                                                <h3 class="timelineleft-header">{{$survey_data->status_name}}</h3>
                                                            @endif
                                                            
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif
                                            <!-- @if($status == 17)
                                                <li> <i class="fa fa-clock-o bg-pink"></i>
                                                    <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 1 hour ago</span>
                                                        <h3 class="timelineleft-header"><a href="report-received.html">CH verified final report</a></h3>
                                                    </div>
                                                </li>
                                            @endif
                                            @if($status == 16)
                                                <li> <i class="fa fa-clock-o bg-pink"></i>
                                                    <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 1 hour ago</span>
                                                        <h3 class="timelineleft-header"><a href="receipt-rejected.html">DH verified final report</a></h3>
                                                    </div>
                                                </li>
                                            @endif
                                            @if($status == 15)
                                                <li> <i class="fa fa-clock-o bg-pink"></i>
                                                    <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 1 hour ago</span>
                                                        <h3 class="timelineleft-header"><a href="receipt-rejected.html">DH verified survey report</a></h3>
                                                    </div>
                                                </li>
                                            @endif
                                            @if($status == 14)
                                                <li> <i class="fa fa-clock-o bg-pink"></i>
                                                    <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 1 hour ago</span>
                                                        <h3 class="timelineleft-header"><a href="receipt-rejected.html">Assigned survey study to suboffice</a></h3>
                                                    </div>
                                                </li>
                                            @endif
                                            @if($status == 13)
                                                <li> <i class="fa fa-clock-o bg-pink"></i>
                                                    <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 1 hour ago</span>
                                                        <h3 class="timelineleft-header"><a href="receipt-rejected.html">Customer payment rejected by AO</a></h3>
                                                    </div>
                                                </li>
                                            @endif
                                            @if($status == 12)
                                                <li> <i class="fa fa-clock-o bg-pink"></i>
                                                    <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 1 hour ago</span>
                                                        <h3 class="timelineleft-header"><a href="receipt-rejected.html">Customer payment verified by AO</a></h3>
                                                    </div>
                                                </li>
                                            @endif
                                            @if($status == 11)
                                                <li> <i class="fa fa-clock-o bg-pink"></i>
                                                    <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 1 hour ago</span>
                                                        <h3 class="timelineleft-header"><a href="receipt-rejected.html">Invoice verified by CH</a></h3>
                                                    </div>
                                                </li>
                                            @endif
                                            @if($status == 10)
                                                <li> <i class="fa fa-clock-o bg-pink"></i>
                                                    <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 1 hour ago</span>
                                                        <h3 class="timelineleft-header"><a href="receipt-rejected.html">Invoice verified by DH</a></h3>
                                                    </div>
                                                </li>
                                            @endif
                                            @if($status == 9)
                                                <li> <i class="fa fa-clock-o bg-pink"></i>
                                                    <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 1 hour ago</span>
                                                        <h3 class="timelineleft-header"><a href="receipt-rejected.html">Invoice rejected</a></h3>
                                                    </div>
                                                </li>
                                            @endif
                                            @if($status == 8)
                                                <li> <i class="fa fa-clock-o bg-orange"></i>
                                                    <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 2 days ago</span>
                                                        <h3 class="timelineleft-header">Invoice received</h3>
                                                    </div>
                                                </li>
                                            @endif
                                            @if($status == 7)
                                                <li> <i class="fa fa-clock-o bg-pink"></i>
                                                    <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 5 days ago</span>
                                                        <h3 class="timelineleft-header">Field study conducted by surveyor</h3>
                                                    </div>
                                                </li>
                                            @endif
                                            @if($status == 6)
                                                <li> <i class="fa fa-clock-o bg-success pb-3"></i> 
                                                    <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 5 days ago</span>
                                                        <h3 class="timelineleft-header">Surveyor rejected field study</h3>
                                                    </div>
                                                </li>
                                            @endif
                                            @if($status == 5)
                                                <li> <i class="fa fa-clock-o bg-success pb-3"></i> 
                                                    <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 5 days ago</span>
                                                        <h3 class="timelineleft-header">Assigned to sub office</h3>
                                                    </div>
                                                </li>
                                            @endif
                                            @if($status == 4)
                                                <li> <i class="fa fa-clock-o bg-warning"></i>
                                                    <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 27 mins ago</span>
                                                        <h3 class="timelineleft-header"><a href="rejected-open.html">Service request rejected open</a></h3>
                                                    </div>
                                                </li>
                                            @endif
                                            @if($status == 3)
                                                <li> <i class="fa fa-clock-o bg-pink"></i>
                                                    <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 1 hour ago</span>
                                                        <h3 class="timelineleft-header"><a href="request-rejected.html">Service request rejected</a></h3>
                                                    </div>
                                                </li>
                                            @endif
                                            @if($status == 2)
                                                <li> <i class="fa fa-clock-o bg-secondary"></i>
                                                    <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 5 mins ago</span>
                                                        <h3 class="timelineleft-header">Service request accepted</h3>
                                                    </div>
                                                </li>
                                            @endif
                                            @if($status == 1)
                                                <li> <i class="fa fa-clock-o bg-secondary"></i>
                                                    <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 5 mins ago</span>
                                                        <h3 class="timelineleft-header">Service request pending</h3>
                                                    </div>
                                                </li>
                                            @endif -->
                                        </ul>
                                    </div>
                                    <div class="menu-part accordion tab-pane fade " id="itinerary">
                                        
                                    </div>
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
                        <p class="mb-0">Copyright 2022 © HSW </p>
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