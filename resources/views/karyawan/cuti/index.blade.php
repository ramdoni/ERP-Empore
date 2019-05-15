@extends('layouts.karyawan')

@section('title', 'Leave / Permit Employee')

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
                <h4 class="page-title hidden-xs hidden-sm">Dashboard</h4> 
            </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">
                @if(cek_approval('cuti_karyawan'))
                    <a href="{{ route('karyawan.cuti.create') }}" class="btn btn-success btn-sm pull-right m-l-20 waves-effect waves-light" onclick=""> <i class="fa fa-plus"></i> ADD LEAVE</a>
                @else
                    <a class="btn btn-success btn-sm pull-right m-l-20 waves-effect waves-light" onclick="bootbox.alert('Sorry, you cannot make this transaction as long as the previous transaction has not been completed approved')"> <i class="fa fa-plus"></i> ADD LEAVE</a>
                @endif
                <ol class="breadcrumb hidden-xs hidden-sm">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Leave / Permit Employee</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Manage Employee Leave</h3>
                    <br />
                    <div class="table-responsive">
                        <table id="data_table_no_search" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>DATE OF LEAVE / PERMIT</th>
                                    <th>LEAVE / PERMIT TYPE</th>
                                    <th>LEAVE / PERMIT DURATION</th>
                                    <th>PURPOSE</th>
                                    <th>STATUS</th>
                                    <th>CREATED</th>
                                    <th width="100">MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>   
                                        <td>{{ date('d F Y', strtotime($item->tanggal_cuti_start)) }} - {{ date('d F Y', strtotime($item->tanggal_cuti_end)) }}</td>
                                        <td>{{ isset($item->cuti) ? $item->cuti->jenis_cuti : '' }}</td>
                                        <td>{{ $item->total_cuti }} days</td>
                                        <td>{{ $item->keperluan }}</td>
                                        <td>
                                            <a onclick="detail_approval_cuti({{ $item->id }})"> 
                                                {!! status_cuti($item->status) !!}
                                            </a>
                                        </td>
                                        <td>{{ $item->created_at }}</td>
                                        <td>
                                            <a href="{{ route('karyawan.cuti.edit', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-search-plus"></i> Detail</button></a>
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

<!-- sample modal content -->
<div id="modal_history_approval" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">History Approval</h4> </div>
                <div class="modal-body" id="modal_content_history_approval"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@section('footer-script')
    <script type="text/javascript">
        function detail_approval(jenis_form, id)
        {
             $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-history-approval-cuti') }}',
                data: {'foreign_id' : id ,'_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    var el = "";
                    if(data.data.jenis_karyawan == 'staff')
                    {
                        el = '<div class="panel-body">'+
                                '<div class="steamline">'+
                                    '<div class="sl-item">'+
                                        (data.data.is_approved_atasan == 1 ? '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>' : '<div class="sl-left bg-danger"> <i class="fa fa-close"></i></div>' )+
                                        '<div class="sl-right">'+
                                            '<div><strong>Supervisor</strong> <br /><a href="#">'+ data.data.atasan +'</a> </div>'+
                                            '<div class="desc">'+ (data.data.date_approved_atasan != null ? data.data.date_approved_atasan : '' ) +'<p>'+ (data.data.catatan_atasan != null ? data.data.catatan_atasan : '' )  +'</p></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                            if(data.data.manager != null) {
                                el += '<div class="panel-body">'+
                                        '<div class="steamline">'+
                                            '<div class="sl-item">'+
                                                (data.data.is_approved_manager == 1 ? '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>' : '<div class="sl-left bg-danger"> <i class="fa fa-close"></i></div>' )+
                                                '<div class="sl-right">'+
                                                    '<div><strong>Manager</strong> <br /><a href="#">'+ data.data.manager +'</a> </div>'+
                                                    '<div class="desc">'+ (data.data.date_approved_manager != null ? data.data.date_approved_manager : '' ) +'<p>'+ (data.data.catatan_manager != null ? data.data.catatan_manager : '' )  +'</p></div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>';
                            } 
                    }
                    if(data.data.jenis_karyawan == 'supervisor')
                    {
                        if(data.data.atasan != null) {
                        el = '<div class="panel-body">'+
                                '<div class="steamline">'+
                                    '<div class="sl-item">'+
                                        (data.data.is_approved_atasan == 1 ? '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>' : '<div class="sl-left bg-danger"> <i class="fa fa-close"></i></div>' )+
                                        '<div class="sl-right">'+
                                            '<div><strong>Manager</strong> <br /><a href="#">'+ data.data.atasan +'</a> </div>'+
                                            '<div class="desc">'+ (data.data.date_approved_atasan != null ? data.data.date_approved_atasan : '' ) +'<p>'+ (data.data.catatan_atasan != null ? data.data.catatan_atasan : '' )  +'</p></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                        }
                            if(data.data.manager != null) {
                                el = '<div class="panel-body">'+
                                        '<div class="steamline">'+
                                            '<div class="sl-item">'+
                                                (data.data.is_approved_manager == 1 ? '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>' : '<div class="sl-left bg-danger"> <i class="fa fa-close"></i></div>' )+
                                                '<div class="sl-right">'+
                                                    '<div><strong>Manager</strong> <br /><a href="#">'+ data.data.manager +'</a> </div>'+
                                                    '<div class="desc">'+ (data.data.date_approved_manager != null ? data.data.date_approved_manager : '' ) +'<p>'+ (data.data.catatan_manager != null ? data.data.catatan_manager : '' )  +'</p></div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>';
                            } 
                    }

                    el += '<div class="panel-body">'+
                            '<div class="steamline">'+
                                '<div class="sl-item">'+
                                    (data.data.approve_direktur == 1 ? '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>' : '<div class="sl-left bg-danger"> <i class="fa fa-close"></i></div>' )+
                                    '<div class="sl-right">'+
                                        '<div><strong>Director</strong><br><a href="#">'+ data.data.direktur +'</a> </div>'+
                                        '<div class="desc"></div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';


                    $("#modal_content_history_approval").html(el);
                }
            });

            $("#modal_history_approval").modal('show');
        }
    </script>
@endsection

@endsection