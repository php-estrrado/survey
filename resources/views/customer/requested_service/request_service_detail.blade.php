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

                        <div class="card-body bodhgt">

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
                                                        <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> {{date('d/m/Y h:i:sa',strtotime($survey_data->log_date))}}</span>
                                                            @if($survey_data->survey_status == 27)
                                                                @if($request_status == 27)
                                                                    <h3 class="timelineleft-header"><a href="{{url('/customer/survey_report')}}/{{$survey_data->survey_request_id}}/{{$survey_data->survey_status}}" target="_blank">{{$survey_data->status_name}}</a></h3>
                                                                @else
                                                                    <h3 class="timelineleft-header">{{$survey_data->status_name}}</h3>
                                                                @endif
                                                            @elseif($survey_data->survey_status == 70)
                                                                @if($request_status == 70)
                                                                    <h3 class="timelineleft-header"><a href="{{url('/customer/receipt_rejected')}}/{{$survey_data->survey_request_id}}/{{$survey_data->survey_status}}">{{$survey_data->status_name}}</a></h3>
                                                                @else
                                                                    <h3 class="timelineleft-header">{{$survey_data->status_name}}</h3>
                                                                @endif 
                                                            @elseif($survey_data->survey_status == 51)
                                                                @if($request_status == 51)
                                                                    <h3 class="timelineleft-header"><a href="{{url('/customer/request_service_invoice')}}/{{$survey_data->survey_request_id}}/{{$survey_data->survey_status}}">{{$survey_data->status_name}}</a></h3>
                                                                @else
                                                                    <h3 class="timelineleft-header">{{$survey_data->status_name}}</h3>
                                                                @endif 
                                                               
                                                            @elseif($survey_data->survey_status == 15)
                                                                @if($request_status == 15)
                                                                    <h3 class="timelineleft-header"><a href="{{url('/customer/request_service_performa_invoice')}}/{{$survey_data->survey_request_id}}/{{$survey_data->survey_status}}">{{$survey_data->status_name}}</a></h3>
                                                                @else
                                                                    <h3 class="timelineleft-header">{{$survey_data->status_name}}</h3>
                                                                @endif                                                                
                                                            @else
                                                                <h3 class="timelineleft-header">{{$survey_data->status_name}}</h3>
                                                            @endif
                                                            
                                                        </div>
                                                    </li>
                                                @endforeach
                                            @endif
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