@extends('layouts.app')

@section('content')

<div class="container">
	<h1>Show Invoice</h1>
	<a href="{{ route('invoice.index') }}" class="btn btn-success">Go back</a><br><br>
    <a href="{{ route('invoice.print', ['id' => $invoice->id]) }}" class="btn btn-success" target="_blank">Print Invoice</a><br><br>
</div>

<div class="container"> 
    <div class="row">
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Invoice Num</h3>
                </div>
                <div class="panel-body">
                    {{$invoice->invoice_num}}
                </div>
            </div>
        </div>
        <div class="col-sm-9">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Sender Company</h3>
                </div>
                <div class="panel-body">
                    {{$invoice['sender_company']['name']}}
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Amount</h3>
                </div>
                <div class="panel-body">
                    {{number_format($invoice->amount, 2, '.', ',')}}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">VAT</h3>
                </div>
                <div class="panel-body">
                    {{number_format($invoice->vat, 2, '.', ',')}}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Paid</h3>
                </div>
                <div class="panel-body">
                    {{number_format($invoice->paid, 2, '.', ',')}}
                </div>
            </div>
        </div>
        <div class="col-sm-3">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Balance</h3>
                </div>
                <div class="panel-body">
                    {{number_format($invoice->bal, 2, '.', ',')}}
                </div>
            </div>
        </div>
    </div>
</div>
@if(count($txns) > 0)
<?php
    $colcount = count($txns);
    $i = 1;
?>
<div class="container">
	<table class="table table-striped" >
        <tr>
        	<th width="10.33%">Sender Company</th>
            <th width="9.33%">AWB#</th>
            <th width="13.33%">Origin</th>
            <th width="13.33%">Destination</th>
            <th width="8.33%">Parcel Type</th>
            <th width="4.33%">Price</th>
            <th width="4.33%">VAT</th>
            <th width="8.33%">Rider</th>
            <th width="8.33%">Mode</th>
            <th width="8.33%">Parcel Status</th>         
            <th width="11.33%">Date/Time Created</th>
            <th width="3.33%">Invoiced</th>
        </tr>

        @foreach($txns as $txn)
        <tr>
            <td>{{$txn['sender_company_name']}}</td>
            <td>{{$txn['awb_num']}}</td>
            <td>{{$txn['origin_addr']}}</td>
            <td>{{$txn['dest_addr']}}</td>
            <td>{{$txn['parcel_type']['name']}}</td>
            <td>{{number_format($txn['price'], 2, '.', ',')}}</td>
            <td>{{number_format($txn['vat'], 2, '.', ',')}}</td>
            <td>{{$txn['driver']['fullname']}}</td>
            @if ($txn['mode'] == 0)
            <td>Normal</td>
            @else ($txn['mode'] == 1)
            <td>Express</td>
            @endif
            <td>{{$txn['parcel_status']['name']}}</td>
            <td>{{$txn['created_at']}}</td>
            @if ($txn['invoiced'] == 0)
            <td>No</td>
            @else ($txn['invoiced'] == 1)
            <td>Yes</td>
            @endif
        </tr>
        @endforeach
    </table>
</div>
@else
	<p>No Transactions To Display</p>
@endif
		
@endsection