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

                <div class="card-body">

                    <div class="row">

                       <div class="col-12">
                         <div id="carouselExampleCaptions" class="carousel slide" data-ride="carousel">
                            <!--<ol class="carousel-indicators">-->
                            <!--  <li data-target="#carouselExampleCaptions" data-slide-to="0" class="active"></li>-->
                            <!--  <li data-target="#carouselExampleCaptions" data-slide-to="1"></li>-->
                            <!--  <li data-target="#carouselExampleCaptions" data-slide-to="2"></li>-->
                            <!--</ol>-->
                            <div class="carousel-inner">
                              <div class="carousel-item active">
                                <img src="{{URL('/public/admin/assets/images/banner.jpg')}}" class="d-block w-100" alt="...">
                              </div>
                            </div>
                            <!--<a class="carousel-control-prev" href="#carouselExampleCaptions" role="button" data-slide="prev">-->
                            <!--  <span class="carousel-control-prev-icon" aria-hidden="true"></span>-->
                            <!--  <span class="sr-only">Previous</span>-->
                            <!--</a>-->
                            <!--<a class="carousel-control-next" href="#carouselExampleCaptions" role="button" data-slide="next">-->
                            <!--  <span class="carousel-control-next-icon" aria-hidden="true"></span>-->
                            <!--  <span class="sr-only">Next</span>-->
                            <!--</a>-->
                          </div>
                       </div>

                    </div>

                </div>


            </div>



        </div>
    </div>
</div>

<!-- Container-fluid starts-->
<div class="container-fluid">
    <div class="row">
        <!-- chart caard section start -->
        <div class="col-sm-6 col-xxl-3 col-lg-3">
            <div class="b-b-primary border-5 border-0 card o-hidden">
                <div class="custome-1-bg b-r-4 card-body">
                    <div class="media align-items-center static-top-widget">
                        <div class="media-body p-0">
                            <span class="m-0">Total Ongoing Services</span>
                            <h4 class="mb-0 counter">{{$ongoing_surveys}}</h4>
                        </div>
                        <div class="align-self-center text-center"><i data-feather="database"></i></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xxl-3 col-lg-3">
            <div class="b-b-danger border-5  border-0 card o-hidden">
                <div class=" custome-2-bg  b-r-4 card-body">
                    <div class="media static-top-widget">
                        <div class="media-body p-0"><span class="m-0">Total Pending Requests</span>
                            <h4 class="mb-0 counter">{{$pending_surveys}}</h4>
                        </div>
                        <div class="align-self-center text-center"><i data-feather="shopping-bag"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xxl-3 col-lg-3">
            <div class="b-b-secondary border-5 border-0  card o-hidden">
                <div class=" custome-3-bg b-r-4 card-body">
                    <div class="media static-top-widget">
                        <div class="media-body p-0"><span class="m-0">Total Rejected Requests</span>
                            <h4 class="mb-0 counter">{{$rejected_surveys}}</h4>
                        </div>
                        <div class="align-self-center text-center"><i data-feather="message-circle"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-xxl-3 col-lg-3">
            <div class="b-b-secondary border-5 border-0  card o-hidden">
                <div class=" custome-3-bg b-r-4 card-body">
                    <div class="media static-top-widget">
                        <div class="media-body p-0"><span class="m-0">Total Invoice Received </span>
                            <h4 class="mb-0 counter">{{$invoice_recieved}}</h4>
                        </div>
                        <div class="align-self-center text-center"><i data-feather="shopping-bag"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Container-fluid Ends-->

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header-title card-header">
                    <h5>Services</h5>
                </div>
                <div class="card-body">

                    <div class="row">
                       <div class="col-xxl-4 col-md-4">
                            <div class="card card-blog">
                                <div class="card-image">
                                    <a href="#"> <img class="img" src="{{URL::asset('public/admin/assets/images/00.jpg')}}"> </a>
                                    <div class="ripple-cont"></div>
                                </div>
                                <div class="table">
                                    <h4 class="card-caption">
                                <a href="#">Hydrographic Survey</a>
                                </h4>
                                    <p class="card-description"> Hydrographic Surveying is an important civil engineering service that determines the physical features of an underwater area.  The user is advised to keep the following information’s ready before beginning of service requesting.  Purpose of study, location, type of water body, scale (line spacing), tentative data, Bench mark details and drawings or maps if available are the pre requisites.  The result of Hydrographic surveying will be provided in the form of bathy metric charts or xyz data in some cases. </p>
                                    <div class="ftr">
                                        <!--<div class="author">-->
                                        <!--    <a href="#"><span>Read More</span> </a>-->
                                        <!--</div>-->
                                        <div class="btn btn-theme">
                                            <a href="{{url('/customer/hydrographic_survey')}}"><span>Request Survey</span> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       </div>

                       <div class="col-xxl-4 col-md-4">
                            <div class="card card-blog">
                                <div class="card-image">
                                    <a href="#"> <img class="img" src="{{URL::asset('public/admin/assets/images/01.jpg')}}"> </a>
                                    <div class="ripple-cont"></div>
                                </div>
                                <div class="table">
                                    <h4 class="card-caption">
                                <a href="#">Tidal Observation</a>
                                </h4>
                                    <p class="card-description"> Tidal observations mean continuous observations of regular eustatic sea level changes caused by tide generating forces such as sun and moon and atmospheric pressure, winds and more.  Tidal observation data is used for the purpose of determination of datum planes, establishment of tidal bench marks, publication of tide tables, maintenance of records of rise and fall of tide, study of tides and tidal phenomena etc prior to request in tidal observation data the user should be able to provide purpose, location, period and bench mark details if available. </p>
                                    <div class="ftr">
                                        <!--<div class="author">-->
                                        <!--    <a href="#"><span>Read More</span> </a>-->
                                        <!--</div>-->
                                        <div class="btn btn-theme">
                                            <a href="{{url('/customer/tidal_observation')}}"><span>Request Survey</span> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                       </div>

                       <div class="col-xxl-4 col-md-4">
                            <div class="card card-blog">
                                <div class="card-image">
                                    <a href="#"> <img class="img" src="{{URL::asset('public/admin/assets/images/02.jpg')}}"> </a>
                                    <div class="ripple-cont"></div>
                                </div>
                                <div class="table">
                                    <h4 class="card-caption">
                                <a href="#">Bottom Sample Coll..</a>
                                </h4>
                                    <p class="card-description"> Bottom sediment sampling helps to learn about the mineral and chemical composition of floor of sea and other water bodies Hydrographic Survey Wing is capable of collection of samples only, (no analysis is done).  The location, depth of sampling, quantity etc. should be provided while requesting a bottom sample collection services.. </p>
                                    <div class="ftr">
                                        <!--<div class="author">-->
                                        <!--    <a href="#"><span>Read More</span> </a>-->
                                        <!--</div>-->
                                        <div class="btn btn-theme">
                                            <a href="{{url('/customer/bottomsample')}}"><span>Request Survey</span> </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                      </div>

                      <div class="col-xxl-4 col-md-4">
                        <div class="card card-blog">
                            <div class="card-image">
                                <a href="#"> <img class="img" src="{{URL::asset('public/admin/assets/images/03.jpg')}}"> </a>
                                <div class="ripple-cont"></div>
                            </div>
                            <div class="table">
                                <h4 class="card-caption">
                            <a href="#">Dredging Survey</a>
                            </h4>
                                <p class="card-description"> Hydrographic Survey Wing conducts pre, post and intermediate dredging surveys and the data collected is used for volume estimation.  The user should specify the location, area to be dredged (boundaries) need for volume estimation and interim surveys.  While requesting the service mark details, User can also opt for method of volume computation  </p>
                                <div class="ftr">
                                    <!--<div class="author">-->
                                    <!--    <a href="#"><span>Read More</span> </a>-->
                                    <!--</div>-->
                                    <div class="btn btn-theme">
                                        <a href="{{url('/customer/dredging_survey')}}"><span>Request Survey</span> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>

                     <div class="col-xxl-4 col-md-4">
                        <div class="card card-blog">
                            <div class="card-image">
                                <a href="#"> <img class="img" src="{{URL::asset('public/admin/assets/images/04.jpg')}}"> </a>
                                <div class="ripple-cont"></div>
                            </div>
                            <div class="table">
                                <h4 class="card-caption">
                            <a href="#">Hydrographic Data..</a>
                            </h4>
                                <p class="card-description"> Hydrographic Survey Wing has a vast collection of Hydrographic data from previous years.  Which can be made available in the form of bathymetric charts or data in various formats like pdf, xyz etc., and the user can check the availability of data by visiting the HYMSYS portal by using the following link. <a href="www.hymsys.hsw.kerala.gov.in" target="_blank">www.hymsys.hsw.kerala.gov.in</a> . </p>
                                <div class="ftr">
                                    <!--<div class="author">-->
                                    <!--    <a href="#"><span>Read More</span> </a>-->
                                    <!--</div>-->
                                    <div class="btn btn-theme">
                                        <a href="{{url('/customer/hydrographic_data')}}"><span>Request Survey</span> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>

                     <div class="col-xxl-4 col-md-4">
                        <div class="card card-blog">
                            <div class="card-image">
                                <a href="#"> <img class="img" src="{{URL::asset('public/admin/assets/images/05.jpg')}}"> </a>
                                <div class="ripple-cont"></div>
                            </div>
                            <div class="table">
                                <h4 class="card-caption">
                            <a href="#">Underwater Videogr..</a>
                            </h4>
                                <p class="card-description"> Hydrographic Survey Wing is providing underwater videography for capturing images and videos under water.  The user should be provide information about the location and type of water body to be captured. </p>
                                <div class="ftr">
                                    <!--<div class="author">-->
                                    <!--    <a href="#"><span>Read More</span> </a>-->
                                    <!--</div>-->
                                    <div class="btn btn-theme">
                                        <a href="{{url('/customer/underwater_videography')}}"><span>Request Survey</span> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>

                     <div class="col-xxl-4 col-md-4">
                        <div class="card card-blog">
                            <div class="card-image">
                                <a href="#"> <img class="img" src="{{URL::asset('public/admin/assets/images/06.jpg')}}"> </a>
                                <div class="ripple-cont"></div>
                            </div>
                            <div class="table">
                                <h4 class="card-caption">
                            <a href="#">Current Meter Obser..</a>
                            </h4>
                                <p class="card-description"> Current meter are sensors that measure the rate of flow of water Hydrographic Survey Wing provides current meter observations taken as a part of bathymetric data collection.  The prerequisites for requesting the current meter observation data are information about location, type of water body and period of observation. </p>
                                <div class="ftr">
                                    <!--<div class="author">-->
                                    <!--    <a href="#"><span>Read More</span> </a>-->
                                    <!--</div>-->
                                    <div class="btn btn-theme">
                                        <a href="{{url('/customer/currentmeter_observation')}}"><span>Request Survey</span> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>

                     <div class="col-xxl-4 col-md-4">
                        <div class="card card-blog">
                            <div class="card-image">
                                <a href="#"> <img class="img" src="{{URL::asset('public/admin/assets/images/07.jpg')}}"> </a>
                                <div class="ripple-cont"></div>
                            </div>
                            <div class="table">
                                <h4 class="card-caption">
                            <a href="#">side scan sonar obse..</a>
                            </h4>
                                <p class="card-description"> Side scan sonar system are used for mapping the sea bed for a wide variety of purpose, including detection and identification of underwater wrecks, objects and bathy metric features.  Hydrographic Survey Wing is providing side scan sonar images & video record when requested.  The location and line interval for scanning should be provided by the user. </p>
                                <div class="ftr">
                                    <!--<div class="author">-->
                                    <!--    <a href="#"><span>Read More</span> </a>-->
                                    <!--</div>-->
                                    <div class="btn btn-theme">
                                        <a href="{{url('/customer/sidescanningsonar_survey')}}"><span>Request Survey</span> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>

                     <div class="col-xxl-4 col-md-4">
                        <div class="card card-blog">
                            <div class="card-image">
                                <a href="#"> <img class="img" src="{{URL::asset('public/admin/assets/images/08.jpg')}}"> </a>
                                <div class="ripple-cont"></div>
                            </div>
                            <div class="table">
                                <h4 class="card-caption">
                            <a href="#">Topographic Survey</a>
                            </h4>
                                <p class="card-description"> Hydrographic Survey Wing periodically conduct surveys for various Government departments.  The locations/area to be surveyed and tentative dates are planned prior to deciding the tentative survey program. </p>
                                <div class="ftr">
                                    <!--<div class="author">-->
                                    <!--    <a href="#"><span>Read More</span> </a>-->
                                    <!--</div>-->
                                    <div class="btn btn-theme">
                                        <a href="{{url('/customer/topographic_survey')}}"><span>Request Survey</span> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>

                     <div class="col-xxl-4 col-md-4">
                        <div class="card card-blog">
                            <div class="card-image">
                                <a href="#"> <img class="img" src="{{URL::asset('public/admin/assets/images/09.jpg')}}"> </a>
                                <div class="ripple-cont"></div>
                            </div>
                            <div class="table">
                                <h4 class="card-caption">
                            <a href="#">Sub Bottom Profiling</a>
                            </h4>
                                <p class="card-description"> Sub bottom profiling systems identify and measure various marine sediment layers that exist below the sediment/water interface.  It can be useful to detect hard substrate that has been covered by sedimentation.  Data can be provided as video records.  The location and line interval of scanning should provide by the user before requesting the data. </p>
                                <div class="ftr">
                                    <!--<div class="author">-->
                                    <!--    <a href="#"><span>Read More</span> </a>-->
                                    <!--</div>-->
                                    <div class="btn btn-theme">
                                        <a href="{{url('/customer/subbottom_profilling')}}"><span>Request Survey</span> </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                     </div>

                     <div class="col-xxl-4 col-md-4">
                            <div class="card card-blog">
                                <div class="card-image">
                                    <a href="#"> <img class="img" src="{{URL::asset('public/admin/assets/images/11.jpg')}}"> </a>
                                    <div class="ripple-cont"></div>
                                </div>
                                <div class="table">
                                    <h4 class="card-caption">
                                <a href="#">Bathymetry Survey</a>
                                </h4>
                                    <p class="card-description"> Hydrographic Surveying is an important civil engineering service that determines the physical features of an underwater area.  The user is advised to keep the following information’s ready before beginning of service requesting.  Purpose of study, location, type of water body, scale (line spacing), tentative data, Bench mark details and drawings or maps if available are the pre requisites.  The result of Hydrographic surveying will be provided in the form of bathy metric charts or xyz data in some cases. </p>
                                    <div class="ftr">
                                        <!--<div class="author">-->
                                        <!--    <a href="#"><span>Read More</span> </a>-->
                                        <!--</div>-->
                                        <div class="btn btn-theme">
                                            <a href="{{url('/customer/bathymetry_survey')}}"><span>Request Survey</span> </a>
                                        </div>
                                    </div>
                                </div>
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