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

                <div class="card-body bodhgt">
                    <section class="single-section small-section bg-inner">

                        <div class="row">
                            <div class="col-12 col-md-6">
                                <div class="description-section tab-section">
                                    <center>
                                        <div class="detail-img">
                                            <img src="{{URL('public/admin/assets/images/05.jpg')}}"
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
                                                <p class="top-space">Hydrographic Survey Wing is providing underwater videography for capturing images and videos under water.  The user should be provide information about the location and type of water body to be captured</p>
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    <!-- section end -->
                    <div style="text-align: right; float: right">
                        <a href="{{url('/customer/underwater_videography/create')}}" class="btn align-items-center btn-theme"> Accept </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@include('includes.customer_footer')
</div>
@endsection