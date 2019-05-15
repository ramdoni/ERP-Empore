@extends('layouts.administrator')

@section('title', 'Business Trip Allowance')

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
                <a href="{{ route('administrator.plafond-dinas.create') }}" class="btn btn-success btn-sm pull-right m-l-20 hidden-xs hidden-sm waves-effect waves-light"> <i class="fa fa-plus"></i> ADD BUSINESS TRIP ALLOWANCE</a>
                
                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Business Trip Allowance</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>

        <!-- .row -->
        <div class="row">
            <div class="col-md-12">
                <div class="white-box">
                            <h3 class="box-title m-b-0">Setting for Local Business Trip Allowance</h3>
                            <br />
                            <div class="table-responsive">
                                <table id="data_tableTest" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="70" class="text-center">#</th>
                                            <th>TYPE</th>
                                            <th>POSITION</th>
                                            <th>HOTEL (IDR)</th>
                                            <th>MEAL ALLOWANCE/DAY'S (IDR)</th>
                                            <th>DAILY ALLOWANCE (IDR / DAY'S)</th>
                                            <th>DESCRIPTION</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $no => $item)
                                        <tr>
                                            <td>{{ $no+1 }}</td>
                                            <td>
                                                @if($item->type=='Dalam Negeri')
                                                    Local
                                                @endif
                                                 @if($item->type=='Luar Negeri')
                                                    Abroad
                                                @endif
                                            </td>
                                            <td>{{ ucfirst( strtolower($item->organisasi_position_text)) }}</td>
                                            <td>{{ number_format($item->hotel) }}</td>
                                            <td>{{ number_format($item->tunjangan_makanan) }}</td>
                                            <td>{{ number_format($item->tunjangan_harian) }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>
                                                    <a href="{{ route('administrator.plafond-dinas.edit', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-edit"></i> edit</button></a>
                                                    <form action="{{ route('administrator.plafond-dinas.destroy', $item->id) }}" onsubmit="return confirm('Delete this data?')" method="post" style="float: left;">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}                                               
                                                        <button type="submit" class="btn btn-danger btn-xs m-r-5"><i class="ti-trash"></i> delete</button>
                                                    </form>
                                                </td>
                                        </tr>
                                        @endforeach 
                                    </tbody>
                                </table>
                    <!--
                     <ul class="nav customtab nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#domestik" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Local</span></a></li>
                        <li role="presentation" class=""><a href="#luarnegeri" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs"> Abroad</span></a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade active in" id="domestik">
                            <h3 class="box-title m-b-0">Setting for Local Business Trip Allowance</h3>
                            <br />
                            <div class="table-responsive">
                                <table id="data_tableTest" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="70" class="text-center">#</th>
                                            <th>POSITION</th>
                                            <th>HOTEL (IDR)</th>
                                            <th>MEAL ALLOWANCE/DAY'S (IDR)</th>
                                            <th>DAILY ALLOWANCE (IDR / DAY'S)</th>
                                            <th>DESCRIPTION</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data as $no => $item)
                                        <tr>
                                            <td>{{ $no+1 }}</td>
                                            <td>{{ ucfirst( strtolower($item->organisasi_position_text)) }}</td>
                                            <td>{{ number_format($item->hotel) }}</td>
                                            <td>{{ number_format($item->tunjangan_makanan) }}</td>
                                            <td>{{ number_format($item->tunjangan_harian) }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>
                                                    <a href="{{ route('administrator.plafond-dinas.edit', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-edit"></i> edit</button></a>
                                                    <form action="{{ route('administrator.plafond-dinas.destroy', $item->id) }}" onsubmit="return confirm('Delete this data?')" method="post" style="float: left;">
                                                        {{ csrf_field() }}
                                                        {{ method_field('DELETE') }}                                               
                                                        <button type="submit" class="btn btn-danger btn-xs m-r-5"><i class="ti-trash"></i> delete</button>
                                                    </form>
                                                </td>
                                        </tr>
                                        @endforeach 
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="luarnegeri">
                            <h3 class="box-title m-b-0">Setting for Abroad Business Trip Allowance</h3>
                            <br />
                            <div class="table-responsive">
                                <table id="data_table2" class="display nowrap" cellspacing="0" width="100%">
                                    <thead>
                                        <tr>
                                            <th width="70" class="text-center">#</th>
                                            <th>POSITION</th>
                                            <th>HOTEL TYPE</th>
                                            <th>MEAL ALLOWANCE/DAY'S (USD)</th>
                                            <th>DAILY ALLOWANCE (USD / DAY'S)</th>
                                            <th>DESCRIPTION</th>
                                            <th>#</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($data_luarnegeri as $no => $item)
                                        <tr>
                                            <td>{{ $no+1 }}</td>
                                            <td>{{ ucfirst( strtolower($item->organisasi_position_text)) }}</td>
                                            <td>{{ $item->hotel }}</td>
                                            <td>{{ number_format($item->tunjangan_makanan) }}</td>
                                            <td>{{ number_format($item->tunjangan_harian) }}</td>
                                            <td>{{ $item->keterangan }}</td>
                                            <td>
                                                    <a href="{{ route('administrator.plafond-dinas.edit-luar-negeri', ['id' => $item->id]) }}"> <button class="btn btn-info btn-xs m-r-5"><i class="fa fa-edit"></i> edit</button></a>
                                                    <a href="{{ route('administrator.plafond-dinas.edit-luar-negeri', ['id' => $item->id]) }}"> <button class="btn btn-danger btn-xs m-r-5"><i class="fa fa-trash"></i> delete</button></a>
                                                </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    -->

                </div>
            </div> 
        </div>
        <!-- ============================================================== -->
    </div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
</div>



@section('footer-script')
<script type="text/javascript">
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
