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
                    <div class="card-header  card-header--2 package-card">
                        <div>
                            <h5>File Number</h5>
                        </div>
                    </div>

                    <div class="card-body">

                        <div class="description-section tab-section">
                            <div class="detail-img">
                                <img src="../assets/images/tours/spain.jpg" class="img-fluid blur-up lazyload" alt="">
                            </div>
                            <div class="menu-top menu-up">
                                <ul class="nav nav-tabs" id="top-tab" role="tablist">
                                    <li class="nav-item"><a data-bs-toggle="tab" class="nav-link active" href="#highlight">Timeline</a></li>
                                    <li class="nav-item"><a data-bs-toggle="tab" class="nav-link" href="#itinerary">Invoice Details</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="description-details tab-content" id="top-tabContent">
                                <div class="menu-part about tab-pane fade show active" id="highlight">
                                    <ul class="timelineleft pb-5 mt-5">
                                        <li> <i class="fa fa-clock-o bg-primary"></i>
                                            <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 12:05</span>
                                                <h3 class="timelineleft-header"><a href="report-received.html">Survey report received</a></h3>
                                            </div>
                                        </li>
                                        <li> <i class="fa fa-clock-o bg-secondary"></i>
                                            <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 5 mins ago</span>
                                                <h3 class="timelineleft-header">Survey study conducted by surveyor</h3>
                                            </div>
                                        </li>
                                        <li> <i class="fa fa-clock-o bg-warning"></i>
                                            <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 27 mins ago</span>
                                                <h3 class="timelineleft-header">Assigned to sub office</h3>
                                            </div>
                                        </li>
                                        <li> <i class="fa fa-clock-o bg-pink"></i>
                                            <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 1 hour ago</span>
                                                <h3 class="timelineleft-header"><a href="receipt-rejected.html">Invoice rejected</a></h3>
                                            </div>
                                        </li>
                                        <li> <i class="fa fa-clock-o bg-orange"></i>
                                            <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 2 days ago</span>
                                                <h3 class="timelineleft-header">Invoice received</h3>
                                            </div>
                                        </li>
                                        <li> <i class="fa fa-clock-o bg-pink"></i>
                                            <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 5 days ago</span>
                                                <h3 class="timelineleft-header">Field study conducted by surveyor</h3>
                                            </div>
                                        </li>
                                        <li> <i class="fa fa-clock-o bg-success pb-3"></i> 
                                            <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 5 days ago</span>
                                                <h3 class="timelineleft-header">Assigned to sub office</h3>
                                            </div>
                                        </li>
                                        <li> <i class="fa fa-clock-o bg-secondary"></i>
                                            <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 5 mins ago</span>
                                                <h3 class="timelineleft-header">Service request accepted</h3>
                                            </div>
                                        </li>
                                        <li> <i class="fa fa-clock-o bg-warning"></i>
                                            <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 27 mins ago</span>
                                                <h3 class="timelineleft-header"><a href="rejected-open.html">Service request rejected open</a></h3>
                                            </div>
                                        </li>
                                        <li> <i class="fa fa-clock-o bg-pink"></i>
                                            <div class="timelineleft-item"> <span class="time"><i class="fa fa-clock-o text-danger"></i> 1 hour ago</span>
                                                <h3 class="timelineleft-header"><a href="request-rejected.html">Service request rejected</a></h3>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                                <div class="menu-part accordion tab-pane fade " id="itinerary">
                                    <div class="card newser">
						                <div class="card-body">
                                            <div id="invoice_div">
                                                <div class="card-title font-weight-bold">Invoice</div>
                                                <div class="row">
                                                    <div>
                                                        <strong>Hi {{$survey_data->receiver_name}},</strong>
                                                        <br />
                                                        This is the receipt for a payment of &#8377; <strong>{{$survey_data->survey_charges}}</strong> for your works
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-6">
                                                        <p>Payment No. <br> <strong>{{$survey_data->bill_invoice_no}}</strong></p>
                                                    </div>
                                                    <div class="col-md-6" style="display: flex; justify-content: end;">
                                                        <p>Payment Date <br> <strong>{{date('d/m/Y',strtotime($survey_data->invoice_date))}}</strong></p>
                                                    </div>
                                                </div>
                                                <hr>
                                                <div class="row" style="margin-top: 10px;">
                                                    <div class="col-md-6">
                                                        <p><strong>Bill From</strong> <br> hsw address <br> hsw email</p>
                                                    </div>
                                                    <div class="col-md-6" style="display: flex; justify-content: end;">
                                                        <p><strong>Bill To</strong> <br> {{$survey_data->receiver_address}} <br> {{$survey_data->username}}</p>
                                                    </div>
                                                </div>
                                                <div class="row" style="margin-top: 10px;">
                                                    <table class="table table-bordered table-striped">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 5%;"></th>
                                                                <th><strong>Service</strong></th>
                                                                <th style="text-align: right; width:10%"><strong>Amount</strong></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr>
                                                                <td style="width: 5%;">1</td>
                                                                <td>{{$survey_data->name_of_work}}</td>
                                                                <td style="text-align: right; width:10%">{{$survey_data->survey_charges}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="text-align: right;">
                                                                    Subtotal
                                                                </td>
                                                                <td style="text-align: right; width:10%">{{$survey_data->survey_charges}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="text-align: right;">
                                                                    Tax
                                                                </td>
                                                                <td style="text-align: right; width:10%">{{$survey_data->cgst_percentage}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="text-align: right;">
                                                                    Tax Amount
                                                                </td>
                                                                <td style="text-align: right; width:10%">{{$survey_data->total_tax_amount}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td colspan="2" style="text-align: right;">
                                                                    <strong>TOTAL</strong>
                                                                </td>
                                                                <td style="text-align: right; width:10%"><strong>&#8377; {{$survey_data->total_invoice_amount}}</strong></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                            <ul class="list-inline pull-right">
                                                <li><a href="{{url('/customer/customer_invoice_download')}}/{{$survey_data->survey_id}}"><button type="button" class="btn btn-info">Download</button></a></li>
                                                <li><button type="button" class="btn btn-info" onclick="printDiv()">Print</button></li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="card newser">
						                <div class="card-body">
                                            {{ Form::open(array('url' => "/customer/customer_receipt_upload/", 'id' => 'receiptForm', 'name' => 'receiptForm', 'class' => '','files'=>'true')) }}
                                                @csrf
			                                    {{Form::hidden('id',$survey_data->survey_id,['id'=>'id'])}}
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <div class="form-group">
                                                            <label class="form-label" for="receipt">Profile Pic <span class="text-red">*</span></label>
                                                            <div class="custom-file">
                                                                <input type="file" class="custom-file-input" name="receipt" id="receipt">
                                                                <label class="custom-file-label"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <img id="receipt_img" src="{{url('storage/app/public/no-avatar.png')}}" alt="avatar" style="height: 120px;" />
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="btn-list d-flex justify-content-end">
                                                        <button class="btn btn-info" type="submit" name="submit">Save</button>
                                                        <a href="{{URL('/customer/requested_services')}}" class="btn btn-danger">Cancel</a>
                                                    </div>
                                                </div>
                                            {{Form::close()}}
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

    @include('includes.customer_footer')
</div>
@endsection
@section('js')
    <script type="text/javascript">
        $(document).ready(function(){
            @if(Session::has('message'))
                @if(session('message')['type'] =="success")
                    toastr.success("{{session('message')['text']}}"); 
                @else
                    toastr.error("{{session('message')['text']}}"); 
                @endif
            @endif
            
            @if ($errors->any())
                @foreach ($errors->all() as $error)
                    toastr.error("{{$error}}"); 
                @endforeach
            @endif
        });
    </script>
    <script>
        function printDiv()
        {
            var divToPrint=document.getElementById('invoice_div');
            var newWin=window.open('','Print-Window');
            newWin.document.open();
            newWin.document.write('<html><body onload="window.print()">'+divToPrint.innerHTML+'</body></html>');
            newWin.document.close();
            setTimeout(function(){newWin.close();},10);
        }
    </script>
    <script>
        if (window.File && window.FileList && window.FileReader)
        {
            $("#avatar").on("change", function(e) {
                $(".pip1").remove();
                var files = e.target.files,
                filesLength = files.length;
                for (var i = 0; i < filesLength; i++)
                {
                    var f = files[i]
                    var fileReader = new FileReader();
                    fileReader.onload = (function(e) {
                        var file = e.target;
                        // $("<span class=\"pip1\">" +
                        //   "<input type=\"file\" id=\"havefil\" hidden name=\"havefil[]\" value=\"" + e.target.result + "\"/>"+
                        //   "<img class=\"imageThumb1\" src=\"" + e.target.result + "\" title=\"" + file.name + "\"/>" +
                        //   "<br/>" +
                        //   "</span>").insertAfter("#avatar");
                        // $(".remove").click(function(){
                        //   $(this).parent(".pip").remove();
                        // });

                        $("#receipt_img").attr("src",e.target.result);

                        // <span class=\"remove\">Remove image</span>Old code here
                        /*$("<img></img>", {
                            class: "imageThumb",
                            src: e.target.result,
                            title: file.name + " | Click to remove"
                        }).insertAfter("#avatar").click(function(){$(this).remove();});*/
                    });
                    fileReader.readAsDataURL(f);
                }
            });
        }
        else
        {
            alert("Your browser doesn't support to File API")
        }
    </script>
@endsection