@extends('layouts.app')

@section('content')
<div class="panel-heading"><h1>Manage Shipments </h1> </div>
<a href="{{ route('shipments.add') }}" class="btn btn-success">Add Shipment</a><br>
<div><a class="pull-right btn btn-default" href="{{ route('shipments.index') }}">Reset</a> </div>
<hr>
<strong>Filter Options: </strong>
<input type="checkbox" autocomplete="off" onchange="checkfilter(this.checked);"/>
<div id="filteroptions" style="display: none ;">
  {!! Form::open(['action' => 'TxnsController@getShipments', 'method' => 'GET']) !!}

    <table class="table" width="100%" table-layout="fixed">
      <tbody>
      <tr>
        <td width="33.3%">
          <div class="form-group">
              {{Form::label('awb_num', 'AWB #')}}
              {{Form::text('awb_num', '', ['class' => 'form-control'])}}
          </div></td>
          <td width="33.3%"><div class="form-group">
              {{Form::label('sender_company_id', 'Customer Company')}}
              {{Form::select('sender_company_id', ['' => ''] + $cuscompanies + [0 => 'Others'] ,'', ['class' => 'form-control'])}}
          </div></td>
          <td width="33.3%"><div class="form-group">
              {{Form::label('rider_id', 'Rider')}}
              {{Form::select('rider_id', ['' => ''] + $riders, '', ['class' => 'form-control', 'id' => 'rider_id'])}}
          </div></td>

          
      </tr>
      <tr>
        <td><div class="form-group">
              {{Form::label('parcel_status_id', 'Parcel Status')}}
              {{Form::select('parcel_status_id', ['' => '', '7' => 'Booked', '10' => 'Received at sort facility', '2' => 'Dispatched', '4' => 'Received at destination', '6' => 'Cancelled', '5' => 'Lost'], '', ['class' => 'form-control', 'id' => 'parcel_status_id'])}}
          </div></td>
          <td ><div class="form-group">
            {{Form::label('first_date', 'First Booked Date')}}
            {{Form::text('first_date', '', ['class' => ' first_date form-control', 'placeholder' => 'yyyy-mm-dd'])}}
          </div></td>
          <td ><div class="form-group">
            {{Form::label('last_date', 'End Booked Date')}}
            {{Form::text('last_date', '', ['class' => 'last_date form-control', 'placeholder' => 'yyyy-mm-dd'])}}
          </div></td>
      </tr>
      
      </tbody>
    </table>
    {{Form::submit('Submit', ['class'=>'btn btn-primary', 'name' => 'submitBtn'])}}
    {{Form::submit('CreatePDF', ['class'=>'btn btn-primary', 'name' => 'submitBtn', 'formtarget' => '_blank'])}}
</div>
<hr>
@if(count($txns) > 0)
  <?php
    $colcount = count($txns);
    $i = 1;
  ?>
  <div class="panel panel-default">
    <div class="panel-body">
      <div class="col-md-4 col-sm-12 col-xs-12">
        <div class="well dash-box">
            <h2><span class="glyphicon glyphicon-th-list" aria-hidden="true"></span> 
            {{$tot_count}} </h2>
            <h4>No of Transactions</h4>
        </div>
      </div>
    </div>
  </div>
      <table class="table table-striped" >
          <tr>
            <th width="10.33%">Sender Company</th>
            <th width="9.33%">AWB#</th>
            <th width="13.33%">Origin</th>
            <th width="13.33%">Destination</th>
            <th width="8.33%">Parcel Type</th>
            <th width="8.33%">Rider</th>
            <th width="8.33%">Mode</th>
            <th width="8.33%">Parcel Status</th>         
            <th width="11.33%">Date/Time Created</th>
            <th width="3.33%">Acknowledge</th>
            <th></th>
            <th></th>
          </tr>
          @foreach($txns as $txn)
          <tr>
            <td>{{$txn['sender_company_name']}}</td>
            <td>{{$txn['awb_num']}}</td>
            <td>{{$txn['origin_addr']}}</td>
            <td>{{$txn['dest_addr']}}</td>
            <td>{{$txn['parcel_type']['name']}}</td>
            <td>{{$txn['driver']['fullname']}}</td>
            @if ($txn['mode'] == 0)
            <td>Normal</td>
            @else ($txn['mode'] == 1)
            <td>Express</td>
            @endif
            <td>{{$txn['parcel_status']['name']}}</td>
            <td>{{$txn['created_at']}}</td>
            @if ($txn['acknowledge'] == 0)
            <td>No</td>
            @else ($txn['acknowledge'] == 1)
            <td>Yes</td>
            @endif
            <td><a class="pull-right btn btn-default btn-xs" target="_blank" href="{{ route('shipments.print', ['awb' => $txn->id ]) }}">Print</a></td>
            <td><a class="pull-right btn btn-default btn-xs" href="{{ route('shipments.edit', ['awb' => $txn->id ]) }}">Edit/Details</a></td>
        </tr>
          @endforeach
      </table>
      {{ $txns->appends(request()->input())->links() }}
@else
  <p>No Transactions To Display</p>
@endif


<script type="text/javascript">
jQuery(document).ready(function($) {
    $(".clickable-row").click(function() {
        window.location = $(this).data("href");
    });
});
</script>
@endsection