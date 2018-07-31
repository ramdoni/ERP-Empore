@extends('layouts.karyawan')

@section('title', 'Cuti Karyawan')

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
                    <li class="active">Approval Cuti Karyawan</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Manage Approval Cuti Karyawan</h3>
                    <br />
                    <div class="table-responsive">
                        <table id="data_table" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>KARYAWAN</th>
                                    <th>TANGGAL CUTI</th>
                                    <th>JENIS CUTI</th>
                                    <th>LAMA CUTI</th>
                                    <th>KEPERLUAN</th>
                                    <th>CREATED</th>
                                    <th>STATUS</th>
                                    <th>MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($data as $no => $item)
                              @if(isset($item->karyawan->name))
                                <tr>
                                    <td class="text-center">{{ $no+1 }}</td>    
                                    <td>{{ $item->karyawan->name }}</td>
                                    <td>{{ date('d F Y', strtotime($item->tanggal_cuti_start)) }} - {{ date('d F Y', strtotime($item->tanggal_cuti_end)) }}</td>
                                    <td> 
                                        {{ isset($item->cuti) ? $item->cuti->jenis_cuti : '' }}</td>
                                    </td>
                                    <td>
                                        {{ $item->total_cuti }}
                                    </td>
                                    <td>{{ $item->keperluan }}</td>
                                    <td>{{ $item->created_at }}</td>
                                    <td>
                                        <a onclick="detail_approval('cuti', {{ $item->id }})">
                                            @if($item->is_approved_atasan === NULL)
                                                <label class="btn btn-warning btn-xs">Waiting Approval</label>
                                            @else 
                                                <label class="btn btn-success btn-xs">Approved</label>
                                            @endif
                                        </a>
                                    </td>
                                    <td>
                                        @if($item->is_approved_atasan ===NULL)
                                            <a href="{{ route('karyawan.approval.cuti-atasan.detail', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-search-plus"></i> proses</button></a>
                                        @endif
                                    </td>
                                </tr>
                              @endif
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
                <div class="modal-body" id="modal_content_history_approval">
                    
                </div>
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

                    var el = '<div class="panel-body">'+
                                        '<div class="steamline">'+
                                            '<div class="sl-item">'+
                                                (data.data.is_approved_atasan == 1 ? '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>' : '<div class="sl-left bg-danger"> <i class="fa fa-close"></i></div>' )+
                                                '<div class="sl-right">'+
                                                    '<div><a href="#">'+ data.data.atasan +'</a> </div>'+
                                                    '<div class="desc">'+ (data.data.date_approved_atasan != null ? data.data.date_approved_atasan : '' ) +'<p>'+ (data.data.catatan_atasan != null ? data.data.catatan_atasan : '' )  +'</p></div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>';

                        el += '<div class="panel-body">'+
                                        '<div class="steamline">'+
                                            '<div class="sl-item">'+
                                                (data.data.is_approved_personalia == 1 ? '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>' : '<div class="sl-left bg-danger"> <i class="fa fa-close"></i></div>' )+
                                                '<div class="sl-right">'+
                                                    '<div><a href="#">Personalia</a> </div>'+
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
