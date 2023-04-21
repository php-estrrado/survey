		<!-- Back to top -->
		<a href="#top" id="back-to-top"><i class="fe fe-chevrons-up"></i></a>

		<!-- Jquery js-->
		<script src="{{URL::asset('admin/assets/js/jquery-3.6.4.min.js')}}"></script>

		<!-- Bootstrap4 js-->
		<script src="{{URL::asset('admin/assets/plugins/bootstrap/popper.min.js')}}"></script>
		<script src="{{URL::asset('admin/assets/plugins/bootstrap/js/bootstrap.min.js')}}"></script>
		<script src="{{URL::asset('admin/assets/js/bootstrap-datepicker.min.js')}}"></script>

		<!--Othercharts js-->
		<script src="{{URL::asset('admin/assets/plugins/othercharts/jquery.sparkline.min.js')}}"></script>

		<!-- Circle-progress js-->
		<script src="{{URL::asset('admin/assets/js/circle-progress.min.js')}}"></script>

		<!-- Jquery-rating js-->
		<script src="{{URL::asset('admin/assets/plugins/rating/jquery.rating-stars.js')}}"></script>

		<!--Sidemenu js-->
		<script src="{{URL::asset('admin/assets/plugins/sidemenu/sidemenu.js')}}"></script>
		
		<!-- P-scroll js-->
		<script src="{{URL::asset('admin/assets/plugins/p-scrollbar/p-scrollbar.js')}}"></script>
		<script src="{{URL::asset('admin/assets/plugins/p-scrollbar/p-scroll1.js')}}"></script>
		<script src="{{URL::asset('admin/assets/plugins/p-scrollbar/p-scroll.js')}}"></script>

		@yield('js')
		<!-- Simplebar JS -->
		<script src="{{URL::asset('admin/assets/plugins/simplebar/js/simplebar.min.js')}}"></script>
		<!-- Custom js-->
		<script src="{{URL::asset('admin/assets/js/custom.js')}}"></script>

		<script src="{{URL::asset('admin/assets/js/toastr.min.js')}}"></script>

		<!-- INTERNAL File uploads js -->
		<script src="{{URL::asset('public/admin/assets/plugins/fileupload/js/dropify.js')}}"></script>
                <script src="{{URL::asset('public/admin/assets/js/filupload.js')}}"></script>
                                <!-- INTERNAL File-Uploads Js-->
                <script src="{{URL::asset('public/admin/assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
                <script src="{{URL::asset('public/admin/assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
                <script src="{{URL::asset('public/admin/assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
                <script src="{{URL::asset('public/admin/assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
                <script src="{{URL::asset('public/admin/assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>
				<!-- <script src="{{URL::asset('public/assets/js/dropzone.min.js')}}"></script> -->

			@php 

			$mark_url = "";
			if(auth()->user()->role_id == 1)
			{
				$mark_url = url("superadmin/mark-notifications");
			}
			elseif(auth()->user()->role_id == 2)
			{
				$mark_url = url("admin/mark-notifications");
			}
			elseif(auth()->user()->role_id == 3)
			{
				$mark_url = url("surveyor/mark-notifications");
			}
			elseif(auth()->user()->role_id == 4)
			{
				$mark_url = url("draftsman/mark-notifications");
			}
			elseif(auth()->user()->role_id == 5)
			{
 				$mark_url = url("accountant/mark-notifications");
			}elseif(auth()->user()->role_id == 6)
			{
 				$mark_url = url("customer/mark-notifications");
			}


			@endphp

		<script type="text/javascript">
			$(document).ready(function(){

				toastr.options.timeOut = 500;

				@if(Session::has('message'))
				var disp_msg = '{{session("message")["text"]}}';
				var disp_type = '{{session("message")["type"]}}';
					if(disp_type=="success"){
						toastr.success(disp_msg, { timeOut: 500 });
					
					}else{

						toastr.error(disp_msg, { timeOut: 500 });
					}
				

					@php
					Session::forget('message');
					@endphp

				@endif

				jQuery(".marknotifications a").click(function(e){
				var self = jQuery(this);
				var href = self.attr('href');
				e.preventDefault();
				// needed operations
				// alert("clicked");
				var not_id = jQuery(this).data("id");
				
					$.ajax({
					type: "POST",
					url: '{{ $mark_url }}',
					data: {not_id:not_id,'_token': '{{ csrf_token()}}'},
					success: function (data) {
						setTimeout(window.location = href, 1000);
					// window.location = href;
						// alert(data);
					console.log(data);
					// $("#data_content").html('').html(data); 
					}
					});

				// window.location = href;
				});

			});
		</script>