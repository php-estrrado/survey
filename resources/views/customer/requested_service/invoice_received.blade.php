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
                        <h5>HSW{{$survey_data->survey_request_id}}</h5>
                    </div>
                    <a style="float:right ;" href="{{url('/customer/customer_invoice_download/')}}/{{$survey_data->survey_id}}"><button class="btn btn-primary">Download</button></a>
                </div>

                <div class="card-body">
                    <div class="card-title font-weight-bold"><b>Basic info:</b></div>
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <div class="media-body">
                                    <div class="font-weight-normal1">
                                        Bill / Invoice No.
                                    </div>
                                </div>
                                <label class="form-label">{{$survey_data->bill_invoice_no}}</label>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <div class="media-body">
                                    <div class="font-weight-normal1">
                                        Name Of Work
                                    </div>
                                </div>
                                <label class="form-label">{{$survey_data->name_of_work}}</label>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <div class="media-body">
                                    <div class="font-weight-normal1">
                                        Work Order No And Date
                                    </div>
                                </div>
                                <label class="form-label">{{$survey_data->work_orderno_date}}</label>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <div class="media-body">
                                    <div class="font-weight-normal1">
                                        Service code (SAC)
                                    </div>
                                </div>
                                <label class="form-label">{{$survey_data->service_code}}</label>
                            </div>
                        </div>
                        <div class="col-sm-8 col-md-8">
                            <div class="form-group">
                                <div class="media-body">
                                    <div class="font-weight-normal1">
                                        Description of Service:
                                    </div>
                                </div>
                                <label class="form-label">{{$survey_data->service_description}}</label>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <div class="media-body">
                                    <div class="font-weight-normal1">
                                        Name of organisation:
                                    </div>
                                </div>
                                <label class="form-label">{{$survey_data->organization_name}}</label>
                            </div>
                        </div>
                        <div class="col-sm-8 col-md-8">
                            <div class="form-group">
                                <div class="media-body">
                                    <div class="font-weight-normal1">
                                        Address
                                    </div>
                                </div>
                                <label class="form-label">Chief Hydrographer,
                                    Hydrographic Survey wing,
                                    Thiruvananthapuram-695009</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card-title font-weight-bold mt-5"><b>Details Of Receiver (Billed To)</b></div>
                    <div class="row">
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <div class="media-body">
                                    <div class="font-weight-normal1">
                                        Name
                                    </div>
                                </div>
                                <label class="form-label">{{$survey_data->receiver_name}}</label>
                            </div>
                        </div>
                        <div class="col-sm-84 col-md-8">
                            <div class="form-group">
                                <div class="media-body">
                                    <div class="font-weight-normal1">
                                        Address
                                    </div>
                                </div>
                                <label class="form-label">{{$survey_data->receiver_address}}</label>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <div class="media-body">
                                    <div class="font-weight-normal1">
                                        State Code
                                    </div>
                                </div>
                                <label class="form-label">{{$survey_data->state_code}}</label>
                            </div>
                        </div>
                        <div class="col-sm-4 col-md-4">
                            <div class="form-group">
                                <div class="media-body">
                                    <div class="font-weight-normal1">
                                        GSTIN/ Unique ID
                                    </div>
                                </div>
                                <label class="form-label">{{$survey_data->gstin_unique_id}}</label>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered card-table table-vcenter text-nowrap">
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
                            </div>
                        </div>
                    </div>
                    <div style="position: relative;">
                        <span class="scis"> <i class="fa fa-scissors"> </i> Please Tear Here <i class="fa fa-scissors"> </i> </span>
                        <hr class="tear">
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-md-12">
                            <div class="table-responsive">
                                <table class="table table-bordered card-table table-vcenter text-nowrap">
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
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="row">
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <div class="media-body">
                                    <div class="font-weight-normal1">
                                        Grand Total (a+b) (in figures):
                                    </div>
                                </div>
                                <label class="form-label"><b>Rs. {{$survey_data->total_invoice_amount}}.00</b></label>
                            </div>
                        </div>
                        <div class="col-sm-6 col-md-6">
                            <div class="form-group">
                                <div class="media-body">
                                    <div class="font-weight-normal1">
                                        Grand Total (a+b) (in words):
                                    </div>
                                </div>
                                <label class="form-label"><b>Rs. {{$survey_data->total_invoice_amount_words}}</b></label>
                            </div>
                        </div>
                    </div>
                    <!-- <div class="row g-2">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label-title mt-3">Upload receipt</label>
                                <div class="dropzone" id="singleFileUpload">
                                  <div class="dz-message needsclick"><i class="icon-cloud-up"></i>
                                      <h6>Drop files here or click to upload.</h6><span
                                          class="note needsclick">(This is just a
                                          demo dropzone. Selected files are <strong>not</strong>
                                          actually uploaded.)</span>
                                  </div>
                                </div>
                              </div>
                        </div>
                    </div> -->
                    <hr />
                    <div class="card newser">
                        <div class="card-body">
                            {{ Form::open(array('url' => "/customer/customer_receipt_upload/", 'id' => 'receiptForm', 'name' => 'receiptForm', 'class' => '','files'=>'true')) }}
                                @csrf
                                {{Form::hidden('id',$survey_data->survey_id,['id'=>'id'])}}
                                <div class="row">
                                    <div class="col-sm-12 col-md-12">
                                        <label class="form-label-title mt-3" for="receipt">Upload receipt</label>
                                        <input class="form-control" type="file" name="receipt" id="receipt" placeholder="Choose Valid File">
                                        <div id="receipt_error"></div>
                                        @error('receipt')
                                            <p style="color: red">{{ $message }}</p>
                                        @enderror
                                    </div>
                                </div>
                                <div class="row mt-3">
                                    <div class="btn-list d-flex justify-content-end">
                                        <button class="btn btn-primary" style="float:right ;" type="submit">Submit</button>
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