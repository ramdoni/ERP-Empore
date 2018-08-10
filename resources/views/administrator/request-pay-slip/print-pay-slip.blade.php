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
	<h3>PT. Empore Hezer Tama </h3>
	<br />
	<table style="width: 100%;">
		<tr>
			<th>EMPORE ID</th>
			<th> : {{ $data->user->nik }}</th>
			<th>Status</th>
			<th> : {{ $data->user->organisasi_status }}</th>
		</tr>
		<tr>
			<th>Name</th>
			<th> : {{ $data->user->name }}</th>
			<th>NPWP</th>
			<th> : {{ $data->user->npwp_number }}</th>
		</tr>
		<tr>
			<th>Position Title</th>
			<th colspan="2"> : {{ empore_jabatan($data->user->id) }}</th>
		</tr>
		<!-- <tr>
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
		</tr> -->
	</table>
	<br />
	<p><strong>IDR Portion</strong></p>
	<table style="width: 100%;" class="border">
		<tr>
			<th colspan="2" style="padding-bottom: 15px;padding-top: 15px;">Income Description</th>
			<th colspan="2">Deduction Description</th>
		</tr>
		<tr>
			<td><strong>Basic Salary</strong></td>
			<td style="text-align: right;">{{ number_format($item->basic_salary) }}</td>
			<td>BPJS TK - JHT (employee)</td>
			<td style="text-align: right;">{{ number_format($item->monthly_income_tax) }}</td>
		</tr>
		<tr>
			<td>Actual Salary</td>
			<td style="text-align: right;">{{ number_format($item->salary) }}</td>
			<td>BPJS Pensiun (employee)</td>
			<td style="text-align: right;"></td>
		</tr>
		<tr>
			<td>Call Allowance</td>
			<td style="text-align: right;">{{ number_format($item->call_allowance) }}</td>
			<td>BPJS Kesehatan (employee)</td>
			<td style="text-align: right;"></td>
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