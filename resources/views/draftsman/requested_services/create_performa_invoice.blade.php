@extends('layouts.admin.master-draftsman')
@section('css')
<!-- Data table css -->
<link href="{{URL::asset('assets/plugins/datatable/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" />
<link href="{{URL::asset('assets/plugins/datatable/css/buttons.bootstrap4.min.css')}}" rel="stylesheet">
<link href="{{URL::asset('assets/plugins/datatable/responsive.bootstrap4.min.css')}}" rel="stylesheet" />
<!-- Slect2 css -->
<link href="{{URL::asset('assets/plugins/select2/select2.min.css')}}" rel="stylesheet" />

@endsection
@section('page-header')
<!--Page header-->
<div class="page-header">
	<div class="page-leftheader">
		<h4 class="page-title mb-0">{{$title}}</h4>
		<!-- <ol class="breadcrumb">
			<li class="breadcrumb-item"><a href="#"><i class="fe fe-layout mr-2 fs-14"></i>Service And Requests</a></li>
			<li class="breadcrumb-item active" aria-current="page"><a href="#">Requested Services</a></li>
		</ol> -->
	</div>
	<!-- <div class="page-rightheader">
		<div class="btn btn-list">
			<a href="#" class="btn btn-info"><i class="fe fe-plus mr-1"></i> Add </a>
		</div>
	</div> -->
</div>
<!--End Page header-->
@endsection
@section('content')
<!-- Row -->
<div class="row">
	<div class="col-12">

		<!--div-->
		<div class="card">
			<div class="card-header">
				<div class="card-title fifty">{{$title}}</div>
				<div class="card-title fifty">
					<div class="panel panel-default block">
						<div class="panel-body p-0" style="float:right;">
							<!-- <div class="btn-group mt-2 mb-2">
								<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
									All Sub Offices <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
								</ul>
							</div>
							<div class="btn-group mt-2 mb-2">
								<button type="button" class="btn btn-light dropdown-toggle" data-toggle="dropdown">
									This Month <span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li><a href="#">Action</a></li>
									<li><a href="#">Another action</a></li>
									<li><a href="#">Something else here</a></li>
								</ul>
							</div> -->
						</div>
					</div>

				</div>
			</div>
			<div class="card-body">
                <form action="{{URL('/draftsman/save_performa_invoice')}}" method="POST">
                    @csrf
                    <input type="hidden" value="{{$survey_id}}" name="id" id="id">
                    <input type="hidden" value="0" name="performa_invoice_id" id="performa_invoice_id">
                    <input type="hidden" value="" name="survey_charges_words" id="survey_charges_words">
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="form-label-title mt-3" for="bill_invoice_no">Bill /Invoice No</label>
                            <input class="form-control" type="text" name="bill_invoice_no" id="bill_invoice_no" value="{{$bill_invoice_no}}" readonly>
                            <div id="bill_invoice_no_error"></div>
                            @error('bill_invoice_no')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-title mt-3" for="invoice_date">Date</label>
                            <input class="form-control" type="text" name="invoice_date" id="invoice_date" placeholder="Date">
                            <div id="invoice_date_error"></div>
                            @error('invoice_date')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-title mt-3" for="name_of_work">Name of Work</label>
                            <input class="form-control" type="text" name="name_of_work" id="name_of_work" placeholder="Name of Work">
                            <div id="name_of_work_error"></div>
                            @error('name_of_work')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-title mt-3" for="work_orderno_date">Work order No & Date</label>
                            <input class="form-control" type="text" name="work_orderno_date" id="work_orderno_date" placeholder="Work order No & Date">
                            <div id="work_orderno_date_error"></div>
                            @error('work_orderno_date')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-title mt-3" for="service_code">Service Code (SAC)</label>
                            <input class="form-control" type="text" name="service_code" id="service_code" placeholder="Service Code (SAC)">
                            <div id="service_code_error"></div>
                            @error('service_code')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-title mt-3" for="service_description">Description of Service</label>
                            <input class="form-control" type="text" name="service_description" id="service_description" placeholder="Description of Service">
                            <div id="service_description_error"></div>
                            @error('service_description')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-title mt-3" for="organization_name">Name of Organisation</label>
                            <input class="form-control" type="text" name="organization_name" id="organization_name" placeholder="Name of Organisation">
                            <div id="organization_name_error"></div>
                            @error('organization_name')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-title mt-3" for="payment_mode">Mode of Payment</label>
                            <input class="form-control" type="text" name="payment_mode" id="payment_mode" placeholder="Mode of Payment">
                            <div id="payment_mode_error"></div>
                            @error('payment_mode')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>                    
                    </div>
                    <hr>
                    <h5>Details of Receiver (Billed To)</h5>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="form-label-title mt-3" for="receiver_name">Name</label>
                            <input class="form-control" type="text" name="receiver_name" id="receiver_name" placeholder="Name">
                            <div id="receiver_name_error"></div>
                            @error('receiver_name')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-title mt-3" for="receiver_address">Address</label>
                            <input class="form-control" type="text" name="receiver_address" id="receiver_address" placeholder="Address">
                            <div id="receiver_address_error"></div>
                            @error('receiver_address')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-title mt-3" for="state_code">State Code</label>
                            <input class="form-control" type="text" name="state_code" id="state_code" placeholder="State Code">
                            <div id="state_code_error"></div>
                            @error('state_code')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                        <div class="col-sm-6">
                            <label class="form-label-title mt-3" for="gstin_unique_id">GSTIN/Unique ID</label>
                            <input class="form-control" type="text" name="gstin_unique_id" id="gstin_unique_id" placeholder="GSTIN/Unique ID">
                            <div id="gstin_unique_id_error"></div>
                            @error('gstin_unique_id')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>                    
                    </div>
                    <hr>
                    <h5>Bill Details</h5>
                    <div class="row">
                        <div class="col-sm-6">
                            <label class="form-label-title mt-3" for="survey_charges">Taxable Bill value</label>
                            <input class="form-control" type="number" name="survey_charges" id="survey_charges" placeholder="Taxable Bill value" oninput="calculateTaxAmount()">
                            <div id="survey_charges_error"></div>
                            @error('survey_charges')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="form-label-title mt-3" for="cgst_percentage">CGST</label>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label-title mt-3" for="cgst_percentage">Rate %</label>
                            <input class="form-control bg-white" type="text" name="cgst_percentage" id="cgst_percentage" value="9" readonly>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label-title mt-3" for="cgst_amount">Amount</label>
                            <input class="form-control bg-white" type="text" name="cgst_amount" id="cgst_amount" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="form-label-title mt-3" for="sgst_percentage">SGST</label>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label-title mt-3" for="sgst_percentage">Rate %</label>
                            <input class="form-control bg-white" type="text" name="sgst_percentage" id="sgst_percentage" value="9" readonly>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label-title mt-3" for="sgst_amount">Amount</label>
                            <input class="form-control bg-white" type="text" name="sgst_amount" id="sgst_amount" readonly>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-sm-4">
                            <label class="form-label-title mt-3" for="survey_charges">IGST</label>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label-title mt-3" for="igst_percentage">Rate %</label>
                            <input class="form-control bg-white" type="text" name="igst_percentage" id="igst_percentage" value="-" readonly>
                        </div>
                        <div class="col-sm-4">
                            <label class="form-label-title mt-3" for="igst_amount">Amount</label>
                            <input class="form-control bg-white" type="text" name="igst_amount" id="igst_amount" readonly>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-4">
                            <label class="form-label-title mt-3" for="total_tax_amount">Total Tax Value (In Figures)</label>
                        </div>
                        <div class="col-sm-4">
                            <input class="form-control bg-white" type="text" name="total_tax_amount" id="total_tax_amount" value="0" readonly>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-4">
                            <label class="form-label-title mt-3" for="total_tax_amount_words">Total Tax Value (In Words)</label>
                        </div>
                        <div class="col-sm-4">
                            <input class="form-control bg-white" type="text" name="total_tax_amount_words" id="total_tax_amount_words" readonly>
                            <div id="survey_charges_error"></div>
                            @error('survey_charges')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-4">
                            <label class="form-label-title mt-3" for="total_invoice_amount">Total Invoice Value (In Figures)</label>
                        </div>
                        <div class="col-sm-4">
                            <input class="form-control bg-white" type="text" name="total_invoice_amount" id="total_invoice_amount" value="0" readonly>
                        </div>
                    </div>
                    <div class="row mt-2">
                        <div class="col-sm-4">
                            <label class="form-label-title mt-3" for="total_invoice_amount_words">Total Invoice Value (In Words)</label>
                        </div>
                        <div class="col-sm-4">
                            <input class="form-control bg-white" type="text" name="total_invoice_amount_words" id="total_invoice_amount_words" readonly>
                            <div id="survey_charges_error"></div>
                            @error('survey_charges')
                                <p style="color: red">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-2">
                        <div class="col-sm-12">
                            <label class="form-label" for="remarks">Remarks</label>
                            <textarea class="form-control" name="remarks" id="remarks" rows="2" placeholder="Type Here..."></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-12">
                            <div class="btn-list d-flex justify-content-end">
                                <button class="btn btn-primary" type="submit">Submit</button>                                
                            </div>
                        </div>
                    </div>
                </form>
			</div>
		</div>
		<!--/div-->

	</div>
</div>
<!-- /Row -->

</div>
</div><!-- end app-content-->
</div>
@endsection
@section('js')
<!-- INTERNAL Data tables -->
<script src="{{URL::asset('assets/plugins/datatable/js/jquery.dataTables.js')}}"></script>
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
<script src="{{URL::asset('assets/js/datatables.js')}}"></script>

<!-- INTERNAL Select2 js -->
<script src="{{URL::asset('assets/plugins/select2/select2.full.min.js')}}"></script>
<script>
    $(document).ready(function(){
        $('#invoice_date').datepicker({
            format: 'dd-mm-yyyy',
            todayHighlight: true,
            startDate: '0',
            autoclose: true
        });
    });
</script>
<script>
    function calculateTaxAmount()
    {
        var survey_charges = $('#survey_charges').val();
        
        var tax_amount = parseInt((survey_charges)/100 * 9);
        $('#cgst_amount').val(tax_amount);
        $('#sgst_amount').val(tax_amount);
    
        var total_gst = parseInt($('#cgst_amount').val()) + parseInt($('#sgst_amount').val());        
        $('#total_tax_amount').val(total_gst);

        var total_invoice_amount = parseInt($('#survey_charges').val()) + parseInt($('#total_tax_amount').val())
        $('#total_invoice_amount').val(total_invoice_amount);
        doConvertTax();
        doConvertTotalAmount();
        doConvertCharges();

    }
    function doConvertCharges()
    {
        let numberInput = document.querySelector('#survey_charges').value ;
        let myDiv = document.querySelector('#survey_charges_words');

        let oneToTwenty = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
        let tenth = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

        if(numberInput.toString().length > 7) return myDiv.innerHTML = 'overlimit' ;
        console.log(numberInput);
        //let num = ('0000000000'+ numberInput).slice(-10).match(/^(\d{1})(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        let num = ('0000000'+ numberInput).slice(-7).match(/^(\d{1})(\d{1})(\d{2})(\d{1})(\d{2})$/);
        console.log(num);
        if(!num) return;

        let outputText = num[1] != 0 ? (oneToTwenty[Number(num[1])] || `${tenth[num[1][0]]} ${oneToTwenty[num[1][1]]}` )+' million ' : ''; 
  
        outputText +=num[2] != 0 ? (oneToTwenty[Number(num[2])] || `${tenth[num[2][0]]} ${oneToTwenty[num[2][1]]}` )+'hundred ' : ''; 
        outputText +=num[3] != 0 ? (oneToTwenty[Number(num[3])] || `${tenth[num[3][0]]} ${oneToTwenty[num[3][1]]}`)+' thousand ' : ''; 
        outputText +=num[4] != 0 ? (oneToTwenty[Number(num[4])] || `${tenth[num[4][0]]} ${oneToTwenty[num[4][1]]}`) +'hundred ': ''; 
        outputText +=num[5] != 0 ? (oneToTwenty[Number(num[5])] || `${tenth[num[5][0]]} ${oneToTwenty[num[5][1]]} `) : ''; 

        document.getElementById("survey_charges_words").value = outputText + 'rupees only';
    }
    function doConvertTax()
    {
        let numberInput = document.querySelector('#total_tax_amount').value ;
        let myDiv = document.querySelector('#total_tax_amount_words');

        let oneToTwenty = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
        let tenth = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

        if(numberInput.toString().length > 7) return myDiv.innerHTML = 'overlimit' ;
        console.log(numberInput);
        //let num = ('0000000000'+ numberInput).slice(-10).match(/^(\d{1})(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        let num = ('0000000'+ numberInput).slice(-7).match(/^(\d{1})(\d{1})(\d{2})(\d{1})(\d{2})$/);
        console.log(num);
        if(!num) return;

        let outputText = num[1] != 0 ? (oneToTwenty[Number(num[1])] || `${tenth[num[1][0]]} ${oneToTwenty[num[1][1]]}` )+' million ' : ''; 
  
        outputText +=num[2] != 0 ? (oneToTwenty[Number(num[2])] || `${tenth[num[2][0]]} ${oneToTwenty[num[2][1]]}` )+'hundred ' : ''; 
        outputText +=num[3] != 0 ? (oneToTwenty[Number(num[3])] || `${tenth[num[3][0]]} ${oneToTwenty[num[3][1]]}`)+' thousand ' : ''; 
        outputText +=num[4] != 0 ? (oneToTwenty[Number(num[4])] || `${tenth[num[4][0]]} ${oneToTwenty[num[4][1]]}`) +'hundred ': ''; 
        outputText +=num[5] != 0 ? (oneToTwenty[Number(num[5])] || `${tenth[num[5][0]]} ${oneToTwenty[num[5][1]]} `) : ''; 

        document.getElementById("total_tax_amount_words").value = outputText + 'rupees only';
    } 
    function doConvertTotalAmount()
    {
        let numberInput = document.querySelector('#total_invoice_amount').value ;
        let myDiv = document.querySelector('#total_invoice_amount_words');

        let oneToTwenty = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
        let tenth = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

        if(numberInput.toString().length > 7) return myDiv.innerHTML = 'overlimit' ;
        console.log(numberInput);
        //let num = ('0000000000'+ numberInput).slice(-10).match(/^(\d{1})(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
        let num = ('0000000'+ numberInput).slice(-7).match(/^(\d{1})(\d{1})(\d{2})(\d{1})(\d{2})$/);
        console.log(num);
        if(!num) return;

        let outputText = num[1] != 0 ? (oneToTwenty[Number(num[1])] || `${tenth[num[1][0]]} ${oneToTwenty[num[1][1]]}` )+' million ' : ''; 
  
        outputText +=num[2] != 0 ? (oneToTwenty[Number(num[2])] || `${tenth[num[2][0]]} ${oneToTwenty[num[2][1]]}` )+'hundred ' : ''; 
        outputText +=num[3] != 0 ? (oneToTwenty[Number(num[3])] || `${tenth[num[3][0]]} ${oneToTwenty[num[3][1]]}`)+' thousand ' : ''; 
        outputText +=num[4] != 0 ? (oneToTwenty[Number(num[4])] || `${tenth[num[4][0]]} ${oneToTwenty[num[4][1]]}`) +'hundred ': ''; 
        outputText +=num[5] != 0 ? (oneToTwenty[Number(num[5])] || `${tenth[num[5][0]]} ${oneToTwenty[num[5][1]]} `) : ''; 

        document.getElementById("total_invoice_amount_words").value = outputText + 'rupees only';
    }
</script>
@endsection