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
  <link href="{{URL::asset('assets/css/jQuery-plugin-progressbar.css')}}" rel="stylesheet" />
<div class="page-body">
    <div class="container-fluid">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header card-header--2">

                        <div>
                            <h5>{{$title}}</h5>
                        </div>

                    </div>

                    <div class="card-body">
                        <div>
                            <div class=" table-responsive table-desi">
                                <table class="all-cars-table table table-striped">
                                    <thead>
                                        <tr>
                                            <th>Sl No</th>
                                            <th>Date</th>
                                            <th>File Number</th>
                                            <th>Requested Services</th>
                                            <th>Service Status</th>
                                            <th>Progress</th>
                                            <th>View</th>
                                            
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if($requested_services && count($requested_services)>0)
                                            @php $i=1; @endphp
                                            @foreach($requested_services as $requested_service)
                                                <tr>
                                                    <td>{{$i;}}</td>
                                                    <td>{{date('d/m/Y',strtotime($requested_service->survey_date))}}</td>
                                                    <td class="fw-bold"><a href="{{URL('/customer/request_service_detail')}}/{{$requested_service->survey_id}}/{{$requested_service->request_status}}">HSW{{$requested_service->survey_id}}</a></td>
                                                    <td>{{$requested_service->service_name}}</td>
                                                    <td>{{$requested_service->current_status}}</td>
                                                    <td>

                                                    <div class="progress-bar-cust position" data-percent='{{ request_progress($requested_service->id); }}' data-color="#ccc,#4aa4d9" ></div>
                                    </td>
                                                    <td><a href="{{URL('/customer/request_service_detail')}}/{{$requested_service->survey_id}}/{{$requested_service->request_status}}"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                                                </tr>
                                                @php $i++; @endphp
                                            @endforeach
                                        @endif
                                        <!--<tr>-->
                                        <!--    <td><span>1</span>-->
                                        <!--    </td>-->
                                        <!--    <td><span>10/11/2022</span></td>-->
                                        <!--    <td><a href="#"><span class="  d-block fw-bold ">AE0123</span></a>-->
                                        <!--    </td>-->
                                            
                                        <!--    <td>Invoice received</td>-->

                                        <!--    <td>-->
                                        <!--        <a href="invoice-received.html"><i class="fa fa-eye"-->
                                        <!--                aria-hidden="true"></i></a>-->
                                        <!--    </td>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                        <!--    <td><span>2</span>-->
                                        <!--    </td>-->
                                        <!--    <td><span>10/11/2022</span></td>-->
                                        <!--    <td><a href="#"><span class="  d-block fw-bold ">AE0123</span></a>-->
                                        <!--    <td>Request rejected closed</td>-->

                                        <!--    <td>-->
                                        <!--        <a href="request-reject.html"><i class="fa fa-eye"-->
                                        <!--                aria-hidden="true"></i></a>-->
                                        <!--    </td>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                        <!--    <td><span>3</span>-->
                                        <!--    </td>-->
                                        <!--    <td><span>10/11/2022</span></td>-->
                                        <!--    <td><a href="#"><span class="  d-block fw-bold ">AE0123</span></a>-->
                                        <!--    <td>Request rejected open</td>-->

                                        <!--    <td>-->
                                        <!--        <a href="rejected-open.html"><i class="fa fa-eye"-->
                                        <!--                aria-hidden="true"></i></a>-->
                                        <!--    </td>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                        <!--    <td><span>4</span>-->
                                        <!--    </td>-->
                                        <!--    <td><span>10/11/2022</span></td>-->
                                        <!--    <td><a href="#"><span class="  d-block fw-bold ">AE0123</span></a>-->
                                        <!--    <td>invoice receipt rejected</td>-->

                                        <!--    <td>-->
                                        <!--        <a href="receipt-rejected.html"><i class="fa fa-eye"-->
                                        <!--                aria-hidden="true"></i></a>-->
                                        <!--    </td>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                        <!--    <td><span>5</span>-->
                                        <!--    </td>-->
                                        <!--    <td><span>10/11/2022</span></td>-->
                                        <!--    <td><a href="#"><span class="  d-block fw-bold ">AE0123</span></a>-->
                                        <!--    <td>Survey report received</td>-->

                                        <!--    <td>-->
                                        <!--        <a href="report-received.html"><i class="fa fa-eye"-->
                                        <!--                aria-hidden="true"></i></a>-->
                                        <!--    </td>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                        <!--    <td><span>6</span>-->
                                        <!--    </td>-->
                                        <!--    <td><span>10/11/2022</span></td>-->
                                        <!--    <td><a href="#"><span class="  d-block fw-bold ">AE0123</span></a>-->
                                        <!--    <td>Invoice received</td>-->

                                        <!--    <td>-->
                                        <!--        <a href="invoice-received.html"><i class="fa fa-eye"-->
                                        <!--                aria-hidden="true"></i></a>-->
                                        <!--    </td>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                        <!--    <td><span>7</span>-->
                                        <!--    </td>-->
                                        <!--    <td><span>10/11/2022</span></td>-->
                                        <!--    <td><a href="#"><span class="  d-block fw-bold ">AE0123</span></a>-->
                                        <!--        <td>Invoice received</td>-->

                                        <!--    <td>-->
                                        <!--        <a href="invoice-received.html"><i class="fa fa-eye"-->
                                        <!--                aria-hidden="true"></i></a>-->
                                        <!--    </td>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                        <!--    <td><span>8</span>-->
                                        <!--    </td>-->
                                        <!--    <td><span>10/11/2022</span></td>-->
                                        <!--    <td><a href="#"><span class="  d-block fw-bold ">AE0123</span></a>-->
                                        <!--    <td>Invoice received</td>-->

                                        <!--    <td>-->
                                        <!--        <a href="invoice-received.html"><i class="fa fa-eye"-->
                                        <!--                aria-hidden="true"></i></a>-->
                                        <!--    </td>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                        <!--    <td><span>9</span>-->
                                        <!--    </td>-->
                                        <!--    <td><span>10/11/2022</span></td>-->
                                        <!--    <td><a href="#"><span class="  d-block fw-bold ">AE0123</span></a>-->
                                        <!--    <td>Invoice received</td>-->
                                        <!--    <td>-->
                                        <!--        <a href="invoice-received.html"><i class="fa fa-eye"-->
                                        <!--                aria-hidden="true"></i></a>-->
                                        <!--    </td>-->
                                        <!--</tr>-->
                                        <!--<tr>-->
                                        <!--    <td><span>10</span>-->
                                        <!--    </td>-->
                                        <!--    <td><span>10/11/2022</span></td>-->
                                        <!--    <td><a href="#"><span class="  d-block fw-bold ">AE0123</span></a>-->
                                        <!--    <td>Invoice received</td>-->

                                        <!--    <td>-->
                                        <!--        <a href="invoice-received.html"><i class="fa fa-eye"-->
                                        <!--                aria-hidden="true"></i></a>-->
                                        <!--    </td>-->
                                        <!--</tr>-->
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <!--<div class=" pagination-box">-->
                    <!--    <nav class="ms-auto me-auto " aria-label="...">-->
                    <!--        <ul class="pagination pagination-primary">-->
                    <!--            <li class="page-item disabled"><a class="page-link"-->
                    <!--                    href="javascript:void(0)" tabindex="-1">Previous</a>-->
                    <!--            </li>-->
                    <!--            <li class="page-item"><a class="page-link" href="javascript:void(0)">1</a>-->
                    <!--            </li>-->
                    <!--            <li class="page-item active"><a class="page-link"-->
                    <!--                    href="javascript:void(0)">2 <span-->
                    <!--                        class="sr-only">(current)</span></a></li>-->
                    <!--            <li class="page-item"><a class="page-link" href="javascript:void(0)">3</a>-->
                    <!--            </li>-->
                    <!--            <li class="page-item"><a class="page-link"-->
                    <!--                    href="javascript:void(0)">Next</a></li>-->
                    <!--        </ul>-->
                    <!--    </nav>-->
                    <!--</div>-->

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
    <script src="http://code.jquery.com/jquery-2.1.4.min.js"></script>
        <script src="{{URL::asset('assets/js/jQuery-plugin-progressbar.js')}}"></script>
        <script type="text/javascript">
            $(".progress-bar-cust").loading();
        </script>
@endsection