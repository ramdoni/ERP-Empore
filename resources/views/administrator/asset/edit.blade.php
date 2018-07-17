@extends('layouts.administrator')

@section('title', 'List Asset')

@section('sidebar')

@endsection

@section('content')

<!-- ============================================================== -->
<!-- Page Content -->
<!-- ============================================================== -->
<div id="page-wrapper">
    <div class="container-fluid">
        <div class="row bg-title">
            <div class="col-lg-3 col-md-4 col-sm-4 col-xs-12">
                <h4 class="page-title">Form List Asset</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">List Asset</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.asset.update', $data->id) }}" method="POST">
                <div class="col-md-12">
                    <div class="white-box">Form Tambah List Asset</h3>
                        <hr />
                        @if (count($errors) > 0)
                            <div class="alert alert-danger">
                                <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                <ul>
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                                </ul>
                            </div>
                        @endif

                        {{ csrf_field() }}
                        
                        <div class="form-group">
                            <label class="col-md-12">Asset Number</label>
                            <div class="col-md-6">
                               <input type="text" readonly="true" class="form-control" value="{{ $data->asset_number }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Asset Name</label>
                            <div class="col-md-6">
                               <input type="text" name="asset_name" class="form-control" value="{{ $data->asset_name }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Asset Type</label>
                            <div class="col-md-6">
                                <select name="asset_type_id" class="form-control">
                                    <option value=""> - none - </option>
                                    @foreach($asset_type as $item)
                                    <option value="{{ $item->id }}" {{ $item->id == $data->asset_type_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Asset S/N or Code</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control" name="asset_sn" value="{{ $data->asset_sn }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Purchase Date</label>
                            <div class="col-md-6">
                                <input type="text" class="form-control datepicker" name="purchase_date" value="{{ $data->purchase_date }}" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Asset Condition</label>
                            <div class="col-md-6">
                                <select class="form-control" name="asset_condition">
                                    <option value=""> - none - </option>
                                    <option value="Good" {{ $data->asset_condition =='Good' ? 'selected' : '' }}>Good</option>
                                    <option value="Malfunction" {{ $data->asset_condition =='Malfunction' ? 'selected' : '' }}>Malfunction</option>
                                    <option value="Lost" {{ $data->asset_condition =='Lost' ? 'selected' : '' }}>Lost</option>
                                </select>
                            </div>
                        </div> 
                        <div class="form-group">
                            <label class="col-md-12">Assign To</label>
                            <div class="col-md-6">
                                <select class="form-control" name="assign_to">
                                    <option value=""> - none - </option>
                                    <option {{ $data->assign_to =='Employee' ? 'selected' : '' }}>Employee</option>
                                    <option {{ $data->assign_to =='Office Facility' ? 'selected' : '' }}>Office Facility</option>
                                    <option {{ $data->assign_to =='Office Inventory/idle' ? 'selected' : '' }}>Office Inventory/idle</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Employee/PIC Name </label>
                            <div class="col-md-6">
                                <input type="text" class="form-control autocomplete-karyawan" readonly value="{{ $data->user->nik .' - '. $data->user->name }}">
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                        <div class="col-md-12">
                            <a href="{{ route('administrator.bank.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                            <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Update Data</button>
                            <br style="clear: both;" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>    
            </form>                    
        </div>
        <!-- /.row -->
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
    @extends('layouts.footer')
</div>

<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
