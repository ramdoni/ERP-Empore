<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" type="image/png" sizes="16x16" href="../plugins/images/favicon.png">
    <title>@yield('title')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Bootstrap Core CSS -->
    <link href="{{ asset('admin-css/bootstrap/dist/css/bootstrap.min.css') }}" rel="stylesheet">
    <!-- Menu CSS -->
    <link href="{{ asset('admin-css/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.css') }}" rel="stylesheet">
    <!-- toast CSS -->
    <link href="{{ asset('admin-css/plugins/bower_components/toast-master/css/jquery.toast.css') }}" rel="stylesheet">
    <!-- morris CSS -->
    <link href="{{ asset('admin-css/plugins/bower_components/morrisjs/morris.css') }}" rel="stylesheet">
    <!-- chartist CSS -->
    <link href="{{ asset('admin-css/plugins/bower_components/chartist-js/dist/chartist.min.css') }}" rel="stylesheet">
    <link href="{{ asset('admin-css/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.css') }}" rel="stylesheet">
    <!-- Calendar CSS -->
    <link href="{{ asset('admin-css/plugins/bower_components/calendar/dist/fullcalendar.css') }}" rel="stylesheet" />
    <!-- animation CSS -->
    <link href="{{ asset('admin-css/css/animate.css') }}" rel="stylesheet">
    <!-- Custom CSS -->
    <link href="{{ asset('admin-css/css/style.css') }}?time=<?=date('His')?>" rel="stylesheet">
    <!-- color CSS -->
    <link href="{{ asset('admin-css/css/colors/green.css?v=2') }}" id="theme" rel="stylesheet">
    
    <link href="{{ asset('admin-css/plugins/bower_components/datatables/jquery.dataTables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="https://cdn.datatables.net/buttons/1.2.2/css/buttons.dataTables.min.css" rel="stylesheet" type="text/css" />
    
    <!-- Global site tag (gtag.js) - Google Analytics -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=UA-123281304-1"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'UA-123281304-1');
    </script>


    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]> 
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
<![endif]-->
    <style type="text/css">
        body {
            font-size: 12px;
        }
        table.table tr th, table.table tr td {
            font-size: 12px;
        }
        .navbar-header {
            background: #eaeaea;
            border-top: 5px solid red;
        }
    </style>
</head>

<body class="fix-header">

     <!-- ============================================================== -->
    <!-- Preloader -->
    <!-- ============================================================== -->
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
        </svg>
    </div>
     
    <!-- ============================================================== -->
    <!-- Wrapper -->
    <!-- ============================================================== -->
    <div id="wrapper">
        <!-- ============================================================== -->
        <!-- Topbar header - style you can find in pages.scss -->
        <!-- ============================================================== -->
        <nav class="navbar navbar-default navbar-static-top m-b-0">
            <div class="navbar-header">
                <div class="top-left-part">
                    <!-- Logo -->
                    <a class="logo" href="{{ route('administrator.dashboard') }}">
                        <span class="hidden-xs"></span>
                        <img src="{{ asset('empore.png') }}" style="width: 132px;">
                    </a>
                </div>
                <!-- /Logo -->
                <!-- Search input and Toggle icon -->
                <ul class="nav navbar-top-links navbar-left">
                    <li><a href="javascript:void(0)" class="open-close waves-effect waves-light visible-xs"><i class="ti-close ti-menu"></i></a></li>
                    <!-- .Megamenu -->
                </ul>
                <ul class="nav navbar-top-links navbar-right pull-right">
                    <li class="dropdown">
                        <a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="javascript:void(0)"> <img src="{{ asset('admin-css/images/user.png') }}" alt="user-img" width="36" class="img-circle"><b style="color:black;" class="hidden-xs">{{ Auth::user()->name }}</b><span class="caret"></span> </a>
                        <ul class="dropdown-menu dropdown-user animated flipInY">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="{{ asset('admin-css/images/user.png') }}" alt="user" /></div>
                                    <div class="u-text">
                                        <h4 style="color:black;">{{ Auth::user()->name }}</h4>
                                    </div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="#" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i class="fa fa-power-off"></i> Logout</a></li>
                        </ul>
                        <!-- /.dropdown-user -->
                    </li>
                    <!-- /.dropdown -->
                </ul>
            </div>
            <!-- /.navbar-header -->
            <!-- /.navbar-top-links -->
            <!-- /.navbar-static-side -->
        </nav>
        <!-- End Top Navigation -->
        <!-- ============================================================== -->
        <!-- Left Sidebar - style you can find in sidebar.scss  -->
        <!-- ============================================================== -->
        <div class="navbar-default sidebar" role="navigation">
            <div class="sidebar-nav">
                <div class="sidebar-head">
                    <h3><span class="fa-fw open-close"><i class="ti-menu hidden-xs"></i><i class="ti-close visible-xs"></i></span> <span class="hide-menu">Navigation</span></h3> </div>
                @include('layouts.nav')
            </div>
        </div>
        <!-- ============================================================== -->
        <!-- End Left Sidebar -->
        <!-- ============================================================== -->
        
        @yield('content')

        @include('layouts.alert')

    <!-- modal status exit -->
    <div id="modal_status_exit" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="myModalLabel">History Approval</h4> </div>
                    <div class="modal-body" id="modal_content_status_exit">
                        
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                    </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
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

    <script type="text/javascript">
    function status_approval_exit(id)
        {
            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-history-approval-exit') }}',
                data: {'foreign_id' : id ,'_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    var el = "";
                    if(data.data.jenis_karyawan == 'staff')
                    {
                        el = '<div class="panel-body">'+
                                '<div class="steamline">'+
                                    '<div class="sl-item">';

                        if(data.data.is_approved_atasan == 1)
                        {
                            el += '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>';
                        }
                        else if(data.data.is_approved_atasan == 0)
                        {
                            el += '<div class="sl-left bg-danger" title="Denied"> <i class="fa fa-close"></i></div>';
                        }
                        else if(data.data.is_approved_atasan === null)
                        {
                            el += '<div class="sl-left bg-warning"> <i class="fa fa-info"></i></div>';
                        }

                        el += '<div class="sl-right">'+
                                            '<div><strong>Manager</strong> <br /><a href="#">'+ data.data.atasan_name +'</a> </div>'+
                                            '<div class="desc">'+ (data.data.date_approved_atasan != null ? data.data.date_approved_atasan : '' ) +'<p>'+ (data.data.catatan_atasan != null ? data.data.catatan_atasan : '' )  +'</p></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                    }

                    el += '<div class="panel-body">'+
                            '<div class="steamline">'+
                                '<div class="sl-item">';

                    if(data.data.is_approved_atasan == 1)
                    {
                        el += '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>';
                    }
                    else if(data.data.is_approved_atasan == 0)
                    {
                        el += '<div class="sl-left bg-danger" title="Denied"> <i class="fa fa-close"></i></div>';
                    }
                    else if(data.data.is_approved_atasan === null)
                    {
                        el += '<div class="sl-left bg-warning"> <i class="fa fa-info"></i></div>';
                    }

                    el += '<div class="sl-right">'+
                                        '<div><strong>Direktur</strong><br><a href="#">'+ data.data.direktur_name +'</a> </div>'+
                                        '<div class="desc">'+ (data.data.approve_direktur_date != null ? data.data.approve_direktur_date : '' )  +'</p></div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                        
                        
                    $("#modal_content_history_approval").html(el);
                }
            });

            $("#modal_history_approval").modal('show');
        }

        function status_approval_actual_bill(id)
        {
            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-history-training-bill') }}',
                data: {'foreign_id' : id ,'_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    var el = "";
                    if(data.data.jenis_karyawan == 'staff')
                    {
                        el = '<div class="panel-body">'+
                                '<div class="steamline">'+
                                    '<div class="sl-item">';

                        if(data.data.is_approve_atasan_actual_bill == 1)
                        {
                            el += '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>';
                        }
                        else if(data.data.is_approve_atasan_actual_bill == 0)
                        {
                            el += '<div class="sl-left bg-danger" title="Denied"> <i class="fa fa-close"></i></div>';
                        }
                        else if(data.data.is_approve_atasan_actual_bill === null)
                        {
                            el += '<div class="sl-left bg-warning"> <i class="fa fa-info"></i></div>';
                        }

                        el +='<div class="sl-right">'+
                                            '<div><strong>Manager</strong> <br /><a href="#">'+ data.data.atasan +'</a> </div>'+
                                            '<div class="desc">'+ (data.data.date_approved_atasan != null ? data.data.date_approved_atasan : '' ) +'<p>'+ (data.data.catatan_atasan != null ? data.data.catatan_atasan : '' )  +'</p></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                    }

                    el += '<div class="panel-body">'+
                            '<div class="steamline">'+
                                '<div class="sl-item">';

                        if(data.data.approve_direktur_actual_bill == 1)
                        {
                            el += '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>';
                        }
                        else if(data.data.approve_direktur_actual_bill == 0)
                        {
                            el += '<div class="sl-left bg-danger" title="Denied"> <i class="fa fa-close"></i></div>';
                        }
                        else if(data.data.approve_direktur_actual_bill === null)
                        {
                            el += '<div class="sl-left bg-warning"> <i class="fa fa-info"></i></div>';
                        }

                    el += '<div class="sl-right">'+
                                        '<div><strong>Direktur</strong><br><a href="#">'+ data.data.direktur +'</a> </div>'+
                                        '<div class="desc">'+ (data.data.approve_direktur_date != null ? data.data.approve_direktur_date : '' )  +'</p></div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                        
                    $("#modal_content_history_approval").html(el);
                }
            });

            $("#modal_history_approval").modal('show');
        }

        function status_approval_training(id)
        {
            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-history-approval-training') }}',
                data: {'foreign_id' : id ,'_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    var el = "";
                    if(data.data.jenis_karyawan == 'staff')
                    {
                        el = '<div class="panel-body">'+
                                '<div class="steamline">'+
                                    '<div class="sl-item">';

                        if(data.data.is_approved_atasan == 1)
                        {
                            el += '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>';
                        }
                        else if(data.data.is_approved_atasan == 0)
                        {
                            el += '<div class="sl-left bg-danger" title="Denied"> <i class="fa fa-close"></i></div>';
                        }
                        else if(data.data.is_approved_atasan === null)
                        {
                            el += '<div class="sl-left bg-warning"> <i class="fa fa-info"></i></div>';
                        }

                        el +='<div class="sl-right">'+
                                            '<div><strong>Manager</strong> <br /><a href="#">'+ data.data.atasan +'</a> </div>'+
                                            '<div class="desc">'+ (data.data.date_approved_atasan != null ? data.data.date_approved_atasan : '' ) +'<p>'+ (data.data.catatan_atasan != null ? data.data.catatan_atasan : '' )  +'</p></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                    }

                    el += '<div class="panel-body">'+
                            '<div class="steamline">'+
                                '<div class="sl-item">';

                        if(data.data.approve_direktur == 1)
                        {
                            el += '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>';
                        }
                        else if(data.data.approve_direktur == 0)
                        {
                            el += '<div class="sl-left bg-danger" title="Denied"> <i class="fa fa-close"></i></div>';
                        }
                        else if(data.data.approve_direktur === null)
                        {
                            el += '<div class="sl-left bg-warning"> <i class="fa fa-info"></i></div>';
                        }

                        el += '<div class="sl-right">'+
                                        '<div><strong>Direktur</strong><br><a href="#">'+ data.data.direktur +'</a> </div>'+
                                        '<div class="desc">'+ (data.data.approve_direktur_date != null ? data.data.approve_direktur_date : '' )  +'</p></div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';
                        
                    $("#modal_content_history_approval").html(el);
                }
            });

            $("#modal_history_approval").modal('show');
        }

        function status_approval_payment_request(id)
        {
             $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-history-approval-payment-request') }}',
                data: {'foreign_id' : id ,'_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    var el = "";
                    if(data.data.jenis_karyawan == 'staff')
                    {
                        el = '<div class="panel-body">'+
                                '<div class="steamline">'+
                                    '<div class="sl-item">';

                    if(data.data.is_approved_atasan == 1)
                    {
                        el += '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>';
                    }
                    else if(data.data.is_approved_atasan == 0)
                    {
                        el += '<div class="sl-left bg-danger" title="Denied"> <i class="fa fa-close"></i></div>';
                    }
                    else if(data.data.is_approved_atasan === null)
                    {
                        el += '<div class="sl-left bg-warning"> <i class="fa fa-info"></i></div>';
                    }
                    
                    el += '<div class="sl-right">'+
                                            '<div><strong>Manager</strong> <br /><a href="#">'+ data.data.atasan_name +'</a> </div>'+
                                            '<div class="desc">'+ (data.data.date_approved_atasan != null ? data.data.date_approved_atasan : '' ) +'<p>'+ (data.data.catatan_atasan != null ? data.data.catatan_atasan : '' )  +'</p></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                    }

                    el += '<div class="panel-body">'+
                            '<div class="steamline">'+
                                '<div class="sl-item">';

                    if(data.data.is_approved_atasan == 1)
                    {
                        el += '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>';
                    }
                    else if(data.data.is_approved_atasan == 0)
                    {
                        el += '<div class="sl-left bg-danger" title="Denied"> <i class="fa fa-close"></i></div>';
                    }
                    else if(data.data.is_approved_atasan === null)
                    {
                        el += '<div class="sl-left bg-warning"> <i class="fa fa-info"></i></div>';
                    }
                    
                    el += '<div class="sl-right">'+
                                        '<div><strong>Direktur</strong><br><a href="#">'+ data.data.direktur_name +'</a> </div>'+
                                        '<div class="desc">'+ (data.data.approve_direktur_date != null ? data.data.approve_direktur_date : '' )  +'</p></div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';

                    $("#modal_content_history_approval").html(el);
                }
            });

            $("#modal_history_approval").modal('show');
        }

        function status_approval_overtime(id)
        {
             $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-history-approval-overtime') }}',
                data: {'foreign_id' : id ,'_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    var el = "";
                    if(data.data.jenis_karyawan == 'staff')
                    {
                        el = '<div class="panel-body">'+
                                '<div class="steamline">'+
                                    '<div class="sl-item">';

                        if(data.data.is_approved_atasan == 1)
                        {
                            el += '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>';
                        }
                        else if(data.data.is_approved_atasan == 0)
                        {
                            el += '<div class="sl-left bg-danger" title="Denied"> <i class="fa fa-close"></i></div>';
                        }
                        else if(data.data.is_approved_atasan === null)
                        {
                            el += '<div class="sl-left bg-warning"> <i class="fa fa-info"></i></div>';
                        }
                        
                        el += '<div class="sl-right">'+
                                            '<div><strong>Manager</strong> <br /><a href="#">'+ data.data.atasan_name +'</a> </div>'+
                                            '<div class="desc">'+ (data.data.date_approved_atasan != null ? data.data.date_approved_atasan : '' ) +'<p>'+ (data.data.catatan_atasan != null ? data.data.catatan_atasan : '' )  +'</p></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                    }

                    el += '<div class="panel-body">'+
                            '<div class="steamline">'+
                                '<div class="sl-item">';

                    if(data.data.approve_direktur == 1)
                    {
                        el += '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>';
                    }
                    else if(data.data.approve_direktur == 0)
                    {
                        el += '<div class="sl-left bg-danger" title="Denied"> <i class="fa fa-close"></i></div>';
                    }
                    else if(data.data.approve_direktur === null)
                    {
                        el += '<div class="sl-left bg-warning"> <i class="fa fa-info"></i></div>';
                    }

                    el += '<div class="sl-right">'+
                                        '<div><strong>Direktur</strong><br><a href="#">'+ data.data.direktur_name +'</a> </div>'+
                                        '<div class="desc">'+ (data.data.approve_direktur_date != null ? data.data.approve_direktur_date : '' )  +'</p></div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';


                    $("#modal_content_history_approval").html(el);
                }
            });

            $("#modal_history_approval").modal('show');
        }

        function status_approval_medical(id)
        {
             $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-history-approval-medical') }}',
                data: {'foreign_id' : id ,'_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    var el = "";
                    if(data.data.jenis_karyawan == 'staff')
                    {
                        el = '<div class="panel-body">'+
                                '<div class="steamline">'+
                                    '<div class="sl-item">';

                                    if(data.data.is_approved_atasan == 1)
                                    {
                                        el += '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>';
                                    }
                                    else if(data.data.is_approved_atasan == 0)
                                    {
                                        el += '<div class="sl-left bg-danger" title="Denied"> <i class="fa fa-close"></i></div>';
                                    }
                                    else if(data.data.is_approved_atasan === null)
                                    {
                                        el += '<div class="sl-left bg-warning"> <i class="fa fa-info"></i></div>';
                                    }

                                    el += '<div class="sl-right">'+
                                            '<div><strong>Manager</strong> <br /><a href="#">'+ data.data.atasan_name +'</a> </div>'+
                                            '<div class="desc">'+ (data.data.date_approved_atasan != null ? data.data.date_approved_atasan : '' ) +'<p>'+ (data.data.catatan_atasan != null ? data.data.catatan_atasan : '' )  +'</p></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                    }

                    el += '<div class="panel-body">'+
                            '<div class="steamline">'+
                                '<div class="sl-item">';

                        if(data.data.approve_direktur == 1)
                        {
                            el += '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>';
                        }
                        else if(data.data.approve_direktur == 0)
                        {
                            el += '<div class="sl-left bg-danger" title="Denied"> <i class="fa fa-close"></i></div>';
                        }
                        else if(data.data.approve_direktur === null)
                        {
                            el += '<div class="sl-left bg-warning"> <i class="fa fa-info"></i></div>';
                        }

                        el += '<div class="sl-right">'+
                                        '<div><strong>Direktur</strong><br><a href="#">'+ data.data.direktur_name +'</a> </div>'+
                                        '<div class="desc">'+ (data.data.approve_direktur_date != null ? data.data.approve_direktur_date : '' )  +'</p></div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>'+
                        '</div>';

                    $("#modal_content_history_approval").html(el);
                }
            });

            $("#modal_history_approval").modal('show');
        }

        function detail_approval_cuti(jenis_form, id)
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
                                    '<div class="sl-item">';

                        if(data.data.is_approved_atasan == 1)
                        {
                            el += '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>';
                        }
                        else if(data.data.is_approved_atasan == 0)
                        {
                            el += '<div class="sl-left bg-danger" title="Denied"> <i class="fa fa-close"></i></div>';
                        }
                        else if(data.data.is_approved_atasan === null)
                        {
                            el += '<div class="sl-left bg-warning"> <i class="fa fa-info"></i></div>';
                        }
                        
                        el += '<div class="sl-right">'+
                                            '<div><strong>Manager</strong> <br /><a href="#">'+ data.data.atasan +'</a> </div>'+
                                            '<div class="desc">'+ (data.data.date_approved_atasan != null ? data.data.date_approved_atasan : '' ) +'<p>'+ (data.data.catatan_atasan != null ? data.data.catatan_atasan : '' )  +'</p></div>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>'+
                            '</div>';
                    }

                    el += '<div class="panel-body">'+
                            '<div class="steamline">'+
                                '<div class="sl-item">';

                    if(data.data.approve_direktur == 1)
                    {
                        el += '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>';
                    }
                    else if(data.data.approve_direktur == 0)
                    {
                        el += '<div class="sl-left bg-danger" title="Denied"> <i class="fa fa-close"></i></div>';
                    }
                    else if(data.data.approve_direktur === null)
                    {
                        el += '<div class="sl-left bg-warning"> <i class="fa fa-info"></i></div>';
                    }
                                    

                    el += '<div class="sl-right">'+
                                        '<div><strong>Direktur</strong><br><a href="#">'+ data.data.direktur +'</a> </div>'+
                                        '<div class="desc">'+ (data.data.approve_direktur_date != null ? data.data.approve_direktur_date : '' )  +'</p></div>'+
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

    <!-- ============================================================== -->
    <!-- End Wrapper -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- All Jquery -->
    <!-- ============================================================== -->
    <script src="{{ asset('admin-css/plugins/bower_components/jquery/dist/jquery.min.js') }}"></script>
    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset('admin-css/bootstrap/dist/js/bootstrap.min.js') }}"></script>
    <!-- Menu Plugin JavaScript -->
    <script src="{{ asset('admin-css/plugins/bower_components/sidebar-nav/dist/sidebar-nav.min.js') }}"></script>
    <!--slimscroll JavaScript -->
    <script src="{{ asset('admin-css/js/jquery.slimscroll.js') }}"></script>
    <!--Wave Effects -->
    <script src="{{ asset('admin-css/js/waves.js') }}"></script>
    <!--Counter js -->
    <script src="{{ asset('admin-css/plugins/bower_components/waypoints/lib/jquery.waypoints.js') }}"></script>
    <script src="{{ asset('admin-css/plugins/bower_components/counterup/jquery.counterup.min.js') }}"></script>
    <!--Morris JavaScript -->
    <script src="{{ asset('admin-css/plugins/bower_components/raphael/raphael-min.js') }}"></script>
    <script src="{{ asset('admin-css/plugins/bower_components/morrisjs/morris.js') }}"></script>
    <!-- chartist chart -->
    <script src="{{ asset('admin-css/plugins/bower_components/chartist-js/dist/chartist.min.js') }}"></script>
    <script src="{{ asset('admin-css/plugins/bower_components/chartist-plugin-tooltip-master/dist/chartist-plugin-tooltip.min.js') }}"></script>
    <!-- Calendar JavaScript -->
    <script src="{{ asset('admin-css/plugins/bower_components/moment/moment.js') }}"></script>
    <script src="{{ asset('admin-css/plugins/bower_components/calendar/dist/fullcalendar.min.js') }}"></script>
    <script src="{{ asset('admin-css/plugins/bower_components/calendar/dist/cal-init.js') }}"></script>
    <script src="{{ asset('admin-css/plugins/bower_components/toast-master/js/jquery.toast.js') }}"></script>
    <script src="{{ asset('js/jquery.priceformat.min.js') }}"></script>
    
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset('admin-css/js/custom.min.js') }}"></script>
    <script src="{{ asset('admin-css/js/dashboard1.js') }}?time=<?=date('His')?>"></script>
    <!-- Custom tab JavaScript -->
    <script src="{{ asset('admin-css/js/cbpFWTabs.js') }}"></script>
    <script src="{{ asset('js/general.js?v='. date('His')) }}"></script>
    <script src="{{ asset('js/bootbox.min.js') }}"></script>

    <!-- start - This is for export functionality only -->
    <script src="{{ asset('admin-css/plugins/bower_components/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.flash.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
    <script src="https://cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.2.2/js/buttons.print.min.js"></script>


    
    <script type="text/javascript">
        
        function status_exit_interview(id)
        {
             $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-history-approval-exit') }}',
                data: {'foreign_id' : id ,'_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    var el = '<div class="panel-body">'+
                                        '<div class="steamline">'+
                                            '<div class="sl-item">'+
                                                (data.data.is_approved_atasan == 1 ? '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>' : '<div class="sl-left bg-danger"> <i class="fa fa-close"></i></div>' )+
                                                '<div class="sl-right">'+
                                                    '<div><a href="#">'+ data.data.atasan +'</a> </div>'+
                                                    '<div class="desc">'+ data.data.date_approved_atasan +'<p>'+ data.data.catatan_atasan +'</p></div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>';

                            el += '<div class="panel-body">'+
                                        '<div class="steamline">'+
                                            '<div class="sl-item">'+
                                                (data.data.is_approved_hrd == 1 ? '<div class="sl-left bg-success"> <i class="fa fa-check"></i></div>' : '<div class="sl-left bg-danger"> <i class="fa fa-close"></i></div>' )+
                                                '<div class="sl-right">'+
                                                    '<div><a href="#">HRD</a> </div>'+
                                                '</div>'+
                                            '</div>'+
                                        '</div>'+
                                    '</div>';

                    $("#modal_content_status_exit").html(el);
                }
            });

            $("#modal_status_exit").modal('show');
        }

        $(".myadmin-alert .closed").click(function(event) {
            $(this).parents(".myadmin-alert").fadeToggle(350);
            return false;
        });

        $('#data_table_no_copy').DataTable({
            dom: 'Bfrtip',
             buttons: []
        });

        $('#data_table_no_copy2').DataTable({
            dom: 'Bfrtip',
             buttons: []
        });

        $('#data_table_no_copy3').DataTable({
            dom: 'Bfrtip',
             buttons: []
        });
        

        $('#data_table').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        $('#data_table2').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        $('#data_table3').DataTable({
            dom: 'Bfrtip',
            buttons: [
                'copy', 'csv', 'excel', 'pdf', 'print'
            ]
        });

        $("#data_table_no_search").DataTable({
            dom: 'Bfrtip',
            searching: false,
            buttons: [
                
            ]
        });

    </script>

    @yield('footer-script')
<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
    {{ csrf_field() }}
</form>
</body>
</html>