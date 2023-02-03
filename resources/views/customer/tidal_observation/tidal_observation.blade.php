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
                            <div class="col-6">
                                <div class="description-section tab-section">
                                    <center>
                                        <div class="detail-img">
                                            <img src="{{URL('public/admin/assets/images/01.jpg')}}"
                                                class="img-fluid blur-up lazyload" alt="">
                                        </div>
                                    </center>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="description-section tab-section">
                                    <div class="description-details tab-content mt-4">
                                        <div class="menu-part about tab-pane fade show active"
                                            id="highlight">
                                            <div class="about-sec">
                                                <p class="top-space">Tidal observations mean continuous observations of regular eustatic sea level changes caused by tide generating forces such as sun and moon and atmospheric pressure, winds and more.  Tidal observation data is used for the purpose of determination of datum planes, establishment of tidal bench marks, publication of tide tables, maintenance of records of rise and fall of tide, study of tides and tidal phenomena etc prior to request in tidal observation data the user should be able to provide purpose, location, period and bench mark details if available.</p>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- section end -->
                    <div style="text-align: right; float: right">
                        <a href="{{url('/customer/tidal_observation/create')}}" class="btn align-items-center btn-theme"> Accept </a>
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