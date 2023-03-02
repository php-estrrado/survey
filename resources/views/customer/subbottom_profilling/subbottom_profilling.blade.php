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
                        <h5>{{$title}}</h5>
                    </div>
                    <form class="d-inline-flex">
                        <button class="btn align-items-center btn-theme me-3"> Request Survey
                        </button>
                    </form>
                </div>

                <div class="card-body">
                    <section class="single-section small-section bg-inner">

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="description-section tab-section">
                                    <center>
                                        <div class="detail-img">
                                            <img src="{{URL('public/admin/assets/images/09.jpg')}}"
                                                class="img-fluid blur-up lazyload" alt="">
                                        </div>
                                    </center>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="description-section tab-section">
                                    <div class="description-details tab-content mt-4">
                                        <div class="menu-part about tab-pane fade show active"
                                            id="highlight">
                                            <div class="about-sec">
                                                <p class="top-space">Sub bottom profiling systems identify and measure various marine sediment layers that exist below the sediment/water interface.  It can be useful to detect hard substrate that has been covered by sedimentation.  Data can be provided as video records.  The location and line interval of scanning should provide by the user before requesting the data.</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- section end -->
                    <div style="text-align: right; float: right">
                        <a href="{{url('/customer/subbottom_profilling/create')}}" class="btn align-items-center btn-theme"> Accept </a>
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