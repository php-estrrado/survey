@extends('layouts.admin.master')
@section('page-header')
	<link href="{{URL::asset('assets/css/jQuery-plugin-progressbar.css')}}" rel="stylesheet" />		  
	<meta name="csrf-token" content="{{ csrf_token() }}" />
	<link href="{{URL::asset('admin/assets/js/datatable/datatables.min.css')}}" rel="stylesheet" />
	<style type="text/css">
		.btn-primary {
    		background-color: #000056 !important;
    		border-color: #000056 !important;
		}

		.paginate_button
		{
			padding: 0.5rem 0.75rem;
			margin-left: -1px;
			line-height: 1.25;
			background-color: #fff;
			border: 1px solid #ebecf1;
		}
		.paginate_button.current
		{
			background-color: #705ec8 !important;
		}
	</style>
						<!--Page header-->
						<div class="page-header">
							<div class="page-leftheader">
								<h4 class="page-title mb-0">Dashboard</h4>
								
							</div>
						</div>
						<!--End Page header-->
						@endsection
						@section('content')

						 	<div class="card">
						       <div class="card-body">
						           <div class="row">
						           		<div class="col-md-10">
						           			
						                   <input type="text" class="form-control" placeholder="Search Service ID" id="search_val">
						               </div>
						               <div class="col-md-2">
						                   <input type="button" class="btn btn-primary" id="search_data" value="Search" style="width: 120px;">
						               </div>
						               <span class="searcherror" style="color: red;padding-left: 15px;margin-top: 10px; display: none;"></span>
						           </div>
						       </div>
						   </div>

						<!-- Row-1 -->
						<div class="row">

							<div class="col-md-12 col-xl-3 col-lg-6">
								<div class="card text-center">
									<div class="card-body"> <span>Total Number Of Service Requests</span>
										<h1 class=" mb-1 mt-1 font-weight-bold">{{$total_surveys}}</h1>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-xl-3 col-lg-6">
								<div class="card text-center">
									<div class="card-body"> <span>Requests to be Approved</span>
										<h1 class=" mb-1 mt-1 font-weight-bold">{{$pending_surveys}}</h1>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-xl-3 col-lg-6">
								<div class="card text-center">
									<div class="card-body"> <span>Completed Services</span>
										<h1 class=" mb-1 mt-1 font-weight-bold">{{ $completed_surveys }}</h1>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-xl-3 col-lg-6">
								<div class="card text-center">
									<div class="card-body"> <span>Pending Services</span>
										<h1 class=" mb-1 mt-1 font-weight-bold">{{$pending_services}}</h1>
									</div>
								</div>
							</div>
						</div>
						<!-- End Row-1 -->

						<!-- Row-1 -->
						<div class="row">

							<div class="col-md-12 col-xl-3 col-lg-6">
								<div class="card text-center">
									<div class="card-body"> <span>Payment Pending</span>
										<h1 class=" mb-1 mt-1 font-weight-bold">{{$payment_pending}}</h1>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-xl-3 col-lg-6">
								<div class="card text-center">
									<div class="card-body"> <span>Cancelled Services</span>
										<h1 class=" mb-1 mt-1 font-weight-bold">{{$rejected_surveys}}</h1>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-xl-3 col-lg-6">
								<div class="card text-center">
									<div class="card-body"> <span>Active No. Of Complaints</span>
										<h1 class=" mb-1 mt-1 font-weight-bold">0</h1>
									</div>
								</div>
							</div>
							<div class="col-md-12 col-xl-3 col-lg-6">
								<div class="card text-center">
									<div class="card-body"> <span>Pending e Signature</span>
										<h1 class=" mb-1 mt-1 font-weight-bold">{{$pending_signature}}</h1>
									</div>
								</div>
							</div>
						</div>
						<!-- End Row-1 -->

						 <div class="card">
						       <div class="card-body">
						           <div class="row">
						           		<div class="col-md-2">
						           			<label>Institution</label>
						                   <select class="form-control" id="filter_institutions">
						                   	<option value="">All</option>
						                   	<?php if(isset($filter_institutions)){
						                   		foreach ($filter_institutions as $fik => $fiv) {
						                   			?>
						                   			<option value="{{ $fiv->id }}">{{ $fiv->institution_name }}</option>
						                   			<?php
						                   		}
						                   	 } ?>
						                   </select>
						               </div>
						               <div class="col-md-2">
						               	<label>Service</label>
						                   <select class="form-control" id="filter_services">
						                   	<option value="">All</option>
						                   	<?php if(isset($filter_services)){
						                   		foreach ($filter_services as $fik => $fiv) {
						                   			?>
						                   			<option value="{{ $fiv->id }}">{{ $fiv->service_name }}</option>
						                   			<?php
						                   		}
						                   	 } ?>
						                   </select>
						               </div>
						               <div class="col-md-2">
						               	<label>AMS</label>
						                   <select class="form-control" id="filter_ams">
						                   	<option value="">All</option>
						                   	<?php if(isset($filter_ams)){
						                   		foreach ($filter_ams as $fik => $fiv) {
						                   			?>
						                   			<option value="{{ $fiv->id }}">{{ $fiv->fname }}</option>
						                   			<?php
						                   		}
						                   	 } ?>
						                   </select>
						               </div>
						               <div class="col-md-2">
						                   <label>From</label>
						                        <input type="date" class="form-control fromdate" id="from_date">
						               </div>
						               <div class="col-md-2">
						                   <label>To</label>
						                        <input type="date" class="form-control to_date" id="to_date">
						               </div>
						               <div class="col-md-2">
						                   <input type="button" class="btn btn-primary" id="filter_data" value="Find" style="margin-top: 28px;width: 120px;">
						               </div>
						               
						           </div>
						       </div>
						   </div>

						<div class="row">
							<div class="col-md-12">
								<div class="e-panel card">

									<div class="card-header">
									<div class="col-6">
									<div class="card-title">Service List</div>  
									</div> 
									<div class="col-6 text-right">
									</div>
									</div>

									<div class="card-body">
										<div class="e-table">
										<div>
											<div class=" table-responsive table-desi servicestable">
											@if(isset($view_type))
											@include('superadmin.dashboard-service-list')
											@endif
											</div>
										</div>
										</div>
									</div>
							</div>	
							</div>
						</div>


						<!-- Row-2 -->
						<div class="row" style="display: none;">
							<div class="col-xl-6 col-lg-6 col-md-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Total Completed Work v/s Total Pending Works</div>
									</div>
									<div class="card-body">
										<div class="chartjs-wrapper-demo">
											<div id="chart" class="h-300 mh-300"></div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-xl-6 col-lg-6 col-md-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">No. Of Service Request For Each Category</div>
									</div>
									<div class="card-body">
										<div id="chart2" class="h-300 mh-300"></div>
									</div>
								</div>
							</div>
						</div>
						<!-- End Row-2 -->

						<!-- Row-3 -->
						<div class="row" style="display:none;">
							<div class="col-xl-6 col-md-12">
								<div class="card">
									<div class="card-header">
										<div class="card-title">Total Request Received v/s Total Accepted Requests</div>
									</div>
									<div class="card-body">
										<div class="chartjs-wrapper-demo">
											<div id="chart8" class="h-300 mh-300"></div>
										</div>
									</div>
								</div>
							</div>
						</div>
						<!-- End Row-3 -->

						</div>
						</div>
						<!-- End app-content-->
						</div>
						@endsection
						@section('js')

				

						<!--INTERNAL Apexchart js-->
						<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>

				

						<!--INTERNAL Moment js-->
						<script src="{{URL::asset('assets/plugins/moment/moment.js')}}"></script>

						<!--INTERNAL Chart js -->
						<script src="{{URL::asset('assets/js/apexcharts.js')}}"></script>
						<!-- <script src="{{URL::asset('assets/js/apexchart-custom.js')}}"></script> -->

						<!--INTERNAL Flot Charts js-->
						<script src="{{URL::asset('assets/plugins/flot/jquery.flot.js')}}"></script>
						<script src="{{URL::asset('assets/plugins/flot/jquery.flot.fillbetween.js')}}"></script>
						<script src="{{URL::asset('assets/plugins/flot/jquery.flot.pie.js')}}"></script>
						<script src="{{URL::asset('assets/js/flot.js')}}"></script>

						<!--INTERNAL Index js-->
						<!-- <script src="{{URL::asset('assets/js/index.js')}}"></script> -->



<script src="{{URL::asset('admin/assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
}); 

var start = document.getElementById('from_date');
var to_date = document.getElementById('to_date');

start.addEventListener('change', function() {
if (start.value)
to_date.min = start.value;
}, false);

$(document).ready(function() {

	$('body').on('click','#search_data',function(){

	var search_val       = $("#search_val").val();
	$(".searcherror").hide(); $(".searcherror").text("");
	$.ajax({
	type: "POST",
	    url: '{{ url("superadmin/dashboard/search") }}',
	    data: {search_val:search_val,'_token': '{{ csrf_token()}}'},
	    success: function (data) {
	    	searchdata = JSON.parse(data);
	    	if(searchdata.id ==0)
	    	{
	    		$(".searcherror").text("No result(s) found!");
	    		$(".searcherror").show();
	    	}else{
	    		if(searchdata.type =="new")
	    		{
	    			window.location = "{{ url('/superadmin/new_service_request_detail/')}}/"+searchdata.id;
	    		}else{
	    			window.location = "{{ url('/superadmin/requested_service_detail/')}}/"+searchdata.id+"/"+searchdata.type;
	    		}
	    	}
	    	
	    	console.log(data);
	        // $("#data_content").html('').html(data); 
	    }
	});
	});
  
 $('body').on('click','#filter_data',function(){ 

var filter_institutions = $("#filter_institutions").val();
var filter_services = $("#filter_services").val();
var filter_ams = $("#filter_ams").val();
var from_date = $("#from_date").val();
var  to_date = $("#to_date").val();

var table =  $('#superadmin_dashboard').DataTable({
      "dom": 'Blfrtip',
        "aLengthMenu": [
        [10,25, 50, 100, 200, -1],
        [10,25, 50, 100, 200, "All"]
    ],	 "bDestroy": true,
           "pageLength": 10,
        "rowReorder": false,
        "colReorder": true,
        "paging": true,
        "pagingType": "simple_numbers",
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "fixedHeader": true,
        "orderCellsTop": false,
        "keys": false,
        "responsive": true,
        "processing": true,
        "scrollX": false,
        "scrollCollapse": true,
         "serverSide": true,
        // "bServerSide": false,
        "search": {
            "caseInsensitive": true,
            "smart": true
        },
     
         "ajax":{
            "url": $('#baseurl').val()+"/superadmin/dashboard/services",
            "dataType": "json",
            "type": "POST",
            "data":{ filter_institutions:filter_institutions,filter_services:filter_services,filter_ams:filter_ams,from_date:from_date,to_date:to_date,"_token": $('#_token').val(), vType: 'ajax'},
        },
     
       
        "columns": [
            { data: "i" },
            { data: "name" },
            { data: "file_no" },
            { data: "sub_office" },
            { data: "email" },
            { data: "requested_service" },
            { data: "status" },
            { data: "progress" },

   
        ],
        "fnStateSave": function (oSettings, oData) {
            localStorage.setItem('offersDataTables', JSON.stringify(oData));

        },
        "fnStateLoad": function (oSettings) {
            return JSON.parse(localStorage.getItem('offersDataTables'));
        },
        "drawCallback": function(settings) {
  $(".progress-bar-cust").loading();
   //do whatever  
}
  });

 });  

var table =  $('#superadmin_dashboard').DataTable({
      "dom": 'Blfrtip',
        "aLengthMenu": [
        [10,25, 50, 100, 200, -1],
        [10,25, 50, 100, 200, "All"]
    ],
        "pageLength": 10,
        "rowReorder": false,
        "colReorder": true,
        "paging": true,
        "pagingType": "simple_numbers",
        "lengthChange": true,
        "searching": true,
        "ordering": true,
        "info": true,
        "autoWidth": true,
        "fixedHeader": true,
        "orderCellsTop": false,
        "keys": false,
        "responsive": true,
        "processing": true,
        "scrollX": false,
        "scrollCollapse": true,
         "serverSide": true,
        // "bServerSide": false,
        "search": {
            "caseInsensitive": true,
            "smart": true
        },
        @if(isset($filter) && $filter==1)
         "ajax":{
            "url": $('#baseurl').val()+"/superadmin/dashboard/services",
            "dataType": "json",
            "type": "POST",
            "data":{ from:from,to:to,"_token": $('#_token').val(), vType: 'ajax'},
        },
        @else
         "ajax":{
            "url": $('#baseurl').val()+"/superadmin/dashboard/services",
            "dataType": "json",
            "type": "POST",
            "data":{ "_token": $('#_token').val(), vType: 'ajax'},
        },
        @endif
       
        "columns": [
            { data: "i" },
            { data: "name" },
            { data: "file_no" },
            { data: "sub_office" },
            { data: "email" },
            { data: "requested_service" },
            { data: "status" },
            { data: "progress" },

   
        ],
        "fnStateSave": function (oSettings, oData) {
            localStorage.setItem('offersDataTables', JSON.stringify(oData));

        },
        "fnStateLoad": function (oSettings) {
            return JSON.parse(localStorage.getItem('offersDataTables'));
        },
        "drawCallback": function(settings) {
  $(".progress-bar-cust").loading();
   //do whatever  
}
  });

// var table = $('#reportlist1').dataTable({
               
//                 dom: 'Bfrtip',
//                 buttons: ['excel',csv]
//             });
    
     $('#filterstatus').on('change', function () {
            table.columns(4).search( this.value ).draw();
        } );
});
</script>
    <!-- <script src="//code.jquery.com/jquery-2.1.4.min.js"></script> -->
        <script src="{{URL::asset('assets/js/jQuery-plugin-progressbar.js')}}"></script>
        <script type="text/javascript">
            $(".progress-bar-cust").loading();
        </script>



						@endsection