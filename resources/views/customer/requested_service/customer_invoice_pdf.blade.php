<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Survey Invoice</title>
        <!-- Bootstrap css-->
        <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/css/bootstrap.css')}}">
        <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/css/bootstrap-datepicker.min.css')}}">
        <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/css/dropzone.css')}}">
        <!-- App css-->
        <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/css/style.css')}}">
        <link rel="stylesheet" type="text/css" href="{{URL::asset('public/assets/css/custom.css')}}">
        <style>
            @media print {
                .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6,
                .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12 {
                    float: left;               
                }

                .col-sm-12 {
                    width: 100%;
                }

                .col-sm-11 {
                    width: 91.66666666666666%;
                }

                .col-sm-10 {
                    width: 83.33333333333334%;
                }

                .col-sm-9 {
                        width: 75%;
                }

                .col-sm-8 {
                        width: 66.66666666666666%;
                }

                .col-sm-7 {
                        width: 58.333333333333336%;
                }

                .col-sm-6 {
                        width: 50%;
                }

                .col-sm-5 {
                        width: 41.66666666666667%;
                }

                .col-sm-4 {
                        width: 33.33333333333333%;
                }

                .col-sm-3 {
                        width: 25%;
                }

                .col-sm-2 {
                        width: 16.666666666666664%;
                }

                .col-sm-1 {
                        width: 8.333333333333332%;
                    }            
            }
        </style>
    </head>
    <body>
        <div class="card newser">
            <div class="card-body">
                <div id="invoice_div">
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
                </div>
            </div>
        </div>
    </body>
</html>