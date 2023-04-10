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
              <h5>{{$title}}</h5>
            </div>
            <div class="card-body bodhgt">
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
                          <form action="{{url('/customer/dredging_survey/save')}}" method="post" id="dredging_survey" class="theme-form">
                            @csrf
                            <input type="hidden" name="id" id="id" value="{{$survey_data->id}}">
                            <input type="hidden" name="service_id" id="service_id" value="{{$service_id}}">
                            <input type="hidden" name="survey_request_id" id="survey_request_id" value="{{$survey_id}}">
                            <div class="tab-content" id="main_form">
                              <div class="tab-pane active" role="tabpanel" id="step1">
                                <h4 class="text-center">Basic Details</h4>
                                <div class="row">
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="fname">Name <span class="text-red">*</span></label>
                                    <input class="form-control bg-white" type="text" name="fname" id="fname" placeholder="Name" value="{{ $survey_data->fname }}" readonly>
                                    <div id="fname_error"></div>
                                    @error('fname')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="designation">Designation <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" name="designation" id="designation" placeholder="Designation" value="{{ $survey_data->designation }}">
                                    <div id="designation_error"></div>
                                    @error('designation')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="sector">Whether Govt./Private/ Public Sector undertaking/person <span class="text-red">*</span></label>
                                    <select class="js-example-basic-single col-sm-12" name="sector" id="sector">
                                      <option value="government" {{ $survey_data->sector == 'government' ? 'selected' : '' }}>Government</option>
                                      <option value="private" {{ $survey_data->sector == 'private' ? 'selected' : '' }}>Private</option>
                                      <option value="public" {{ $survey_data->sector == 'public' ? 'selected' : '' }}>Public Sector</option>
                                      <option value="person" {{ $survey_data->sector == 'person' ? 'selected' : '' }}>Person</option>
                                    </select>
                                    <div id="sector_error"></div>
                                    @error('sector')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="department">Name of Department (for government departments) <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" placeholder="Name of Department" name="department" id="department" value="{{ $survey_data->department }}">
                                    <div id="department_error"></div>
                                    @error('department')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                      <label class="form-label-title mt-3" for="firm">Type of organization <span class="text-red">*</span></label>
                                      <!--<input class="form-control" type="text" placeholder="Type of organization" name="firm" id="firm" value="{{ old('fname') }}">-->
                                      {{ Form::select('firm', $org_types, $survey_data->firm,['id'=>'firm','class'=>'form-control']); }}
                                      <div id="firm_error"></div>
                                      @error('firm')
                                        <p style="color: red">{{ $message }}</p>
                                      @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="others">Others</label>
                                    <input class="form-control" type="text" placeholder="Others" name="others" id="others" value="{{ $survey_data->others }}">
                                    <div id="others_error"></div>
                                      @error('others')
                                        <p style="color: red">{{ $message }}</p>
                                      @enderror
                                  </div>
                                  <div class="col-sm-6">
                                      <label class="form-label-title mt-3" for="purpose">Purpose <span class="text-red">*</span></label>
                                      <input class="form-control" type="text" placeholder="Name of project or specify the purpose" name="purpose" id="purpose" value="{{ $survey_data->purpose }}">
                                      <div id="purpose_error"></div>
                                      @error('purpose')
                                        <p style="color: red">{{ $message }}</p>
                                      @enderror
                                  </div>
                                   <div class="col-sm-6">
                                    <input type="hidden" name="service" value="{{ $service }}">
                                    <label class="form-label-title mt-3" for="service">Additional service needed <span class="text-red">*</span></label>
                                    <select class="js-example-basic-single col-sm-12 multiselect" name="additional_services[]" id="additional_services" multiple="multiple" >
                                      <?php $additional_services_arr = explode(',', $survey_data->additional_services);?>
                                      @if($services && count($services)>0)
                                        @foreach($services as $service)
                                          <option value="{{$service['id']}}" {{in_array($service['id'],$additional_services_arr) ? 'selected' : '' }}>{{$service['service_name']}}</option>
                                        @endforeach
                                      @endif
                                    </select>
                                    <div id="service_error"></div>
                                    @error('additional_services')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-12">
                                    <label class="form-label-title mt-3" for="description">Brief description of type of work <span class="text-red">*</span></label>
                                    <textarea id="description" name="description" placeholder="Location, scale, format of result required" rows="4" style="width:100%;">{{$survey_data->description}}</textarea>
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
                                    <label class="form-label-title mt-3" for="state">State <span class="text-red">*</span></label>
                                    <select class="js-example-basic-single col-sm-12" name="state" id="state">
                                      <option value="">Select</option>
                                      @if($states && count($states)>0)
                                        @foreach($states as $state)
                                          <option value="{{$state['id']}}" {{ $survey_data->state == $state['id'] ? "selected" : "" }}>{{$state['state_name']}}</option>
                                        @endforeach  
                                      @endif
                                    </select>
                                    <div id="state_error"></div>
                                    @error('state')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="district">District <span class="text-red">*</span></label>
                                    <select class="js-example-basic-single col-sm-12" name="district" id="district">
                                      <option value="">Select</option>
                                      @if($cities && count($cities)>0)
                                        @foreach($cities as $city)
                                          <option value="{{$city['id']}}" {{ $survey_data->district == $city['id'] ? 'selected' : '' }}>{{$city['city_name']}}</option>
                                        @endforeach  
                                      @endif
                                    </select>
                                    <div id="district_error"></div>
                                    @error('district')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="place">Name of Place <span class="text-red">*</span></label>
                                    <input class="form-control" type="text" placeholder="Place" name="place" id="place" value="{{ $survey_data->place }}">
                                    <div id="place_error"></div>
                                    @error('place')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="survey_area">Survey Area Location <span class="text-red">*</span></label>
                                      <input class="form-control" type="text" placeholder="Survey Area Location" name="survey_area" id="survey_area" value="{{ $survey_data->survey_area }}">
                                    </div>
                                    <div id="survey_area_error"></div>
                                    @error('survey_area')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-md-12">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for=""><b>Limit of survey Location Coordinates</b></label>
                                    </div>
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="lattitude">Lattitude 1</label>
                                      <input class="form-control" type="text" placeholder="Lattitude, deg, min, sec" name="lattitude" id="lattitude" value="{{ $survey_data->lattitude }}">
                                    </div>
                                    <div id="depth_at_saples_collected_error"></div>
                                    @error('lattitude')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="longitude">Longitude 1</label>
                                      <input class="form-control" type="text" placeholder="Longitude , deg, min, sec" name="longitude" id="longitude" value="{{ $survey_data->longitude }}">
                                    </div>
                                    <div id="depth_at_saples_collected_error"></div>
                                    @error('depth_at_saples_collected')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="x_coordinates">X Coordinates 1</label>
                                      <input class="form-control" type="text" placeholder="X Coordinates" name="x_coordinates" id="x_coordinates" value="{{ $survey_data->x_coordinates }}">
                                    </div>
                                    <div id="depth_at_saples_collected_error"></div>
                                    @error('x_coordinates')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="y_coordinates">Y Coordinates 1</label>
                                      <input class="form-control" type="text" placeholder="Y Coordinates" name="y_coordinates" id="y_coordinates" value="{{ $survey_data->y_coordinates }}">
                                    </div>
                                    <div id="depth_at_saples_collected_error"></div>
                                    @error('y_coordinates')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>


                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="lattitude2">Lattitude 2</label>
                                      <input class="form-control" type="text" placeholder="Lattitude, deg, min, sec" name="lattitude2" id="lattitude2" value="{{ $survey_data->lattitude2 }}">
                                    </div>
                                    <div id="depth_at_saples_collected_error"></div>
                                    @error('lattitude2')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="longitude2">Longitude 2</label>
                                      <input class="form-control" type="text" placeholder="Longitude , deg, min, sec" name="longitude2" id="longitude2" value="{{ $survey_data->longitude2 }}">
                                    </div>
                                    <div id="depth_at_saples_collected_error"></div>
                                    @error('longitude2')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="x_coordinates2">X Coordinates 2</label>
                                      <input class="form-control" type="text" placeholder="X Coordinates" name="x_coordinates2" id="x_coordinates2" value="{{ $survey_data->x_coordinates2 }}">
                                    </div>
                                    <div id="depth_at_saples_collected_error"></div>
                                    @error('x_coordinates2')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="y_coordinates2">Y Coordinates 2</label>
                                      <input class="form-control" type="text" placeholder="Y Coordinates" name="y_coordinates2" id="y_coordinates2" value="{{ $survey_data->y_coordinates2 }}">
                                    </div>
                                    <div id="depth_at_saples_collected_error"></div>
                                    @error('y_coordinates2')
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
                                    <label class="form-label-title mt-3" for="detailed_description_area">Detailed description of area (Type of waterbody) <span class="text-red">*</span></label>
                                   
                                      <input class="form-control" type="text" placeholder="Detailed description of area" name="detailed_description_area" id="detailed_description_area" value="{{ $survey_data->detailed_description_area }}">
                                    <div id="detailed_description_area_error"></div>
                                    @error('detailed_description_area')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="no_of_surveys">Number of Surveys needed</label>
                                    <input class="form-control" type="number" placeholder="Number of Surveys needed" min="0" max="5" name="no_of_surveys" id="no_of_surveys" value="{{ $survey_data->no_of_surveys }}">
                                    <div id="no_of_surveys_error"></div>
                                    @error('no_of_surveys')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  
                                  <div class="col-sm-6">
                        
                                    <label class="form-label-title mt-3" for="dredging_survey_method">Whether pre/post dredging survey required or both <span class="text-red">*</span></label>
                                    <select class="js-example-basic-single col-sm-12 multiselect" name="dredging_survey_method[]" id="dredging_survey_method" multiple="multiple" >
                                      
                                          <option value="pre" {{ $survey_data->dredging_survey_method == "pre" ? 'selected' : '' }}>Pre</option>
                                          <option value="post" {{ $survey_data->dredging_survey_method == "post" ? 'selected' : '' }}>Post</option>
                                          <option value="intermediate" {{ $survey_data->dredging_survey_method == "intermediate" ? 'selected' : '' }}>Intermediate</option>
                                        
                                    </select>
                                    <div id="dredging_survey_method_error"></div>
                                    @error('dredging_survey_method')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>

                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="interim_surveys_needed_infuture">Whether interim surveys are needed in future <span class="text-red">*</span></label>
                                      <div>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="interim_surveys_needed_infuture" id="interim_surveys_needed_infuture1" value="yes" {{ $survey_data->interim_surveys_needed_infuture == "yes" ? 'checked' : '' }}>
                                          <label class="form-check-label" for="interim_surveys_needed_infuture1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="interim_surveys_needed_infuture" id="interim_surveys_needed_infuture2" value="no" {{ $survey_data->interim_surveys_needed_infuture == "no" ? 'checked' : '' }}>
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
                                      <label class="form-label-title mt-3" for="dredging_quantity_calculation">Whether dredging quantity calculation required <span class="text-red">*</span></label>
                                      <div>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="dredging_quantity_calculation" id="dredging_quantity_calculation1" value="yes" {{ $survey_data->dredging_quantity_calculation == "yes" ? 'checked' : '' }}>
                                          <label class="form-check-label" for="dredging_quantity_calculation1">Yes</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="dredging_quantity_calculation" id="dredging_quantity_calculation2" value="no" {{ $survey_data->dredging_quantity_calculation == "no" ? 'checked' : '' }}>
                                          <label class="form-check-label" for="dredging_quantity_calculation2">No</label>
                                        </div>
                                      </div>
                                    </div>
                                    <div id="dredging_quantity_calculation_error"></div>
                                    @error('dredging_quantity_calculation')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-md-6">
                                    <div class="form-group">
                                      <label class="form-label-title mt-3" for="method_volume_calculation">Method to be adopted for volume calculation <span class="text-red">*</span></label>
                                      <div>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="method_volume_calculation" id="method_volume_calculation1" value="manual" {{ $survey_data->method_volume_calculation == "manual" ? 'checked' : '' }}>
                                          <label class="form-check-label" for="method_volume_calculation1">Manual</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                          <input class="form-check-input" type="radio" name="method_volume_calculation" id="method_volume_calculation2" value="software" {{ $survey_data->method_volume_calculation == "software" ? 'checked' : '' }}>
                                          <label class="form-check-label" for="method_volume_calculation2">Software</label>
                                        </div>
                                      </div>
                                    </div>
                                    <div id="method_volume_calculation_error"></div>
                                    @error('method_volume_calculation')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="length">Length for Survey Calculation <span class="text-red">*</span></label>
                                    <input class="form-control" type="number" placeholder="Length for Survey Calculation (metres)" name="length" id="length" value="{{$survey_data->length}}">
                                    <div id="length_error"></div>
                                    @error('length')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="width">Width for Survey Calculation <span class="text-red">*</span></label>
                                    <input class="form-control" type="number" placeholder="Width for Survey Calculation (metres)" name="width" id="width" value="{{ $survey_data->width }}">
                                    <div id="width_error"></div>
                                    @error('width')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="depth">Depth for Survey Calculation <span class="text-red">*</span></label>
                                    <input class="form-control" type="number" placeholder="Depth for Survey Calculation (metres)" name="depth" id="depth" value="{{ $survey_data->depth }}">
                                    <div id="depth_error"></div>
                                    @error('depth')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
                                  </div>
                                  <div class="col-sm-6">
                                    <label class="form-label-title mt-3" for="level_upto">Level upto which dredged (in meter)</label>
                                    <input class="form-control" type="text" placeholder="Level upto which dredged (in meter)" name="level_upto" id="level_upto" value="{{ $survey_data->level_upto }}">
                                    <div id="level_upto_error"></div>
                                    @error('level_upto')
                                      <p style="color: red">{{ $message }}</p>
                                    @enderror
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
    @include('includes.customer_footer')
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
    $("#dredging_survey").validate({
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
        detailed_description_area: {
          required: true,
        },
        dredging_survey_method: {
          required: true,
        },
        interim_surveys_needed_infuture: {
          required: true,
        },
        dredging_quantity_calculation: {
          required: true,
        },
        method_volume_calculation: {
          required: true,
        },
        length: {
          required: true,
        },
        width: {
          required: true,
        },
        depth: {
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
        detailed_description_area: {
          required: "Please enter Type of Waterbody",
        },
        dredging_survey_method: {
          required: "Please select Dredging Survey Method",
        },
        interim_surveys_needed_infuture: {
          required: "Please select Whether interim surveys are needed in future",
        },
        dredging_quantity_calculation: {
          required: "Please select Dredging Quantity Calculation",
        },
        method_volume_calculation: {
          required: "Please select Method of Volume Calculation",
        },
        length: {
          required: "Please enter Length",
        },
        width: {
          required: "Please enter Width",
        },
        depth: {
          required: "Please enter Depth",
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
        else if (element.attr("name") == "detailed_description_area")
        {
          error.appendTo("#detailed_description_area_error");
        }
        else if (element.attr("name") == "dredging_survey_method")
        {
          error.appendTo("#dredging_survey_method_error");
        }
        else if (element.attr("name") == "interim_surveys_needed_infuture")
        {
          error.appendTo("#interim_surveys_needed_infuture_error");
        }
        else if (element.attr("name") == "dredging_quantity_calculation")
        {
          error.appendTo("#dredging_quantity_calculation_error");
        }
        else if (element.attr("name") == "method_volume_calculation")
        {
          error.appendTo("#method_volume_calculation_error");
        }
        else if (element.attr("name") == "length")
        {
          error.appendTo("#length_error");
        }
        else if (element.attr("name") == "width")
        {
          error.appendTo("#width_error");
        }
        else if (element.attr("name") == "depth")
        {
          error.appendTo("#depth_error");
        }
        else
        {
          error.insertAfter(element)
        }
      },
    });
  </script>
@endsection