		<!-- Back to top -->
		<a href="#top" id="back-to-top"><i class="fe fe-chevrons-up"></i></a>

		<!-- Jquery js-->
		<script src="{{URL::asset('admin/assets/js/jquery-3.5.1.min.js')}}"></script>

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

		<script type="text/javascript">
			$(document).ready(function(){
				@if(Session::has('message'))
					@if(session('message')['type'] =="success")
						toastr.success("{{session('message')['text']}}");
					@else
						toastr.error("{{session('message')['text']}}");
					@endif
				@endif
			});
		</script>