@extends('layouts.karyawan')

@section('title', 'Request Pay Slip')

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
                    <li class="active">Request Pay Slip</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Manage Request Pay Slip</h3>
                    <br />
                    <div class="table-responsive">
                        <table id="data_table" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>KARYAWAN</th>
                                    <th>DEPARTMEN / POSITION</th>
                                    <th>TANGGAL PENGAJUAN</th>
                                    <th>NOTE</th>
                                    <th>STATUS</th>
                                    <th>MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td> 
                                        <td><a onclick="bootbox.alert('<p>Nama : <b>{{ $item->user->name }}</b></p><p>NIK : <b>{{ $item->user->nik }}<b></p>');">{{ $item->user->name }}</a></td>
                                        <td>{{ $item->user->department->name }} / {{ $item->user->organisasi_job_role }}</td>
                                        <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                        <td>{{ $item->note }}</td>
                                        <td>
                                            @if($item->status == 1)
                                                <label class="btn btn-warning btn-xs">Waiting Proses Admin</label>
                                            @else
                                                <label class="btn btn-success btn-xs">Done</label>
                                            @endif
                                        </td>
                                        <td>
                                            @if($item->status == 1)
                                                <a href="{{ route('administrator.request-pay-slip.proses', $item->id) }}" class="btn btn-info btn-xs">proses <i class="fa fa-arrow-right"></i> </a>
                                            @else
                                                <a href="{{ route('administrator.request-pay-slip.proses', $item->id) }}" class="btn btn-info btn-xs">detail <i class="fa fa-search-plus"></i> </a>
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
