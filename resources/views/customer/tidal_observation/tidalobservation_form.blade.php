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
              <h5>Tidal observation</h5>
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
                          <form action="{{url('/customer/tidal_observation/save')}}" method="post" id="tidal_observation" class="theme-form">
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
                                      <label class="form-label-title mt-3" for="tidal_area">Tidal area location</label>
                                      <input class="form-control" type="text" placeholder="Tidal Area Location" name="tidal_area" id="tidal_area" value="{{ old('tidal_area') }}"`>
                                    </div>
                                    <div id="tidal_area_error"></div>
                                    @error('tidal_area')
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
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="period_of_observation"><b>Period of observation</b></label>
                                   
                                    </div>
                                   
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="start_date">Start Date</label>
                                      <input class="form-control" type="date" placeholder="Period of observation" name="start_date" id="start_date" value="{{ old('start_date') }}">
                                    </div>
                                    <div id="start_date_error"></div>
                                    @error('start_date')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="end_date">End Date</label>
                                      <input class="form-control" type="date" placeholder="Period of observation" name="end_date" id="end_date" value="{{ old('end_date') }}">
                                    </div>
                                    <div id="end_date_error"></div>
                                    @error('end_date')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>

                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="duration">Duration (Years)</label>
                                      <input class="form-control" type="text" placeholder="Duration (Years)" name="duration" id="duration" value="{{ old('duration') }}">
                                    </div>
                                    <div id="duration_error"></div>
                                    @error('duration')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="duration_weeks">Duration (Weeks)</label>
                                      <input class="form-control" type="text" placeholder="Duration (Weeks)" name="duration_weeks" id="duration_weeks" value="{{ old('duration_weeks') }}">
                                    </div>
                                    <div id="duration_weeks_error"></div>
                                    @error('duration_weeks')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="duration_days">Duration (Days)</label>
                                      <input class="form-control" type="text" placeholder="Duration (Days)" name="duration_days" id="duration_days" value="{{ old('duration_days') }}">
                                    </div>
                                    <div id="duration_days_error"></div>
                                    @error('duration_days')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="duration_hours">Duration (Hours)</label>
                                      <input class="form-control" type="text" placeholder="Duration (Hours)" name="duration_hours" id="duration_hours" value="{{ old('duration_hours') }}">
                                    </div>
                                    <div id="duration_hours_error"></div>
                                    @error('duration_hours')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="benchmark_chart_datum">Whether Bench mark/Chart Datum available in the area</label>
                                      <div>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" onclick="displayDesc(1);" name="benchmark_chart_datum" id="benchmark_chart_datum1" value="yes" checked {{ old('benchmark_chart_datum') == "yes" ? 'checked' : '' }}>
                                          <label class="form-check-label" for="benchmark_chart_datum1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" onclick="displayDesc(0);" name="benchmark_chart_datum" id="benchmark_chart_datum2" value="no" {{ old('benchmark_chart_datum') == "no" ? 'checked' : '' }}>
                                          <label class="form-check-label" for="benchmark_chart_datum2">No</label>
                                        </div>
                                      </div>
                                    </div>
                                    <div id="benchmark_chart_datum_error"></div>
                                    @error('benchmark_chart_datum')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>

                                  <div class="col-md-6 description_of_benchmark_class">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="description_of_benchmark">Description of Benchmark</label>
                                      <textarea class="form-control" type="text" placeholder="Description of Benchmark" name="description_of_benchmark" id="description_of_benchmark" value="{{ old('description_of_benchmark') }}"></textarea>
                                    </div>
                                    <div id="description_of_benchmark_error"></div>
                                    @error('description_of_benchmark')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="method_of_observation">Method of observation</label>
                                    <select class="js-example-basic-single col-sm-12" name="method_of_observation" id="method_of_observation">
                                      <option value="manual">Manual</option>
                                      <option value="automatic">Automatic</option>
                                    </select>
                                    <div id="method_of_observation_error"></div>
                                    @error('method_of_observation')
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

    function displayDesc(disp)
    {
      if(disp == 1)
      {
        $(".description_of_benchmark_class").show();
      }else{
        $(".description_of_benchmark_class").hide();
      }
    }
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
    $("#tidal_observation").validate({
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
        tidal_area: {
          required: true,
        },
        period_of_observation: {
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
        tidal_area: {
          required: "Please enter Survey Area Location",
        },
        period_of_observation: {
          required: "Please enter Period of Observation",
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
        else if (element.attr("name") == "tidal_area")
        {
          error.appendTo("#tidal_area_error");
        }
        else if (element.attr("name") == "period_of_observation")
        {
          error.appendTo("#period_of_observation_error");
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