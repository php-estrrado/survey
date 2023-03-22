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

                <!--div-->
                <div class="card">
                    <div class="card-header">
                        <div class="card-title">Notifications List</div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-bordered text-nowrap" id="example2">
                                <thead>
                                    <tr>
                                        <th class="wd-15p border-bottom-0">SL. NO</th>
                                        <th class="wd-15p border-bottom-0">Title</th>
                                        <th class="wd-20p border-bottom-0">Description</th>						
                                        <th class="wd-20p border-bottom-0">Created On</th>
                                    </tr>
                                </thead>
                                <tbody class="marknotifications">
                                    @if($notifications && count($notifications) > 0)
                                        @php $i=1; @endphp
                                        @foreach($notifications as $notify)
                                            <tr>
                                                <td>{{ $i; }}</td>
                                                <td><a href="{{ url($notify->ref_link) }}" style="color:#2b8fca; <?php if($notify->viewed ==1){ echo 'font-weight:normal;';  }else{ echo 'font-weight:bold;'; } ?> " data-id="{{ $notify->id }}">{{ $notify->title }}</a></td>
                                                <td>{{ $notify->description }}</td>
                                                <td>{{  date('d/m/Y', strtotime($notify->created_at)); }}</td>
                                            </tr>
                                            @php $i++; @endphp
                                        @endforeach
                                    @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--/div-->

            </div>
        </div>
    </div>
    @include('includes.customer_footer')
</div>
@endsection