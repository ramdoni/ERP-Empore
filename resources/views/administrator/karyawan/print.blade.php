<!DOCTYPE html>
<html>
<head>
	<title>{{ $data->name }} - {{ $data->nik }}</title>
	<style type="text/css">
		table {
			border-collapse: collapse;
    		border-spacing: 0;
		}
		table tr td {
			-border-bottom: 1px solid #666666;
			padding: 5px 0;
		}

		.table-border {
			width: 100%;
		}
		.table-border tr td, .table-border tr th{
			border-bottom: 1px solid #666666;
		}
	</style>
</head>
<body>
	<h3 style="margin-bottom:0;">{{ $data->name }}</h3>
	<h4 style="margin-top:0;">{{ $data->nik }}</h4>
	
	@if(!empty($data->foto))
		<img src="{{ public_path('storage/foto/'. $data->foto) }}" style="width: 200px; position: absolute; right: 0; top: 100px;">
	@endif

	<hr>
	<table>
		<tr>
			<td>Place of birth</td>
			<td>: {{ $data->tempat_lahir }}</td>
		</tr>
		<tr>
			<td>Date of birth</td>
			<td>: {{ $data->tanggal_lahir }}</td>
		</tr>
		<tr>
			<td>Gender</td>
			<td>: {{ $data->jenis_kelamin }}</td>
		</tr>
		<tr>
			<td>E-mail</td>
			<td>: {{ $data->email }}</td>
		</tr>
		<tr>
			<td>Join Date</td>
			<td>: {{ $data->join_date }}</td>
		</tr>
		<tr>
			<td>Telephone</td>
			<td>: {{ $data->telepon }}</td>
		</tr>
		<tr>
			<td>Religion</td>
			<td>: {{ $data->agama }}</td>
		</tr>
		<tr>
			<td>Mobile 1</td>
			<td>: {{ $data->mobile_1 }}</td>
		</tr>
		<tr>
			<td>Mobile 2</td>
			<td>: {{ $data->mobile_2 }}</td>
		</tr>
		<tr>
			<td>KTP Number</td>
			<td>: {{ $data->ktp_number }}</td>
		</tr>
		<tr>
			<td>Passport Number</td>
			<td>: {{ $data->passport_number }}</td>
		</tr>
		<tr>
			<td>KK Number</td>
			<td>: {{ $data->kk_number }}</td>
		</tr>
		<tr>
			<td>NPWP Number</td>
			<td>: {{ $data->npwp_number }}</td>
		</tr>
		<tr>
			<td>BPJS Kesehatan Number</td>
			<td>: {{ $data->jamsostek_number }}</td>
		</tr>
		<tr>
			<td>BPJS Ketenagakerjaan Number</td>
			<td>: {{ $data->bpjs_number }}</td>
		</tr>
		<tr>
			<td>Position</td>

			<td>:@if(!empty($data->empore_organisasi_staff_id))
                                                Staff
                                            @endif

                                            @if(empty($data->empore_organisasi_staff_id) and !empty($data->empore_organisasi_supervisor_id))
                                                Supervisor
                                            @endif

                                            @if(empty($data->empore_organisasi_staff_id) and empty($data->empore_organisasi_supervisor_id) and
                                            !empty($data->empore_organisasi_manager_id))
                                                Manager
                                            @endif

                                            @if(empty($data->empore_organisasi_staff_id) and 
                                            empty($data->empore_organisasi_supervisor_id) and
                                            empty($data->empore_organisasi_manager_id) and !empty($data->empore_organisasi_direktur))
                                                Direktur
                                            @endif

			</td>
		</tr>
		<tr>
			<td>Job Rule</td>
			<td>: @if(!empty($data->empore_organisasi_staff_id))
                                                {{ isset($data->empore_staff->name) ? $data->empore_staff->name : '' }}
                                            @endif
                                            
                                            @if(empty($data->empore_organisasi_staff_id) and
                                                 !empty($data->empore_organisasi_supervisor_id))
                                                {{ isset($data->empore_supervisor->name) ? $data->empore_supervisor->name : '' }}
                                            @endif
                                            @if(empty($data->empore_organisasi_staff_id) and
                                                 empty($data->empore_organisasi_supervisor_id) and
                                                 !empty($data->empore_organisasi_manager_id))
                                                {{ isset($data->empore_manager->name) ? $data->empore_manager->name : '' }}
                                            @endif
            </td>
		</tr>
		<tr>
			<td>ID Address</td>
			<td>: {{ (isset($data->id_address) ? $data->id_address : '') }}</td>
		</tr>
		<tr>
			<td>ID City</td>
			<td>: {{ (isset($data->id_city) ? $data->id_city : '') }}</td>
		</tr>
		<tr>
			<td>ID Zip Code</td>
			<td>: {{ (isset($data->id_zip_code) ? $data->id_zip_code : '') }}</td>
		</tr>
		<tr>
			<td>Blood Type</td>
			<td>: {{ (isset($data->blood_type) ? $data->blood_type : '') }}</td>
		</tr>
		<tr>
			<td>Office Type</td>
			<td>: {{ (isset($data->branch_type) ? $data->branch_type : '') }}</td>
		</tr>
		<tr>
			<td>Bank</td>
			<td>: {{ (isset($data->bank->name) ? $data->bank->name : '') }}</td>
		</tr>
		<tr>
			<td>Name of Account</td>
			<td>: {{ (isset($data->nama_rekening) ? $data->nama_rekening : '') }}</td>
		</tr>
		<tr>
			<td>Account Number</td>
			<td>: {{ (isset($data->nomor_rekening) ? $data->nomor_rekening : '') }}</td>
		</tr>
		<tr>
			<td>Name of Bank</td>
			<td>: {{ (isset($data->cabang) ? $data->cabang : '') }}</td>
		</tr>
	</table>
	<br />
	<h4 style="background: #eee; padding: 10px; margin-bottom: 0; ">Dependent</h4>
	<hr>
	<br />
	<table class="table-border">
		<tr>
			<th>No</th>
			<th>Name</th>
			<th>Relationship</th>
			<th>Place of birth</th>
			<th>Date of birth</th>
			<th>Education level</th>
			<th>Occupation</th>
		</tr>
		@foreach($data->userFamily as $no => $i)
		<tr>
			<td>{{ $no + 1 }}</td>
			<td>{{ $i->nama }}</td>
			<td>{{ $i->hubungan }}</td>
			<td>{{ $i->tempat_lahir }}</td>
			<td>{{ $i->tanggal_lahir }}</td>
			<td>{{ $i->jenjang_pendidikan }}</td>
			<td>{{ $i->pekerjaan }}</td>
		</tr>
		@endforeach
	</table>

	<br />
	<h4 style="background: #eee; padding: 10px; margin-bottom: 0; ">Education</h4>
	<hr>
	<br />
	<table class="table-border">
		<tr>
			<th>No</th>
			<th>Education</th>
			<th>Year of Start</th>
			<th>Year of Graduate</th>
			<th>School Name</th>
			<th>Major</th>
			<th>Grade</th>
		</tr>
		@foreach($data->userEducation as $no => $i)
		<tr>
			<td>{{ $no + 1 }}</td>
			<td>{{ $i->pendidikan }}</td>
			<td>{{ $i->tahun_awal }}</td>
			<td>{{ $i->tahun_akhir }}</td>
			<td>{{ $i->fakultas }}</td>
			<td>{{ $i->jurusan }}</td>
			<td>{{ $i->nilai }}</td>
		</tr>
		@endforeach
	</table>
	

	<br />
	<h4 style="background: #eee; padding: 10px; margin-bottom: 0; ">Cuti</h4>
	<hr>
	<br />
	<table class="table-border">
		<tr>
			<th>#</th>
			<th>Leave Type</th>
			<th>Quota</th>
		</tr>
		@foreach($data->cuti as $no => $m)
		<tr>
			<td>{{ $no+1 }}</td>
			<td>{{ $m->jenis_cuti }}</td>
			<td>{{ $m->kuota }}</td>
		</tr>		
		@endforeach
	</table>
</body>
</html>
