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
                        <h5>Hydrographic Survey</h5>
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
                                        <img src="{{URL('public/admin/assets/images/00.jpg')}}"
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
                                                <p class="top-space">Hydrographic Surveying is an important civil engineering service that determines the physical features of an underwater area.  The user is advised to keep the following information’s ready before beginning of service requesting.  Purpose of study, location, type of water body, scale (line spacing), tentative data, Bench mark details and drawings or maps if available are the pre requisites.  The result of Hydrographic surveying will be provided in the form of bathy metric charts or xyz data in some cases.</p>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- section end -->
                    <div style="text-align: right; float: right">
                        <a href="{{url('/customer/hydrographic_survey/create')}}" class="btn align-items-center btn-theme"> Accept </a>
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