@extends('layouts.master-draftsman')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />
<!-- INTERNAL Gallery css -->
<link href="{{URL::asset('assets/plugins/gallery/gallery.css')}}" rel="stylesheet">

@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">Services And Requests</h4>
		<ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Services And Requests</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Invoice</a></li>
		</ol>
	</div>
</div>
<!--End Page header-->
@endsection
@section('content')

<!--/app header-->
<div class="main-proifle">
	<div class="row">
		<div class="col-lg-6">
			<div class="box-widget widget-user">
				<div class="widget-user-image1 d-sm-flex">
					<div class="mt-1">
						<h4 class="pro-user-username mb-3 font-weight-bold">File Number</h4>
						<ul class="mb-0 pro-details">
							<li><span class="h6 mt-3">Name: John</span></li>
							<li><span class="h6 mt-3">Name of the firm: XYZ</span></li>
							<li><span class="h6 mt-3">Type of firm: Private</span></li>
							<li><span class="h6 mt-3">Email ID: xyz@gmail.com</span></li>
							<li><span class="h6 mt-3">Mobile No.: Private</span></li>
							<li><span class="h6 mt-3">Valid ID Proof: xyz@gmail.com</span></li>
						</ul>
					</div>
				</div>
			</div>
		</div>
		<div class="col-lg-6 col-md-auto">
			<div class="text-lg-right btn-list mt-4 mt-lg-0">
				<a href="#" class="modal-effect btn btn-primary" data-effect="effect-scale" data-target="#modaldemo1" data-toggle="modal" href="">Create Invoice</a>
				<!-- <a href="#" class="modal-effect btn btn-danger" data-effect="effect-scale" data-target="#modaldemo2" data-toggle="modal" href="">Reject</a> -->
			</div>
			<div class="mt-5">
				<div class="main-profile-contact-list row">
					<div class="media col-sm-3">
						<div class="media-icon bg-primary text-white mr-3 mt-1">
							<i class="fa fa-comments fs-18"></i>
						</div>
						<div class="media-body">
							<small class="text-muted">Date</small>
							<div class="font-weight-normal1">
								11/12/2022
							</div>
						</div>
					</div>
					<div class="media col-sm-4">
						<div class="media-icon bg-secondary text-white mr-3 mt-1">
							<i class="fa fa-users fs-18"></i>
						</div>
						<div class="media-body">
							<small class="text-muted">Requested Service</small>
							<div class="font-weight-normal1">
								Hydrographic Survey
							</div>
						</div>
					</div>
					<div class="media col-sm-5">
						<div class="media-icon bg-info text-white mr-3 mt-1">
							<i class="fa fa-feed fs-18"></i>
						</div>
						<div class="media-body">
							<small class="text-muted">Status</small>
							<div class="font-weight-normal1">
								Field study report and ETA received
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="profile-cover">
		<div class="wideget-user-tab">
			<div class="tab-menu-heading p-0">
				<div class="tabs-menu1 px-3">
					<ul class="nav">
						<li><a href="#tab-7" class="active fs-14" data-toggle="tab">Basic</a></li>
						<li><a href="#tab-8" data-toggle="tab" class="fs-14">Timeline</a></li>
						<li><a href="#tab-9" data-toggle="tab" class="fs-14">Submitted Form</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div><!-- /.profile-cover -->
</div>


<!-- Row -->
<div class="row">
	<div class="col-xl-12 col-lg-12 col-md-12">
		<div class="border-0">
			<div class="tab-content">
				<div class="tab-pane active" id="tab-7">
					<div class="card newser">
						<div class="card-body">
							<div class="card-title font-weight-bold">Basic info:</div>
							<div class="row">
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Date And Time Of Inspection
											</div>
										</div>
										<label class="form-label">29-.9-2022, 10:20am</label>
									</div>
								</div>
								<div class="col-sm-8 col-md-8">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Name Of Department / Firm With Which Reconnaissance Survey Is Conducted
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												From Hydrographic Survey Wing
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Name Of Officers Participating In Field Inspection
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Location
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Type Of Water Body
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Limit Of Survey Area
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
							</div>
							<hr />
							<div class="card-title font-weight-bold mt-5">ETA</div>
							<div class="row">
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												General Area
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Location
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												No. Of Days Required
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Scale Of Survey Recommended
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Type Of Survey
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Charges
											</div>
										</div>
										<label class="form-label">1000</label>
									</div>
								</div>
							</div>
							<hr />
							<div class="row">
								<div class="col-sm-12 col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Upload Images
											</div>
										</div>
										<ul id="lightgallery" class="list-unstyled row">
											<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="{{URL::asset('assets/images/photos/1.jpg')}}" data-src="{{URL::asset('assets/images/photos/1.jpg')}}" data-sub-html="<h4>Gallery Image 1</h4><p> Many desktop publishing packages and web page editors now use Lorem Ipsum</p>">
												<a href="">
													<img class="img-responsive" src="{{URL::asset('assets/images/photos/1.jpg')}}" alt="Thumb-1">
												</a>
											</li>
											<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="{{URL::asset('assets/images/photos/2.jpg')}}" data-src="{{URL::asset('assets/images/photos/2.jpg')}}" data-sub-html="<h4>Gallery Image 2</h4><p> Many desktop publishing packages and web page editors now use Lorem Ipsum</p>">
												<a href="">
													<img class="img-responsive" src="{{URL::asset('assets/images/photos/2.jpg')}}" alt="Thumb-2">
												</a>
											</li>
											<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="{{URL::asset('assets/images/photos/3.jpg')}}" data-src="{{URL::asset('assets/images/photos/3.jpg')}}" data-sub-html="<h4>Gallery Image 3</h4><p> Many desktop publishing packages and web page editors now use Lorem Ipsum</p>">
												<a href="">
													<img class="img-responsive" src="{{URL::asset('assets/images/photos/3.jpg')}}" alt="Thumb-1">
												</a>
											</li>
											<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="{{URL::asset('assets/images/photos/4.jpg')}}" data-src="{{URL::asset('assets/images/photos/4.jpg')}}" data-sub-html=" <h4>Gallery Image 4</h4><p> Many desktop publishing packages and web page editors now use Lorem Ipsum</p>">
												<a href="">
													<img class="img-responsive" src="{{URL::asset('assets/images/photos/4.jpg')}}" alt="Thumb-2">
												</a>
											</li>
										</ul>
									</div>
								</div>
								<div class="col-sm-12 col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Remarks
											</div>
										</div>
										<textarea class="form-control mb-4" placeholder="Textarea" rows="3"></textarea>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="tab-pane" id="tab-8">
					<div class="card p-5">
						<ul class="timelineleft pb-5">
							<li>
								<i class="fa fa-clock-o bg-primary"></i>
								<div class="timelineleft-item">
									<span class="time"><i class="fa fa-clock-o text-danger"></i> 12:05</span>
									<h3 class="timelineleft-header"><a href="#">Support Team</a> <span>sent you an email</span></h3>
								</div>
							</li>
							<li>
								<i class="fa fa-clock-o bg-secondary"></i>
								<div class="timelineleft-item">
									<span class="time"><i class="fa fa-clock-o text-danger"></i> 5 mins ago</span>
									<h3 class="timelineleft-header no-border"><a href="#">Sarah Young</a> accepted your friend request</h3>
								</div>
							</li>
							<li>
								<i class="fa fa-clock-o bg-warning"></i>
								<div class="timelineleft-item">
									<span class="time"><i class="fa fa-clock-o text-danger"></i> 27 mins ago</span>
									<h3 class="timelineleft-header"><a href="#">Jay White</a> commented on your post</h3>
								</div>
							</li>
							<li>
								<i class="fa fa-clock-o bg-pink"></i>
								<div class="timelineleft-item">
									<span class="time"><i class="fa fa-clock-o text-danger"></i> 1 hour ago</span>
									<h3 class="timelineleft-header"><a href="#">Mr. John</a> shared a video</h3>
								</div>
							</li>
							<li>
								<i class="fa fa-clock-o bg-orange"></i>
								<div class="timelineleft-item">
									<span class="time"><i class="fa fa-clock-o text-danger"></i> 2 days ago</span>
									<h3 class="timelineleft-header"><a href="#">Mina Lee</a> uploaded new photos</h3>
								</div>
							</li>
							<li>
								<i class="fa fa-clock-o bg-pink"></i>
								<div class="timelineleft-item">
									<span class="time"><i class="fa fa-clock-o text-danger"></i> 5 days ago</span>
									<h3 class="timelineleft-header"><a href="#">Mr. Doe</a> shared a video</h3>
								</div>
							</li>
						</ul>
					</div>
				</div>
				<div class="tab-pane" id="tab-9">
					<div class="card newser">
						<div class="card-body">
							<div class="card-title font-weight-bold">Basci info:</div>
							<div class="row">
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Name
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Designation
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Name Of Department
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Name Of Firm
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Type Of Organization
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Purpose
											</div>
										</div>
										<label class="form-label">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </label>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Brief Description Of Type Of Work
											</div>
										</div>
										<label class="form-label">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. </label>
									</div>
								</div>
								<div class="col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Required Service From HSW
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
							</div>
							<hr />
							<div class="card-title font-weight-bold mt-5">Location</div>
							<div class="row">
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												State
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												District
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Name Of Place
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Survey Area Location
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
							</div>
							<hr />
							<div class="card-title font-weight-bold mt-5">Details</div>
							<div class="row">
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Type Of Waterbody
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Area Of Survey
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Scale Of Survey
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												When Service To Be Conducted
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Whether Interim Surveys Are Needed In Future
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-4 col-md-4">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Whether Benchmark / Chart Datum Available In The Area
											</div>
										</div>
										<label class="form-label">John Jerry</label>
									</div>
								</div>
								<div class="col-sm-12 col-md-12">
									<div class="form-group">
										<div class="media-body">
											<div class="font-weight-normal1">
												Existing Drawings / Maps Showing The Location
											</div>
										</div>
										<ul id="lightgallery" class="list-unstyled row">
											<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="{{URL::asset('assets/images/photos/1.jpg')}}" data-src="{{URL::asset('assets/images/photos/1.jpg')}}" data-sub-html="<h4>Gallery Image 1</h4><p> Many desktop publishing packages and web page editors now use Lorem Ipsum</p>">
												<a href="">
													<img class="img-responsive" src="{{URL::asset('assets/images/photos/1.jpg')}}" alt="Thumb-1">
												</a>
											</li>
											<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="{{URL::asset('assets/images/photos/2.jpg')}}" data-src="{{URL::asset('assets/images/photos/2.jpg')}}" data-sub-html="<h4>Gallery Image 2</h4><p> Many desktop publishing packages and web page editors now use Lorem Ipsum</p>">
												<a href="">
													<img class="img-responsive" src="{{URL::asset('assets/images/photos/2.jpg')}}" alt="Thumb-2">
												</a>
											</li>
											<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="{{URL::asset('assets/images/photos/3.jpg')}}" data-src="{{URL::asset('assets/images/photos/3.jpg')}}" data-sub-html="<h4>Gallery Image 3</h4><p> Many desktop publishing packages and web page editors now use Lorem Ipsum</p>">
												<a href="">
													<img class="img-responsive" src="{{URL::asset('assets/images/photos/3.jpg')}}" alt="Thumb-1">
												</a>
											</li>
											<li class="col-xs-6 col-sm-4 col-md-3" data-responsive="{{URL::asset('assets/images/photos/4.jpg')}}" data-src="{{URL::asset('assets/images/photos/4.jpg')}}" data-sub-html=" <h4>Gallery Image 4</h4><p> Many desktop publishing packages and web page editors now use Lorem Ipsum</p>">
												<a href="">
													<img class="img-responsive" src="{{URL::asset('assets/images/photos/4.jpg')}}" alt="Thumb-2">
												</a>
											</li>
										</ul>
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


<div class="row">
	<div class="col-12">
		<div class="btn-list d-flex justify-content-end">
			<a href="#" class="modal-effect btn btn-primary" data-effect="effect-scale" data-target="#modaldemo1" data-toggle="modal" href="">Create Invoice</a>
			<!-- <a href="#" class="modal-effect btn btn-danger" data-effect="effect-scale" data-target="#modaldemo2" data-toggle="modal" href="">Reject</a> -->
		</div>
	</div>
</div>


</div>
</div><!-- end app-content-->
</div>

<!-- <div class="modal" id="modaldemo1">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<div class="modal-header">
				<h6 class="modal-title">Assign</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div>
			<div class="modal-body">
				<div class="col-md-12">
					<div class="form-group">
						<label class="form-label">Recipient <span class="text-red">*</span></label>
						<select class="form-control custom-select select2">
							<option value="0">--Select--</option>
							<option value="1">Germany</option>
							<option value="2">Canada</option>
							<option value="3">Usa</option>
							<option value="4">Aus</option>
						</select>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" type="button">Assign</button> <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
			</div>
		</div>
	</div>
</div> -->

<div class="modal" id="modaldemo2">
	<div class="modal-dialog" role="document">
		<div class="modal-content modal-content-demo">
			<!-- <div class="modal-header">
				<h6 class="modal-title">Reject</h6><button aria-label="Close" class="close" data-dismiss="modal" type="button"><span aria-hidden="true">&times;</span></button>
			</div> -->
			<div class="modal-body">
				<div class="col-md-12">
					<div class="form-group">
						<label class="form-label">Select which are needs to be rejected <span class="text-red">*</span></label>
						<div class="custom-controls-stacked">
							<label class="custom-control custom-checkbox d-inline-block mr-3">
								<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
								<span class="custom-control-label">Report</span>
							</label>
							<label class="custom-control custom-checkbox d-inline-block">
								<input type="checkbox" class="custom-control-input" name="example-checkbox1" value="option1">
								<span class="custom-control-label">ETA</span>
							</label>
						</div>
					</div>
				</div>
				<div class="col-md-12">
					<div class="form-group">
						<label class="form-label">Remark <span class="text-red">*</span></label>
						<textarea class="form-control" rows="3">Type Here...</textarea>
					</div>
				</div>
			</div>
			<div class="modal-footer">
				<button class="btn btn-primary" type="button">Send</button> <button class="btn btn-secondary" data-dismiss="modal" type="button">Close</button>
			</div>
		</div>
	</div>
</div>


@endsection
@section('js')
<!-- INTERNAL Data tables -->
<!-- <script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.bootstrap4.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/dataTables.buttons.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/jszip.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/pdfmake.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/vfs_fonts.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.html5.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.print.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/js/buttons.colVis.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/dataTables.responsive.min.js')}}"></script>
<script src="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.js')}}"></script>
<script src="{{URL::asset('assets/js/datatables.js')}}"></script> -->
<!-- INTERNAL Gallery js -->
<script src="{{URL::asset('assets/plugins/gallery/picturefill.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lightgallery.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lg-pager.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lg-autoplay.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lg-fullscreen.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lg-zoom.js')}}"></script>
<script src="{{URL::asset('assets/plugins/gallery/lg-hash.js')}}"></script>
<script src="{{URL::asset('assets/js/gallery.js')}}"></script>

<!-- INTERNAL Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
@endsection