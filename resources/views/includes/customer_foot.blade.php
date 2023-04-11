<!-- latest jquery-->
<script src="{{URL::asset('admin/assets/js/jquery-3.6.4.min.js')}}"></script>

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

@php
    $mark_url = "";
    if(auth()->user()->role_id == 6)
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
            }else
            {
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
                    // window.location = href;
                    // alert(data);
                    setTimeout(window.location = href, 1000);
                    console.log(data);
                    // $("#data_content").html('').html(data); 
                }
            });
            // window.location = href;
		});

        $('body').on('click','#search_data',function(){
            var search_val       = $("#search_val").val();
            $(".searcherror").hide(); $(".searcherror").text("");
            $.ajax({
                type: "POST",
                url: '{{ url("customer/search") }}',
                data: {search_val:search_val,'_token': '{{ csrf_token()}}'},
                success: function (data) {
                    searchdata = JSON.parse(data);
                    if(searchdata.id ==0)
                    {
                        $(".searcherror").text("No result(s) found!");
                        $(".searcherror").show();
                    }
                    else
                    {
                        if(searchdata.type =="new")
                        {
                            window.location = "{{ url('/customer/request_service_detail/')}}/"+searchdata.id;
                        }
                        else
                        {
                            window.location = "{{ url('/customer/request_service_detail/')}}/"+searchdata.id+"/"+searchdata.type;
                        }
                    }        
                    console.log(data);
                    // $("#data_content").html('').html(data); 
                }
            });
        });
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
