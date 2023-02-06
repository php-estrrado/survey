<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
    </head>
    <body>
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
            </div>
        </div>
    </body>
</html>