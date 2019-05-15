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
                <h4 class="page-title">Form Karyawan</h4> </div>
            <div class="col-lg-9 col-sm-8 col-md-8 col-xs-12">

                <ol class="breadcrumb">
                    <li><a href="javascript:void(0)">Dashboard</a></li>
                    <li class="active">Employee</li>
                </ol>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        <!-- .row -->
    <div class="row">
        <form class="form-horizontal" enctype="multipart/form-data" action="{{ route('administrator.karyawan.update', $data->id ) }}" method="POST">
            <input type="hidden" name="_method" value="PUT">
            <div class="col-md-12">
                <div class="white-box">
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
                    <ul class="nav customtab nav-tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#biodata" aria-controls="home" role="tab" data-toggle="tab" aria-expanded="true"><span class="visible-xs"><i class="ti-home"></i></span><span class="hidden-xs"> Personal Information</span></a></li>

                        <li role="presentation" class=""><a href="#dependent" aria-controls="messages" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-email"></i></span> <span class="hidden-xs">Dependent</span></a></li>

                        <li role="presentation" class=""><a href="#education" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Education</span></a></li>

                        <li role="presentation" class=""><a href="#department" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Department / Division</span></a></li>

                        <li role="presentation" class=""><a href="#rekening_bank" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Bank Account</span></a></li>

                        <li role="presentation" class=""><a href="#cuti" aria-controls="settings" role="tab" data-toggle="tab" aria-expanded="false"><span class="visible-xs"><i class="ti-settings"></i></span> <span class="hidden-xs">Leave</span></a></li>
                    </ul>

                    <div class="tab-content">
                        <div role="tabpanel" class="tab-pane fade" id="cuti">
                            <h3 class="box-title m-b-0">Leave</h3>
                            <a class="btn btn-info btn-xs" id="add_cuti"><i class="fa fa-plus"></i> Add</a>
                            <div class="clearfix"></div>
                            <div class="col-md-6">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Leave / Permit Type</th>
                                            <th>Quota</th>
                                            <th>Leave Taken</th>
                                            <th>Leave Balance</th>
                                            <td>#</td>
                                        </tr>
                                    </thead>
                                    <tbody class="table_cuti">
                                        @foreach($data->cuti as $no => $item)
                                        <tr>
                                            <td>{{ $no+1 }}</td>
                                            <td>{{ isset($item->cuti->jenis_cuti) ? $item->cuti->jenis_cuti : '' }}</td>
                                            <td>{{ $item->kuota }}</td>
                                            <td>{{ $item->cuti_terpakai }}</td>
                                            <td>{{ $item->sisa_cuti }}</td>
                                            <td>
                                                <a onclick="edit_cuti({{ $item->id }}, {{ $item->cuti_id }}, {{ empty($item->kuota) ? 0 : $item->kuota }}, {{ empty($item->cuti_terpakai) ? 0 : $item->cuti_terpakai }})" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> </a>
                                                <a onclick="return confirm('Delete leave data ?')" href="{{ route('administrator.karyawan.delete-cuti', $item->id) }}" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                                <br />
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        
                        <div role="tabpanel" class="tab-pane fade" id="rekening_bank">
                            <div class="form-group">
                                <label class="col-md-12">Name of Account</label>
                                <div class="col-md-6">
                                    <input type="text" name="nama_rekening" class="form-control" value="{{ $data->nama_rekening }}"  />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Account Number</label>
                                <div class="col-md-6">
                                   <input type="text" name="nomor_rekening" class="form-control" value="{{ $data->nomor_rekening }}" />
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Name of Bank</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="bank_id">
                                        <option value="">Choose Bank</option>
                                        @foreach(get_bank() as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $data->bank_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade" id="department">

                            <div class="form-group">
                                <label class="col-md-12">Office Type</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="branch_type">
                                        <option value=""> - none - </option>
                                        @foreach(['HO', 'BRANCH'] as $item)
                                        <option {{ strtoupper($data->branch_type) == $item ? ' selected' : '' }}>{{ $item }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>

                            <div class="form-group section-cabang" style="{{ $data->branch_type == "HO" ? 'display:none' : ''  }}">
                                <label class="col-md-3">Branch</label>
                                <div class="clearfix"></div>
                                <div class="col-md-3">
                                    <select class="form-control" name="cabang_id">
                                        <option value="">Choose Branch</option>
                                        @foreach(get_cabang() as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $data->cabang_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="clearfix" /></div>
                                <br class="clearfix" />
                                <br>
                                <div class="col-md-12">
                                    <label><input type="checkbox" name="is_pic_cabang" value="1" {{ $data->is_pic_cabang == 1 ? 'checked' : '' }}> Branch PIC</label>
                                </div>
                                <div class="clearfix"></div>
                                <hr />
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Director</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="empore_organisasi_direktur">
                                        <option value=""> Choose </option>
                                        @foreach(empore_list_direktur() as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $data->empore_organisasi_direktur ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Manager</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="empore_organisasi_manager_id">
                                        <option value=""> Choose </option>
                                        @foreach($list_manager as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $data->empore_organisasi_manager_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Supervisor</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="empore_organisasi_supervisor_id">
                                        <option value=""> Choose </option>
                                        @foreach($list_supervisor as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $data->empore_organisasi_supervisor_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label class="col-md-12">Staff</label>
                                <div class="col-md-6">
                                    <select class="form-control" name="empore_organisasi_staff_id">
                                        <option value=""> Choose </option>
                                        @foreach($list_staff as $item)
                                        <option value="{{ $item->id }}" {{ $item->id == $data->empore_organisasi_staff_id ? 'selected' : '' }}>{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div role="tabpanel" class="tab-pane fade active in" id="biodata">
                            <h3 class="box-title m-b-0">Personal Information</h3>
                            <hr />
                            {{ csrf_field() }}
                            <div class="col-md-6" style="padding-left: 0">
                                <div class="form-group">
                                    <label class="col-md-12">NIK</label>
                                    <div class="col-md-10">
                                        <input type="text" name="nik" value="{{ $data->nik }}" class="form-control  "> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Name</label>
                                    <div class="col-md-10">
                                        <input type="text" name="name" style="text-transform: uppercase" class="form-control  " value="{{ $data->name }}"> </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-md-12">Ext</label>
                                    <div class="col-md-10">
                                        <input type="text" name="ext" value="{{ $data->ext }}" class="form-control  "> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Place of Birth</label>
                                    <div class="col-md-10">
                                        <input type="text" name="tempat_lahir" value="{{ $data->tempat_lahir }}" class="form-control  "> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Date of Birth</label>
                                    <div class="col-md-10">
                                        <input type="text" name="tanggal_lahir" value="{{ $data->tanggal_lahir }}" class="form-control   datepicker"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Marital Status</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="marital_status">
                                            <option value="">- Marital Status -</option>
                                             <option value="Bujangan/Wanita" {{old('marital_status',$data->marital_status)=="Bujangan/Wanita"? 'selected':''}} >Single</option>
                                    <option value="Menikah" {{old('marital_status',$data->marital_status)=="Menikah"? 'selected':''}} >Married</option>
                                    <option value="Menikah Anak 1" {{old('marital_status',$data->marital_status)=="Menikah Anak 1"? 'selected':''}} >Married with 1 Child</option>
                                    <option value="Menikah Anak 2" {{old('marital_status',$data->marital_status)=="Menikah Anak 2"? 'selected':''}} >Married with 2 Child</option>
                                    <option value="Menikah Anak 3" {{old('marital_status',$data->marital_status)=="Menikah Anak 3"? 'selected':''}} >Married with 3 Child</option>
                                        </select>
                                   
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-5">Gender</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="jenis_kelamin">
                                            <option value=""> - Gender - </option>
                                            @foreach(['Male', 'Female'] as $item)
                                                <option {{ $data->jenis_kelamin == $item ? 'selected' : '' }}>{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                    
                                </div>
                                 <div class="form-group">
                                    <label class="col-md-5">Blood Type</label>
                                    <div class="col-md-10">
                                        <input type="text" class="form-control  " value="{{ $data->blood_type }}" name="blood_type">
                                     </div>
                                </div>

                                <div class="form-group">
                                    <label for="example-email" class="col-md-12">Email</label>
                                    <div class="col-md-10">
                                        <input type="email" value="{{ $data->email }}" class="form-control  " name="email" id="example-email"> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Password</label>
                                    <div class="col-md-10">
                                        <input type="password" name="password" class="form-control" value="{{ $data->password }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Confirm Password</label>
                                    <div class="col-md-10">
                                        <input type="password" name="confirm" class="form-control" value="{{ $data->password }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Join Date</label>
                                    <div class="col-md-10">
                                        <input type="text" name="join_date" class="form-control datepicker" value="{{ ($data->join_date == '0000-00-00' ? '' : $data->join_date) }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Employee Status</label>
                                    <div class="col-md-10">
                                        <select class="form-control" name="organisasi_status">
                                            <option value="">- select - </option>
                                            @foreach(['Permanent', 'Contract'] as $item)
                                            <option {{ $data->organisasi_status == $item ? 'selected' : '' }}>{{ $item }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">BPJS Ketenagakerjaan Number</label>
                                    <div class="col-md-10">
                                        <input type="text" name="bpjs_number" value="{{ $data->bpjs_number }}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">BPJS Kesehatan Number</label>
                                    <div class="col-md-10">
                                        <input type="text" name="jamsostek_number" value="{{ $data->jamsostek_number }}" class="form-control">
                                    </div>
                                </div>
                                
                            </div>
                            <div class="col-md-6" style="padding-left: 0">
                                 <div class="form-group">
                                    <label class="col-md-12">NPWP Number</label>
                                    <div class="col-md-10">
                                        <input type="text" name="npwp_number" class="form-control"  value="{{ $data->npwp_number }}">
                                    </div>
                                </div>
                                 <div class="form-group">
                                    <label class="col-md-12">ID Number</label>
                                    <div class="col-md-10">
                                        <input type="text" name="ktp_number" class="form-control"  value="{{ $data->ktp_number }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Passport Number</label>
                                    <div class="col-md-10">
                                        <input type="text" name="passport_number" value="{{ $data->passport_number }}" class="form-control">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">KK Number</label>
                                    <div class="col-md-10">
                                        <input type="text" name="kk_number" class="form-control" value="{{ $data->kk_number }}">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Telephone</label>
                                    <div class="col-md-12">
                                        <input type="number" value="{{ $data->telepon }}" name="telepon" class="form-control  "> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Mobile 1</label>
                                    <div class="col-md-12">
                                        <input type="number" value="{{ $data->mobile_1 }}" name="mobile_1" class="form-control  "> </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Mobile 2</label>
                                    <div class="col-md-12">
                                        <input type="number" value="{{ $data->mobile_2 }}" name="mobile_2" class="form-control  "> </div>
                                </div>
                               <div class="form-group">
                                    <label class="col-md-12">Religion</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="agama">
                                            <option value=""> - Religion - </option>
                                            @foreach(agama() as $item)
                                                <option value="{{ $item }}" {{ $data->agama == $item ? 'selected' : '' }}> {{ $item }} </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Current Address</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="alamat">{{ $data->alamat }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">ID address</label>
                                    <div class="col-md-12">
                                        <textarea class="form-control" name="id_address">{{ $data->id_address }}</textarea>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">ID City</label>
                                    <div class="col-md-12">
                                        <select class="form-control" name="id_city">
                                            <option value="">- none - </option>
                                            @foreach(get_kabupaten() as $item)
                                            <option value="{{ $item->id_kab }}" {{ $data->id_city == $item->id_kab ? 'selected' : '' }}>{{ $item->nama }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">ID Zip Code</label>
                                    <div class="col-md-12">
                                        <input type="text" name="id_zip_code" class="form-control" value="{{ $data->id_zip_code }}" />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-md-12">Photograph</label>
                                    <div class="col-md-12">
                                        <input type="file" name="foto" class="form-control" />
                                        @if(!empty($data->foto))
                                        <img src="{{ asset('storage/foto/'. $data->foto) }}" style="width: 200px;" />
                                        @endif
                                    </div>
                                </div>
                                
                               
                                
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="dependent">
                            <h3 class="box-title m-b-0">Dependent</h3><a class="btn btn-info btn-sm" id="btn_modal_dependent"><i class="fa fa-plus"></i> Add</a>
                            <br />
                            <br />
                            <div class="table-responsive">
                                <table class="table">
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
                                            <th>#</th>
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
                                            <td>
                                                <a href="javascript:;" onclick="edit_dependent({{ $item->id }}, '{{ $item->nama }}', '{{ $item->hubungan }}', '{{ $item->tempat_lahir }}', '{{ $item->tanggal_lahir }}', '{{ $item->tanggal_meninggal }}', '{{ $item->jenjang_pendidikan }}', '{{ $item->pekerjaan }}', '{{ $item->tertanggung }}')" class="btn btn-default btn-xs"><i class="fa fa-edit"></i> </a>
                                                <a href="{{ route('administrator.karyawan.delete-dependent', $item->id) }}" onclick="return confirm('Delete this data?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i> </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div role="tabpanel" class="tab-pane fade" id="education">
                            <h3 class="box-title m-b-0">Education</h3><a class="btn btn-info btn-sm" id="btn_modal_education"><i class="fa fa-plus"></i> Add</a>
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
                                            <th>#</th>
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
                                            <td>
                                                <a class="btn btn-default btn-xs" onclick="edit_education({{ $item->id }}, '{{ $item->pendidikan }}', '{{ $item->tahun_awal }}', '{{ $item->tahun_akhir }}', '{{ $item->fakultas }}', '{{ $item->jurusan }}', '{{ $item->nilai }}', '{{ $item->kota }}')"><i class="fa fa-edit"></i></a>
                                                <a href="{{ route('administrator.karyawan.delete-education', $item->id) }}" onclick="return confirm('Delete this data?')" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table><br /><br />
                            </div>
                        </div>

                    </div>
                    <hr />
                    <a href="{{ route('administrator.karyawan.index') }}" class="btn btn-sm btn-default waves-effect waves-light m-r-10"><i class="fa fa-arrow-left"></i> Cancel</a>
                    <button type="submit" class="btn btn-sm btn-success waves-effect waves-light m-r-10"><i class="fa fa-save"></i> Save Employee Data </button>
                    <br style="clear: both;" />
                    <div class="clearfix"></div>
                </div>
            </div>
        </form>
    </div>
    <!-- /.row -->
    <!-- ============================================================== -->
</div>
    <!-- /.container-fluid -->
    @include('layouts.footer')
</div>
<!-- modal content dependent  -->
<div id="modal_dependent" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Add Dependent</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal frm-modal-dependent">
                        <div class="form-group">
                            <label class="col-md-12">Name</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control modal-nama">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Relationship</label>
                            <div class="col-md-12">
                                <select class="form-control modal-hubungan">
                                    <option value="">Choose Relationship</option>
                                    <option value="Suami">Husband</option>
                                    <option value="Istri">Wife</option>
                                    <option value="Anak 1">First Child</option>
                                    <option value="Anak 2">Second Child</option>
                                    <option value="Anak 3">Third Child</option>
                                    <option value="Anak 4">Fourth Child</option>
                                    <option value="Anak 5">Fifth Child</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Place of birth</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control modal-tempat_lahir">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Date of birth</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control datepicker modal-tanggal_lahir">
                            </div>
                        </div>
                         <div class="form-group">
                            <label class="col-md-12">Date of death</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control datepicker modal-tanggal_meninggal">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Education level</label>
                            <div class="col-md-12">
                                <select class="form-control modal-jenjang_pendidikan">
                                    <option value="">Choose Education Level</option>
                                    <option value="SD">SD</option>
                                    <option value="SMP">SMP</option>
                                    <option value="SMA">SMA / SMK</option>
                                    <option value="DIPLOMA">DIPLOMA</option>
                                    <option value="S1">S1</option>
                                    <option value="S2">S2</option>
                                    <option value="S3">S3</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Occupation</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control modal-pekerjaan" >
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Dependent</label>
                            <div class="col-md-12">
                                <select class="form-control modal-tertanggung">
                                    <option>Yes</option>
                                    <option>No</option>
                                </select>
                            </div>
                        </div>
                        <input type="hidden" name="action_dependent" value="insert">
                        <input type="hidden" name="id_dependent">
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-info btn-sm" id="add_modal_dependent">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- modal content education  -->
<div id="modal_education" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Add Education</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal frm-modal-education">
                        <div class="form-group">
                            <label class="col-md-3">Education</label>
                            <div class="col-md-9">
                                <select class="form-control modal-pendidikan">
                                    <option value="">Coose Education</option>
                                    <option>SD</option>
                                    <option>SMP</option>
                                    <option>SMA</option>
                                    <option>DIPLOMA</option>
                                    <option>S1</option>
                                    <option>S2</option>
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Year of Start</label>
                            <div class="col-md-9">
                                <input type="number" class="form-control modal-tahun_awal" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Year of Graduate</label>
                            <div class="col-md-9">
                                <input type="number" class="form-control modal-tahun_akhir" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">School Name</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control modal-fakultas" />
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Major</label>
                            <div class="col-md-9">
                                <select class="form-control modal-jurusan">
                                    <option value="">Choose Major</option>
                                    @foreach(get_jurusan() as $item)
                                    <option>{{ $item->name }}</option>
                                    @endforeach
                                    @foreach(get_program_studi() as $item)
                                    <option>{{ $item->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-3">Grade</label>
                            <div class="col-md-9">
                                <input type="text" class="form-control modal-nilai" />
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label class="col-md-3">City</label>
                           <div class="col-md-9">
                                <input type="text" class="form-control modal-kota" />
                            </div>
                        </div>
                        <input type="hidden" name="action_education" value="insert" />
                        <input type="hidden" name="id_education" value="">
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-info btn-sm" id="add_modal_education">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- modal content education  -->
<div id="modal_inventaris_mobil" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Tambah Inventaris Mobil</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal frm-modal-inventaris">
                        <div class="form-group">
                            <label class="col-md-12">Tipe Mobil</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control modal-tipe_mobil">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Tahun</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control modal-tahun">
                            </div>
                       </div>
                       <div class="form-group">
                            <label class="col-md-12">No Polisi</label>
                            <div class="col-md-12">
                                <input type="text" class="form-control modal-no_polisi">
                            </div>
                       </div>
                       <div class="form-group">
                            <label class="col-md-12">Status Mobil</label>
                            <div class="col-md-12">
                                <select class="form-control modal-status_mobil">
                                    <option value="">- none -</option>
                                    <option>Rental</option>
                                    <option>Perusahaan</option>
                                </select>
                            </div>
                       </div>
                       <input type="hidden" name="id_inventaris_mobil">
                       <input type="hidden" name="action_inventaris_mobil" value="insert">
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-info btn-sm" id="add_modal_inventaris_mobil">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<!-- modal content education  -->
<div id="modal_cuti" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
                <h4 class="modal-title" id="myModalLabel">Leave / Permit Type</h4> </div>
                <div class="modal-body">
                   <form class="form-horizontal frm-modal-cuti">
                        <div class="form-group">
                            <label class="col-md-12">Leave Type</label>
                            <div class="col-md-12">
                                <select class="form-control modal-jenis_cuti">
                                    <option value="">- none -</option>
                                    @foreach(get_master_cuti() as $i)
                                    <option value="{{ $i->id }}">{{ $i->jenis_cuti }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-12">Quota</label>
                            <div class="col-md-12">
                                <input type="number" class="form-control modal-kuota">
                            </div>
                       </div>
                       <div class="form-group">
                            <label class="col-md-12">Leave Taken</label>
                            <div class="col-md-12">
                                <input type="number" class="form-control modal-terpakai">
                            </div>
                       </div>
                       <div class="form-group">
                            <label class="col-md-12">Leave Balance</label>
                            <div class="col-md-12">
                                <input type="text" readonly="true" class="form-control modal-sisa_cuti">
                            </div>
                       </div>
                       <input type="hidden" name="action_cuti" value="insert" />
                       <input type="hidden" name="cuti_id" />
                   </form>
                </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default waves-effect btn-sm" data-dismiss="modal">Close</button>
                <button type="reset" class="btn btn-info btn-sm" id="add_modal_cuti">Save</button>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

@section('footer-script')
    <style type="text/css">
        .staff-branch-select, .head-branch-select {
            display: none;
        }

        @if($data->jabatan_cabang == 'Head')
        .head-branch-select { display: block; }
        @endif

        @if($data->jabatan_cabang == 'Staff')
        .staff-branch-select { display: block; }
        @endif

    </style>
    <!-- Date picker plugins css -->
    <link href="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Date Picker Plugin JavaScript -->
    <script src="{{ asset('admin-css/plugins/bower_components/bootstrap-datepicker/bootstrap-datepicker.min.js') }}"></script>
    <script type="text/javascript">

        var el_dependent;
        var el_education;
        var el_cuti;

        $(".modal-terpakai, .modal-kuota").on("input", function(){

            if($('.modal-terpakai').val() == "" || $('.modal-terpakai').val() == 0)
            {
                $('.modal-sisa_cuti').val($('.modal-kuota').val());
            }
            else
            {
                $('.modal-sisa_cuti').val(parseInt($('.modal-kuota').val()) - parseInt($(".modal-terpakai").val()) );
            }
        });

        function edit_inventaris_mobil(id, tipe_mobil, tahun, no_polisi, status_mobil)
        {
            $('.modal-tipe_mobil').val(tipe_mobil);
            $('.modal-tahun').val(tahun);
            $('.modal-no_polisi').val(no_polisi);
            $('.modal-status_mobil').val(status_mobil);

            $("#modal_inventaris_mobil").modal('show');
            $("input[name='id_inventaris_mobil']").val(id);
        }

        function edit_cuti(id, jenis_cuti, kuota, terpakai)
        {
            $('.modal-jenis_cuti').val(jenis_cuti);
            $('.modal-kuota').val(kuota);
            $('.modal-terpakai').val(terpakai);
            $('.modal-sisa_cuti').val(parseInt(kuota) - parseInt(terpakai));

            $("input[name='cuti_id']").val(id);

            $("#modal_cuti").modal('show');
        }

        function edit_row_cuti(el, jenis_cuti, kuota, terpakai)
        {
            el_cuti = el;

            $('.modal-jenis_cuti').val(jenis_cuti);
            $('.modal-kuota').val(kuota);
            $('.modal-terpakai').val(terpakai);
            $('.modal-sisa_cuti').val(parseInt(kuota) - parseInt(terpakai));

            $("input[name='action_cuti']").val('update');
            $("#modal_cuti").modal('show');
        }

        function edit_education(id, pendidikan, tahun_awal, tahun_akhir, fakultas, jurusan, nilai)
        {
            $('.modal-pendidikan').val(pendidikan);
            $('.modal-tahun_awal').val(tahun_awal);
            $('.modal-tahun_akhir').val(tahun_akhir);
            $('.modal-fakultas').val(fakultas);
            $('.modal-jurusan').val(jurusan);
            $('.modal-nilai').val(nilai);
            $('.modal-kota').val(kota);

            $("#modal_education").modal("show");

            $("input[name='action_education']").val('update');
            $("input[name='id_education']").val(id);
        }

        function update_row_education(el, pendidikan, tahun_awal, tahun_akhir, fakultas, jurusan, nilai)
        {
            el_education = el;

            $('.modal-pendidikan').val(pendidikan);
            $('.modal-tahun_awal').val(tahun_awal);
            $('.modal-tahun_akhir').val(tahun_akhir);
            $('.modal-fakultas').val(fakultas);
            $('.modal-jurusan').val(jurusan);
            $('.modal-nilai').val(nilai);
            $('.modal-kota').val(kota);

            $("#modal_education").modal("show");

            $("input[name='action_education']").val('update');
        }

        function update_row_dependent(el, nama, hubungan, tempat_lahir, tanggal_lahir, tanggal_meninggal, jenjang_pendidikan, pekerjaan, tertanggung)
        {
            $("input[name='action_dependent']").val('update');

            $('.modal-nama').val(nama);
            $('.modal-hubungan').val(hubungan);
            $('.modal-tempat_lahir').val(tempat_lahir);
            $('.modal-tanggal_lahir').val(tanggal_lahir);
            $('.modal-tanggal_meninggal').val(tanggal_meninggal);
            $('.modal-jenjang_pendidikan').val(jenjang_pendidikan);
            $('.modal-pekerjaan').val(pekerjaan);
            $('.modal-tertanggung').val(tertanggung);

            $('#modal_dependent').modal('show');

            el_dependent = el;
        }

        function edit_dependent(id, nama, hubungan, tempat_lahir, tanggal_lahir, tanggal_meninggal, jenjang_pendidikan, pekerjaan, tertanggung)
        {
            $("input[name='id_dependent']").val(id);

            $('.modal-nama').val(nama);
            $('.modal-hubungan').val(hubungan);
            $('.modal-tempat_lahir').val(tempat_lahir);
            $('.modal-tanggal_lahir').val(tanggal_lahir);
            $('.modal-tanggal_meninggal').val(tanggal_meninggal);
            $('.modal-jenjang_pendidikan').val(jenjang_pendidikan);
            $('.modal-pekerjaan').val(pekerjaan);
            $('.modal-tertanggung').val(tertanggung);

            $('#modal_dependent').modal('show');
        }

        $("select[name='branch_type']").on('change', function(){

            if($(this).val() == 'BRANCH')
            {
                $(".section-cabang").show();
            }
            else
            {
                $(".section-cabang").hide();
            }
        });

        $("#add_cuti").click(function(){
            $("#modal_cuti").modal('show');
        });


        $("select[name='empore_organisasi_direktur']").on('change', function(){
            var id  = $(this).val();
            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-manager-by-direktur') }}',
                data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {
                    var el = '<option value="">Choose</option>';

                    $(data.data).each(function(k,v){
                        console.log(v);
                       el += '<option value="'+ v.id +'">'+ v.name +'</option>';
                    });

                    $("select[name='empore_organisasi_manager_id']").html(el);
                }
            });
        }); 


        $("select[name='empore_organisasi_manager_id']").on('change', function(){
            var id  = $(this).val();
            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-supervisor-by-manager') }}',
                data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {
                    var el = '<option value="">Choose</option>';

                    $(data.data).each(function(k,v){
                        console.log(v);
                       el += '<option value="'+ v.id +'">'+ v.name +'</option>';
                    });

                    $("select[name='empore_organisasi_supervisor_id']").html(el);
                }
            });
        }); 

        $("select[name='empore_organisasi_supervisor_id']").on('change', function(){
            var id  = $(this).val();
            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-staff-by-supervisor') }}',
                data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {
                    var el = '<option value="">Choose</option>';

                    $(data.data).each(function(k,v){
                        console.log(v);
                       el += '<option value="'+ v.id +'">'+ v.name +'</option>';
                    });

                    $("select[name='empore_organisasi_staff_id']").html(el);
                }
            });
        }); 
        

        $("#add_modal_cuti").click(function(){

            var jenis_cuti = $('.modal-jenis_cuti :selected');
            var kuota = $('.modal-kuota').val();
            var terpakai = $('.modal-terpakai').val() == "" ? 0 : $('.modal-terpakai').val();

            var el = '<tr><td>'+ (parseInt($('.table_cuti tr').length) + 1) +'</td><td>'+ jenis_cuti.text() +'</td><td>'+ kuota +'</td>';

            el += '<td>'+ terpakai +'</td>';
            el += '<td>'+ (parseInt(kuota) - parseInt(terpakai)) +'</td>';
            el += '<td><a class="btn btn-default btn-xs" onclick="edit_row_cuti(this,'+ jenis_cuti.val() +','+ kuota +','+ terpakai +','+ ( parseInt(kuota)-parseInt(terpakai) ) +')"><i class="fa fa-edit"></i></a><a class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a></td>';
            el += '<input type="hidden" name="cuti[cuti_id][]" value="'+ jenis_cuti.val() +'" />';
            el += '<input type="hidden" name="cuti[kuota][]" value="'+ kuota +'" />';
            el += '<input type="hidden" name="cuti[terpakai][]" value="'+ terpakai +'" />';
            el += '</tr>';

            var id = $("input[name='cuti_id']").val();

            $("form.frm-modal-cuti").trigger('reset');

            if(id != "")
            {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.update-cuti') }}',
                    data: {'id' : id, 'cuti_id' : jenis_cuti.val(), 'kuota' : kuota, 'terpakai': terpakai, '_token' : $("meta[name='csrf-token']").attr('content')},
                    dataType: 'json',
                    success: function (data) {
                        window.location.href = '{{ route('administrator.karyawan.edit', $data->id) }}';
                    }
                });

                return false;
            }

            var act = $("input[name='action_cuti']").val();
            if(act == 'update')
            {
                $(el_cuti).parent().parent().remove();

                $("input[name='action_cuti']").val('insert')
            }

            $('.table_cuti').append(el);

            $("#modal_cuti").modal('hide');
        });

         $("#add_modal_dependent").click(function(){

            var el = '<tr>';
            var modal_nama                  = $('.modal-nama').val();
            var modal_hubungan              = $('.modal-hubungan').val();
            var modal_tempat_lahir          = $('.modal-tempat_lahir').val();
            var modal_tanggal_lahir         = $('.modal-tanggal_lahir').val();
            var modal_tanggal_meninggal     = $('.modal-tanggal_meninggal').val();
            var modal_jenjang_pendidikan    = $('.modal-jenjang_pendidikan').val();
            var modal_pekerjaan             = $('.modal-pekerjaan').val();
            var modal_tertanggung           = $('.modal-tertanggung').val();

            $('.modal-nama, .modal-hubungan, .modal-tempat_lahir, .modal-tanggal_lahir').val("");

            var id = $("input[name='id_dependent']").val();
            if(id != "")
            {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.update-dependent') }}',
                    data: {'id' : id, 'nama' : modal_nama, 'hubungan': modal_hubungan, 'tempat_lahir': modal_tempat_lahir, 'tanggal_lahir': modal_tanggal_lahir, 'tanggal_meninggal' : modal_tanggal_meninggal, 'jenjang_pendidikan' : modal_jenjang_pendidikan, 'pekerjaan' : modal_pekerjaan,'tertanggung': modal_tertanggung, '_token' : $("meta[name='csrf-token']").attr('content')},
                    dataType: 'json',
                    success: function (data) {

                        $("input[name='id_dependent']").val("");

                        window.location.href = '{{ route('administrator.karyawan.edit', $data->id) }}';
                    }
                });

                return false;
            }

            el += '<td>'+ parseInt($('.dependent_table tr').length) + 1  +'</td>';
            el +='<td>'+ modal_nama +'</td>';
            el +='<td>'+ modal_hubungan +'</td>';
            el +='<td>'+ modal_tempat_lahir +'</td>';
            el +='<td>'+ modal_tanggal_lahir +'</td>';
            el +='<td>'+ modal_tanggal_meninggal +'</td>';
            el +='<td>'+ modal_jenjang_pendidikan +'</td>';
            el +='<td>'+ modal_pekerjaan +'</td>';
            el +='<input type="hidden" name="dependent[nama][]" value="'+ modal_nama +'" />';
            el +='<input type="hidden" name="dependent[hubungan][]" value="'+ modal_hubungan +'" />';
            el +='<input type="hidden" name="dependent[tempat_lahir][]" value="'+ modal_tempat_lahir +'" />';
            el +='<input type="hidden" name="dependent[tanggal_lahir][]" value="'+ modal_tanggal_lahir +'" />';
            el +='<input type="hidden" name="dependent[tanggal_meninggal][]" value="'+ modal_tanggal_meninggal +'" />';
            el +='<input type="hidden" name="dependent[jenjang_pendidikan][]" value="'+ modal_jenjang_pendidikan +'" />';
            el +='<input type="hidden" name="dependent[pekerjaan][]" value="'+ modal_pekerjaan +'" />';
            el +='<input type="hidden" name="dependent[tertanggung][]" value="'+ modal_tertanggung +'" />';
            el += '<td>';
            el += '<a onclick="delete_row_dependent(this)" class="btn btn-danger btn-xs"><i class="fa fa-trash"></i></a>';
            el += '<a onclick="update_row_dependent(this,\''+ modal_nama +'\',\''+ modal_hubungan +'\',\''+ modal_tempat_lahir +'\',\''+ modal_tanggal_lahir +'\',\''+ modal_tanggal_meninggal +'\',\''+ modal_jenjang_pendidikan +'\',\''+ modal_pekerjaan +'\',\''+ modal_tertanggung +'\')" class="btn btn-default btn-xs"><i class="fa fa-edit"></i></a>';
            el += '</td>';

            var act = $("input[name='action_dependent']").val();
            if(act == 'update')
            {
                $(el_dependent).parent().parent().remove();

                $("input[name='action_dependent']").val('insert')
            }

            $('.dependent_table').append(el);
            $('#modal_dependent').modal('hide');

            $('.frm-modal-dependent').trigger('reset');
        });

        function delete_row_dependent(el)
        {
            if(confirm('Hapus data ini'))
            {
                $(el).parent().parent().remove();
            }
        }

        $("#add_modal_education").click(function(){

            var el = '<tr>';
            var modal_pendidikan            = $('.modal-pendidikan').val();
            var modal_tahun_awal            = $('.modal-tahun_awal').val();
            var modal_tahun_akhir           = $('.modal-tahun_akhir').val();
            var modal_fakultas              = $('.modal-fakultas').val();
            var modal_jurusan               = $('.modal-jurusan').val();
            var modal_nilai                 = $('.modal-nilai').val();
            var modal_kota                  = $('.modal-kota').val();

            var id = $("input[name='id_education']").val();

            if(id != "")
            {
                $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.update-education') }}',
                    data: {'id' : id, 'pendidikan' : modal_pendidikan, 'tahun_awal': modal_tahun_awal, 'tahun_akhir': modal_tahun_akhir, 'fakultas': modal_fakultas, 'jurusan' : modal_jurusan, 'nilai' : modal_nilai, '_token' : $("meta[name='csrf-token']").attr('content')},
                    dataType: 'json',
                    success: function (data) {

                        $("input[name='id_education']").val("");

                        window.location.href = '{{ route('administrator.karyawan.edit', $data->id) }}';
                    }
                });

                return false;
            }

            el += '<td>'+ (parseInt($('.education_table tr').length) + 1 )  +'</td>';
            el +='<td>'+ modal_pendidikan +'</td>';
            el +='<td>'+ modal_tahun_awal +'</td>';
            el +='<td>'+ modal_tahun_akhir +'</td>';
            el +='<td>'+ modal_fakultas +'</td>';
            el +='<td>'+ modal_jurusan +'</td>';
            el +='<td>'+ modal_nilai +'</td>';
            el +='<td>'+ modal_kota +'</td>';
            el +='<input type="hidden" name="education[pendidikan][]" value="'+ modal_pendidikan +'" />';
            el +='<input type="hidden" name="education[tahun_awal][]" value="'+ modal_tahun_awal +'" />';
            el +='<input type="hidden" name="education[tahun_akhir][]" value="'+ modal_tahun_akhir +'" />';
            el +='<input type="hidden" name="education[fakultas][]" value="'+ modal_fakultas +'" />';
            el +='<input type="hidden" name="education[jurusan][]" value="'+ modal_jurusan +'" />';
            el +='<input type="hidden" name="education[nilai][]" value="'+ modal_nilai +'" />';
            el +='<input type="hidden" name="education[kota][]" value="'+ modal_kota +'" />';
            el +='<td><a class="btn btn-default btn-xs" onclick="update_row_education(this,\''+ modal_pendidikan +'\',\''+ modal_tahun_awal +'\',\''+ modal_tahun_akhir +'\',\''+ modal_fakultas +'\',\''+ modal_jurusan +'\', \''+ modal_nilai +'\', \''+ modal_kota +'\')"><i class="fa fa-edit"></i></a>';
            el +='<a class="btn btn-danger btn-xs" onclick="delete_row_dependent(this)"><i class="fa fa-trash"></i></a></td>';
            $('.education_table').append(el);

            var act = $("input[name='action_education']").val();
            if(act == 'update')
            {
                $(el_education).parent().parent().remove();

                $("input[name='action_education']").val('insert')
            }

            $('#modal_education').modal('hide');
            $('form.frm-modal-education').trigger('reset');
        });

        $("#btn_modal_dependent").click(function(){

            $('#modal_dependent').modal('show');

        });

         $("#btn_modal_education").click(function(){

            $('#modal_education').modal('show');

        });

        function get_kabupaten(el)
        {
            var id = $(el).val();

            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-kabupaten-by-provinsi') }}',
                data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    var html_ = '<option value="">Choose District</option>';

                    $(data.data).each(function(k, v){
                        html_ += "<option value=\""+ v.id_kab +"\">"+ v.nama +"</option>";
                    });

                    $(el).parent().find('select').html(html_);
                }
            });
        }

        jQuery('.datepicker').datepicker({
            format: 'yyyy-mm-dd',
        });


        $("select[name='division_id']").on('change', function(){

            var id = $(this).val();

            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-department-by-division') }}',
                data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    var html_ = '<option value=""> Choose Department</option>';

                    $(data.data).each(function(k, v){
                        html_ += "<option value=\""+ v.id +"\">"+ v.name +"</option>";
                    });

                    $("select[name='department_id'").html(html_);
                }
            });
        });

        $("select[name='department_id']").on('change', function(){

            var id = $(this).val();

            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-section-by-department') }}',
                data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    var html_ = '<option value=""> Choose Section</option>';

                    $(data.data).each(function(k, v){
                        html_ += "<option value=\""+ v.id +"\">"+ v.name +"</option>";
                    });

                    $("select[name='section_id'").html(html_);
                }
            });
        });

        $("select[name='provinsi_id']").on('change', function(){

            var id = $(this).val();

            $.ajax({
                type: 'POST',
                url: '{{ route('ajax.get-kabupaten-by-provinsi') }}',
                data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                dataType: 'json',
                success: function (data) {

                    var html_ = '<option value=""> Choose Districts</option>';

                    $(data.data).each(function(k, v){
                        html_ += "<option value=\""+ v.id_kab +"\">"+ v.nama +"</option>";
                    });

                    $("select[name='kabupaten_id'").html(html_);
                }
            });
        });

        $("select[name='kabupaten_id']").on('change', function(){

            var id = $(this).val();

            $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.get-kecamatan-by-kabupaten') }}',
                    data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                    dataType: 'json',
                    success: function (data) {

                        var html_ = '<option value=""> Choose Sub-District</option>';

                        $(data.data).each(function(k, v){
                            html_ += "<option value=\""+ v.id_kec +"\">"+ v.nama +"</option>";
                        });

                        $("select[name='kecamatan_id'").html(html_);
                    }
            });
        });

        $("select[name='kecamatan_id']").on('change', function(){

            var id = $(this).val();

            $.ajax({
                    type: 'POST',
                    url: '{{ route('ajax.get-kelurahan-by-kecamatan') }}',
                    data: {'id' : id, '_token' : $("meta[name='csrf-token']").attr('content')},
                    dataType: 'json',
                    success: function (data) {

                        var html_ = '<option value=""> Choose Sub-District</option>';

                        $(data.data).each(function(k, v){
                            html_ += "<option value=\""+ v.id_kel +"\">"+ v.nama +"</option>";
                        });

                        $("select[name='kelurahan_id'").html(html_);
                    }
            });
        });

    </script>
@endsection

@endsection
