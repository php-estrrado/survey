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
                        <h5>Search Results</h5>
                    </div>
                </div>
                <div class="card-body bodhgt">
                        @if(count($results) > 0 && $type == 'survey_request')
                            <ul class="list-group list-group-flush">
                                @foreach($results as $result)
                                    <li class="list-group-item"><a href="{{url('/customer/request_service_detail/').'/'.$result->id.'/'.$result->request_status}}">HSW{{$result->id}}</a></li>
                                @endforeach
                            </ul>
                        @elseif(count($results) > 0 && $type == 'service')
                            <ul class="list-group list-group-flush">
                                @foreach($results as $result)
                                    <li class="list-group-item">
                                        @if($result->id == 1)
                                            <a href="{{url('/customer/hydrographic_survey')}}">{{$result->service_name}}</a>
                                        @elseif($result->id == 2)
                                            <a href="{{url('/customer/tidal_observation')}}">{{$result->service_name}}</a>
                                        @elseif($result->id == 3)
                                            <a href="{{url('/customer/bottomsample')}}">{{$result->service_name}}</a>
                                        @elseif($result->id == 4)
                                            <a href="{{url('/customer/dredging_survey')}}">{{$result->service_name}}</a>
                                        @elseif($result->id == 5)
                                            <a href="{{url('/customer/hydrographic_data')}}">{{$result->service_name}}</a>
                                        @elseif($result->id == 6)
                                            <a href="{{url('/customer/underwater_videography')}}">{{$result->service_name}}</a>
                                        @elseif($result->id == 7)
                                            <a href="{{url('/customer/currentmeter_observation')}}">{{$result->service_name}}</a>
                                        @elseif($result->id == 8)
                                            <a href="{{url('/customer/sidescanningsonar_survey')}}">{{$result->service_name}}</a>
                                        @elseif($result->id == 9)
                                            <a href="{{url('/customer/topographic_survey')}}">{{$result->service_name}}</a>
                                        @elseif($result->id == 10)
                                            <a href="{{url('/customer/subbottom_profilling')}}">{{$result->service_name}}</a>
                                        @elseif($result->id == 11)
                                            <a href="{{url('/customer/bathymetry_survey')}}">{{$result->service_name}}</a>
                                        @endif
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <ul class="list-group list-group-flush">
                                <li class="list-group-item"><span style="color: #ff0000;"><strong>No results found !</strong></span></li>
                            </ul>
                        @endif
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