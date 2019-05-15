@extends('layouts.karyawan')

@section('title', 'Interna Memo')

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
                <h4 class="page-title">HOME</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Home</a></li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <div class="row">
            
                <div class="panel panel-themecolor">
                    <div class="panel-heading" style="background: #53e69d; border:1px solid #53e69d;"><i class="fa fa-gavel"></i> Product Information</h2>
                        <form method="GET" action="" style="float: right; width: 40%;margin-top: -9px;">
                            <div class="form-group">
                                <input type="text" name="keyword-peraturan" class="form-control" style="float:left;width: 80%;margin-right: 5px;height: 28px;" placeholder="Search Here ..." value="{{ isset($_GET['keyword-peraturan']) ? $_GET['keyword-peraturan'] : '' }}" >
                                <button type="submit" class="btn btn-default" style="height: 28px; padding-top: 4px;">GO</button>
                            </div>
                        </form>
                    </div>
                    <div class="panel-body">
                        @foreach($peraturan_perusahaan as $item)
                            <div class="col-md-12" style="padding-bottom:0;padding-top:0;">
                                <a href="{{ asset('storage/peraturan-perusahaan/'. $item->file) }}" target="_blank">
                                    <h4 style="margin-bottom:0;padding-bottom:0;color:#53e69d;">{{ $item->title }}</h4>
                                </a>
                                    <p style="margin-top:0;"><small>{{ date('d F Y H:i', strtotime($item->created_at)) }}</small></p>
                                <a href="{{ route('karyawan.download-peraturan-perusahaan', $item->id) }}">
                                    <p style="position: absolute;top: 0;right: 0; font-size: 20px;color:#53e69d;">
                                        <i class="fa fa-cloud-download"></i>
                                    </p>
                                </a>
                            </div>
                            <div class="clearfix"></div>
                            <hr style="margin-top: 5px; margin-bottom:5px;" />
                        @endforeach
                        <br />
                    </div>
                </div>
        </div>

    </div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
</div>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
</div>
<style type="text/css">
    .col-in h3 {
        font-size: 20px;
    }
</style>
@endsection
