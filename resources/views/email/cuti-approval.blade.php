@extends('email.general')

@section('content')
<p><strong>Dear Bapak/Ibu {{ $atasan->name }}</strong>,</p>
<p> {{ $user->name }} / {{ $user->nik }} mengajukan Cuti dan butuh persetujuan Anda.</p>

<table>
	<thead>
		<tr>
			<th style="text-align: left;">Tanggal Cuti / Izin </th>
			<th style="text-align: left;"> : {{ date('d F Y', strtotime($cuti->tanggal_cuti_start)) }} - {{ date('d F Y', strtotime($cuti->tanggal_cuti_end)) }}</th>
		</tr>
		<tr>
			<th style="text-align: left;">Jenis Cuti / Izin </th>
			<th style="text-align: left;"> : {{ isset($cuti->cuti) ? $cuti->cuti->jenis_cuti : '' }}</th>
		</tr>
		<tr>
			<th style="text-align: left;">Lama Cuti / Izin </th>
			<th style="text-align: left;"> : {{ $cuti->total_cuti }} Hari</th>
		</tr>
		<tr>
			<th style="text-align: left;">Keperluan</th>
			<th style="text-align: left;"> : {{ $cuti->keperluan }}</th>
		</tr>
	</thead>
</table>
<br />	


<div class="modal-body" id="modal_content_history_approval">
	<div class="panel-body">
		<div class="steamline" style="position: relative; border-left: 1px solid rgba(120,130,140,.13);margin-left: 20px;">
			<div class="sl-item" style="border-bottom: 1px solid rgba(120,130,140,.13);margin: 20px 0;">
				<div class="sl-left" style="background: transparent; float: left;margin-left: -20px;z-index: 1;width: 40px;line-height: 40px;text-align: center;height: 40px;border-radius: 100%;color: #fff;margin-right: 15px;">
					@if($cuti->is_approved_atasan === NULL)
					<img src="{{ asset('images/info.png') }}" style="width: 33px;margin-left: -4px;margin-top: -12px;" />
					@endif
					@if($cuti->is_approved_atasan == 1)
					<img src="{{ asset('images/oke.png') }}" style="width: 48px;margin-left: -4px;margin-top: -12px;" />
					@endif
					@if($cuti->is_approved_atasan === 0)
					<img src="{{ asset('images/close.png') }}" style="width: 33px;margin-left: -4px;margin-top: -12px;" />
					@endif
				</div>
				<div class="sl-right">
					<div>
						<strong>Manager</strong> <br>
						<a href="#">{{ $cuti->atasan->nik }} - {{ $cuti->atasan->name }}</a> 
					</div>
				<div class="desc">{{ $cuti->date_approved_atasan }}<p></p></div></div>
			</div>
		</div>
	</div>

	<div class="panel-body">
		<div class="steamline" style="position: relative; border-left: 1px solid rgba(120,130,140,.13);margin-left: 20px;">
			<div class="sl-item" style="border-bottom: 1px solid rgba(120,130,140,.13);margin: 20px 0;">
				<div class="sl-left" style="background: transparent; float: left;margin-left: -20px;z-index: 1;width: 40px;line-height: 40px;text-align: center;height: 40px;border-radius: 100%;color: #fff;margin-right: 15px;">
					@if($cuti->approve_direktur === NULL)
					<img src="{{ asset('images/info.png') }}" style="width: 33px;margin-left: -4px;margin-top: -12px;" />
					@endif
					@if($cuti->approve_direktur == 1)
					<img src="{{ asset('images/oke.png') }}" style="width: 48px;margin-left: -4px;margin-top: -12px;" />
					@endif
					@if($cuti->approve_direktur === 0)
					<img src="{{ asset('images/close.png') }}" style="width: 33px;margin-left: -4px;margin-top: -12px;" />
					@endif
				</div>
				<div class="sl-right" style="padding-left: 50px;">
					<div>
						<strong>Direktur</strong> <br>
						<a href="#">{{ $cuti->direktur->nik }} - {{ $cuti->direktur->name }}</a> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection