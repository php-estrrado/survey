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
            <div class="card-header-title card-header">
              <h5>Bathymetry Survey</h5>
            </div>
            <div class="card-body">
              <div class="row">
                <section class="signup-step-container">
                  <div class="container">
                    <div class="row d-flex justify-content-center">
                      <div class="col-md-12">
                        <div class="wizard">
                          <div class="wizard-inner">
                            <div class="connecting-line"></div>
                            <ul class="nav nav-tabs" role="tablist">
                              <li role="presentation" class="active">
                                <a href="#step1" data-toggle="tab" aria-controls="step1" role="tab" aria-expanded="true"><span class="round-tab">1 </span> <i>Step 1</i></a>
                              </li>
                              <li role="presentation">
                                <a href="#step2" data-toggle="tab" aria-controls="step2" role="tab" aria-expanded="false"><span class="round-tab">2</span> <i>Step 2</i></a>
                              </li>
                              <li role="presentation">
                                <a href="#step4" data-toggle="tab" aria-controls="step4" role="tab"><span class="round-tab">3</span> <i>Step 3</i></a>
                              </li>
                            </ul>
                          </div>                            
                          <form action="{{url('/customer/bathymetry_survey/save')}}" method="post" id="bathymetry_survey" class="theme-form">
                            @csrf
                            <div class="tab-content" id="main_form">
                              <div class="tab-pane active" role="tabpanel" id="step1">
                                <h4 class="text-center">Basic Details</h4>
                                <div class="row">
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="fname">Name</label>
                                    <input class="form-control" type="text" name="fname" id="fname" placeholder="Name" value="{{ old('fname') }}">
                                    <div id="fname_error"></div>
                                    @error('fname')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="designation">Designation</label>
                                    <input class="form-control" type="text" name="designation" id="designation" placeholder="Designation" value="{{ old('designation') }}">
                                    <div id="designation_error"></div>
                                    @error('designation')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="sector">Whether Govt./Private/ Public Sector undertaking/person</label>
                                    <select class="js-example-basic-single col-sm-12" name="sector" id="sector">
                                      <option value="government" {{ old('sector') == 'government' ? 'selected' : '' }}>Government</option>
                                      <option value="private" {{ old('sector') == 'private' ? 'selected' : '' }}>Private</option>
                                      <option value="public" {{ old('sector') == 'public' ? 'selected' : '' }}>Public Sector</option>
                                      <option value="person" {{ old('sector') == 'person' ? 'selected' : '' }}>Person</option>
                                    </select>
                                    <div id="sector_error"></div>
                                    @error('sector')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="department">Name of Department (for government departments)</label>
                                    <input class="form-control" type="text" placeholder="Name of Department" name="department" id="department" value="{{ old('department') }}">
                                    <div id="department_error"></div>
                                    @error('department')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                      <label class="form-label-title mt-3" for="firm">Type of organization</label>
                                      <!--<input class="form-control" type="text" placeholder="Type of organization" name="firm" id="firm" value="{{ old('firm') }}">-->
                                      {{ Form::select('firm', $org_types, null,['id'=>'firm','class'=>'form-control']); }}
                                      <div id="firm_error"></div>
                                      @error('firm')
                                        <p style="color: red">{{ $message }}</p>
                                      @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="others">Others</label>
                                    <input class="form-control" type="text" placeholder="Others" name="others" id="others" value="{{ old('others') }}">
                                    <div id="others_error"></div>
                                      @error('others')
                                        <p style="color: red">{{ $message }}</p>
                                      @enderror
                                  </div>
                                  <div class="col-sm-6">
                                      <label class="form-label-title mt-3" for="purpose">Purpose</label>
                                      <input class="form-control" type="text" placeholder="Name of project or specify the purpose" name="purpose" id="purpose" value="{{ old('purpose') }}">
                                      <div id="purpose_error"></div>
                                      @error('purpose')
                                        <p style="color: red">{{ $message }}</p>
                                      @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <input type="hidden" name="service" value="{{ $service }}">
                                    <label class="form-label-title mt-3" for="service">Additional service needed</label>
                                    <select class="js-example-basic-single col-sm-12 multiselect" name="additional_services[]" id="additional_services" multiple="multiple" >
                                      @if($services && count($services)>0)
                                        @foreach($services as $service)
                                          <option value="{{$service['id']}}" {{ old('service') == $service['id'] ? 'selected' : '' }}>{{$service['service_name']}}</option>
                                        @endforeach
                                      @endif
                                    </select>
                                    <div id="service_error"></div>
                                    @error('additional_services')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-12">
                                    <label class="form-label-title mt-3" for="description">Brief description of type of work</label>
                                    <textarea id="description" name="description" placeholder="Location, scale, format of result required" rows="4" style="width:100%;">{{ old('description') }}</textarea>
                                    <div id="description_error"></div>
                                    @error('description')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                </div>
                                <ul class="list-inline pull-right">
                                  <li><button type="button" class="default-btn next-step">Continue</button></li>
                                </ul>
                              </div>
                              <div class="tab-pane" role="tabpanel" id="step2">
                                <h4 class="text-center">Location</h4>
                                <div class="row">
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="state">State</label>
                                    <select class="js-example-basic-single col-sm-12" name="state" id="state" onchange="getCity()">
                                      <option value="">Select</option>
                                      @if($states && count($states)>0)
                                        @foreach($states as $state)
                                          <option value="{{$state['id']}}" {{ old('state') == $state['id'] ? 'selected' : '' }}>{{$state['state_name']}}</option>
                                        @endforeach  
                                      @endif
                                    </select>
                                    <div id="state_error"></div>
                                    @error('state')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="district">District</label>
                                    <select class="js-example-basic-single col-sm-12" name="district" id="district">
                                      <option value="ST">select</option>
                                    </select>
                                    <div id="district_error"></div>
                                    @error('district')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="place">Name of Place</label>
                                    <input class="form-control" type="text" placeholder="Place" name="place" id="place" value="{{ old('place') }}">
                                    <div id="place_error"></div>
                                    @error('place')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="survey_area">Survey Area Location</label>
                                      <input class="form-control" type="text" placeholder="Survey Area Location" name="survey_area" id="survey_area" value="{{ old('survey_area') }}">
                                    </div>
                                    <div id="survey_area_error"></div>
                                    @error('survey_area')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>

                                   <div class="col-sm-6">
                                   
                                    <label class="form-label-title mt-3" for="service">Data Required</label>
                                    <select class="js-example-basic-single col-sm-12 multiselect" name="data_required[]" id="data_required" multiple="multiple" >
                                      
                                          <option value="sounding" {{ old('data_required') == 'sounding' ? 'selected' : '' }}>Sounding</option>
                                          <option value="current_meter_survey" {{ old('data_required') == 'current_meter_survey' ? 'selected' : '' }}>Current meter survey</option>
                                          <option value="bottom_profile" {{ old('data_required') == 'bottom_profile' ? 'selected' : '' }}>Bottom profile</option>
                                          <option value="velocity" {{ old('data_required') == 'velocity' ? 'selected' : '' }}>Velocity</option>
                                          <option value="bottom_sample_collection" {{ old('data_required') == 'bottom_sample_collection' ? 'selected' : '' }}>Bottom sample collection</option>
                                          <option value="tide_data" {{ old('data_required') == 'tide_data' ? 'selected' : '' }}>Tide data</option>
                                        
                                    </select>
                                    <div id="service_error"></div>
                                    @error('data_required')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>

                                  <div class="col-sm-6">
                          
                                    <label class="form-label-title mt-3" for="service">Method/Equipment for Data Collection </label>
                                    <select class="js-example-basic-single col-sm-12 multiselect" name="data_collection_equipments[]" id="data_collection_equipments" multiple="multiple" >
                                      @if($data_collection && count($data_collection)>0)
                                        @foreach($data_collection as $data_collections)
                                          <option value="{{$data_collections->id}}" {{ old('data_collection_equipments') == $data_collections->id ? 'selected' : '' }}>{{$data_collections->title}}</option>
                                        @endforeach
                                      @endif
                                    </select>
                                    <div id="service_error"></div>
                                    @error('data_collection_equipments')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for=""><b>Location Coordinates</b></label>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="lattitude">Lattitude</label>
                                      <input class="form-control" type="text" placeholder="Lattitude, deg, min, sec" name="lattitude" id="lattitude" value="{{ old('lattitude') }}">
                                    </div>
                                    <div id="depth_at_saples_collected_error"></div>
                                    @error('lattitude')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="longitude">Longitude </label>
                                      <input class="form-control" type="text" placeholder="Longitude , deg, min, sec" name="longitude" id="longitude" value="{{ old('longitude') }}">
                                    </div>
                                    <div id="depth_at_saples_collected_error"></div>
                                    @error('depth_at_saples_collected')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="x_coordinates">X Coordinates </label>
                                      <input class="form-control" type="text" placeholder="X Coordinates" name="x_coordinates" id="x_coordinates" value="{{ old('x_coordinates') }}">
                                    </div>
                                    <div id="depth_at_saples_collected_error"></div>
                                    @error('x_coordinates')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="y_coordinates">Y Coordinates </label>
                                      <input class="form-control" type="text" placeholder="Y Coordinates" name="y_coordinates" id="y_coordinates" value="{{ old('y_coordinates') }}">
                                    </div>
                                    <div id="depth_at_saples_collected_error"></div>
                                    @error('y_coordinates')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  
                                </div>
                                <ul class="list-inline pull-right">
                                  <li><button type="button" class="default-btn prev-step">Back</button></li>
                                  <li><button type="button" class="default-btn next-step">Continue</button></li>
                                </ul>
                              </div>
                              <div class="tab-pane" role="tabpanel" id="step4">
                                <h4 class="text-center">Details</h4>
                                <div class="row">
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="type_of_waterbody">Type of Waterbody</label>
                                    <select id="menu-type" class="js-example-basic-single col-sm-12" name="type_of_waterbody" id="type_of_waterbody">
                                      <option value="sea" {{ old('type_of_waterbody') == 'sea' ? 'selected' : '' }}>Sea</option>
                                      <option value="river" {{ old('type_of_waterbody') == 'river' ? 'selected' : '' }}>River</option>
                                      <option value="lake" {{ old('type_of_waterbody') == 'lake' ? 'selected' : '' }}>Lake</option>
                                      <option value="pond" {{ old('type_of_waterbody') == 'pond' ? 'selected' : '' }}>Pond</option>
                                      <option value="canal" {{ old('type_of_waterbody') == 'canal' ? 'selected' : '' }}>Canal</option>
                                            <option value="reservoir" {{ old('type_of_waterbody') == 'reservoir' ? 'selected' : '' }}>Reservoir</option>
                                            <option value="backwater" {{ old('type_of_waterbody') == 'backwater' ? 'selected' : '' }}>Backwater</option>
                                    </select>
                                    <div id="type_of_waterbody_error"></div>
                                    @error('type_of_waterbody')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="area_of_survey">Area Of Survey</label>
                                      <input class="form-control" type="text" placeholder="Area Of Survey" name="area_of_survey" id="area_of_survey" value="{{ old('area_of_survey') }}">
                                    </div>
                                    <div id="area_of_survey_error"></div>
                                    @error('area_of_survey')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="scale_of_survey">Scale of Survey</label>
                                    <input class="form-control" type="number" placeholder="Scale Of Survey (metres)" name="scale_of_survey" id="scale_of_survey" value="{{ old('scale_of_survey') }}">
                                    <div id="scale_of_survey_error"></div>
                                    @error('scale_of_survey')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="service_to_be_conducted">When Service to be conducted</label>
                                      <input class="form-control" type="text" name="service_to_be_conducted" id="service_to_be_conducted" placeholder="When Service to be conducted" value="{{ old('service_to_be_conducted') }}">
                                    </div>
                                    <div id="service_to_be_conducted_error"></div>
                                    @error('service_to_be_conducted')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="interim_surveys_needed_infuture">Whether interim surveys are needed in future</label>
                                      <div>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="interim_surveys_needed_infuture" id="interim_surveys_needed_infuture1" value="yes" {{ old('interim_surveys_needed_infuture') == "yes" ? 'checked' : '' }}>
                                          <label class="form-check-label" for="interim_surveys_needed_infuture1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="interim_surveys_needed_infuture" id="interim_surveys_needed_infuture2" value="no" {{ old('interim_surveys_needed_infuture') == "no" ? 'checked' : '' }}>
                                          <label class="form-check-label" for="interim_surveys_needed_infuture2">No</label>
                                        </div>
                                      </div>
                                    </div>
                                    <div id="interim_surveys_needed_infuture_error"></div>
                                    @error('interim_surveys_needed_infuture')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="benchmark_chart_datum">Whether Bench mark/Chart Datum available in the area</label>
                                      <div>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="benchmark_chart_datum" id="benchmark_chart_datum1" value="yes" {{ old('benchmark_chart_datum') == "yes" ? 'checked' : '' }}>
                                          <label class="form-check-label" for="benchmark_chart_datum1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="benchmark_chart_datum" id="benchmark_chart_datum2" value="no" {{ old('benchmark_chart_datum') == "no" ? 'checked' : '' }}>
                                          <label class="form-check-label" for="benchmark_chart_datum2">No</label>
                                        </div>
                                      </div>
                                    </div>
                                    <div id="benchmark_chart_datum_error"></div>
                                    @error('benchmark_chart_datum')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="drawing_maps">Existing drawings/maps showing the location</label>
                                      <div class="dropzone" id="singleFileUpload">
                                        <div class="dz-message needsclick"><i class="icon-cloud-up"></i>
                                          <h6>Drop files here or click to upload.</h6>
                                          <spanclass="note needsclick">(This is just a
                                            demo dropzone. Selected files are <strong>not</strong>
                                            actually uploaded.)
                                          </span>
                                        </div>
                                      </div>
                                    </div>
                                  </div>
                                </div>
                                <ul class="list-inline pull-right">
                                  <li><button type="button" class="default-btn prev-step">Back</button></li>
                                  <li><button type="submit" name="submit" value="submit" class="default-btn next-step">Submit</button></li>
                                </ul>
                              </div>
                              <div class="clearfix"></div>
                            </div>
                          </form>
                        </div>
                      </div>
                    </div>
                  </div>
                </section>
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
@section('js')
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>

  <script type="text/javascript">
    // ------------step-wizard-------------
    $(document).ready(function () {
      $(".nav-tabs > li a[title]").tooltip();
      //Wizard
      $('a[data-toggle="tab"]').on("shown.bs.tab", function (e) {
        var target = $(e.target);
        if (target.parent().hasClass("disabled")) {
          return false;
        }
      });
      $(".next-step").click(function (e) {
        var active = $(".wizard .nav-tabs li.active");
        active.next().removeClass("disabled");
        nextTab(active);
      });
      $(".prev-step").click(function (e) {
        var active = $(".wizard .nav-tabs li.active");
        prevTab(active);
      });
    });

    function nextTab(elem) {
      $(elem).next().find('a[data-toggle="tab"]').click();
    }
    function prevTab(elem) {
      $(elem).prev().find('a[data-toggle="tab"]').click();
    }

    $(".nav-tabs").on("click", "li", function () {
      $(".nav-tabs li.active").removeClass("active");
      $(this).addClass("active");
    });
  </script>
  <script type="text/javascript">
    function getCity()
    {
      var state_id = $('#state').val();
      console.log(state_id);

      $.ajax({
        url: "{{url('/customer/getCity')}}",
        type: "post",
        data: {
          "_token": "{{ csrf_token() }}",
          "state_id": state_id,
        },
        success: function(result)
        {
          $("#district").html(result);
        }
      });
    }

    $(document).ready(function(){
      $('#service_to_be_conducted').datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        startDate: '0',
        autoclose: true
      });
    }); 
  </script>
  <script type="text/javascript">
    $("#bathymetry_survey").validate({
      rules: {
        fname: {
          required: true,
        },
        designation: {
          required: true,
        },
        sector: {
          required: true,
        },
        department: {
          required: true,
        },
        firm: {
          required: true,
        },
        purpose: {
          required: true,
        },
        service: {
          required: true,
        },
        description: {
          required: true,
        },
        state: {
          required: true,
        },
        district: {
          required: true,
        },
        place: {
          required: true,
        },
        survey_area: {
          required: true,
        },
        type_of_waterbody: {
          required: true,
        },
        area_of_survey: {
          required: true,
        },
        scale_of_survey: {
          required: true,
        },
        service_to_be_conducted: {
          required: true,
        },
        interim_surveys_needed_infuture: {
          required: true,
        },
        benchmark_chart_datum: {
          required: true,
        }
      },
      messages: {
        fname: {
          required: "Please enter Name",
        },
        designation: {
          required: "Please enter Designation",
        },
        sector: {
          required: "Please enter Sector",
        },
        department: {
          required: "Please enter Department",
        },
        firm: {
          required: "Please enter Type of organization",
        },
        purpose: {
          required: "Please enter Purpose",
        },
        service: {
          required: "Please enter Service",
        },
        description: {
          required: "Please enter Description",
        },
        state: {
          required: "Please enter State",
        },
        district: {
          required: "Please enter District",
        },
        place: {
          required: "Please enter Place",
        },
        survey_area: {
          required: "Please enter Survey Area Location",
        },
        type_of_waterbody: {
          required: "Please enter Type of Waterbody",
        },
        area_of_survey: {
          required: "Please enter Area Of Survey",
        },
        scale_of_survey: {
          required: "Please enter Scale of Survey",
        },
        service_to_be_conducted: {
          required: "Please enter When Service to be conducted",
        },
        interim_surveys_needed_infuture: {
          required: "Please select Whether interim surveys are needed in future",
        },
        benchmark_chart_datum: {
          required: "Please select Whether Bench mark/Chart Datum available in the area",
        }
      },
      errorPlacement: function (error, element) 
      {
        if (element.attr("name") == "fname")
        {
          error.appendTo("#fname_error");
        }
        else if (element.attr("name") == "designation")
        {
          error.appendTo("#designation_error");
        }
        else if (element.attr("name") == "sector")
        {
          error.appendTo("#sector_error");
        }
        else if (element.attr("name") == "department")
        {
          error.appendTo("#department_error");
        }
        else if (element.attr("name") == "firm")
        {
          error.appendTo("#firm_error");
        }
        else if (element.attr("name") == "others")
        {
          error.appendTo("#others_error");
        }
        else if (element.attr("name") == "purpose")
        {
          error.appendTo("#purpose_error");
        }
        else if (element.attr("name") == "service")
        {
          error.appendTo("#service_error");
        }
        else if (element.attr("name") == "description")
        {
          error.appendTo("#description_error");
        }
        else if (element.attr("name") == "state")
        {
          error.appendTo("#state_error");
        }
        else if (element.attr("name") == "district")
        {
          error.appendTo("#district_error");
        }
        else if (element.attr("name") == "place")
        {
          error.appendTo("#place_error");
        }
        else if (element.attr("name") == "survey_area")
        {
          error.appendTo("#survey_area_error");
        }
        else if (element.attr("name") == "type_of_waterbody")
        {
          error.appendTo("#type_of_waterbody_error");
        }
        else if (element.attr("name") == "area_of_survey")
        {
          error.appendTo("#area_of_survey_error");
        }
        else if (element.attr("name") == "scale_of_survey")
        {
          error.appendTo("#scale_of_survey_error");
        }
        else if (element.attr("name") == "service_to_be_conducted")
        {
          error.appendTo("#service_to_be_conducted_error");
        }
        else if (element.attr("name") == "interim_surveys_needed_infuture")
        {
          error.appendTo("#interim_surveys_needed_infuture_error");
        }
        else if (element.attr("name") == "benchmark_chart_datum")
        {
          error.appendTo("#benchmark_chart_datum_error");
        }
        else
        {
          error.insertAfter(element)
        }
      },
    });
  </script>
@endsection