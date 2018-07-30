<!DOCTYPE html>
<html>
<head>
	<title>Payslip {{ $data->user->nik .'/'. $data->user->name }}</title>
	<style type="text/css">
		table {
			border-collapse: collapse;
    		border-spacing: 0;
		}
		table.border tr th, table.border tr td {
			border: 1px solid black;
			padding: 5px 10px;
		}
	</style>
</head>
<body>
	<img src="{{  asset('empore.png') }}" style="width: 140px; float: right;" /> 

	@foreach($dataArray as $k => $item)
	<h3>PAY-SLIP</h3>
	<br />
	<table style="width: 100%;">
		<tr>
			<th style="color: #538135;">PERIODE</th>
			<th style="color: #538135;">METODE PEMBAYARAN</th>
			<th style="color: #538135;">BANK</th>
		</tr>
		<tr>
			<td style="padding-bottom: 30px;">{{ $bulan[$k] }} {{ date('Y', strtotime($item->created_at)) }}</td>
			<td style="padding-bottom: 30px;">Direct Transfer</td>
			<td style="padding-bottom: 30px;">{{ isset($data->user->bank->name) ? $data->user->bank->name : '' }}</td>
		</tr>
		<tr>
			<th style="color: #538135;">DIVISI/TEAM</th>
			<th style="color: #538135;">NAMA KARYAWAN</th>
			<th style="color: #538135;">E-MAIL</th>
		</tr>
		<tr>
			<td>{{ $data->user->organisasi_job_role }}</td>
			<td>{{ $data->user->name }}</td>
			<td>{{ $data->user->email }}</td>
		</tr>
	</table>
	<br />
	<table style="width: 100%;" class="border">
		<tr>
			<th colspan="2" style="padding-bottom: 15px;padding-top: 15px;">PENDAPATAN</th>
			<th colspan="2">PENGURANGAN</th>
		</tr>
		<tr>
			<td><strong>Gaji Pokok</strong></td>
			<td style="text-align: right;">{{ number_format($item->salary) }}</td>
			<td>PPh 21</td>
			<td style="text-align: right;">{{ number_format($item->monthly_income_tax) }}</td>
		</tr>
		<tr>
			<td>Tunjangan Jabatan</td>
			<td style="text-align: right;">{{ number_format($item->burden_allow) }}</td>
			<td>BPJS Ketenagakerjaan</td>
			<td style="text-align: right;">{{ number_format($item->jamsostek_result) }}</td>
		</tr>
		<tr>
			<td>Tunjangan Komunikasi</td>
			<td style="text-align: right;">0</td>
			<td>BPJS Kesehatan</td>
			<td style="text-align: right;">0</td>
		</tr>
		<tr>
			<td>Tunjangan Transportasi</td>
			<td style="text-align: right;">0</td>
			<td>Pemotongan Lain-lain</td>
			<td style="text-align: right;">0</td>
		</tr>
		<tr>
			<td>THR</td>
			<td style="text-align: right;">{{ number_format($item->bonus) }}</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Bonus Project</td>
			<td style="text-align: right;">0</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Lembur</td>
			<td style="text-align: right;">0</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>BPJS Ketenagakerjaan</td>
			<td style="text-align: right;">0</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>BPJS Kesehatan</td>
			<td style="text-align: right;">0</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<td>Pendapatan Lain</td>
			<td style="text-align: right;">0</td>
			<td></td>
			<td></td>
		</tr>
		<tr>
			<th>TOTAL PENDAPATAN</th>
			<th style="text-align: right;">{{ number_format($item->thp * 12) }}</th>
			<th>TOTAL PENGURANGAN</th>
			<th style="text-align: right;">{{ number_format($data->less * 12) }}</th>
		</tr>
	</table>
	<br />
	<p><strong>Gaji Bersih</strong><br />
		<label style="font-size: 10px;">Take Home Pay</label>
	</p>
	<h3>Rp. {{ number_format($item->thp*12) }}</h3>

	@if($total == 0)

	@elseif(($k+1) != $total)
		<div style="page-break-before:always"></div>
	@endif

	@endforeach
</body>
</html>