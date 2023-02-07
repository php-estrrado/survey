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
                            <div class="col-12">
                                <div class="description-section tab-section">
                                    <div class="detail-img">
                                        <img src="http://themes.pixelstrap.com/rica/backend/assets/images/tours/spain.jpg"
                                            class="img-fluid blur-up lazyload" alt="">
                                    </div>
                                    <div class="description-details tab-content mt-4">
                                        <div class="menu-part about tab-pane fade show active"
                                            id="highlight">
                                            <div class="about-sec">
                                                <p class="top-space">Hola Espana! The vibrant
                                                    country of Spain beckons for an
                                                    adventure that lets us explore the sights 'n'
                                                    sounds of this remarkable
                                                    destination. Visit architechturally brilliant
                                                    and culture-rich cities of Madrid,
                                                    Seville, Barcelona, Cordoba, Valencia on this
                                                    tour and have the experience of a
                                                    lifetime!</p>
                                            </div>
                                            <div class="row g-2">
                                                <div class="col-md-6">
                                                    <div class="about-sec">
                                                        <h4>inclusion</h4>
                                                        <ul>
                                                            <li>Return economy class airfare with
                                                                taxes</li>
                                                            <li>Barcelona to Prague Internal flight
                                                                ticket</li>
                                                            <li>2 Nights Stay With Breakfast At
                                                                Prague</li>
                                                            <li>2 Nights Stay With Breakfast At
                                                                Budapest</li>
                                                            <li>1 Night Stay With Breakfast At
                                                                Vienna</li>
                                                            <li>Normal Visa Charges of Schengen</li>
                                                            <li>5% GST</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="col-md-6 margin-up">
                                                    <div class="about-sec">
                                                        <h4>exclusion</h4>
                                                        <ul>
                                                            <li>Any Extra Sightseeing Which Is Not
                                                                Mentioned In The Itinerary</li>
                                                            <li>Overseas Travel Insurance & Personal
                                                                Expense Such As Mineral Water,
                                                                Laundry Etc</li>
                                                            <li>Personal expenses</li>
                                                            <li>Excess baggage charge</li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </section>
                    <!-- section end -->
                </div>

            </div>



        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">

                <div class="card-body">
                    <section class="single-section small-section bg-inner">

                        <div class="row">
                            <div class="col-12">
                                <div class="description-section tab-section">
                                    <div class="description-details tab-content mt-4">
                                        <div class="menu-part about tab-pane fade show active"
                                            id="highlight">

                                            <div class="about-sec ">
                                                <h6>Terms And Conditions
                                                </h6>
                                                <p>A road trip along Spain’s Mediterranean coast is
                                                    a guarantee of sunshine, lovely
                                                    beaches, and plenty of destinations with things
                                                    to see and do. We suggest
                                                    following the coastline at your own pace,
                                                    without a fixed timetable and with
                                                    room to improvise.We choose Barcelona as a
                                                    starting point because it’s a huge
                                                    transport hub. You might fancy heading north for
                                                    a couple of days to see the
                                                    Costa Brava (Girona): beautiful bays like Roses,
                                                    coves where the pine trees grow
                                                    right to the shoreline, large seaside resorts
                                                    and the fishing villages that once
                                                    inspired Dalí.</p>
                                                <h6>the history of spain's great civilisations</h6>
                                                <p>In Spain, you can get a history lesson while you
                                                    enjoy your holiday. Let us show
                                                    you places to visit where you can discover
                                                    milestones of human development, like
                                                    the earliest humans, the birth of art, and the
                                                    power of the great civilisations.
                                                </p>
                                                <h6>foodies, prepare to be enthused</h6>
                                                <p class="bottom-space">From tasty tapas to superb
                                                    seafood and traditional roasts,
                                                    food in Spain is all about making the most of
                                                    the best local produce.Whether
                                                    you're on a city break in Barcelona or Madrid,
                                                    or you've plumped for a
                                                    countryside or coastal retreat, Spanish food is
                                                    full of flavour and character.
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </section>
                    <button class="btn align-items-center btn-theme mt-3" data-bs-original-title="" title="" onclick="window.location.href = 'form1.html';"> Accept</button>
                    <!-- section end -->
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