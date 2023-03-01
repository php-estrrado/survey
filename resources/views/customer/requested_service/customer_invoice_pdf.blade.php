<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Untitled Document</title>
	<style>
		body{
			font-size: 14px;
		}
		.table{
			border-collapse: collapse;
		}
		.table thead, .table tbody, .table tfoot, .table tr, .table td, .table th {
			padding: 0.25rem 0.25rem 0.25rem 0rem;
		}
		.table-bordered thead, .table-bordered tbody, .table-bordered tfoot, .table-bordered tr, .table-bordered td, .table-bordered th {
			border-color: #f2f4ff;
			border: 1px solid rgba(153, 153, 153, 0.3);
			padding: 0.35rem;
		}
		.tearhere{
			position: relative;
			height: 50px;
		}
		.tear {
			border:0;
			border-top: 3px dashed #d9d9d9;
			background-color: transparent;
			opacity: 1;
		}
		.scis {
			position: relative;
			margin: 0 auto;
			display: block;
			z-index: 1;
			width: 170px;
			text-align: center;
			top: 20px;
			background: #fff;
		}
		.space{
			height: 20px;
			display: block;
		}
	</style>
</head>

<body>
	
<table class="table" width="100%" border="0" cellspacing="1" cellpadding="1">
  <tbody>
    <tr>
		<td colspan="3"><b>Basic Info</b></td>
    </tr>
    <tr>
      <td width="35%">Bill / Invoice No.</td>
      <td width="35%">Name Of Work</td>
      <td width="30%">Work Order No And Date</td>
    </tr>
    <tr>
      <td>{{$survey_data->bill_invoice_no}}</td>
      <td>{{$survey_data->name_of_work}}</td>
      <td>{{$survey_data->work_orderno_date}}</td>
    </tr>
    <tr>
      <td>Service code (SAC)</td>
      <td colspan="2">Description of Service:</td>
    </tr>
    <tr>
      <td>{{$survey_data->service_code}}</td>
      <td colspan="2">{{$survey_data->service_description}}</td>
    </tr> 
    <tr>
      <td>Name of organisation</td>
      <td colspan="2">Address</td>
    </tr>
    <tr>
      <td>{{$survey_data->organization_name}}</td>
      <td colspan="2">Chief Hydrographer, Hydrographic Survey wing, Thiruvananthapuram-695009</td>
    </tr>
  </tbody>
</table>
	
<div class="space">	</div>
	
<table class="table" width="100%" border="0" cellspacing="1" cellpadding="1">
  <tbody>
    <tr>
      <td colspan="2"><b>Details Of Receiver (Billed To)</b></td>
    </tr>
    <tr>
      <td width="35%">Name</td>
      <td width="65%">Address</td>
    </tr>
    <tr>
      <td>{{$survey_data->receiver_name}}</td>
      <td>{{$survey_data->receiver_address}}</td>
    </tr>
    <tr>
      <td>State Code</td>
      <td>GSTIN/ Unique ID</td>
    </tr>
    <tr>
      <td>{{$survey_data->state_code}}</td>
      <td>{{$survey_data->gstin_unique_id}}</td>
    </tr>
  </tbody>
</table>	
	
<div class="space">	</div>	
	
<table class="table-bordered" width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tbody>
		<tr>
			<td rowspan="4" width="2%">a</td>
			<td colspan="3" align="center"><b>Survey Charges</b></td>
		</tr>
		<tr>
			<td colspan="2" align="center">Amount</td>
			<td width="50%" align="center">Head Of Account</td>
		</tr>
		<tr>
			<td width="11%">In Figures</td>
			<td width="37%">{{$survey_data->survey_charges}}</td>
			<td rowspan="2" align="center">1051-80-800-96-03-mis-HSW
				(through Treasury In words / e-treasury)</td>
		</tr>
		<tr>
			<td>In Words</td>
			<td>{{$survey_data->survey_charges_words}}</td>
		</tr>
	</tbody>
</table>
	
<div class="tearhere">
	<span class="scis"> Please Tear Here </span>
	<hr class="tear">
</div>
	
<table class="table-bordered" width="100%" border="0" cellspacing="0" cellpadding="0">
  	<tbody>
		<tr>
			<td rowspan="7" width="2%">b</td>
			<td colspan="4" align="center"><b>GST (GSTIN: 32AAAGH0628E1Z2)</b></td>
		</tr>
		<tr>
			<td colspan="3" align="center">Amount</td>
			<td width="40%" align="center">Bank Account Details</td>
		</tr>
		<tr>
			<td width="16%">CGST</td>
			<td width="4%">{{$survey_data->cgst_percentage}}%</td>
			<td width="38%">{{$survey_data->cgst_amount}}</td>
			<td rowspan="5" align="center">A/c no: 00000037884341757,
				SBI, Fort, Trivandrum.
				IFSC: SBIN0060333</td>
		</tr>
		<tr>
			<td>SGST</td>
			<td>{{$survey_data->sgst_percentage}}%</td>
			<td>{{$survey_data->sgst_amount}}</td>
		</tr>
		<tr>
			<td>IGST</td>
			<td>-</td>
			<td>-</td>
		</tr>
		<tr>
			<td>Total(in figures)</td>
			<td colspan="2">{{$survey_data->total_tax_amount}}</td>
		</tr>
		<tr>
			<td>Total(in words)</td>
			<td colspan="2">{{$survey_data->total_tax_amount_words}}</td>
		</tr>
	</tbody>
</table>	
	
<div class="space">	</div>	
<table class="table" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tbody>
    <tr>
      <td>Grand Total (a+b) (in figures):</td>
      <td>Grand Total (a+b) (in words):</td>
    </tr>
    <tr>
      <td><b>Rs. {{$survey_data->total_invoice_amount}}.00</b></td>
		<td><b>Rs. {{$survey_data->total_invoice_amount_words}}</b></td>
    </tr>
  </tbody>
</table>
	
</body>
</html>