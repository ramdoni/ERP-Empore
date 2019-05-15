@extends('layouts.karyawan')

@section('title', 'Business Trip')

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
                <h4 class="page-title"></h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Business Trip</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
        <div class="row">
            <form class="form-horizontal" id="form-actual-bill" enctype="multipart/form-data" action="{{ route('karyawan.training.submit-biaya') }}" method="POST">
                <div class="col-md-12">
                    <div class="white-box">
                        <h3 class="box-title m-b-0">Form Actual Bill</h3>
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

                        <?php 
                        
                        $readonly = ''; 
                        if($data->status_actual_bill >= 2)
                        {
                            $readonly = ' readonly="true"'; 
                        }

                        ?>
                        <table class="table table-bordered">
                            <tbody>
                                <tr>
                                    <th style="background: #eee;">1. Transportation</th>
                                    <th style="background: #eee;">Nominal</th>
                                    <th style="background: #eee;">Nominal Approved</th>
                                    <th style="background: #eee;">Receipt Transaction</th>
                                    <th style="background: #eee;">Note</th>
                                </tr>
                                <tr>
                                    <td>Ticket (Train/Airlines/Ship,etc)</td>
                                    <td><input placeholder="IDR" type="number" class="form-control calculate_1" {{$readonly}}  name="transportasi_ticket" value="{{ $data->transportasi_ticket }}" ></td>
                                    <td><input placeholder="IDR"  type="number" class="form-control" readonly="true" value="{{ $data->transportasi_ticket_disetujui }}"></td>
                                    <td>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="transportasi_ticket_file" />
                                        </div>
                                        @if(!empty($data->transportasi_ticket_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_ticket_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" readonly="true" value="{{ $data->transportasi_ticket_catatan }}"></td>
                                </tr>
                                <tr>
                                    <td>Taxi</td>
                                    <td><input placeholder="IDR" type="number" {{$readonly}} class="form-control calculate_1" name="transportasi_taxi" value="{{ $data->transportasi_taxi }}" ></td>
                                    <td><input placeholder="IDR" type="number" class="form-control" readonly="true" value="{{ $data->transportasi_taxi_disetujui }}"></td>
                                    <td>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="transportasi_taxi_file" />
                                        </div>
                                        @if(!empty($data->transportasi_taxi_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_taxi_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" readonly="true" value="{{ $data->transportasi_taxi_catatan }}"></td>
                                </tr>
                                <tr>
                                    <td>Gasoline</td>
                                    <td><input placeholder="IDR"  type="number" {{$readonly}} class="form-control calculate_1" name="transportasi_gasoline" value="{{ $data->transportasi_gasoline }}" ></td>
                                    <td><input placeholder="IDR" type="number" class="form-control" readonly="true" value="{{ $data->transportasi_gasoline_disetujui }}"></td>
                                    <td>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="transportasi_gasoline_file" />
                                        </div>
                                        @if(!empty($data->transportasi_gasoline_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_gasoline_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" readonly="true" value="{{ $data->transportasi_gasoline_catatan }}"></td>
                                </tr>
                                <tr>
                                    <td>Toll</td>
                                    <td><input placeholder="IDR" type="number" {{$readonly}} class="form-control calculate_1" name="transportasi_tol" value="{{ $data->transportasi_tol }}" ></td>
                                    <td><input placeholder="IDR" type="number" class="form-control" readonly="true" value="{{ $data->transportasi_tol_disetujui }}"></td>
                                    <td>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="transportasi_tol_file" />
                                        </div>
                                        @if(!empty($data->transportasi_tol_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_tol_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" readonly="true" value="{{ $data->transportasi_tol_catatan }}"></td>
                                </tr>
                                <tr>
                                    <td>Parking</td>
                                    <td><input placeholder="IDR" type="number" {{$readonly}} class="form-control calculate_1" name="transportasi_parkir" value="{{ $data->transportasi_parkir }}" ></td>
                                    <td><input placeholder="IDR" type="number" class="form-control" readonly="true" value="{{ $data->transportasi_parkir_disetujui }}"></td>
                                    <td>
                                        <div class="col-md-6">
                                            <input type="file" class="form-control" name="transportasi_parkir_file" />
                                        </div>
                                        @if(!empty($data->transportasi_parkir_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_parkir_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" readonly="true" value="{{ $data->transportasi_parkir_catatan }}"></td>
                                </tr>
                                <tr>
                                    <th style="text-align: right;">Sub Total</th>
                                    <th class="total_transport">{{ number_format($data->sub_total_1) }}</th>
                                    <th colspan="3">{{ number_format($data->sub_total_1_disetujui) }}</th>
                                </tr>
                            </tbody>
                    </table>
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                    <th style="background: #eee;" colspan="12">2. Daily & Meal Allowance </th>
                                    </tr>
                                    <tr>
                                        <th style="background: #eee;">Date</th>
                                        <th style="background: #eee;">Plafond Meal Allowance</th>
                                        <th style="background: #eee;">Morning</th>
                                        <th style="background: #eee;">Nominal Approved</th>
                                        <th style="background: #eee;">Afternoon</th>
                                        <th style="background: #eee;">Nominal Approved</th>
                                        <th style="background: #eee;">Evening</th>
                                        <th style="background: #eee;">Nominal Approved</th>
                                        <th style="background: #eee;">Plafond Daily Allowance</th>
                                        <th style="background: #eee;">Daily Allowance</th>
                                        <th style="background: #eee;">Nominal Approved</th>
                                        <th style="background: #eee;">Receipt Transaction</th>
                                    </tr>
                                </thead>
                                @if($data->status_actual_bill >0)
                                <tbody class="table-content-lembur">
                                    @foreach($allowance as $key => $item)
                                        <tr>
                                            <td>{{ $item->date }}</td>
                                            <td>{{ number_format($item->meal_plafond) }}</td>
                                            <td>{{ number_format($item->morning) }}</td>
                                            <td>{{ number_format($item->morning_approved) }}</td>
                                            <td>{{ number_format($item->afternoon) }}</td>
                                            <td>{{ number_format($item->afternoon_approved) }}</td>
                                            <td>{{ number_format($item->evening) }}</td>
                                            <td>{{ number_format($item->evening_approved) }}</td>
                                            <td>{{ number_format($item->daily_plafond) }}</td>
                                            <td>{{ number_format($item->daily) }}</td>
                                            <td>{{ number_format($item->daily_approved) }}</td>
                                           <td>
                                            @if(!empty($item->file_struk)) 
                                                <a onclick="show_image('{{ $item->file_struk }}')" class="btn btn-default btn-xs"><i class="fa fa-search-plus"></i>View </a> 
                                            @endif
                                        </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                    <th colspan="2" class="text-left" style="font-size: 12px;">Sub Total Daily & Meal Allowance</th>
                                     <th colspan="11" class="sub_total_2" style="font-size: 12px;">{{ number_format($data->sub_total_2) }}</th>
                                    </tr>
                                    <tr>
                                    <th colspan="2" class="text-left" style="font-size: 12px;">Sub Total Daily & Meal Allowance Approved</th>
                                     <th colspan="11" class="sub_total_2" style="font-size: 12px;">{{ number_format($data->sub_total_2_disetujui) }}</th>
                                    </tr>
                                </tfoot>
                                @else
                                    @php ($plafond_dinas = plafond_perjalanan_dinas($data->lokasi_kegiatan,jabatan_level_user($data->user_id)))
                                @if($plafond_dinas)
                                <tbody class="table-content-lembur">
                                    <tr>
                                        <td>
                                            <input type="date" name="date[]"  required class="form-control" placeholder="Date" onchange="calculateAllowance()">
                                        </td>
                                        <td>{{ number_format($plafond_dinas->tunjangan_makanan) }}
                                            <input type="hidden" name="meal_plafond[]" value="{{ $plafond_dinas->tunjangan_makanan }}"></td>
                                        <td>
                                            <input type="text"  class="form-control morning" name="morning[]">
                                        </td>
                                        <td>
                                            <input type="text" name="morning_approved[]"  class="form-control price_format" readonly="true">
                                        </td>
                                        <td>
                                            <input type="text" name="afternoon[]" class="form-control afternoon ">
                                        </td>
                                        <td>
                                            <input type="text" name="afternoon_approved[]" class="form-control price_format" readonly="true">
                                        </td>
                                        <td>
                                            <input type="text" name="evening[]" class="form-control evening">
                                        </td>
                                        <td>
                                            <input type="text" name="evening_approved[]" class="form-control price_format" readonly="true">
                                        </td>
                                        <td>{{ number_format($plafond_dinas->tunjangan_harian)}}
                                         <input type="hidden" name="daily_plafond[]" value="{{ $plafond_dinas->tunjangan_harian }}">
                                         </td>
                                        <td>
                                            <input type="text" name="daily[]" class="form-control daily">
                                        </td>
                                        <td>
                                            <input type="text" name="daily_approved[]" class="form-control price_format" readonly="true">
                                        </td>
                                        <td>
                                            <input type="file" name="file_struk[]" class="form-control input">
                                        </td>
                                    </tr>
                                </tbody>
                                @endif
                                <tfoot>
                                    <tr>
                                        <th colspan="3" class="text-right" style="font-size: 12px;">Sub Total : </th>
                                        <th class="total_morning" style="font-size: 12px;">0</th>
                                        <th class="total_morningApproved" style="font-size: 12px;">0</th>
                                        <th class="total_afternoon" style="font-size: 12px;">0</th>
                                        <th class="total_afternoonApproved" style="font-size: 12px;">0</th>
                                        <th class="total_evening" style="font-size: 12px;">0</th>
                                        <th colspan="2" class="total_eveningApproved" style="font-size: 12px;">0</th>
                                        <th class="total_daily" style="font-size: 12px;" >0</th>
                                        <th colspan="2"  class="total_dailyApproved" style="font-size: 12px;" >0</th>
                                    </tr>
                                    <tr>
                                    <th colspan="3" class="text-left" style="font-size: 12px;">Sub Total Daily & Meal Allowance:</th>
                                     <th colspan="10" class="sub_total_2" style="font-size: 12px;">0</th>
                                    </tr>
                                </tfoot>

                                @endif
                                
                            </table>
                            <a class="btn btn-info btn-xs pull-right" id="add"><i class="fa fa-plus"></i> Add</a>
                        </div>
                    <div class="clearfix"></div>
                        <br />
                    
                    <table class="table table-bordered">
                            <tr>
                                <th colspan="2" style="background: #eee;">3. Other's </th>
                                <th style="background: #eee;">Nominal </th>
                                <th style="background: #eee;">Nominal Approved </th>
                                <th style="background: #eee;">Receipt Transaction </th>
                                <th style="background: #eee;">Note </th>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="text" name="uang_biaya_lainnya1" {{$readonly}}  class="form-control" placeholder="Other Expense" value="{{ $data->uang_biaya_lainnya1 }}" />
                                </td>
                                <td>
                                    <input type="text" name="uang_biaya_lainnya1_nominal" {{$readonly}}  value="{{ $data->uang_biaya_lainnya1_nominal }}" class="form-control calculate_3" placeholder="IDR " />
                                </td>
                                <td>
                                    <input type="text" readonly="true" class="form-control" value="{{ $data->uang_biaya_lainnya1_nominal_disetujui }}" {{$readonly}}  placeholder="IDR " />
                                </td>
                                <td>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" name="uang_biaya_lainnya1_file" />
                                    </div>
                                    @if(!empty($data->uang_biaya_lainnya1_file))
                                    <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_biaya_lainnya1_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                    @endif
                                </td>`
                                <td>
                                    <input type="text" readonly="true" class="form-control" value="{{ $data->uang_biaya_lainnya1_catatan }}" placeholder="Note" />
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2">
                                    <input type="text" name="uang_biaya_lainnya2" {{$readonly}}  value="{{ $data->uang_biaya_lainnya2 }}" class="form-control" placeholder="Other Expense" />
                                </td>
                                <td>
                                    <input type="text" class="form-control calculate_3" {{$readonly}}  value="{{ $data->uang_biaya_lainnya2_nominal }}" name="uang_biaya_lainnya2_nominal" placeholder="IDR " />
                                </td>
                                <td>
                                    <input type="text" class="form-control" readonly="true" placeholder="IDR" value="{{ $data->uang_biaya_lainnya2_nominal_disetujui }}" />
                                </td>
                                <td>
                                    <div class="col-md-6">
                                        <input type="file" class="form-control" name="uang_biaya_lainnya2_file" />
                                    </div>
                                    @if(!empty($data->uang_biaya_lainnya2_file))
                                    <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_biaya_lainnya2_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                    @endif
                                </td>
                                <td>
                                    <input type="text" readonly="true" value="{{ $data->uang_biaya_lainnya2_catatan }}" class="form-control" placeholder="Note" />
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2">Sub Total</th>
                                <th class="sub_total_nominal_lainnya">{{ number_format($data->sub_total_3) }}</th>
                                <th colspan="3" class="total_lain_lain_disetujui">{{ number_format($data->sub_total_3_disetujui) }}</th>
                            </tr>
                        </table>

                        <div class="col-md-6 table-total" style="padding-left:0;">
                            <table class="table table-hover">
                                <tr>
                                    <th>Total Actual Bill</th>
                                    <th class="total_actual_bill">
                                        IDR {{ number_format($data->sub_total_1 + $data->sub_total_2 + $data->sub_total_3) }}
                                    </th>
                                </tr>
                                <tr>
                                    <th>Cash Advance</th>
                                    <th>IDR {{ number_format($data->pengambilan_uang_muka) }}</th>
                                </tr>
                            </table>
                        </div>
                        <div class="col-md-6 table-total" style="padding-right:0;">
                            <table class="table table-hover">
                                <tr>
                                    <th>Total Actual Bill Approved</th>
                                    <th class="total_actual_bill_disetujui">
                                         IDR {{ number_format($data->sub_total_1_disetujui + $data->sub_total_2_disetujui + $data->sub_total_3_disetujui) }}
                                    </th>
                                </tr>
                                <tr>
                                    @php( $total_reimbursement_disetujui = $data->sub_total_1_disetujui + $data->sub_total_2_disetujui + $data->sub_total_3_disetujui - $data->pengambilan_uang_muka )
                                    @if($total_reimbursement_disetujui < 0)
                                    <th>Total Return </th>
                                    @php ($total_reimbursement_disetujui = abs($total_reimbursement_disetujui))
                                    @else
                                    <th>Total Reimbursement Approved </th>
                                    @endif
                                    <th class="total_reimbursement_disetujui">
                                        IDR {{ number_format($total_reimbursement_disetujui) }}
                                    </th>
                                </tr>
                            </table>
                        </div>
                        <div class="clearfix"></div>
                        <table class="table table-hover">
                            <tr>
                                <th>
                                    Note
                                    <textarea class="form-control" name="noted_bill"  {{ $readonly }} >{{ $data->noted_bill }}</textarea>
                                </th>
                            </tr>
                        </table>
                        <div class="clearfix"></div>
                        <hr style="margin-top:0;" />
                    
                    <input type="hidden" name="id" value="{{ $data->id }}" />
                    <input type="hidden" name="status_actual_bill" value="1">
                    <input type="hidden" name="sub_total_1" value="{{ $data->sub_total_1 }}" />
                    <input type="hidden" name="sub_total_2" value="{{ $data->sub_total_2 }}" />
                    <input type="hidden" name="sub_total_3" value="{{ $data->sub_total_3 }}" />

                    <div class="col-md-12" style="padding-left: 0;">
                        <a href="{{ route('karyawan.training.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>
                        @if($data->status_actual_bill ==1 or $data->status_actual_bill =="")
                        <button type="submit" class="btn btn-sm btn-warning waves-effect waves-light m-r-10" id="save-as-draft-form"><i class="fa fa-save"></i> Save as Draft</button>

                        <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="submit-form"><i class="fa fa-save"></i> Submit Actual Bill</a>
                        @endif
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
<style type="text/css">
    .custome_table tr th {
        padding-top: 5px !important;
        padding-bottom: 5px !important;
    }
    .table-total table tr th {
        font-size: 14px !important; 
    }
</style>
@section('footer-script')
<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

<link href="{{ asset('admin-css/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.css') }}" rel="stylesheet">
<!-- Clock Plugin JavaScript -->
<script src="{{ asset('admin-css/plugins/bower_components/clockpicker/dist/jquery-clockpicker.min.js') }}"></script>

<script type="text/javascript">
    
    $(".morning").on('input', function(){
        calculate_morning();
        calculate_allAllowance();
        calculate_all();
        });

        $(".afternoon").on('input', function(){
        calculate_afternoon();
        calculate_allAllowance();
        calculate_all();
        });

        $(".evening").on('input', function(){
        calculate_evening();
        calculate_allAllowance();
        calculate_all();
        });

        $(".daily").on('input', function(){
        calculate_daily();
        calculate_allAllowance();
        calculate_all();
        });

    function calculateAllowance(){
        $(".morning").on('input', function(){
        calculate_morning();
        calculate_allAllowance();
        calculate_all();
        });

        $(".afternoon").on('input', function(){
        calculate_afternoon();
        calculate_allAllowance();
        calculate_all();
        });

        $(".evening").on('input', function(){
        calculate_evening();
        calculate_allAllowance();
        calculate_all();
        });

        $(".daily").on('input', function(){
        calculate_daily();
        calculate_allAllowance();
        calculate_all();
        });
    }

    var calculate_morning  = function(){
    var totalMorning = 0;
    $('.morning').each(function(){
        if($(this).val() != ""){
            totalMorning += parseInt($(this).val());
        }
    });

    $('.total_morning').html(numberWithComma(totalMorning));
    }

    var calculate_afternoon  = function(){
        var totalAfternoon = 0;
        $('.afternoon').each(function(){
            if($(this).val() != ""){
                totalAfternoon += parseInt($(this).val());
            }
        });

        $('.total_afternoon').html(numberWithComma(totalAfternoon));
    }

    var calculate_evening  = function(){
        var totalEvening = 0;
        $('.evening').each(function(){
            if($(this).val() != ""){
                totalEvening += parseInt($(this).val());
            }
        });

        $('.total_evening').html(numberWithComma(totalEvening));
    }

    var calculate_daily  = function(){
        var totalDaily = 0;
        $('.daily').each(function(){
            if($(this).val() != ""){
                totalDaily += parseInt($(this).val());
            }
        });

        $('.total_daily').html(numberWithComma(totalDaily));
    }
    var calculate_allAllowance  = function(){
        var totalAll = 0;

        var totalMorning    = parseInt(document.getElementsByClassName("total_morning")[0].innerHTML.replace(/,/g, ""));
        var totalAfternoon  = parseInt(document.getElementsByClassName("total_afternoon")[0].innerHTML.replace(/,/g, ""));
        var totalEvening    = parseInt(document.getElementsByClassName("total_evening")[0].innerHTML.replace(/,/g, ""));
        var totalDaily      = parseInt(document.getElementsByClassName("total_daily")[0].innerHTML.replace(/,/g, ""));
        totalAll =(parseInt(totalMorning + totalAfternoon + totalEvening + totalDaily));
        
        $('.sub_total_2').html(numberWithComma(totalAll));
        $("input[name='sub_total_2']").val(totalAll);
    }
</script>

<script type="text/javascript">

var general_el;
var validate_form = false;

show_hide_add();
cek_button_add();

function show_hide_add()
{       
    validate_form = true;
    
    $('.input').each(function(){
     
        if($(this).val() == "")
        {
            validate_form = false;
        }
    });
}

function cek_button_add()
{
    $('.input').each(function(){
        $(this).on('keyup',function(){
            show_hide_add();
        })
        $(this).on('change',function(){
            show_hide_add();
        })
    });
}

$("#add").click(function(){
     @php ($plafond_dinas = plafond_perjalanan_dinas($data->lokasi_kegiatan,jabatan_level_user($data->user_id)))
    var no = $('.table-content-lembur tr').length;
    var html = '<tr>';
        html += '<td><input type="date" name="date[]" required class="form-control" onchange="calculateAllowance()" \
        placeholder="Date"></td>';
        html += '<td>{{ number_format($plafond_dinas->tunjangan_makanan) }} <input type="hidden" name="meal_plafond[]" value="{{ $plafond_dinas->tunjangan_makanan }}">';
        html += '<td><input type="text" class="form-control morning" name="morning[]"></td>';
        html += '<td><input type="text" name="morning_approved[]"  class="form-control price_format" readonly="true"></td>';
        html += '<td><input type="text" name="afternoon[]" class="form-control afternoon "></td>';
        html += '<td><input type="text" name="afternoon_approved[]" class="form-control price_format" readonly="true"></td>';
        html += '<td><input type="text" name="evening[]" class="form-control evening"></td>';
        html += '<td><input type="text" name="evening_approved[]" class="form-control price_format" readonly="true"></td>';
        html += '<td>{{ number_format($plafond_dinas->tunjangan_harian)}}<input type="hidden" name="daily_plafond[]" value="{{ $plafond_dinas->tunjangan_harian }}"></td>';
        html += '<td><input type="text" name="daily[]" class="form-control daily"></td>';
        html += '<td><input type="text" name="daily_approved[]" class="form-control price_format" readonly="true"></td>';
        html += '<td><input type="file" name="file_struk[]" class="form-control input"></td>';
        html += '<td><a class="btn btn-xs btn-danger" onclick="delete_item(this);"><i class="fa fa-trash"></i></a></td>';
        html += '</tr>';

    $('.table-content-lembur').append(html);

    $(".morning").on('input', function(){
        calculate_morning();
        calculate_allAllowance();
        calculate_all();
    });
        
    $(".afternoon").on('input', function(){
        calculate_afternoon();
        calculate_allAllowance();
        calculate_all();
    });

    $(".evening").on('input', function(){
        calculate_evening();
        calculate_allAllowance();
        calculate_all();
    });

    $(".daily").on('input', function(){
        calculate_daily();
        calculate_allAllowance();
        calculate_all();
    });
    
    show_hide_add();
    cek_button_add();
});

function delete_item(el)
{
    if(confirm('Hapus data ini?'))
    {
        $(el).parent().parent().hide("slow", function(){
            $(el).parent().parent().remove();

            setTimeout(function(){
                show_hide_add();
                cek_button_add();
            });
        });

        
    }
}


    $( "#from" ).datepicker({
        defaultDate: "+1w",
        changeMonth: true,
        numberOfMonths: 2,
        dateFormat: 'yy-mm-dd',
        onSelect: function( selectedDate ) {
            if(this.id == 'from'){
              var dateMin = $('#from').datepicker("getDate");
              var rMin = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate()); // Min Date = Selected + 1d
              var rMax = new Date(dateMin.getFullYear(), dateMin.getMonth(),dateMin.getDate() + 31); // Max Date = Selected + 31d
              $('#to').datepicker("option","minDate",rMin);
              $('#to').datepicker("option","maxDate",rMax);                    
            }
        }
    });

    $(".calculate_1").on('input', function(){

        var val = 0;

        $(".calculate_1").each(function(){

            if($(this).val() != "")
            {
                val += parseInt($(this).val());                
            }
        });

        $('.total_transport').html(numberWithComma(val));
        $("input[name='sub_total_1']").val(val);

        calculate_all();
    });


    $(".calculate_3").on('input', function(){

        var val = 0;

        $(".calculate_3").each(function(){

            if($(this).val() != "")
            {
                val += parseInt($(this).val());                
            }
        });

        $('.sub_total_nominal_lainnya').html(numberWithComma(val));
        $("input[name='sub_total_3']").val(val);

        calculate_all();
    });

    function calculate_all()
    {
        var val = 0;

        var sub_total_1   = $("input[name='sub_total_1']").val();
        var sub_total_2   = $("input[name='sub_total_2']").val();
        var sub_total_3   = $("input[name='sub_total_3']").val();

        var total_reimbursement = 0;
        var total_actual_bill = 0;

        if($("input[name='sub_total_1']").val() != "")
        {
            total_reimbursement     += parseInt($("input[name='sub_total_1']").val());   
            total_actual_bill       += parseInt($("input[name='sub_total_1']").val());
        }

        if( $("input[name='sub_total_2']").val() != "")
        {
            total_reimbursement     += parseInt($("input[name='sub_total_2']").val());
            total_actual_bill       += parseInt($("input[name='sub_total_2']").val());
        }

        if( $("input[name='sub_total_3']").val() != "")
        {
            total_reimbursement     += parseInt($("input[name='sub_total_3']").val());
            total_actual_bill       += parseInt($("input[name='sub_total_3']").val());
        }

        {{ !empty($data->pengambilan_uang_muka) ? ' total_reimbursement -='. $data->pengambilan_uang_muka .';' : '' }};


        $('.total_actual_bill').html(numberWithComma(total_actual_bill));
        $('.total_reimbursement').html(numberWithComma(total_reimbursement));
    }

    function show_img(img)
    {
        bootbox.alert(
        {
            message : '<img src="'+ img +'" style="width: 100%;" />',
            size: 'large' 
        });
    }
    function show_image(img)
    {
        bootbox.alert('<img src="{{ asset('storage/file-allowance/')}}/'+ img +'" style = \'width: 100%;\' />');      
    }

    $("#submit-form").click(function(){

        bootbox.confirm('Submit Actual Bill ?', function(res){
            if(res)
            {
                $("input[name='status_actual_bill']").val(2);
                $("#form-actual-bill").submit();
            }
        });     
    });
</script>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
@endsection
