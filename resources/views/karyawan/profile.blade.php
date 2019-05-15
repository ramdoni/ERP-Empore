@extends('layouts.karyawan')

@section('title', 'Profile')

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
            <div class="col-md-6 col-sm-12 col-lg-4">
                <div class="panel">
                    <div class="p-30">
                        <div class="row">
                            <div class="col-xs-4 col-sm-4">
                                @if(empty(Auth::user()->foto))
                                <img src="{{ asset('admin-css/images/user.png') }}" alt="varun" class="img-circle img-responsive">
                                @else
                                <img src="{{ asset('storage/foto/'. Auth::user()->foto) }}" alt="varun" class="img-circle img-responsive">
                                @endif
                            </div>
                            <div class="col-xs-12 col-sm-8">
                                <h2 class="m-b-0">{{ Auth::user()->name }}</h2>
                                <h4>{{ empore_jabatan(Auth::user()->id) }}</h4>
                                <a class="btn btn-info btn-xs" id="change_password">Change Password <i class="fa fa-key"></i></a>
                                @if(Auth::user()->last_change_password !== null) 
                                    <p>Last Update :  {{ date('d F Y H:i', strtotime(Auth::user()->last_change_password)) }}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="p-20 text-center">
                        <table class="table table-hover">
                            <tr>
                                <th>NIK</th>
                                <th> : {{ Auth::user()->nik }}</th>
                            </tr>
                            <tr>
                                <th>Email</th>
                                <th> : {{ Auth::user()->email }}</th>
                            </tr>
                            <tr>
                                <th>Place of birth</th>
                                <th> : {{ Auth::user()->tempat_lahir }}</th>
                            </tr>
                            <tr>
                                <th>Date of birth</th>
                                <th> : {{ Auth::user()->tanggal_lahir }}</th>
                            </tr>
                            <tr>
                                <th>Gender</th>
                                <th> : {{ Auth::user()->jenis_kelamin }}</th>
                            </tr>
                            <tr>
                                <th>Religion</th>
                                <th> : {{ Auth::user()->agama }}</th>
                            </tr>
                            
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-lg-8 col-sm-12">
                <div class="white-box">
                    <div class="panel">
                         <ul class="nav customtab nav-tabs" role="tablist">
                            <li role="presentation" class="active"><a href="#dependent" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Dependent</span></a></li>                            
                            <li role="presentation" class=""><a href="#education" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Education</span></a></li>
                            
                            <li role="presentation" class=""><a href="#rekening_bank" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Bank Account</span></a></li>
                           
                            <li role="presentation" class=""><a href="#cuti" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Leave</span></a></li>
                        </ul>
                        <div class="tab-content">
                            <div role="tabpanel" class="tab-pane fade" id="cuti">
                                <h3 class="box-title m-b-0">Leave / Permit</h3>
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Leave / Permit Type</th>
                                            <th>Quota</th>
                                            <th>Leave Taken</th>
                                            <th>Leave Balance</th>
                                        </tr>
                                    </thead>
                                    <tbody class="table_cuti">
                                        @foreach(Auth::user()->cuti as $no => $item)
                                        <tr>
                                            <td>{{ $no+1 }}</td>
                                            <td>{{ isset($item->cuti->jenis_cuti) ? $item->cuti->jenis_cuti : '' }}</td>
                                            <td>{{ $item->kuota }}</td>
                                            <td>{{ $item->cuti_terpakai }}</td>
                                            <td>{{ $item->sisa_cuti }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br />
                            </div>

                            <div role="tabpanel" class="tab-pane fade" id="rekening_bank">
                                <div class="form-group">
                                    <label class="col-md-12">Name of Account</label>
                                    <div class="col-md-6">
                                        <input type="text" name="nama_rekening" class="form-control" readonly="true" value="{{ $data->nama_rekening }}"  />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Account Number</label>
                                    <div class="col-md-6">
                                       <input type="text" name="nomor_rekening" class="form-control"  readonly="true" value="{{ $data->nomor_rekening }}" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Name of Bank</label>
                                    <div class="col-md-6">
                                        <select class="form-control" name="bank_id" readonly="true">
                                            <option value="">Pilih Bank</option>
                                            @foreach(get_bank() as $item)
                                            <option value="{{ $item->id }}" {{ $item->id == $data->bank_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                        
                            <div role="tabpanel" class="tab-pane fade in active" id="dependent">
                                <h3 class="box-title m-b-0">Dependent</h3>
                                <br />
                                <br />
                                <div class="table-responsive">
                                    <table class="table table-hover">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Name</th>
                                                <th>Relationship</th>
                                                <th>Place of birth</th>
                                                <th>Date of birth</th>
                                                <th>Date of death</th>
                                                <th>Education level</th>
                                                <th>Occupation</th>
                                            </tr>
                                        </thead>
                                        <tbody class="dependent_table">
                                            @foreach($data->userFamily as $no => $item)
                                            <tr>
                                                <td>{{ $no+1 }}</td>
                                                <td>{{ $item->nama }}</td>
                                                <td>{{ $item->hubungan }}</td>
                                                <td>{{ $item->tempat_lahir }}</td>
                                                <td>{{ $item->tanggal_lahir }}</td>
                                                <td>{{ $item->tanggal_meninggal }}</td>
                                                <td>{{ $item->jenjang_pendidikan }}</td>
                                                <td>{{ $item->pekerjaan }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                             <div role="tabpanel" class="tab-pane fade" id="education">
                                <h3 class="box-title m-b-0">Education</h3>
                                <br />
                                <br />
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th></th>
                                                <th>Education</th>
                                                <th>Year of Start</th>
                                                <th>Year of Graduate</th>
                                                <th>School Name</th>
                                                <th>Major</th>
                                                <th>Grade</th>
                                                <th>City</th>
                                            </tr>
                                        </thead>
                                        <tbody class="education_table">
                                            @foreach($data->userEducation as $no => $item)
                                            <tr>
                                                <td>{{ $no+1 }}</td>
                                                <td>{{ $item->pendidikan }}</td>
                                                <td>{{ $item->tahun_awal }}</td>
                                                <td>{{ $item->tahun_akhir }}</td>
                                                <td>{{ $item->fakultas }}</td>
                                                <td>{{ $item->jurusan }}</td>
                                                <td>{{ $item->nilai }}</td>
                                                <td>{{ $item->kota }}</td>
                                            </tr>
                                            @endforeach
                                        </tbody>
                                    </table><br /><br />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="clearfix"></div><br />
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


@section('footer-script')
     <div class="modal fade" id="modal_reset_password" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel1">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
              <form>
                
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                    <h4 class="modal-title" id="exampleModalLabel1">Reset Password !</h4> 
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Password:</label>
                        <input type="password" name="password"class="form-control" placeholder="Password"> 
                    </div>

                    <div class="form-group">
                        <label for="recipient-name" class="control-label">Confirm Password:</label>
                        <input type="password" name="confirm"class="form-control" placeholder="Confirm Password"> 
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-info" id="submit_password">Submit Password <i class="fa fa-arrow-right"></i></button>
                </div>
              </form>
            </div>
        </div>
    </div> 

    <script type="text/javascript">
    

        $("#change_password").click(function(){

            $("#modal_reset_password").modal("show");

        });

        $("#submit_password").click(function(){

            var password    = $("input[name='password']").val();
            var confirm     = $("input[name='confirm']").val();

            if(password == "" || confirm == "")
            {
                bootbox.alert('Password atau Konfirmasi Password harus diisi !');
                return false;
            }

            if(password != confirm)
            {
                bootbox.alert('Password tidak sama');
            }
            else
            {
                 $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.update-first-password') }}',
                    data: {'id' : {{ Auth::user()->id }}, 'password' : password, '_token' : $("meta[name='csrf-token']").attr('content')},
                    dataType: 'json',
                    success: function (data) {
                        location.reload();
                    }
                });
            }
        });
    </script>
@endsection

@endsection
