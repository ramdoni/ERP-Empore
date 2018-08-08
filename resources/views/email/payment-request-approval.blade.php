@extends('email.general')

@section('content')
{!! $text !!}

<table>
	<thead>
		<tr>
			<th style="text-align: left;">Tujuan / Purpose </th>
			<th style="text-align: left;"> : {{ $data->tujuan }}</th>
		</tr>
		<tr>
			<th style="text-align: left;">Jenis Transaksi / Trancation Type </th>
			<th style="text-align: left;"> : {{ $data->transaction_type }}</th>
		</tr>
		<tr>
			<th style="text-align: left;">Cara Pembayaran / Payment Method </th>
			<th style="text-align: left;"> : {{ $data->payment_method }}</th>
		</tr>
	</thead>
</table>
<br />	


<div class="modal-body" id="modal_content_history_approval">
	<div class="panel-body">
		<div class="steamline" style="position: relative; border-left: 1px solid rgba(120,130,140,.13);margin-left: 20px;">
			<div class="sl-item" style="border-bottom: 1px solid rgba(120,130,140,.13);margin: 20px 0;">
				<div class="sl-left" style="background: transparent; float: left;margin-left: -20px;z-index: 1;width: 40px;line-height: 40px;text-align: center;height: 40px;border-radius: 100%;color: #fff;margin-right: 15px;">
					@if($data->is_approved_atasan === NULL)
					<img src="{{ asset('images/info.png') }}" style="width: 33px;margin-left: -4px;margin-top: -12px;" />
					@endif
					@if($data->is_approved_atasan == 1)
					<img src="{{ asset('images/oke.png') }}" style="width: 48px;margin-left: -4px;margin-top: -12px;" />
					@endif
					@if($data->is_approved_atasan === 0)
					<img src="{{ asset('images/close.png') }}" style="width: 33px;margin-left: -4px;margin-top: -12px;" />
					@endif
				</div>
				<div class="sl-right">
					<div>
						<strong>Manager</strong> <br>
						<a href="#">{{ $data->atasan->nik }} - {{ $data->atasan->name }}</a> 
					</div>
				<div class="desc">{{ $data->date_approved_atasan }}<p></p></div></div>
			</div>
		</div>
	</div>

	<div class="panel-body">
		<div class="steamline" style="position: relative; border-left: 1px solid rgba(120,130,140,.13);margin-left: 20px;">
			<div class="sl-item" style="border-bottom: 1px solid rgba(120,130,140,.13);margin: 20px 0;">
				<div class="sl-left" style="background: transparent; float: left;margin-left: -20px;z-index: 1;width: 40px;line-height: 40px;text-align: center;height: 40px;border-radius: 100%;color: #fff;margin-right: 15px;">
					@if($data->approve_direktur === NULL)
					<img src="{{ asset('images/info.png') }}" style="width: 33px;margin-left: -4px;margin-top: -12px;" />
					@endif
					@if($data->approve_direktur == 1)
					<img src="{{ asset('images/oke.png') }}" style="width: 48px;margin-left: -4px;margin-top: -12px;" />
					@endif
					@if($data->approve_direktur === 0)
					<img src="{{ asset('images/close.png') }}" style="width: 33px;margin-left: -4px;margin-top: -12px;" />
					@endif
				</div>
				<div class="sl-right" style="padding-left: 50px;">
					<div>
						<strong>Direktur</strong> <br>
						<a href="#">{{ $data->direktur->nik }} - {{ $data->direktur->name }}</a> 
					</div>
				</div>
			</div>
		</div>
	</div>
</div>


@endsection