			<!--Footer-->
			<footer class="footer">
				<div class="container">
					<div class="row align-items-center flex-row-reverse">
						<div class="col-md-12 col-sm-12 text-center">
							Copyright � 2020 <a href="{{url('/' . $page='#')}}">Admintro</a>. Designed by <a href="{{url('/' . $page='#')}}">Spruko Technologies Pvt.Ltd</a> All rights reserved.
						</div>
					</div>
				</div>
			</footer>
			<!-- End Footer-->
<script type="text/javascript">
    $(document).ready(function(){  
        $('body').on('change','.number',function(){  
            var id  =   this.id; var val = this.value.replace(/[^0-9\.]/g,''); $(this).val(val); if($(this).val() == ''){ $(this).val(0); }
        });
        $('body').on('change','.numberonly',function(){  
            var id  =   this.id; var val = this.value.replace(/[^0-9]/g,''); $(this).val(val); if($(this).val() == ''){ $(this).val(0); }
        });
    });
</script>