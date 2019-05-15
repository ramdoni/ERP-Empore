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
            <form class="form-horizontal" id="form-actual-bill" enctype="multipart/form-data" action="{{ route('karyawan.approval.training-atasan.proses-biaya') }}" method="POST">
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
                            $readonly = "";
                            if($data->is_approve_atasan_actual_bill == 1 || $data->is_approve_atasan_actual_bill === 0)
                            {
                                $readonly = ' readonly="true" ';
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
                                    <td><input placeholder="IDR" type="number" class="form-control" readonly="true" name="transportasi_ticket" value="{{ $data->transportasi_ticket }}" ></td>
                                    <td><input placeholder="IDR"  type="number" class="form-control calculate_1" name="transportasi_ticket_disetujui" value="{{ $data->transportasi_ticket_disetujui }}"{{$readonly}}></td>
                                    <td>
                                        @if(!empty($data->transportasi_ticket_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_ticket_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" name="transportasi_ticket_catatan" value="{{ $data->transportasi_ticket_catatan }}" {{$readonly}}></td>
                                </tr>
                                <tr>
                                    <td>Taxi</td>
                                    <td><input placeholder="IDR" type="number" class="form-control" readonly="true" name="transportasi_taxi" value="{{ $data->transportasi_taxi }}" ></td>
                                    <td><input placeholder="IDR" type="number" class="form-control calculate_1" name="transportasi_taxi_disetujui" value="{{ $data->transportasi_taxi_disetujui }}"{{$readonly}}></td>
                                    <td>
                                        @if(!empty($data->transportasi_taxi_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_taxi_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" name="transportasi_taxi_catatan" value="{{ $data->transportasi_taxi_catatan }}" {{$readonly}} ></td>
                                </tr>
                                <tr>
                                    <td>Gasoline</td>
                                    <td><input placeholder="IDR"  type="number" class="form-control" name="transportasi_gasoline" value="{{ $data->transportasi_gasoline }}" readonly="true" ></td>
                                    <td><input placeholder="IDR" type="number" class="form-control calculate_1" name="transportasi_gasoline_disetujui" value="{{ $data->transportasi_gasoline_disetujui }}"{{$readonly}}></td>
                                    <td>
                                        @if(!empty($data->transportasi_gasoline_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_gasoline_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" name="transportasi_gasoline_catatan" class="form-control" {{$readonly}} /></td>
                                </tr>
                                <tr>
                                    <td>Toll</td>
                                    <td><input placeholder="IDR" type="number" class="form-control" name="transportasi_tol" value="{{ $data->transportasi_tol }}" readonly="true" ></td>
                                    <td><input placeholder="IDR" type="number" class="form-control calculate_1" name="transportasi_tol_disetujui" value="{{ $data->transportasi_tol_disetujui }}" {{$readonly}}></td>
                                    <td>
                                        @if(!empty($data->transportasi_tol_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_tol_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" name="transportasi_tol_catatan" value="{{ $data->transportasi_tol_catatan }}" {{$readonly}}></td>
                                </tr>
                                <tr>
                                    <td>Parking</td>
                                    <td><input placeholder="IDR" type="number" class="form-control" name="transportasi_parkir" value="{{ $data->transportasi_parkir }}" readonly="" ></td>
                                    <td><input placeholder="IDR" type="number" class="form-control calculate_1" name="transportasi_parkir_disetujui" value="{{ $data->transportasi_parkir_disetujui }}"{{$readonly}}></td>
                                    <td>
                                        @if(!empty($data->transportasi_parkir_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->transportasi_parkir_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td><input type="text" class="form-control" name="transportasi_parkir_catatan" value="{{ $data->transportasi_parkir_catatan }}" {{$readonly}}></td>
                                </tr>
                                <tr>
                                    <th>Sub Total</th>
                                    <th class="total_transport">{{ number_format($data->sub_total_1) }}</th>
                                    <th class="total_transport_disetujui" colspan="3">{{ number_format($data->sub_total_1_disetujui) }}</th>
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
                                @foreach($allowance as $key => $item)
                                <tbody class="table-content-lembur">
                                    <tr>
                                        <input type="hidden" name="id_allowance[]" class="form-control"  value="{{ $item->id }}" readonly="true">
                                        <td>
                                            <input type="date" name="date" class="form-control"  value="{{ $item->date }}" readonly="true">
                                        </td>
                                        <td>{{ number_format($item->meal_plafond) }}</td>
                                        <td style="background: #eee;">{{ number_format($item->morning) }}</td>
                                        <td>
                                            @if($item->morning_approved != null)
                                             <input type="text" name="morning_approved[]"  class="form-control morning_approved"value="{{$item->morning_approved}}" {{$readonly}}>
                                            @endif
                                             @if($item->morning_approved == null)
                                            <input type="text" name="morning_approved[]"  class="form-control morning_approved"value="{{$item->morning}}" {{$readonly}}>
                                            @endif
                                        </td>
                                        <td style="background: #eee;">{{ number_format($item->afternoon) }} </td>
                                        <td>
                                            @if($item->afternoon_approved != null)
                                             <input type="text" name="afternoon_approved[]" class="form-control afternoon_approved" value="{{$item->afternoon_approved}}" {{$readonly}}>
                                            @endif
                                             @if($item->afternoon_approved == null)
                                            <input type="text" name="afternoon_approved[]" class="form-control afternoon_approved" value="{{$item->afternoon}}" {{$readonly}}>
                                            @endif
                                        </td>
                                        <td style="background: #eee;">{{ number_format($item->evening) }} </td>
                                        <td>
                                            @if($item->evening_approved != null)
                                             <input type="text" name="evening_approved[]" class="form-control evening_approved" value="{{$item->evening_approved}}" {{$readonly}}>
                                            @endif
                                             @if($item->evening_approved == null)
                                            <input type="text" name="evening_approved[]" class="form-control evening_approved" value="{{$item->evening}}" {{$readonly}}>
                                            @endif
                                        </td>
                                        <td>{{ number_format($item->daily_plafond) }} </td>
                                        <td style="background: #eee;">{{ number_format($item->daily) }} </td>
                                        <td>
                                             @if($item->daily_approved != null)
                                             <input type="text" name="daily_approved[]" class="form-control daily_approved" value="{{$item->daily_approved}}" {{$readonly}}>
                                            @endif
                                             @if($item->daily_approved == null)
                                            <input type="text" name="daily_approved[]" class="form-control daily_approved" value="{{$item->daily}}" {{$readonly}}>
                                            @endif
                                        </td>
                                        <td>
                                            @if(!empty($item->file_struk)) 
                                                <a onclick="show_image('{{ $item->file_struk }}')" class="btn btn-default btn-xs"><i class="fa fa-search-plus"></i>View </a> 
                                            @endif
                                        </td>
                                    </tr>
                                </tbody>
                                @endforeach
                                <tfoot>
                                    @if($data->is_approve_atasan_actual_bill == 1 || $data->is_approve_atasan_actual_bill === 0)
                                    <tr>
                                    <th colspan="4" class="text-right" style="font-size: 12px;">Sub Total Daily & Meal Allowance : </th>
                                     <th colspan="9" class="sub_total_2" style="font-size: 12px;">{{ number_format($data->sub_total_2) }}</th>
                                    </tr>
                                    <tr>
                                    <th colspan="4" class="text-right" style="font-size: 12px;">Sub Total Daily & Meal Allowance Approved : </th>
                                     <th colspan="9" class="sub_total_2_disetujui" style="font-size: 12px;">{{ number_format($data->sub_total_2_disetujui) }}</th>
                                    </tr>
                                    @else
                                    <tr>
                                        <th colspan="3" class="text-right" style="font-size: 12px;">Sub Total : </th>
                                        <th colspan="2" class="total_morningApproved" style="font-size: 12px;">0</th>
                                        <th colspan="2" class="total_afternoonApproved" style="font-size: 12px;">0</th>
                                        <th colspan="3" class="total_eveningApproved" style="font-size: 12px;">0</th>
                                        <th colspan="2"  class="total_dailyApproved" style="font-size: 12px;" >0</th>
                                    </tr>
                                    <tr >
                                    <th colspan="2" class="text-left" style="font-size: 12px;">Sub Total Daily & Meal Allowance Claim: </th>
                                     <th colspan="11" class="sub_total_2" style="font-size: 12px;">{{ number_format($data->sub_total_2) }}</th>
                                    </tr>
                                    <tr>
                                    <th colspan="2" class="text-left" style="font-size: 12px;">Sub Total Daily & Meal Allowance Approved : </th>
                                     <th colspan="11" class="sub_total_2_disetujui" style="font-size: 12px;">{{ number_format($data->sub_total_2_disetujui) }}</th>
                                    </tr>
                                    @endif
                                    
                                </tfoot>
                            </table>
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
                                        <input type="text" name="uang_biaya_lainnya1" class="form-control" placeholder="Other Expense" value="{{ $data->uang_biaya_lainnya1 }}" readonly="true" />
                                    </td>
                                    <td>
                                        <input type="text" name="uang_biaya_lainnya1_nominal" value="{{ $data->uang_biaya_lainnya1_nominal }}" class="form-control" placeholder="IDR " readonly="true" />
                                    </td>
                                    <td>
                                        <input type="text" name="uang_biaya_lainnya1_nominal_disetujui" value="{{ $data->uang_biaya_lainnya1_nominal_disetujui }}"  class="form-control calculate_3" placeholder="IDR " {{$readonly}} />
                                    </td>
                                    <td>
                                        @if(!empty($data->uang_biaya_lainnya1_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_biaya_lainnya1_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" name="uang_biaya_lainnya1_catatan" value="{{ $data->uang_biaya_lainnya1_catatan }}" placeholder="Catatan" {{$readonly}} />
                                    </td>
                                </tr>
                                <tr>
                                    <td colspan="2">
                                        <input type="text" name="uang_biaya_lainnya2" value="{{ $data->uang_biaya_lainnya2 }}" class="form-control" placeholder="Other Expense" readonly="true" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control" value="{{ $data->uang_biaya_lainnya2_nominal }}" name="uang_biaya_lainnya2_nominal" placeholder="IDR " readonly="true" />
                                    </td>
                                    <td>
                                        <input type="text" class="form-control calculate_3" name="uang_biaya_lainnya2_nominal_disetujui" value="{{ $data->uang_biaya_lainnya2_nominal_disetujui }}" placeholder="IDR" {{$readonly}} />
                                    </td>
                                    <td>
                                        @if(!empty($data->uang_biaya_lainnya2_file))
                                        <label onclick="show_img('{{ asset('storage/file-training/'. $data->uang_biaya_lainnya2_file)  }}')" class="btn btn-info btn-xs"><i class="fa fa-image"></i> view</label>
                                        @endif
                                    </td>
                                    <td>
                                        <input type="text" name="uang_biaya_lainnya2_catatan" value="{{ $data->uang_biaya_lainnya2_catatan }}" class="form-control" placeholder="Note" {{$readonly}} />
                                    </td>
                                </tr>
                               <tr>
                                    <th colspan="2">Sub Total</th>
                                    <th class="sub_total_nominal_lainnya">{{ number_format($data->sub_total_3) }}</th>
                                    <th colspan="3" class="total_lain_lain_disetujui">{{ number_format($data->sub_total_3_disetujui) }}</th>
                                </tr>
                            </tbody>
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
                                    <th>Total Reimbursement Disetujui </th>
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
                        <input type="hidden" name="status_actual_bill" value="0">
                        <input type="hidden" name="sub_total_1_disetujui" value="{{ $data->sub_total_1_disetujui }}">
                        <input type="hidden" name="sub_total_2_disetujui" value="{{ $data->sub_total_2_disetujui }}">
                        <input type="hidden" name="sub_total_3_disetujui" value="{{ $data->sub_total_3_disetujui }}">

                        <div class="col-md-12" style="padding-left: 0;">
                            <a href="{{ route('karyawan.approval.training-atasan.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Back</a>

                            @if($data->is_approve_atasan_actual_bill === NULL)
                            <a class="btn btn-sm btn-success waves-effect waves-light m-r-10" id="btn_approved"><i class="fa fa-check"></i> Approved </a>
                            <a class="btn btn-sm btn-danger waves-effect waves-light m-r-10" id="btn_tolak"><i class="fa fa-close"></i> Denied</a>
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

<script type="text/javascript">
     $(document).ready(function () {

        calculate_morning();
        calculate_afternoon();
        calculate_evening();
        calculate_daily();
        calculate_allAllowance();
        calculate_all();
 });
     
    $(".morning_approved").on('input', function(){
         calculate_morning();
         calculate_allAllowance();
         calculate_all();
    });
    $(".afternoon_approved").on('input', function(){
         calculate_afternoon();
         calculate_allAllowance();
         calculate_all();
    });
    $(".evening_approved").on('input', function(){
         calculate_evening();
         calculate_allAllowance();
         calculate_all();
    });
    $(".daily_approved").on('input', function(){
         calculate_daily();
         calculate_allAllowance();
         calculate_all();
    });

    var calculate_morning  = function(){
    var totalMorning = 0;
    $('.morning_approved').each(function(){
        if($(this).val() != ""){
            totalMorning += parseInt($(this).val());
        }
    });

    $('.total_morningApproved').html(numberWithComma(totalMorning));
    }

    var calculate_afternoon  = function(){
        var totalAfternoon = 0;
        $('.afternoon_approved').each(function(){
            if($(this).val() != ""){
                totalAfternoon += parseInt($(this).val());
            }
        });

        $('.total_afternoonApproved').html(numberWithComma(totalAfternoon));
    }

    var calculate_evening  = function(){
        var totalEvening = 0;
        $('.evening_approved').each(function(){
            if($(this).val() != ""){
                totalEvening += parseInt($(this).val());
            }
        });

        $('.total_eveningApproved').html(numberWithComma(totalEvening));
    }

    var calculate_daily  = function(){
        var totalDaily = 0;
        $('.daily_approved').each(function(){
            if($(this).val() != ""){
                totalDaily += parseInt($(this).val());
            }
        });

        $('.total_dailyApproved').html(numberWithComma(totalDaily));
    }

    var calculate_allAllowance  = function(){
        var totalAll = 0;

        var totalMorning    = parseInt(document.getElementsByClassName("total_morningApproved")[0].innerHTML.replace(/,/g, ""));
        var totalAfternoon  = parseInt(document.getElementsByClassName("total_afternoonApproved")[0].innerHTML.replace(/,/g, ""));
        var totalEvening    = parseInt(document.getElementsByClassName("total_eveningApproved")[0].innerHTML.replace(/,/g, ""));
        var totalDaily      = parseInt(document.getElementsByClassName("total_dailyApproved")[0].innerHTML.replace(/,/g, ""));
        totalAll =(parseInt(totalMorning + totalAfternoon + totalEvening + totalDaily));
        
        $('.sub_total_2_disetujui').html(numberWithComma(totalAll));
        $("input[name='sub_total_2_disetujui']").val(totalAll);
    }

</script>


<script type="text/javascript">
    $(".calculate_1").on('input', function(){

        var val = 0;

        $(".calculate_1").each(function(){

            if($(this).val() != "")
            {
                val += parseInt($(this).val());                
            }
        });

        $('.total_transport_disetujui').html(numberWithComma(val));
        $("input[name='sub_total_1_disetujui']").val(val);

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

        $('.total_lain_lain_disetujui').html(numberWithComma(val));
        $("input[name='sub_total_3_disetujui']").val(val);
        calculate_all();
    });

    function calculate_all()
    {
        var val = 0;

        var sub_total_1_disetujui   = $("input[name='sub_total_1_disetujui']").val();
        var sub_total_2_disetujui   = $("input[name='sub_total_2_disetujui']").val();
        var sub_total_3_disetujui   = $("input[name='sub_total_3_disetujui']").val();

        var total_reimbursement_disetujui = 0;
        var total_actual_bill_disetujui = 0;

        if($("input[name='sub_total_1_disetujui']").val() != "")
        {
            total_reimbursement_disetujui     += parseInt($("input[name='sub_total_1_disetujui']").val());
            total_actual_bill_disetujui       += parseInt($("input[name='sub_total_1_disetujui']").val());  
            
        }

        if( $("input[name='sub_total_2_disetujui']").val() != "")
        {
            total_reimbursement_disetujui      += parseInt($("input[name='sub_total_2_disetujui']").val());
            total_actual_bill_disetujui        += parseInt($("input[name='sub_total_2_disetujui']").val());
        }

        if( $("input[name='sub_total_3_disetujui']").val() != "")
        {
            total_reimbursement_disetujui      += parseInt($("input[name='sub_total_3_disetujui']").val());
            total_actual_bill_disetujui        += parseInt($("input[name='sub_total_3_disetujui']").val());
        }

        {{ !empty($data->pengambilan_uang_muka) ? ' total_reimbursement_disetujui -='. $data->pengambilan_uang_muka .';' : '' }};


        $('.total_actual_bill_disetujui ').html(numberWithComma(total_actual_bill_disetujui ));
        $('.total_reimbursement_disetujui ').html(numberWithComma(total_reimbursement_disetujui ));
    }

   

</script>
<script type="text/javascript">
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

    $("#btn_approved").click(function(){
        bootbox.confirm('Approve Actual Bill Employee Business Trip ?', function(result){

            $("input[name='status_actual_bill']").val(1);
            if(result)
            {
                $('#form-actual-bill').submit();
            }

        });
    });

    $("#btn_tolak").click(function(){
        bootbox.confirm('Reject Actual Bill Employee Business Trip ?', function(result){

            if(result)
            {
                $('#form-actual-bill').submit();
            }

        });
    });
</script>
<!-- ============================================================== -->
<!-- End Page Content -->
<!-- ============================================================== -->
@endsection
@endsection
