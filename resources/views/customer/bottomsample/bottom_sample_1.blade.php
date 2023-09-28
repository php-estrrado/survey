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
                    <!-- <form class="d-inline-flex">
                        <button class="btn align-items-center btn-theme me-3"> Request Survey
                        </button>
                    </form> -->
                </div>

                <div class="card-body">
                    <section class="single-section small-section bg-inner">

                        <div class="row">
                            <div class="col-12">
                                <div class="description-section tab-section">
                                    <center>
                                        <div class="detail-img">
                                            <img src="{{URL('public/admin/assets/images/02.jpg')}}"
                                                class="img-fluid blur-up lazyload" alt="">
                                        </div>
                                    </center>
                                    <div class="description-details tab-content mt-4">
                                        <div class="menu-part about tab-pane fade show active"
                                            id="highlight">
                                            <div class="about-sec">
                                                <p class="top-space">Bottom sediment sampling helps to learn about the mineral and chemical composition of floor of sea and other water bodies Hydrographic Survey Wing is capable of collection of samples only, (no analysis is done).  The location, depth of sampling, quantity etc. should be provided while requesting a bottom sample collection services</p>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </section>
                    <!-- section end -->
                    <div style="text-align: right; float: right">
                        <a href="{{url('/customer/bottomsample/create')}}" class="btn align-items-center btn-theme"> Accept </a>
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