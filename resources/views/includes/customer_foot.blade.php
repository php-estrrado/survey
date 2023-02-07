<!-- latest jquery-->
<script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
<!-- Bootstrap js-->
<script src="{{URL::asset('public/assets/js/bootstrap.bundle.min.js')}}"></script>
<!-- feather icon js-->
<script src="{{URL::asset('public/assets/js/feather.min.js')}}"></script>
<script src="{{URL::asset('public/assets/js/feather-icon.js')}}"></script>
<!-- scrollbar js-->
<script src="{{URL::asset('public/assets/js/simplebar.js')}}"></script>
<script src="{{URL::asset('public/assets/js/custom.js')}}"></script>
<!-- Sidebar jquery-->
<script src="{{URL::asset('public/assets/js/config.js')}}"></script>

<!-- tooltip init js  start-->
<script src="{{URL::asset('public/assets/js/tooltip-init.js')}}"></script>
<!-- tooltip init js  end-->

<!-- slick js start -->
<script src="{{URL::asset('public/assets/js/slick.js')}}"></script>
<!-- slick js end -->

<!-- Plugins JS start-->
<script src="{{URL::asset('public/assets/js/sidebar-menu.js')}}"></script>

<script src="{{URL::asset('public/assets/js/index.js')}}"></script>
<!-- Plugins JS Ends-->

<!-- <script src="{{URL::asset('public/assets/js/datepicker.js')}}"></script>

<script src="{{URL::asset('public/assets/js/datepicker.en.js')}}"></script>

<script src="{{URL::asset('public/assets/js/datepicker.custom.js')}}"></script> -->

<script src="{{URL::asset('public/assets/js/bootstrap-datepicker.min.js')}}"></script>
<!-- ratio start  -->
<script src="{{URL::asset('public/assets/js/ratio.js')}}"></script>
<!-- Theme js-->
<script src="{{URL::asset('public/assets/js/script.js')}}"></script>
<!-- <script src="{{URL::asset('public/assets/js/jquery.validate.min.js')}}"></script> -->
  <script src="{{URL::asset('public/assets/plugins/sumoselect/jquery.sumoselect.js')}}"></script>
<script src="{{URL::asset('admin/assets/js/toastr.min.js')}}"></script>

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
<script>
    $(document).ready(function(){

        $('.multiselect').SumoSelect();
        
        $(".sidebar-submenu.customer").show();
        $(".sidebar-submenu.customer").parents("li.sidebar-list").find(".sidebar-link.sidebar-title").addClass('active');
    });
</script>

                        <!-- INTERNAL File uploads js -->
                <script src="{{URL::asset('public/admin/assets/plugins/fileupload/js/dropify.js')}}"></script>
                <script src="{{URL::asset('public/admin/assets/js/filupload.js')}}"></script>
                                <!-- INTERNAL File-Uploads Js-->
                <script src="{{URL::asset('public/admin/assets/plugins/fancyuploder/jquery.ui.widget.js')}}"></script>
                <script src="{{URL::asset('public/admin/assets/plugins/fancyuploder/jquery.fileupload.js')}}"></script>
                <script src="{{URL::asset('public/admin/assets/plugins/fancyuploder/jquery.iframe-transport.js')}}"></script>
                <script src="{{URL::asset('public/admin/assets/plugins/fancyuploder/jquery.fancy-fileupload.js')}}"></script>
                <script src="{{URL::asset('public/admin/assets/plugins/fancyuploder/fancy-uploader.js')}}"></script>