@extends('layouts.administrator')

@section('title', 'Payment Request')

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
                    <li class="active">Payment Request</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                    <h3 class="box-title m-b-0">Manage Payment Request</h3>
                    <br />
                    <div class="table-responsive">
                        <table id="data_table" class="display nowrap" cellspacing="0" width="100%">
                            <thead>
                                <tr>
                                    <th width="70" class="text-center">#</th>
                                    <th>TO</th>
                                    <th>FROM</th>
                                    <th>TUJUAN</th>
                                    <th>JENIS TRANSAKSI</th>
                                    <th>CARA PEMBAYARAN</th>
                                    <th>TOTAL AMOUNT</th>
                                    <th>STATUS</th>
                                    <th>CREATED</th>
                                    <th>MANAGE</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($data as $no => $item)
                                    <?php if(!isset($item->user->name)) { continue; } ?>
                                    <tr>
                                        <td class="text-center">{{ $no+1 }}</td>    
                                        <td>Accounting Department</td>
                                        <td>{{ $item->user->nik }} / {{ $item->user->name }}</td>
                                        <td>{{ $item->tujuan }}</td>
                                        <td>{{ $item->transaction_type }}</td>
                                        <td>{{ $item->payment_method }}</td>
                                        <td>{{ number_format(sum_payment_request_price($item->id)) }}</td>
                                        <td>
                                            <a onclick="status_approval_payment_request({{ $item->id }})"> 
                                                {!! status_payment_request($item->status) !!}
                                            </a>
                                        </td>
                                        <td>{{ date('d F Y', strtotime($item->created_at)) }}</td>
                                        <td>
                                            @if($item->status == 1)
                                            <a onclick="batalkan_pengajuan({{ $item->id }})" class="btn btn-danger btn-xs"><i class="fa fa-close"></i> Batalkan Payment Request</a>
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

<!-- sample modal content -->
<div id="modal_pembatalan" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <form class="form-horizontal" id="form-pembatalan" enctype="multipart/form-data" action="{{ route('administrator.payment-request.batal') }}" method="POST">
                    {{ csrf_field() }}
                    <h4 class="modal-title" id="myModalLabel">Pembatalan Form</h4> </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label class="col-md-3">Alasan Pembatalan</label>
                            <div class="col-md-8">
                                <textarea class="form-control" name="note"></textarea>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <input type="hidden" class="id-pembatalan" name="id" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal"> <i class="fa fa-close"></i> Close</button>
                        <button type="button" class="btn btn-info btn-sm" id="btn_pembatalan">Proses Pembatalan <i class="fa fa-arrow-right"></i> </button>
                    </div>
                </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>


@section('footer-script')
    <script type="text/javascript">

        $("#btn_pembatalan").click(function(){

            if($("textarea[name='note']").val() == "")
            {
                bootbox.alert('Alasan pembatalan harus diisi ');
                return false;
            }

            $("#form-pembatalan").submit();
        });

        function batalkan_pengajuan(id)
        { 
            $('.id-pembatalan').val(id);

            $("#modal_pembatalan").modal('show');
        }

    </script>
@endsection

@endsection
