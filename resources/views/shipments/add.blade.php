@extends('layouts.app')

@section('content')

<div class="container"> 
    <h1>Add Shipment</h1>
</div>
{!! Form::open(['action' => 'TxnsController@storeShipment', 'method' => 'POST', 'enctype' => 'multipart/form-data']) !!}
<div class="container">
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Sender Details</h3>
                </div>
                <div class="panel-body">
                    <div class="input-group">
                        <span class="input-group-addon" >Name</span>
                        <input type="text" id="sender_name" name="sender_name" value="{{old('sender_name')}}" class="form-control"  aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">Company *</span>
                        {{Form::select('sender_company', ['' => ''] + $companies + ['0' => 'Others'], old('sender_company'), ['class' => 'form-control', 'id' => 'sender_company'])}}
                    </div>
                    <div class="input-group" id="other_company_name" style="display: none ;">
                        <span class="input-group-addon">Company Name *</span>
                        <input type="text" id="other_company" name="other_company" value="{{ old('other_company') }}" class="form-control"  aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">Phone</span>
                        <input type="text" id="sender_phone" name="sender_phone" value="{{old('sender_phone')}}" class="form-control"  aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Receiver Details</h3>
                </div>
                <div class="panel-body">
                    <div class="input-group">
                        <span class="input-group-addon" >Name *</span>
                        <input type="text" id="receiver_name" name="receiver_name" value="{{ old('receiver_name') }}" class="form-control"  aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">Company *</span>
                        <input type="text" id="receiver_company" name="receiver_company" value="{{ old('receiver_company') }}" class="form-control"  aria-describedby="basic-addon1">
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon">Phone *</span>
                        <input type="text" id="receiver_phone" name="receiver_phone" value="{{ old('receiver_phone') }}" class="form-control" placeholder="e.g. 254723000000" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>
        </div>
     </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Origin - Physical Address</h3>
                </div>
                <div class="panel-body">
                    <div class="input-group">
                        <span class="input-group-addon" >Building Name *</span>
                        <input type="text" id="origin_addr_1" name="origin_addr_1" value="{{ old('origin_addr_1')  }}" class="form-control"  aria-describedby="basic-addon1" >
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" >Floor no/Office no</span>
                        <input type="text" id="origin_addr_2" name="origin_addr_2" value="{{ old('origin_addr_2')  }}" class="form-control"  aria-describedby="basic-addon1" >
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" >Street/Road Name</span>
                        <input type="text" id="origin_addr_3" name="origin_addr_3" value="{{ old('origin_addr_3')  }}" class="form-control"  aria-describedby="basic-addon1" >
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" >Area Name</span>
                        <input type="text" id="origin_addr_4" name="origin_addr_4" value="{{ old('origin_addr_4')  }}" class="form-control"  aria-describedby="basic-addon1" >
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Destination - Physical Address</h3>
                </div>
                <div class="panel-body">
                    <div class="input-group">
                        <span class="input-group-addon" >Building Name *</span>
                        <input type="text" id="dest_addr_1" name="dest_addr_1" value="{{ old('dest_addr_1')  }}" class="form-control"  aria-describedby="basic-addon1" >
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" >Floor no/Office no</span>
                        <input type="text" id="dest_addr_2" name="dest_addr_2" value="{{ old('dest_addr_2')  }}" class="form-control"  aria-describedby="basic-addon1" >
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" >Street/Road Name</span>
                        <input type="text" id="dest_addr_3" name="dest_addr_3" value="{{ old('dest_addr_3')  }}" class="form-control"  aria-describedby="basic-addon1" >
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" >Area Name</span>
                        <input type="text" id="dest_addr_4" name="dest_addr_4" value="{{ old('dest_addr_4')  }}" class="form-control"  aria-describedby="basic-addon1" >
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Shipment Type</h3>
                </div>
                <div class="panel-body">
                    <div class="input-group">
                        <span class="input-group-addon" >Type *</span>
                        {{Form::select('parcel_type_id', ['' => ''] + $parcel_types, old('parcel_type_id'), ['class' => 'form-control'])}}
                    </div>
                    <div class="input-group">
                        <span class="input-group-addon" >Description</span>
                        <input type="text" id="parcel_desc" name="parcel_desc" value="{{ old('parcel_desc') }}" class="form-control"  aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Booking Mode</h3>
                </div>
                <div class="panel-body">
                    <div class="input-group">
                        <span class="input-group-addon" >Mode *</span>
                        {{Form::select('mode', ['' => '', 0 => 'Normal', 1 => 'Express'],  '0' , ['class' => 'form-control', 'disabled' => 'true' ])}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Units</h3>
                </div>
                <div class="panel-body">
                    <div class="input-group">
                        <span class="input-group-addon" >No of units *</span>
                        <input type="text" id="units" name="units" value="{{ old('units')}}" class="form-control" placeholder="e.g. 1" aria-describedby="basic-addon1">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <h3 class="panel-title">Bring Back Acknowledgement Docs</h3>
                </div>
                <div class="panel-body">
                    <div class="input-group">
                        <span class="input-group-addon" >Required *</span>
                        {{Form::select('acknowledge', ['' => '', 0 => 'No', 1 => 'Yes'], '0', ['class' => 'form-control'])}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-12 text-center"> 
        <input type="submit" value="Submit" class="btn btn-primary btn-xl" name="submitBtn" onclick="this.disabled=true;this.form.submit();">
    </div>
</div>
{!! Form::close() !!}

<script type="text/javascript">
    jQuery(document).ready(function($) {
        $('#sender_company').change(function(){
            var i= $('#sender_company').val();
            if (i == '0'){
                $('#other_company_name').show();
            }
            else {
                $('#other_company_name').hide();
            }
        });
    });
</script>

@endsection