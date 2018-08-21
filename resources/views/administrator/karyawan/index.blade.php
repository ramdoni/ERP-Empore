@extends('layouts.administrator')

@section('title', 'Karyawan')

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
                <a href="{{ route('administrator.karyawan.create') }}" class="btn btn-success btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> TAMBAH KARYAWAN</a>

                <a class="btn btn-info btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light" id="add-import-karyawan"> <i class="fa fa-upload"></i> IMPORT</a>
                
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Karyawan</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Manage Karyawan</h3>
                    <br />
                    <div class="table-responsive">
                        <table id="data_table" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>NIK</th>
                                    <th>NAME</th>
                                    <th>JENIS KELAMIN</th>
                                    <th>TELEPON</th>
                                    <th>EMAIL</th>
                                    <th>POSITION</th>
                                    <th>JOB RULE</th>
                                    <th>MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>
                                        <td>{{ $item->nik }}</td>
                                        <td>{{ strtoupper($item->name) }}</td>
                                        <td>{{ $item->jenis_kelamin }}</td>
                                        <td>{{ $item->telepon }}</td>
                                        <td>{{ $item->email }}</td>
                                        <td>
                                            @if(!empty($item->empore_organisasi_staff_id))
                                                Staff
                                            @endif

                                            @if(empty($item->empore_organisasi_staff_id) and !empty($item->empore_organisasi_manager_id))
                                                Manager
                                            @endif

                                            @if(empty($item->empore_organisasi_staff_id) and empty($item->empore_organisasi_manager_id) and !empty($item->empore_organisasi_direktur))
                                                Direktur
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($item->empore_organisasi_staff_id))
                                                {{ isset($item->empore_staff->name) ? $item->empore_staff->name : '' }}
                                            @endif

                                            @if(empty($item->empore_organisasi_staff_id) and !empty($item->empore_organisasi_manager_id))
                                                {{ isset($item->empore_manager->name) ? $item->empore_manager->name : '' }}
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('administrator.karyawan.edit', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-search-plus"></i> detail</button></a>
                                            <form action="{{ route('administrator.karyawan.destroy', $item->id) }}" onsubmit="return confirm('Hapus data ini?')" method="post" style="float: left;">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}                                               
                                                <button type="submit" class="btn btn-danger btn-xs m-r-5"><i class="ti-trash"></i> delete</button>
                                            </form>
                                            <a href="{{ route('administrator.karyawan.print-profile', $item->id) }}" target="_blank" class="btn btn-default btn-xs"><i class="fa fa-print"></i> print</a>

                                            @if(!empty($item->generate_kontrak_file))
                                                <br />
                                                <a href="{{ asset('/storage/file-kontrak/'. $item->id. '/'. $item->generate_kontrak_file) }}" class="btn btn-default btn-xs" target="_blank"><i class="fa fa-search-plus"></i> View File Kontrak</a> 
                                            @endif

                                            @if($item->is_generate_kontrak == "")
                                            <br /> <label class="btn btn-info btn-xs" onclick="generate_file_document({{ $item->id }})"><i class="fa fa-file"></i> Generate Dokument Kontrak</label><br />
                                            @endif

                                            <label class="btn btn-info btn-xs" onclick="upload_file_dokument({{ $item->id }})"><i class="fa fa-upload"></i> Upload File Kontrak</label>

                                            <a onclick="confirm_loginas('{{ $item->name }}','{{ route('administrator.karyawan.autologin', $item->id) }}')"  class="btn btn-warning btn-xs"><i class="fa fa-key"></i> Autologin</a>
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



<!-- modal content education  -->
<div id="modal_upload_dokument" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Upload Dokumen Kontrak</h4> </div>
                    <form method="POST" id="form-upload-file-dokument" enctype="multipart/form-data" class="form-horizontal" action="{{ route('administrator.karyawan.upload-dokument-file') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-3">File (xls)</label>
                            <div class="col-md-9">
                                <input type="file" name="file" class="form-control" />
                                <input type="hidden" name="user_id">
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info btn-sm">Upload File</button>
                    </div>
                </form>
                <div style="text-align: center;display: none;" class="div-proses-upload">
                    <h3>Proses upload harap menunggu !</h3>
                    <h1 class=""><i class="fa fa-spin fa-spinner"></i></h1>
                </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


<!-- modal content education  -->
<div id="modal_generate_dokument" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Generate Dokumen Kontrak</h4> </div>
                    <form method="POST" id="form-generate-file-dokument" enctype="multipart/form-data" class="form-horizontal" action="{{ route('administrator.karyawan.generate-dokument-file') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-6">Join Date</label>
                            <label class="col-md-6">End Date</label>
                            <div class="col-md-6">
                                <input type="text" name="join_date" class="form-control datepicker">
                            </div>
                            <div class="col-md-6">
                                <input type="text" name="end_date" class="form-control datepicker">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Status</label>
                            <div class="col-md-9">                                
                                <select class="form-control" name="organisasi_status">
                                    <option value="">- pilih -</option>
                                    <option>Permanent</option>
                                    <option>Contract</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <input type="hidden" name="user_id">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-info btn-sm">Generate File</button>
                    </div>
                </form>
                <div style="text-align: center;display: none;" class="div-proses-upload">
                    <h3>Proses upload harap menunggu !</h3>
                    <h1 class=""><i class="fa fa-spin fa-spinner"></i></h1>
                </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- modal content education  -->
<div id="modal_import" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">Import Data</h4> </div>
                    <form method="POST" id="form-upload" enctype="multipart/form-data" class="form-horizontal frm-modal-education" action="{{ route('administrator.karyawan.import') }}">
                    {{ csrf_field() }}
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-3">File (xls)</label>
                            <div class="col-md-9">
                                <input type="file" name="file" class="form-control" />
                            </div>
                        </div>
                        <a href="{{ asset('storage/sample/Sample-Karyawan.xlsx') }}"><i class="fa fa-download"></i> Download Sample Excel</a>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                        <label class="btn btn-info btn-sm" id="btn_import">Import</label>
                    </div>
                </form>
                <div style="text-align: center;display: none;" class="div-proses-upload">
                    <h3>Proses upload harap menunggu !</h3>
                    <h1 class=""><i class="fa fa-spin fa-spinner"></i></h1>
                </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@section('footer-script')
<link href="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
<script src="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    
    function confirm_loginas(name, url)
    {
        bootbox.confirm("Login sebagai "+ name +" ? ", function(result){

            if(result)
            {
                window.location = url;
            }
        });
    }

    jQuery('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });

    function generate_file_document(id)
    {
        $("#modal_generate_dokument").modal("show");

        $("#form-generate-file-dokument input[name='user_id']").val(id);

        $.ajax({
            type: 'POST',
            url: '{{ route('ajax.get-karyawan-by-id') }}',
            data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
            dataType: 'json',
            success: function (data) {

                $("#form-generate-file-dokument input[name='join_date']").val(data.data.join_date);
                $("#form-generate-file-dokument input[name='end_date']").val(data.data.end_date);
                $("#form-generate-file-dokument select[name='organisasi_status']").val(data.data.organisasi_status);
            }
        });
    }

    function upload_file_dokument(id)
    {
        $("#modal_upload_dokument").modal("show");

        $("#form-upload-file-dokument input[name='user_id']").val(id);
    }

    $("#btn_import").click(function(){

        $("#form-upload").submit();
        $("#form-upload").hide();
        $('.div-proses-upload').show();

    });

    $("#add-import-karyawan").click(function(){
        $("#modal_import").modal("show");
        $('.div-proses-upload').hide();
        $("#form-upload").show();
    })
</script>
@endsection

@endsection