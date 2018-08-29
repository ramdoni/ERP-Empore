@extends('layouts.administrator')

@section('title', 'Asset Tracking')

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
                <h4 class="page-title">Dashboard</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Asset Tracking</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Manage List Asset Tracking</h3>
                    <br />
                    <form method="GET">
                        <div class="col-md-2" style="padding-left: 0;">
                            <select name="asset_type_id" class="form-control">
                                <option value="">- Asset Type -</option>
                                @foreach(asset_type() as $i)
                                <option value="{{ $i->id }}">{{ $i->name }}</option>
                                @endforeach
                            </select> 
                        </div>
                        <div class="col-md-2">
                            <select name="asset_condition" class="form-control">
                                <option value="">- Asset Condition -</option>
                                <option value="Good">Good</option>
                                <option value="Malfunction">Malfunction</option>
                                <option value="Lost">Lost</option>
                            </select>  
                        </div>
                        <div class="col-md-2">
                            <select name="assign_to" class="form-control">
                                <option value="">- Assign To -</option>
                                <option>Employee</option>
                                <option>Office Facility</option>
                                <option>Office Inventory/idle</option>
                            </select>  
                        </div>
                        <div class="col-md-2" style="padding-left:0;">
                            <button type="submit" class="btn btn-info ">Filter</button>
                        </div>
                        <div class="clearfix"></div>
                        <br />
                    </form>
                    
                    <div class="table-responsive">
                        <table id="data_table" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>ASSET NUMBER</th>
                                    <th>ASSET NAME</th>
                                    <th>ASSET TYPE</th>
                                    <th>SN</th>
                                    <th>PURCHASE DATE</th>
                                    <th>ASSET CONDITION</th>
                                    <th>ASSIGN TO</th>
                                    <th>KARYAWAN</th>
                                    <th>HANDOVER DATE</th>
                                    <th>STATUS</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>   
                                        <td>{{ $item->asset_number }}</td>
                                        <td>{{ $item->asset_name }}</td>
                                        <td>{{ isset($item->asset_type->name) ? $item->asset_type->name : ''  }}</td>
                                        <td>{{ $item->asset_sn }}</td>
                                        <td>{{ $item->purchase_date }}</td>
                                        <td>{{ $item->asset_condition }}</td>
                                        <td>{{ $item->assign_to }}</td>
                                        <td>{{ isset($item->user->name) ? $item->user->name : '' }}</td>
                                        <td>{{ $item->handover_date != "" ?  date('Y-m-d', strtotime($item->handover_date)) : '' }}</td>
                                        <td>
                                            @if($item->handover_date === NULL)
                                                <label class="btn btn-warning btn-xs">Waiting Acceptance</label>
                                            @endif

                                            @if($item->handover_date !== NULL)
                                                <label class="btn btn-success btn-xs">Accepted</label>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div> 
        </div>
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
</div>
@endsection